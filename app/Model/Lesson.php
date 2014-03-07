<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
class Lesson extends AppModel {

    var $name = 'Lesson';

    const _STATUS_NORMAL = 0;
    const _STATUS_LOCKED = 1;

    var $validate = array(
        "LessonName" => array(
            "rule1" => array(
                "rule" => "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9ａ-ｚＡ-Ｚ０-９々〆〤！：ﾞﾟ／ ]{0, 765}$/",
                "message" => "授業の名前は特定文字がある。"
            ),            
        ),
    );
}

?>