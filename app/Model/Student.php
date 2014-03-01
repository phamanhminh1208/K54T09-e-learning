<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright 
* @license by MinhPA
**/

class Student extends AppModel {

	var $name = 'Student';
	
	var $validate 		=	array(
		"CreditCardNum"		=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"クレジットカード情報の入力がありませんでした。"
			),
			"rule2"				=>	array(
				"rule"				=>	"/^[0-9]{8}-[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/i",
				"message"			=>	"クレジットカード情報のフォーマットが不正した。"
			)
		)
	);
	
	/**
	* check the validation of a Student
	* @return
	* 	TRUE: user's information is validation
	* 	FALSE: else	* 
	*/
	public function validateStudent(){
		if($this->validates($this->validate)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>