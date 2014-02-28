<?php
/**
* @author 
* @website 
* @email 
* @copyright 
* @license 
**/

class Warning extends AppModel {

	var $name = 'Warning';
	
	public $validate = array(
			'WarnContent' => array(
					'rule1' => array(
							'rule' => 'notEmpty',
							"Message" => '理由はまだ入力されていない。',
					)
			),
	);
	
	var $belongsTo = array(
			'Lesson' => array(
					'className' => 'Lesson',
					'foreignKey' => 'WarnedLessonID',
					'conditions' => '',
					'order' => 'Warning.WarnTime DESC',
			)
	);
	
}
?>