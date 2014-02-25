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
	
	
	function validateTeacher(){
		return TRUE;
	}
	
	
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