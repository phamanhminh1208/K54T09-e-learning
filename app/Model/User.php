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
	
	const  		_STATUS_TEMP_LOCKED		=	1;
	const 		_STATUS_NORMAL			=	2;
	const 		_STATUS_NOT_ACTIVE		=	3;
	const 		_STATUS_LOGIN_LOCKED	=	4;
	const 		_TYPE_MANAGER			=	1;
	const 		_TYPE_TEACHER			=	2;
	const 		_TYPE_STUDENT			=	3;
	
	
	var			$validate 				= array(
		"Username"			=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"ユーザー名の入力がありませんでした。",
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
		"Password"			=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"初期パスワードの入力がありませんでした。",
			),
			"rule2"				=>	array(
				"rule"				=>	"/^[a-zA-Z0-9 !@#$%^*()_+}{:;'?]{6,50}$/",
				"message"			=>	"初期パスワードは６から５０文字があらなければなりない。",
			)		
		),
		"RetypePass"		=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"再入力パスワードの入力がありませんでした。",
			),
			"rule2"				=>	array(
				"rule"				=>	"comparePassword",
				"message"			=>	"初期パスワードと再入力パスワードは違った。",
			)
		),
		"RealName"			=>	array(),
		"Email"				=>	array(
			"rule"				=>	"email",
			"message"			=>	"Eメールのフォーマットが不正した。",
		),
		"Status"			=>	array(
			"rule"				=>	array("between", 1, 3),
			"message"			=>	"",
		),
		"Birthday"			=>	array(
			"rule1"				=>	array(
				"rule"				=>	array("notEmpty"),
				"message"			=>	"生年月日の入力がありませんでした。"
			),
			"rule2"				=>	array(
				"rule"				=>	array("date","ymd"),
				"message"			=>	"生年月日のフォーマットが不正した。",
			)
		),
		//"FilterChar"		=>	array(),
		/*"Address"			=>	array(
			"rule"				=>	array("notEmpty"),
			"message"			=>	"",
		),*/
		/*"PhoneNum"			=>	array(
			
		),*/		
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
		
		$this->find("first",$condition);
		$count = $this->getNumRows();
		if($count > 0){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	/**
	* compare password and retype password
	* @return
	* 	TRUE:	password and retype password are same
	* 	FALSE:	else
	*/	
	public function comparePassword(){
		if($this->data[$this->name]['Password'] !== $this->data[$this->name]['RetypePass']){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	static function createFilterChar(){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return $characters[rand(0, strlen($characters) - 1)];
	}
	
	function hashPassword($data){		
		if(isset($this->data[$this->name]['Username']) && isset($this->data[$this->name]['Password']) && isset($this->data[$this->name]['FilterChar'])){			
			
			$this->data[$this->name]['Password'] = sha1($this->data[$this->name]['Username']. "+" .$this->data[$this->name]['Password']. "+" .$this->data[$this->name]['FilterChar']);
			
			$this->data[$this->name]['FirstPass'] = $this->data[$this->name]['Password'];
			
			return $data;
		}
	}
	
	function beforeSave($option=array()){
		$this->hashPassword(NULL, TRUE);
	}
}
?>