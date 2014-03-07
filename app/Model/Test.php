<?php

/**
 * @author 
 * @website 
 * @email 
 * @copyright 
 * @license 
 * */
class Test extends AppModel {

    var $name = 'Test';

    const _STATUS_NORMAL = 0;
    const _STATUS_LOCKED = 1;

    var $validate = array(
        "TestName" => array(
            "rule1" => array(
                "rule" => "/^[一-龠ぁ-ゔァ-ヴーa-zA-Z0-9ａ-ｚＡ-Ｚ０-９々〆〤！：ﾞﾟ／ ]{0, 765}$/",
                "message" => "テストの名前は特定文字がある。"
            ),
        ),
    );

}

?>