<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $components = array(
		"Session",		
	);
	
	var $helpers = array('Form', 'Html');
	
	function beforeFilter(){		
		$this->set("siteName", "E-Learning システム");
	}
	
	function updateLastActionTime($user_id){
		$this->loadModel('User');
		$this->User->id = $user_id;
		$this->User->save(array(
			"User"			=>	array(				
				"LastActionTime"		=>	DboSource::expression('NOW()')//date ('Y-m-d H:i:s'),
			)
		));
	}
	
	function checkPermission($user_type){
		if($this->Session->check('User') && $this->Session->read('User.UserType')!=$user_type){
			return $this->render('/Errors/permission_denied');
		}		
	}
}
