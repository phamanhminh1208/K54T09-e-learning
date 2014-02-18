<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

class UsersController extends AppController {

	var $name = 'Users';
	
	var $layout			=	"default";
	var $helpers		=	array("Session");	
		
	function beforeFilter(){
		parent::beforeFilter();		
	}
	
	function login() {
		if($this->request->is('post')){			
			/* get data of user */				
			$sql = array(
				'fields'		=>	array(
					'id', 
					'Username',
					'Password',
					'FilterChar',
					'UserType',
					'Status',
					'RealName',
				),
				'conditions'	=>	array(
					'Username'		=>	$this->request->data['User']['Username'],						
				),	
			);
			$u = $this->User->find("first",$sql);
			/* end of getting data of user */
			
			if($this->User->getNumRows() > 0){	//if user with this username is exist
				//encode password
				$password = sha1($this->request->data['User']['Username']. "+" .$this->request->data['User']['Password']. "+". $u["User"]["FilterChar"]);
					
				if($password === $u["User"]["Password"]){	//username and password are correct
					/* delete WrongNum */
					if($this->Session->check('Login.WrongNum')){
						$this->Session->delete('Login');
					}
					/* end of deleting WrongNum */
					
					/* redirect if not active */
					if($u["User"]["Status"] == User::$_STATUS_NOT_ACTIVE){//if user is not active
						return $this->redirect(array('controller'=>'users', 'action'=>'notConfirm'));
					}
					/* end of redirecting if not active */
					
					$this->Session->write('User',$u["User"]);	//store user data in Session
					
					$ip = $this->get_client_ip();					
					/* redirect	user */
					switch($u["User"]["UserType"]){
						case User::$_TYPE_MANAGER:	//if user is manager
							/* check ip */
							//Controller:loadModel('AllowedIp');
							/*-- check client ip in list ip 
							$this->AllowedIp->find("first", array(
								'fields'		=>	array('id'),
								'conditions'	=>	array(
									'IP'			=>	$ip,
								)
							));*/
							/*-- end of checking client ip in list ip */
							/*if($this->AllowedIp->getNumRows()>0){	//if client ip in list
								return $this->redirect(array('controller'=>'managers', 'action'=>'homepage'));
							}
							comment because not have real ip*/
							
							return $this->redirect(array('controller'=>'managers', 'action'=>'cancelAccess'));
							break;
							
						case User::$_TYPE_TEACHER:	//if user if teacher
							/* check last ip */
							/*-- check lastip == current client ip */
							/*Controller:loadModel('Teacher');
							$this->Teacher->find("first", array(
								'fields'		=>	array('id'),
								'conditions'	=>	array(
									'user_id'			=>	$u["User"]["id"],
									'LastIP'			=>	$ip,
								)
							));*/
							/*-- end of checking lastip */
							/*if($this->Teacher->getNumRows()>0){	//if lastip == current ip
								if($u["User"]["Status"] == User::$_STATUS_LOCKED){	//if user is locked
									return $this->redirect(array(
										'controller'		=>	'teachers', 
										'action'			=>	'verifycodeConfirm',
										'reason'				=>	'locked'
									));
								}else{	//user is normal
									return $this->redirect(array('controller'=>'teachers', 'action'=>'homepage'));
								}
							}
							comment becase not have real ip*/
							//if lastip != current ip
							return $this->redirect(array(
								'controller'		=>	'teachers', 
								'action'			=>	'verifycodeConfirm',
								'reason'				=>	'lastip'
							));							
							break;
							
						case User::$_TYPE_STUDENT:	 //if user is student				
							if($u["User"]["Status"] == User::$_STATUS_LOCKED){//if student is locked
								return $this->redirect(array('controller'=>'students', 'action'=>'locked'));
							}else{
								return $this->redirect(array('controller'=>'students', 'action'=>'homepage'));	
							}							
							break;
					}
					/* end of redirecting	user */
				}else{	//if username is exist and password is wrong
					$WrongNum = 0;		//time of wrong password 	
					$max_time_wrong_pass	= null;
					
					/* get MAX_TIME_WRONG_PASSWORD from database and store into Session*/						
					if(!$this->Session->check('SystemParam.MAX_TIME_WRONG_PASSWORD')){
						Controller::loadModel('SystemParam');
						$system_param = $this->SystemParam->find("first", array(
							'fields'		=>	array('Value'),
							'conditions'	=>	array(
								'ParamName'		=>	'MAX_TIME_WRONG_PASSWORD',
							)
						));
						
						if($this->SystemParam->getNumRows()>0){
							do{
								//Cache::write('MAX_TIME_WRONG_PASSOWRD', $system_param['SystemParam']['Value'], 'longterm');							
								$max_time_wrong_pass = $system_param['SystemParam']['Value'];
								$this->Session->write('SystemParam.MAX_TIME_WRONG_PASSWORD', $max_time_wrong_pass);
							}//while(!($max_time_wrong_pass = Cache::read('MAX_TIME_WRONG_PASSOWRD', 'longterm')));
							while(!$this->Session->check('SystemParam.MAX_TIME_WRONG_PASSWORD'));
						}
					}else{
						$max_time_wrong_pass = $this->Session->read('SystemParam.MAX_TIME_WRONG_PASSWORD');
					}					
					/* end of getting and storing MAX_TIME_WRONG_PASSWORD*/
					
					if(!$this->Session->check('Login.WrongNum') || $this->Session->read('Login.Username') !== $this->request->data['User']['Username']){ //if not save Wrong time and Username
						/* Save Wrong time and Username	*/											
						$this->Session->write('Login.WrongNum', $WrongNum);
						$this->Session->write('Login.Username', $this->request->data['User']['Username']);
						/* End of Saving Wrong time and Username	*/
					}
											
					$WrongNum = $this->Session->read('Login.WrongNum')+1;
					
					if($u["User"]["UserType"]==User::$_TYPE_TEACHER || $u["User"]["UserType"]==User::$_TYPE_STUDENT){//if user is teacher or student						
						if($WrongNum>=$max_time_wrong_pass){						
							//Lock user if being student or teacher	
							/* change status of user in database */
							$this->User->id = $u["User"]["id"];
							$this->User->save(array(
								"User"			=>	array(
									"Status"		=>	1,
								)
							));
							/* end of changing status of user in database */							
														
							$this->redirect(array(
								'action'		=>	(($u["User"]["UserType"]==2)?'verifycodeConfirm':'locked'),
								'controller'	=>	(($u["User"]["UserType"]==2)?'teachers':'students'),
								'reason'			=>	'locked'
							));
						}else{
							//send message to teacher of student
							$this->Session->write('Login.WrongNum', $WrongNum);
							$this->Session->setFlash(__("ユーザーとかパスワードは". $WrongNum . "/" . $max_time_wrong_pass ."回が間違った。"));
						}						
					}else{
						//send message to manager
						$this->Session->setFlash(__("ユーザーとかパスワードが間違った。"));
					}
				}
			}else{//username is not exist
				if($this->Session->check('Login.WrongNum')){
					$this->Session->delete('Login.WrongNum');	
				}				
				$this->Session->setFlash(__('ユーザーとかパスワードが間違った。'));	
			}
		}
	}

	function logout() {
		$this->Session->delete('User');
		return $this->redirect(array('controller'=>'users', 'action'=>'login'));
	}
	
	function notConfirm(){
		
	}
	
	function get_client_ip() {
	    /*$ipaddress = '';
	    if ($_SERVER['HTTP_CLIENT_IP'])
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_X_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if($_SERVER['HTTP_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if($_SERVER['REMOTE_ADDR'])
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	 
	    return $ipaddress;	*/
	}
}
?>