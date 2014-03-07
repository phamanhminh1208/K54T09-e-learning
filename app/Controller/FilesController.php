<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
App::uses('Model', 'SystemDirectory');

class FilesController extends AppController {

    var $name = 'Files';

    const _STATUS_NORMAL = 0;
    const _STATUS_LOCKED = 1;

    function add() {
        
    }

    function delete($file_id = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('post')) {
            if ($this->request->data['file_id'] != "") {
                $file = $this->File->find("first", array(
                    'conditions' => array(
                        'id' => $this->request->data['file_id']
                    )
                ));

                $this->loadModel('SystemDirectory');
                $direcs = $this->SystemDirectory->find("first", array(
                    'conditions' => array(
                        'DirectoryName' => array(
                            'learns'
                        )
                    ),
                ));

                if (unlink(SystemDirectory::_FILE_LINK . DIRECTORY_SEPARATOR . $direcs['SystemDirectory']['Value'] . DIRECTORY_SEPARATOR . $file['File']['Link'])) {
                    $this->File->id = $this->request->data['file_id'];
                    if ($this->File->delete()) {
                        return "true";
                    } else {
                        return "false";
                    }
                } else {
                    return "false";
                }
            } else {
                return "false";
            }
        }
        return "false";
    }

}

?>