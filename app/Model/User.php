<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

class User extends AppModel {

	var $name = 'User';
	
	var	$validate = array(
		"Username"			=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"ユーザーの入力がありませんでした。 ",
			),
			"rule2"				=>	array(
				"rule"				=>	"/^[a-z A-Z 0-9]{6,50}$/i",
				"message"			=>	"ユーザー名は６から５０文字があらなければなりない。"
			),
			"rule3"				=>	array(
				"rule"				=>	"checkUsername",
				"message"			=>	"このユーザー名は既に登録された。",
			),
		),
		"Password"			=>	array(),
		"RetypePass"		=>	array(),
		"RealName"			=>	array(),
		"Email"				=>	array(
			"rule"				=>	"email",
			"message"			=>	"Eメールのフォーマットが不正した。",
		),
		"Status"			=>	array(),
		"Birthday"			=>	array(),
		"FilterChar"		=>	array(),
		"Address"			=>	array(),
		"PhoneNum"			=>	array(),		
	);
	
	
	/**
	* check the validation of a User
	* @return
	* 	TRUE: user's information is validation
	* 	FALSE: else	* 
	*/
	public function validateUser(){
		if($this->validates($this->validate)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	/**
	* check unique username in database
	* @return
	* 	TRUE:	username hasn't used
	* 	FALSE:	username has used
	*/
	public function checkUsername(){
		if(isset($this->data[$this->name]['id'])){
			$condition = array(
					"conditions"	=>	array(
							"id !="		=>	$this->data[$this->name]['id'],
							"Username"	=>	$this->data[$this->name]['Username'],
					),
					"limit"			=>	1,
			);
		}else{
			$condition = array(
					"conditions"	=>	array(
							"Username"	=>	$this->data[$this->name]['Username'],
					),
					"limit"			=>	1,
			);
		}
	}
	
	/**
	* compare password and retype password
	* @return
	* 	TRUE:	password and retype password are same
	* 	FALSE:	else
	*/	
	public function comparePassword(){
		if($this->data[$this->name]['Password'] != $this->data[$this->name]['RetypePass']){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function hashPassword($data){
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		if(isset($this->data[$this->name]['Username']) && isset($this->data[$this->name]['Password'])){
			//$this->data[$this->name]['FilterChar'] = $characters[rand(0, strlen($characters) - 1)];
			$this->data[$this->name]['FilterChar'] = 'a';
			$this->data[$this->name]['Password'] = Security::hash($this->data[$this->name]['Password']. "+" .$this->data[$this->name]['Password']. "+" .$this->data[$this->name]['FilterChar'], NULL, TRUE);
			return $data;
		}
	}
}
?>