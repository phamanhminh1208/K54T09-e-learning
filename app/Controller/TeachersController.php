<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

App::import('Controller', 'Users');
App::import('Model', 'User');

class TeachersController extends AppController {

	var $name= 'Teachers';
	
	const		_REASON_LASTIP			=	'lastip';
	const		_REASON_TEMP_LOCKED		=	'locked';
	
	function homepage() {
		
	}

	function listTeacher() {
		
	}
	
	/**
	* verifycodeConfirm function
	* 	get verifycode from a teacher and confirm this
	* @param undefined $reason: define why need verifycode
	* 
	*/
	function verifycodeConfirm($reason=null){
				
		if($this->Session->check('User.id') && $reason!=null && ($reason==self::_REASON_LASTIP || $reason==self::_REASON_TEMP_LOCKED)){
			$this->set("title_for_layout", "Verifycode確認");
			
			if($this->request->is('post')){ //if answer is entered
				/* encode answer */
				$answer = sha1($this->Session->read('User.Username'). "+" .$this->request->data['Teacher']['Answer']. "+" .$this->Session->read('User.FilterChar'));
				/* end of endcoding answer */
				
				/* check answer */
				$id = $this->Teacher->find("first", array(
					'fields'		=>	'id',
					'conditions'	=>	array(
						'user_id'		=>	$this->Session->read('User.id'),
						'Answer'		=>	$answer,
					)
				));
				
				if($this->Teacher->getNumRows()>0){	//if answer is correct					
					if($reason == self::_REASON_LASTIP){
						/* save new ip */
						$this->Teacher->id = $id['Teacher']['id'];
						$this->Teacher->save(array(
							"Teacher"	=>	array(
								"LastIP"		=>	$this->request->clientIp(),
							)
						));						
						
						/* end saving new ip */
					}else if($reason == self::_REASON_TEMP_LOCKED){
						/* unlock this user */
						$Users = new UsersController;
						$Users->constructClasses();
						$Users->unlockUser($this->Session->read('User.id'));
						/* end of unlocking user */
						
						/* delete Login session */
						if($this->Session->check('Login.WrongNum')){
							$this->Session->delete('Login');
						}						
						
						/* end of deleting Login session */
					}					
					
					$this->updateLastActionTime($this->Session->read('User.id'));
					
					$this->redirect(array(
						'controller'		=>	'teachers',
						'action'			=>	'homepage'
					));
				}else{ //if answer is incorrect
					$this->Session->setFlash(__('秘密の答えは正しくない。'));					
				}
				/* end of check answer */			
				//$this->render();
			}
							
			$question = $this->Teacher->find("first", array(
				'fields'		=>	'SecretQuestion',
				'conditions'	=>	array(
					'user_id'		=>	$this->Session->read('User.id')
				)
			));
			if($this->Teacher->getNumRows()>0){
				$this->set('data',$question);	
			}
						
		}else{
			$this->redirect(array(
				'controller'		=>	'users',
				'action'			=>	'login',
			));
		}
	}
	
	/**
	* register function
	* show the register view and save teacher's information after inputing
	*/
	
	function register(){
		$this->set("title_for_layout", "登録");			
		
		if($this->request->is('post') && !empty($this->data)){		
			$data = array();
			$data['User'] = $this->data['Teacher'];
			$data['User']['FilterChar'] = User::createFilterChar();
			$data['User']['UserType'] = User::_TYPE_TEACHER;
			$data['Teacher'] = $data['User'];
			$data['Teacher']['LastIP'] = $this->request->clientIp();		
			
			if(!is_array($error_messages=$this->isValidate($data))){
				/* load UsersController */
				$Users = new UsersController;		    
			    $Users->constructClasses();
				/* end of loading UsersController */
				
				$inserted_id = $Users->addUser($data, false, false);	//save User
				unset($data['User']);				
				$data['Teacher']['user_id'] = $inserted_id;		//add user_id to Teacher
				
				/* save Teacher */
				$this->Teacher->set($data);				
				$this->Teacher->save($data, array('validate' => false));
				/* end of saving Teacher */
				$this->redirect(array("controller" => "users", "action" => "registerSuccess"));
								
			}else{				
				/* show error message for each field*/				
				foreach($error_messages as $key => $message){
					$this->Teacher->invalidate( $key, $message[0] );
				}
				/* end of showing error message for each field*/		
			}			
		}		
	}
	
	/**
	* check validate of a Teacher's Information
	* @param undefined $data
	* @return
	* 	TRUE: if Teacher's Information is validate
	* 	array of error's message: else
	*/
	function isValidate($data){	
		if(!empty($data)){
			/* load UsersController */
			$Users = new UsersController;		    
		    $Users->constructClasses();
			/* end of loading UsersController */			
		
			$user_errors=$Users->isValidate($data);	//get user invalidation messages
			
			/* get teacher invalidation messages */
			$this->Teacher->set($data);
			//$teacher_errors = array();
			$teacher_errors = $this->Teacher->invalidFields();
			/* end of getting teacher invalidation messages */
			
			if(count($teacher_errors)==0){
				if(!is_array($user_errors)){
					return TRUE;
				}else{
					return $user_errors;
				}
			}else{
				if(!is_array($user_errors)){
					return array();
				}else{
					return $user_errors;
				}				
			}			
		}else{
			return array();
		}
	}
}
?>