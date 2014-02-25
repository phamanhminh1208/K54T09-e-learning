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
	const		_REASON_LOCKED			=	'locked';
	
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
				
		if($this->Session->check('User.id') && $reason!=null){
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
					}elseif($reason == self::_REASON_LOCKED){
						/* unlock this user */
						$Users = new UsersController;
						$Users->constructClasses();
						$Users->unlockUser($this->Session->read('User.id'));
						/* end of unlocking user */
					}
					
					
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
	* 
	*/
	
	function register(){
		$this->set("title_for_layout", "登録");		
		
		if($this->request->is('post') && !empty($this->data)){
			$this->loadModel('User');
			/* load UsersController */
			$Users = new UsersController;		    
		    $Users->constructClasses();
			/* end of loading UsersController */			
			
			$data = array();
			$data['User'] = $this->data['Teacher'];
			$data['User']['FilterChar'] = User::createFilterChar();
			$data['User']['UserType'] = User::_TYPE_TEACHER;
			
			if(!is_array($inserted_id=$Users->addUser($data, true))){//when inserting into users table success		
				$data['Teacher'] = $data['User'];
				unset($data['User']);
				$data['Teacher']['LastIP'] = $this->request->clientIp();
				$data['Teacher']['user_id'] = $inserted_id;					
				
				$this->Teacher->set($data);				
				
				if($this->Teacher->validateTeacher()){
					$this->Teacher->save($data);
					
					$this->redirect(array("controller" => "teachers", "action" => "registerSuccess"));
				}				
			}else{
				/* show error message for each field*/				
				foreach($inserted_id as $key => $message){
					$this->Teacher->invalidate( $key, $message[0] );
				}
			}			
		}		
	}
	
	function registerSuccess(){
		$this->set("title_for_layout", "登録が成功した");
		$this->render();
	}
}
?>