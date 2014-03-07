<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
class TestsController extends AppController {

    var $name = 'Tests';

    const _STATUS_NORMAL = 0;
    const _STATUS_LOCKED = 1;

    function add() {
        
    }

    function delete($test_id = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('post')) {
            if ($this->request->data['test_id'] != "") {
                $file = $this->Test->find("first", array(
                    'conditions' => array(
                        'id' => $this->request->data['test_id']
                    )
                ));

                $this->loadModel('SystemDirectory');
                $direcs = $this->SystemDirectory->find("first", array(
                    'conditions' => array(
                        'DirectoryName' => array(
                            'tests'
                        )
                    ),
                ));

                if (unlink(SystemDirectory::_FILE_LINK . DIRECTORY_SEPARATOR . $direcs['SystemDirectory']['Value'] . DIRECTORY_SEPARATOR . SystemDirectory::_TSV_LINK . DIRECTORY_SEPARATOR . $file['Test']['LinkTsv']) &&
                        unlink(SystemDirectory::_FILE_LINK . DIRECTORY_SEPARATOR . $direcs['SystemDirectory']['Value'] . DIRECTORY_SEPARATOR . SystemDirectory::_HTML_LINK . DIRECTORY_SEPARATOR . $file['Test']['LinkHtml'])) {
                    $this->Test->id = $this->request->data['test_id'];
                    if ($this->Test->delete()) {
                        return "true";
                    } else {
                        return "false";
                    }
                    return "true";
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