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
		
		$systemParams = $this->loadSystemParams();
		
		if($systemParams !== FALSE){	//get param success		
			
			/* show temp_locked view if being temp locking */
			if($this->Session->check('TempLocked.LockTime')){	// if being temp locking 				
				$lockedTime = $systemParams['TEMP_LOCK_TIME']-(time()-$this->Session->read('TempLocked.LockTime'));
				debug($lockedTime);
				if($lockedTime>0){
					return $this->renderTempLocked(-1, $lockedTime);
				}else{
					$this->Session->delete('TempLocked');					
					$this->redirect(array(
						'controller'	=>	'users',
						'action'		=>	'login'
					));
				}
			}
			/* end of showing temp_locked view if being temp locking */			
			
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
						$this->Session->write('User',$u["User"]);	//store user data in Session
						
						$inLockTime = $this->User->query("SELECT TIME_TO_SEC(TIMEDIFF(SEC_TO_TIME(`system_params`.`value`) , TIMEDIFF(now(),`users`.`LockTime`))) as time  
											FROM `system_params`,`users`
											WHERE `system_params`.ParamName = 'TEMP_LOCK_TIME' 
											  AND `users`.`id` = '".$u["User"]["id"]."' 
											  AND TIME_TO_SEC(TIMEDIFF(now(),`users`.`LockTime`))<`system_params`.`value`");		
										
						if(isset($inLockTime[0])){	//if in locking time
							return $this->renderTempLocked($u["User"]["UserType"], $inLockTime[0][0]['time']);
						}else{
							if($u["User"]['UserType']==User::_TYPE_TEACHER){
								return $this->redirect(array(
									'controller'	=>	'teachers',
									'action'		=>	'verifycodeConfirm',
									TeachersController::_REASON_TEMP_LOCKED
								));
							}else if($u['User']['UserType']==User::_TYPE_STUDENT){
								return $this->redirect(array(
									'controller'	=>	'users',
									'action'		=>	'login',								
								));
							}
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
						
						if(!$this->Session->check('Login.WrongNum') || !$this->Session->check('Login.id') || $this->Session->read('Login.id') !== $u['User']['id']){ //if not save Wrong time and Username
							/* Save Wrong time and Username	*/											
							$this->Session->write('Login.WrongNum', $WrongNum);
							$this->Session->write('Login.id', $u['User']['id']);
							/* End of Saving Wrong time and Username	*/			
						}
												
						$WrongNum = $this->Session->read('Login.WrongNum')+1;
						
						if($u["User"]["UserType"]==User::_TYPE_TEACHER || $u["User"]["UserType"]==User::_TYPE_STUDENT){//if user is teacher or student						
							if($WrongNum >= $systemParams['MAX_TIME_WRONG_PASSWORD']){							
								//Lock user if being student or teacher	
								/* change status of user in database */							
								$this->lockUser($u["User"]["id"]);
								/* end of changing status of user in database */
								
								if($u['User']['UserType'] == User::_TYPE_TEACHER){
									$this->Session->write('User',$u["User"]);	//store user data in Session
								}						
								
								return $this->renderTempLocked($u['User']['UserType'], $systemParams['TEMP_LOCK_TIME'], $systemParams['MAX_TIME_WRONG_PASSWORD']);							
							}else{
								//send message to teacher of student							
								$this->Session->write('Login.WrongNum', $WrongNum);
								$this->Session->setFlash(__("ユーザーとかパスワードは". $WrongNum . "/" . $systemParams['MAX_TIME_WRONG_PASSWORD'] ."回が間違った。"));
							}						
						}else{
							//send message to manager
							$this->Session->setFlash(__("ユーザーとかパスワードが間違った。"));
						}
					}
				}else{//username is not exist					
					if($this->Session->check('Login.WrongNum') && !$this->Session->check('Login.id')){
						$WrongNum = $this->Session->read('Login.WrongNum')+1;						
					}else if(!$this->Session->check('Login.WrongNum') && !$this->Session->check('Login.id')){
						$WrongNum = 1;
					}else if($this->Session->check('Login.id')){
						$WrongNum = 1;
						$this->Session->delete('Login');
					}
					
					$this->Session->write('Login.WrongNum',$WrongNum);							
					
					if($WrongNum>=$systemParams['MAX_TIME_WRONG_PASSWORD']){						
						$this->Session->write('TempLocked.LockTime',time());
						return $this->renderTempLocked(-1, $systemParams['TEMP_LOCK_TIME'], $systemParams['MAX_TIME_WRONG_PASSWORD']);
					}else{
						$this->Session->setFlash(__("ユーザーとかパスワードは". $WrongNum . "/" . $systemParams['MAX_TIME_WRONG_PASSWORD'] ."回が間違った。"));	
					}			
				}
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
		}
		$this->Session->delete('Login');
	}
	
	/**
	* render temp_locked view
	* @param int $userType:	user's type
	* @param int $temp_lock_time:	time of temp locking in second
	* @param int $max_time_wrong_password:	max time allowed to wrong password
	* 
	*/
	function renderTempLocked($userType, $temp_lock_time, $max_time_wrong_password=-1){
		//$this->autoRender = false;
		$this->set('temp_lock_time', $temp_lock_time);
		$this->set('max_time_wrong_password', $max_time_wrong_password);
		$this->set('UserType', $userType);	
		return $this->render('/Users/temp_locked');
	}
	
	function loadSystemParams(){
		$this->loadModel('SystemParam');
		
		$paramNames = array(
			'TEMP_LOCK_TIME', 
			'MAX_TIME_WRONG_PASSWORD'
		);
		
		$sys = $this->SystemParam->find("all", array(
			'fileds'		=>	'Value',
			'conditions'	=>	array(
				'ParamName'		=>	$paramNames
			)
		));		
		
		if($this->SystemParam->getNumRows()>0){
			return array(
				'TEMP_LOCK_TIME'			=>	$sys[1]['SystemParam']['Value'],
				'MAX_TIME_WRONG_PASSWORD'	=>	$sys[0]['SystemParam']['Value'],
			);
		}else{
			return FALSE;
		}
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
	* @param int $user_id
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
	* @param int $user_id
	* 
	*/
	function deleteUser($user_id){
		
	}

	/**
	* add a User to database
	* @param array $data: user's information
	* @param boolean $return_error:
	* 		TRUE:	return error message if adding has error
	* 		FALSE:	return FALSE if adding has error
	* @param boolean $checkValidate
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
	* @param array $data user information
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