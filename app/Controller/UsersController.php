<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

App::import('Controller', 'Teachers');

class UsersController extends AppController {

	var $name = 'Users';
	
	var $layout			=	"default";
	var $helpers		=	array("Session", "Cache");
	//var $components 	=	array('RequestHandler');
		
	function beforeFilter(){
		parent::beforeFilter();		
	}
	
	/**
	* show login view and process after inputing	* 
	*/
	function login() {
		/* delete session if exist */
		if($this->Session->check('User')){
			$this->Session->delete('User');	
		}
		/* end of deleting session if exist */
		
		$this->set("title_for_layout", "ログイン");
		
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
				/* render if temp locked */
				if($u["User"]["Status"] == User::_STATUS_TEMP_LOCKED){
					$inLockTime = $this->User->query("SELECT TIME_TO_SEC(TIMEDIFF(SEC_TO_TIME(`system_params`.`value`) , TIMEDIFF(now(),`users`.`LockTime`))) as time  
										FROM `system_params`,`users`
										WHERE `system_params`.ParamName = 'TEMP_LOCK_TIME' 
										  AND `users`.`id` = '".$u["User"]["id"]."' 
										  AND TIME_TO_SEC(TIMEDIFF(now(),`users`.`LockTime`))<`system_params`.`value`");		
					
					if($inLockTime!=null){
						return $this->renderTempLocked($u["User"]["UserType"], $inLockTime[0][0]['time']);
					}					
				}
				/* end of rendering if temp locked */				
				
				$password = sha1($this->request->data['User']['Username']. "+" .$this->request->data['User']['Password']. "+". $u["User"]["FilterChar"]);	//encode password
					
				if($password === $u["User"]["Password"]){	//username and password are correct
					/* delete WrongNum */
					if($this->Session->check('Login.WrongNum')){
						$this->Session->delete('Login');
					}
					/* end of deleting WrongNum */
					
					$this->Session->write('User',$u["User"]);	//store user data in Session
					
					/* render if not active */
					if($u["User"]["Status"] == User::_STATUS_NOT_ACTIVE){//if user is not active					
						return $this->render('/Users/not_confirm');
					}
					/* end of rendering if not active */
					
					/* render if login locked */
					if($u["User"]["Status"] == User::_STATUS_LOGIN_LOCKED){
						return $this->render('/Users/login_locked');
					}
					/* end of rendering if login locked */				
					
					/* get client ip */
					$ip = $this->request->clientIp();				
					
					/* redirect	user */
					switch($u["User"]["UserType"]){
						case User::_TYPE_MANAGER:	//if user is manager
							/* check ip */
							$this->loadModel('AllowedIp');
							/*-- check client ip in list ip */
							$this->AllowedIp->find("first", array(
								'fields'		=>	array('id'),
								'conditions'	=>	array(
									'IP'			=>	$ip,
								)
							));
							/*-- end of checking client ip in list ip */
														
							if($this->AllowedIp->getNumRows()>0){	//if client ip in list
								$this->updateLastActionTime($u['User']['id']);
								return $this->redirect(array('controller'=>'managers', 'action'=>'homepage'));
							}else{
								return $this->render('/Managers/cancel_access');								
							}			
							
							break;
							
						case User::_TYPE_TEACHER:	//if user if teacher							
							/* check last ip */							
							$this->loadModel('Teacher');
							/*-- check lastip == current client ip */
							$this->Teacher->find("first", array(
								'fields'		=>	array('id'),
								'conditions'	=>	array(
									'user_id'			=>	$u["User"]["id"],
									'LastIP'			=>	$ip,
								)
							));							
							/*-- end of checking lastip */
							if($this->Teacher->getNumRows()>0){	//if lastip == current ip						
								$this->updateLastActionTime($u['User']['id']);
								return $this->redirect(array('controller'=>'teachers', 'action'=>'homepage'));		
							}
							
							//if lastip != current ip
							return $this->redirect(array(
								'controller'		=>	'teachers', 
								'action'			=>	'verifycodeConfirm',
								TeachersController::_REASON_LASTIP
							));
							break;
							
						case User::_TYPE_STUDENT:	 //if user is student										
							if($u["User"]["Status"] == User::_STATUS_LOGIN_LOCKED){//if student is locked		
								return $this->render('/Students/locked');
							}else{
								$this->updateLastActionTime($u['User']['id']);
								return $this->redirect(array('controller'=>'students', 'action'=>'homepage'));	
							}							
							break;
					}
					/* end of redirecting user */
				}else{	//if username is exist but password is wrong
					$WrongNum = 0;		//time of wrong password 	
					$max_time_wrong_password	= $this->loadMaxTimeWrongPassword();					
					
					if(!$this->Session->check('Login.WrongNum') || $this->Session->read('Login.id') !== $u['User']['id']){ //if not save Wrong time and Username
						/* Save Wrong time and Username	*/											
						$this->Session->write('Login.WrongNum', $WrongNum);
						$this->Session->write('Login.id', $u['User']['id']);
						/* End of Saving Wrong time and Username	*/
						
					}
											
					$WrongNum = $this->Session->read('Login.WrongNum')+1;
					
					if($u["User"]["UserType"]==User::_TYPE_TEACHER || $u["User"]["UserType"]==User::_TYPE_STUDENT){//if user is teacher or student						
						if($WrongNum>=$max_time_wrong_password){							
							//Lock user if being student or teacher	
							/* change status of user in database */							
							$this->lockUser($u["User"]["id"]);
							/* end of changing status of user in database */
							
							if($u['User']['UserType'] == User::_TYPE_TEACHER){
								$this->Session->write('User',$u["User"]);	//store user data in Session
							}
							
							/* load time of temp lock */
							$this->loadModel('SystemParam');
							
							$system_param = $this->SystemParam->find("first", array(
								'fields'		=>	array('Value'),
								'conditions'	=>	array(
									'ParamName'		=>	'TEMP_LOCK_TIME',
								)
							));
							/* end of loading time of temp lock */
							
							return $this->renderTempLocked($u['User']['UserType'], $system_param['SystemParam']['Value'], $max_time_wrong_password);							
						}else{
							//send message to teacher of student							
							$this->Session->write('Login.WrongNum', $WrongNum);
							$this->Session->setFlash(__("ユーザーとかパスワードは". $WrongNum . "/" . $max_time_wrong_password ."回が間違った。"));
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
	
	/**
	* delete Session and redirect to login
	*/
	function logout() {
		$this->Session->delete('User');
		return $this->redirect(array('controller'=>'users', 'action'=>'login'));
	}
	
	function notConfirm(){
		
	}
	
	function unTempLocked(){		
		if($this->Session->check('Login.WrongNum')&&$this->Session->check('Login.id')){
			$this->unlockUser($this->Session->read('Login.id'));
			$this->Session->delete('Login');
		}		
	}
	
	/**
	* render temp_locked view
	* @param undefined $userType:	user's type
	* @param undefined $temp_lock_time:	time of temp locking
	* @param undefined $max_time_wrong_password:	max time allowed to wrong password
	* 
	*/
	function renderTempLocked($userType, $temp_lock_time, $max_time_wrong_password=-1){
		//$this->autoRender = false;
		$this->set('temp_lock_time', $temp_lock_time);
		$this->set('max_time_wrong_password', $max_time_wrong_password);
		$this->set('UserType', $userType);	
		return $this->render('/Users/temp_locked');
	}
	
	/**
	* load max time allowed to wrong passwrod
	* @return
	* 	max time allowed to wrong passwrod
	*/
	function loadMaxTimeWrongPassword(){
		//$this->autoRender = false;
		
		$max_time_wrong_password = 5;
		/* get MAX_TIME_WRONG_PASSWORD from database and store into Session*/						
		if(!$this->Session->check('SystemParam.MAX_TIME_WRONG_PASSWORD')){
			$this->loadModel('SystemParam');
			$system_param = $this->SystemParam->find("first", array(
				'fields'		=>	array('Value'),
				'conditions'	=>	array(
					'ParamName'		=>	'MAX_TIME_WRONG_PASSWORD',
				)
			));
			
			if($this->SystemParam->getNumRows()>0){
				do{
					//Cache::write('MAX_TIME_WRONG_PASSOWRD', $system_param['SystemParam']['Value'], 'longterm');							
					$max_time_wrong_password = $system_param['SystemParam']['Value'];
					$this->Session->write('SystemParam.MAX_TIME_WRONG_PASSWORD', $max_time_wrong_password);
				}//while(!($max_time_wrong_password = Cache::read('MAX_TIME_WRONG_PASSOWRD', 'longterm')));
				while(!$this->Session->check('SystemParam.MAX_TIME_WRONG_PASSWORD'));
			}
		}else{
			$max_time_wrong_password = $this->Session->read('SystemParam.MAX_TIME_WRONG_PASSWORD');
		}					
		/* end of getting and storing MAX_TIME_WRONG_PASSWORD*/		
		return $max_time_wrong_password;
	}
	
	function lockUser($user_id, $lock_type=User::_STATUS_TEMP_LOCKED){	
		$this->User->id = $user_id;
		$this->User->save(array(
			"User"			=>	array(
				"Status"		=>	$lock_type,
				"LockTime"		=>	DboSource::expression('NOW()')//date ('Y-m-d H:i:s'),
			)
		));
	}
	
	/**
	* unlock a user by id
	* @param undefined $user_id
	* 
	*/
	function unlockUser($user_id){	
		$this->User->id = $user_id;
		$this->User->save(array(
			"User"			=>	array(
				"Status"		=>	User::_STATUS_NORMAL,
			)
		));
	}
	
	/**
	* delete a user by id
	* @param undefined $user_id
	* 
	*/
	function deleteUser($user_id){
		
	}
	
	/**
	* add a User to database
	* @param undefined $data: user's information
	* @param undefined $return_error: 
	* 		TRUE:	return error message if adding has error
	* 		FALSE:	return FALSE if adding has error
	* @param undefined $checkValidate
	* 		TRUE:	check validation of information before saving
	* 		FALSE:	skip checking validation
	* @return
	* 		TRUE: if adding success
	* 		else: 
	* 			array of error's message if $return_error is TRUE
	* 			FALSE if $return_error is FALSE 		
	*/
	function addUser($data, $return_error=false, $checkValidate=true){		
		if(!empty($data)){
			if(!isset($data['User']['FilterChar'])){
				$data['User']['FilterChar'] = User::createFilterChar();
			}
						
			$this->User->set($data);
			if($checkValidate){
				if($this->User->validateUser()){					
					$this->User->save($data);
					return $this->User->getInsertID();
				}else{
					if($return_error){
						return $this->User->validationErrors;	
					}				
					return FALSE;	
				}				
			}else{
				$this->User->save($data, array('validate' => false));
				return $this->User->getInsertID();
			}			
		}else{
			if($return_error){
				return array();
			}
			return FALSE;
		}
	}
	
	/**
	* check validate of a User's Information
	* @param undefined $data
	* @return
	* 	TRUE: if User's Information is validate
	* 	array of error's message: else
	*/
	function isValidate($data){
		if(!empty($data)){						
			$this->User->set($data);
			$error = $this->User->invalidFields();
			if(count($error)==0){			
				return TRUE;
			}else{				
				return $error;
			}			
		}else{
			return array();
		}
	}
}
?>