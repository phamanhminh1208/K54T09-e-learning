<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Log extends Object {
    //Log's folder
    const _LOG_FOLDER       = 'Logs';
    
    //Log's type
    const _TYPE_INFO        = 'INFO';
    const _TYPE_WARNING     = 'WARNING';
    const _TYPE_ERROR       = 'ERROR';
    //Log's status
    const _STATUS_START     = 'START';
    const _STATUS_SUCCESS   = 'SUCCESS';
    const _STATUS_CANCEL    = 'CANCEL';
    const _STATUS_ERROR     = 'ERROR';

    //Log's Object type
    const _OBJECT_USER      = 'USER';
    const _OBJECT_LINK      = 'LINK';
    const _OBJECT_LESSON    = 'LESSON';
    const _OBJECT_TEST      = 'TEST';
    const _OBJECT_FILE      = 'FILE';
    const _OBJECT_NULL      = 'NULL';
    const _OBJECT_SQL       = 'SQL';
    const _OBJECT_CONSTANT  = 'CONSTANT';
    const _OBJECT_IP        = 'IP';
    
    //Log's system performer
    const _PERFORMER_SYSTEM = 'SYSTEM';
    
    public static function write($type, $message){
        $now = new DateTime();

        $log_folder = self::_LOG_FOLDER . DIRECTORY_SEPARATOR . $now->format('Y-m');
        if (!file_exists($log_folder . "/")) {
            mkdir($log_folder, 0777);
        }

        $filename = $log_folder . DIRECTORY_SEPARATOR . $now->format("Y-m-d") . ".log";       
        
        $output = $now->format('Y-m-d H:i:s') . "\t" . $type . "\t" . $message . PHP_EOL;
        
        if(!file_exists($filename)){
            file_put_contents($filename, "TIME\tTYPE\tFUNCTION\tPERFORMER_ID\tOBJECT\tCONTENT\tSTATUS".PHP_EOL);
        }
        
        return file_put_contents($filename, $output, FILE_APPEND);
    }
}

?>