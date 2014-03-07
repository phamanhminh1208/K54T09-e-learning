<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('BaseLog', 'Log/Engine');
App::uses('Hash', 'Utility');

class ELearningLog extends BaseLog {

    public function __construct($config = array()) {
        parent::__construct($config);
        $config = Hash::merge(array(
                    'path' => LOGS,
                    'file' => null,
                    'types' => null,
                    'scopes' => array(),
                        ), $this->_config);
        $config = $this->config($config);
        $this->_path = $config['path'];
        $this->_file = $config['file'];
        if (!empty($this->_file) && substr($this->_file, -4) !== '.log') {
            $this->_file .= '.log';
        }
    }

    public function write($type, $message) {
        $now = new DateTime();

        $log_folder = $this->_path . DIRECTORY_SEPARATOR . $now->format('Y-m');
        if (!file_exists($log_folder . "/")) {
            mkdir($log_folder, 0777);
        }

        $filename = $this->_path . DIRECTORY_SEPARATOR . $now->format('Y-m') . DIRECTORY_SEPARATOR . $now->format("Y-m-d") . ".log";
        $output = $now->format('Y-m-d H:i:s') . "\t" . $type . "\t" . $message . PHP_EOL;
        
        if(!file_exists($filename)){
            file_put_contents($filename, "TIME\tTYPE\tFUNCTION\tPERFORMER_ID\tOBJECT\tCONTENT\tSTATUS".PHP_EOL);
        }
        
        return file_put_contents($filename, $output, FILE_APPEND);
    }

}

?>