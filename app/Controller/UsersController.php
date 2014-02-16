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
			
			if($this->User->getNumRows() > 0){
				$password = sha1($this->request->data['User']['Username']. "+" .$this->request->data['User']['Password']. "+a");	
				if($password === $u["User"]["Password"]){
					if($this->Session->check('Login.WrongNum')){
						$this->Session->delete('Login');
					}
					$this->Session->write('User',$u["User"]);
								
					switch($this->Session->read('User.UserType')){
						case 1:
							return $this->redirect(array('controller'=>'managers', 'action'=>'homepage'));
							break;
						case 2:
							return $this->redirect(array('controller'=>'teachers', 'action'=>'homepage'));
							break;
						case 3:						
							return $this->redirect(array('controller'=>'students', 'action'=>'homepage'));
							break;
					}
				}else{
					if(!$this->Session->check('Login.WrongNum') || $this->Session->read('Login.Username') !== $this->request->data['User']['Username']){
						$this->Session->write('Login.WrongNum', 1);
						$this->Session->write('Login.Username', $this->request->data['User']['Username']);
					}else{						
						$WrongNum = $this->Session->read('Login.WrongNum')+1;
						if($WrongNum==3){//Lock user if being student or teacher
								
						}else{
							$this->Session->write('Login.WrongNum', $WrongNum);
						}						
					}
					$this->Session->setFlash(__('ユーザーとかパスワードがが間違った。'.$this->Session->read('Login.WrongNum')));		
				}
			}else{
				if($this->Session->check('Login.WrongNum')){
					$this->Session->delete('Login.WrongNum');	
				}				
				$this->Session->setFlash(__('ユーザーとかパスワードがが間違った。'));	
			}
		}
	}

	function logout() {
		$this->Session->delete('User');
		return $this->redirect(array('controller'=>'users', 'action'=>'login'));
	}

}
?>