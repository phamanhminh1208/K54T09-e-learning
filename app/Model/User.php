<?php

/**
 * @author MinhPA
 * @website 
 * @email phamanhminh1208@gmail.com
 * @copyright by MinhPA
 * @license 
 * */
class User extends AppModel {

    var $name = 'User';

    const _STATUS_TEMP_LOCKED = 1;
    const _STATUS_NORMAL = 2;
    const _STATUS_NOT_ACTIVE = 3;
    const _STATUS_LOGIN_LOCKED = 4;
    const _TYPE_MANAGER = 1;
    const _TYPE_TEACHER = 2;
    const _TYPE_STUDENT = 3;
    const _REGEX_FULLWITH = "[一-龠あ-ゔア-ヴーａ-ｚＡ-Ｚ０-９！：／々〆〤]{1,}";
    const _REGEX_ADDRESS = "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9 ａ-ｚＡ-Ｚ０-９々〆〤！：／ﾞﾟ]{0,256}$/";
    const _REGEX_REALNAME = "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9 ａ-ｚＡ-Ｚ０-９々〆〤！：／ﾞﾟ]{0,128}$/";

    var $validate = array(
        "Username" => array(
            "rule1" => array(
                "rule" => array("notEmpty"),
                "message" => "ユーザー名の入力がありませんでした。",
            ),
            "rule2" => array(
                "rule" => "/^[a-z A-Z 0-9]{6,36}$/i",
                "message" => "ユーザー名は６から５０文字があらなければなりない。"
            ),
            "rule3" => array(
                "rule" => "checkUsername",
                "message" => "このユーザー名は既に登録された。",
            ),
        ),
        "Password" => array(
            "rule1" => array(
                "rule" => array("notEmpty"),
                "message" => "初期パスワードの入力がありませんでした。",
            ),
            "rule2" => array(
                "rule" => "/^[a-zA-Z0-9 !@#$%^*()_+}{:;'?]{6,50}$/",
                "message" => "初期パスワードは６から５０文字があらなければなりない。",
            )
        ),
        "RetypePass" => array(
            "rule1" => array(
                "rule" => array("notEmpty"),
                "message" => "再入力パスワードの入力がありませんでした。",
            ),
            "rule2" => array(
                "rule" => "comparePassword",
                "message" => "初期パスワードと再入力パスワードは違った。",
            )
        ),
        "RealName" => array(
            "rule1" => array(
                "rule" => "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9ａ-ｚＡ-Ｚ０-９々〆〤！：ﾞﾟ／ ]{0,384}$/",
                "message" => "氏名は　全角６４桁以内 か 半角１２８桁以内だ。"
            ),
            "rule2" => array(
                "rule" => "validateRealname",
                "message" => "氏名は　全角６４桁以内 か 半角１２８桁以内だ。"
            ),
        ),
        "Email" => array(
            "rule" => "email",
            "message" => "Eメールのフォーマットが不正した。",
            'allowEmpty' => true
        ),
        "Status" => array(
            "rule" => array("between", 1, 3),
            "message" => "",
        ),
        "Birthday" => array(
            "rule" => array("date", "ymd"),
            "message" => "生年月日のフォーマットが不正した。",
            'allowEmpty' => true
        ),
        //"FilterChar"		=>	array(),
        "Address" => array(
            "rule1" => array(
                "rule" => "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9ａ-ｚＡ-Ｚ０-９々〆〤！：ﾞﾟ／ ]{0,768}$/",
                "message" => "住所は　全角１２８桁以内 か 半角２５６桁以内だ。"
            ),
            "rule2" => array(
                "rule" => "validateAddress",
                "message" => "住所は　全角１２８桁以内 か 半角２５６桁以内だ。"
            ),
        //'allowEmpty' 		=> 	true
        ),
        "PhoneNum" => array(
            /* "rule"				=>	array("notEmpty"),
              "message"			=>	"電話番号の入力がありませんでした。" */
            "rule" => "/^[0-9]{3}-[0-9]{4}-[0-9]{4}[0-9 -]{0,11}$/",
            "message" => "電話番号のフォーマットが不正した。",
            "allowEmpty" => true
        ),
    );

    /**
     * check the validation of a User
     * @return
     * 	TRUE: user's information is validation
     * 	FALSE: else	* 
     */
    public function validateUser() {
        if ($this->validates($this->validate)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * check unique username in database
     * @return
     * 	TRUE:	username hasn't used
     * 	FALSE:	username has used
     */
    public function checkUsername() {
        if (isset($this->data[$this->name]['id'])) {
            $condition = array(
                "conditions" => array(
                    "id !=" => $this->data[$this->name]['id'],
                    "Username" => $this->data[$this->name]['Username'],
                ),
                "limit" => 1,
            );
        } else {
            $condition = array(
                "conditions" => array(
                    "Username" => $this->data[$this->name]['Username'],
                ),
                "limit" => 1,
            );
        }

        $this->find("first", $condition);
        $count = $this->getNumRows();
        if ($count > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * compare password and retype password
     * @return bool TRUE:    password and retype password are same
     */
    public function comparePassword() {
        if ($this->data[$this->name]['Password'] !== $this->data[$this->name]['RetypePass']) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * check validation of Addresss
     * @return bool TRUE:    Address is validation
     */
    public function validateAddress() {
        $leng = mb_strlen($this->data[$this->name]['Address']);
        if ($leng > 256) {
            return FALSE;
        } else if ($leng > 128) {
            if (mb_ereg(self::_REGEX_FULLWITH, $this->data[$this->name]['Address']) !== false) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * check validation of Realname
     * @return bool TRUE:    Realname is validation
     */
    public function validateRealname() {
        $leng = mb_strlen($this->data[$this->name]['RealName']);
        if ($leng > 128) {
            return FALSE;
        } else if ($leng > 64) {
            if (mb_ereg(self::_REGEX_FULLWITH, $this->data[$this->name]['RealName']) !== false) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * create a random FilterChar
     * @return char FilterChar
     */
    static function createFilterChar() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $characters[rand(0, strlen($characters) - 1)];
    }

    /**
     * encode password by using sha1
     * @param $data array   user information
     * @return array
     */
    function hashPassword($data) {       
        if (!$this->id && !isset($this->data[$this->name]['id'])) {
            if (!isset($this->data[$this->name]['FilterChar'])) {
                $this->data[$this->name]['FilterChar'] = self::createFilterChar();
            }
            if (isset($this->data[$this->name]['Username']) && isset($this->data[$this->name]['Password']) && isset($this->data[$this->name]['FilterChar'])) {

                $this->data[$this->name]['Password'] = sha1($this->data[$this->name]['Username'] . "+" . $this->data[$this->name]['Password'] . "+" . $this->data[$this->name]['FilterChar']);

                $this->data[$this->name]['FirstPass'] = $this->data[$this->name]['Password'];

                return $data;
            }
        }
    }

    function beforeSave($option = array()) {
        $this->hashPassword(NULL, TRUE);
    }

}

?>