<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
class File extends AppModel {

    var $name = 'File';

    const _STATUS_NORMAL = 0;
    const _STATUS_LOCKED = 1;

    var $validate = array(
        "FileName" => array(
            "rule1" => array(
                "rule" => "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9ａ-ｚＡ-Ｚ０-９々〆〤！：ﾞﾟ／ ]{0, 765}$/",
                "message" => "ファイルの名前は特定文字がある。"
            ),
        ),
    );

}

?>