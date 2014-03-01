<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

class Teacher extends AppModel {

	var $name = 'Teacher';
	
	
	var $validate 		=	array(
		"BankAccount"		=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"クレジットカード情報の入力がありませんでした。"
			),
			"rule2"				=>	array(
				"rule"				=>	"/^[0-9]{4}-[0-9]{3}-[0-9]{1}-[0-9]{7}$/i",
				"message"			=>	"クレジットカード情報のフォーマットが不正した。"
			)
		)
	);
	
	/**
	* check the validation of a Teacher
	* @return
	* 	TRUE: user's information is validation
	* 	FALSE: else	* 
	*/
	public function validateTeacher(){
		if($this->validates($this->validate)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

    /**
     * encode Answer by using sha1
     * @param $data array   teacher information
     * @return array
     */
    function hashVerifycode($data){
		if(isset($this->data[$this->name]['user_id']) && isset($this->data[$this->name]['Username']) && isset($this->data[$this->name]['FilterChar']) && isset($this->data[$this->name]['NAnswer'])){		
			
			$this->data[$this->name]['Answer'] = sha1($this->data[$this->name]['Username']. "+" .$this->data[$this->name]['NAnswer']. "+" .$this->data[$this->name]['FilterChar']);
			
			$this->data[$this->name]['FirstAnswer'] = $this->data[$this->name]['Answer'];
			
			return $data;
		}
	}
	
	function beforeSave($option=array()){
		$this->hashVerifycode(NULL, TRUE);
	}
}
?>