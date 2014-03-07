<?php

/**
 * @author MinhPA
 * @website 
 * @email phamanhminh1208@gmail.com
 * @copyright by MinhPA
 * @license 
 * */
App::import('Model', 'User');

class ManagersController extends AppController {

    var $name = 'Managers';
    var $layout = "default";
    var $helpers = array("Session");
    var $cacheAction = array(
    );

    function homepage() {
        
    }

    function backup() {
        
    }

    function cancelAccess() {
        
    }

    function add() {
        $this->set("title_for_layout", "管理者追加");

        $this->checkPermission(User::_TYPE_MANAGER);

        if ($this->request->is('post') && !empty($this->data)) {
            $this->loadModel('User');

            $data = $this->request->data;
            $data['User']['UserType'] = 1;
            $data['User']['Status'] = 2;

            $user = $this->User->save($data);
            if (!empty($user)) {
                $this->request->data['Manager']['user_id'] = $this->User->id;
                $this->Manager->save($this->request->data);
                return $this->redirect(array("controller" => "managers", "action" => "addSuccess"));
            }
        }
    }

    function addSuccess() {
        $this->render();
    }

}

?>