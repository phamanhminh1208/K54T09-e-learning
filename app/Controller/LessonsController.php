<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
App::import('Model', 'User');
App::import('Model', 'SystemDirectory');

class LessonsController extends AppController {

    var $name = 'Lessons';

    function view($lesson_id) {
        /* load lesson information */
        $this->Lesson->bindModel(array(
            'hasMany' => array(
                'LessonTag',
                'File',
                'Test',
                'LessonStudent' => array(
                    'conditions' => array(
                        'user_id' => $this->Session->read('User.id'),
                        'Time <= NOW()',
                        'EndTime >= NOW()'
                    )
                )
            )
        ));

        $conditions = array(
            'id' => $lesson_id
        );

        $con = compact('order', 'fields', 'joins', 'conditions', 'group', 'limit');

        $data = $this->Lesson->find("first", $con);
        /* end of loading lesson information */

        /* load comment */
        $this->loadModel('Comment');

        $this->Comment->bindModel(array(
            'belongsTo' => array(
                'User' => array(
                    'fields' => array(
                        'id', 'Username', 'RealName', 'UserType'
                    )
                )
            )
        ));

        $comments = $this->Comment->find("all", array(
            'order' => array(
                'Time' => 'DESC'
            ),
            'conditions' => array(
                'lesson_id' => $lesson_id
            )
        ));
        /* end of loading comment */

//            debug($comments);
//            debug($data);die;

        $this->set("comments", $comments);
        $this->set("data", $data);        
    }

    function add() {
        
    }

    function delete() {
        
    }

}

?>