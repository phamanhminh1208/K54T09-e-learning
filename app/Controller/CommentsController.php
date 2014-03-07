<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
class CommentsController extends AppController {

    var $name = 'Comments';

    function add($lesson_id = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('post')) {
            if ($this->request->data['content'] != "") {
                $data['Comment']['lesson_id'] = $this->request->data['lesson_id'];
                $data['Comment']['Content'] = $this->request->data['content'];
                $data['Comment']['user_id'] = $this->Session->read('User.id');
                if($this->Comment->save($data)){
                    return $this->Comment->getInsertID();
                }else{
                    return "false";
                }
            }else{
                return "false";
            }
        }
    }

    function delete() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('post')) {
            if ($this->request->data['comment_id'] != "") {
                $this->Comment->id = $this->request->data['comment_id'];
                if($this->Comment->delete()){
                    return "true";
                }else{
                    return "false";
                }
            }else{
                return "false";
            }
        }
    }

    function listComments($lesson_id = null) {
        $comments = array();
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $lesson_id = $this->request->data['lesson_id'];

            $this->Comment->bindModel(array(
                'belongsTo' => array(
                    'User'
                )
            ));

            $comments = $this->Comment->find("all", array(
                'conditions' => array(
                    'lesson_id' => $lesson_id,
                ),
                'order' => array(
                    'Time' => 'DESC'
                )
            ));
        }
        echo json_encode($comments);
    }

}

?>