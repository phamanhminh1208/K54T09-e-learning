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
App::uses('Log', 'Lib/Log');

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
        "Session"
    );
    var $helpers = array('Form', 'Html', 'Cache', 'Session');

    function beforeFilter() {
        $this->set("siteName", "E-Learning システム");
    }

    function updateLastActionTime() {
        $this->loadModel('User');
        $this->User->id = $this->Session->read('User.id');
        $this->User->save(array(
            "User" => array(
                "LastActionTime" => DboSource::expression('NOW()')//date ('Y-m-d H:i:s'),
            )
        ));
    }

    function checkPermission($user_type) {
        if (is_array($user_type)) {
            if ($this->Session->check('User') && !in_array($this->Session->read('User.UserType'), $user_type)) {
                $this->set("title_for_layout", "エラー");
                return $this->render('/Errors/permission_denied');
            }
        } else {
            if ($this->Session->check('User') && $this->Session->read('User.UserType') != $user_type) {
                $this->set("title_for_layout", "エラー");
                return $this->render('/Errors/permission_denied');
            }
        }
    }
    
    function checkTimeOut(){
        $this->loadModel('User');
        $timeout = $this->User->query("SELECT system_params.Value 
                                        FROM system_params, users 
                                        WHERE TIME_TO_SEC( TIMEDIFF( NOW( ) , users.LastActionTime ) ) > system_params.Value 
                                        AND system_params.ParamName = 'AUTO_LOGOUT_TIME' 
                                        AND users.id =".$this->Session->read('User.id'));
        if($this->User->getNumRows()>0){
            $this->set("title_for_layout", "エラー");
            $this->set('timeout', $timeout[0]['system_params']['Value']);
            return $this->render('/Errors/timeout');
        }
    }
    
    function throwFileException(){
        $exception = error_get_last();
        if(isset($exceptionp['file'])){
            throw new FileAccessException($exception['file'], $exception['message']);
        }
    }

    function writeLog($content = array()){
        if(!empty($content) && isset($content['type'])){
            $log = $this->name. "->" .$content['function'] . "\t".
                    ((isset($content['performer']))?(isset($content['performer'])):($this->Session->read('User.Username'))) . "\t";
            if($content['objectType']!=Log::_OBJECT_NULL){
                $log .= $content['objectType'] . "[" . $content['object'] . "]" . "\t";
            }else{
                $log .= Log::_OBJECT_NULL."\t";
            }
                    
            $log .= ((isset($content['content']))?($content['content']."\t"):"NULL\t").
                    $content['status'];
            
            Log::write($content['type'], $log);
        }        
    }
}
