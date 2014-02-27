<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright 
* @license by MinhPA
**/

App::import('Controller', 'Users');
App::import('Model', 'User');

class StudentsController extends AppController {

	var $name= 'Students';
	
	function homepage() {
		
	}
	
	function locked(){
		
	}
	
	/**
	* register function
	* show the register view and save teacher's information after inputing
	*/
	
	function register(){
		$this->set("title_for_layout", "登録");	
		$this->loadModel('User');	
		
		if($this->request->is('post') && !empty($this->data)){		
			$data = array();
			$data['User'] = $this->data['Student'];
			$data['User']['FilterChar'] = User::createFilterChar();
			$data['User']['UserType'] = User::_TYPE_STUDENT;
			$data['Student'] = $data['User'];
			$data['Student']['LastIP'] = $this->request->clientIp();		
			
			if(!is_array($error_messages=$this->isValidate($data))){
				/* load UsersController */
				$Users = new UsersController;		    
			    $Users->constructClasses();
				/* end of loading UsersController */
				
				$inserted_id = $Users->addUser($data, false, false);	//save User
				unset($data['User']);				
				$data['Student']['user_id'] = $inserted_id;		//add user_id to Student
				
				/* save Student */
				$this->Student->set($data);				
				$this->Student->save($data, array('validate' => false));
				/* end of saving Student */
				//$this->redirect(array("controller" => "users", "action" => "registerSuccess"));
				$this->render('/Users/register_success');
								
			}else{				
				/* show error message for each field*/				
				foreach($error_messages as $key => $message){
					$this->Student->invalidate( $key, $message[0] );
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
			$this->Student->set($data);
			//$student_errors = array();
			$student_errors = $this->Student->invalidFields();
			/* end of getting teacher invalidation messages */
			
			if(count($student_errors)==0){
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