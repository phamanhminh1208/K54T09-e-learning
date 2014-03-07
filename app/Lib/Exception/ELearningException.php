<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileWritingException
 *
 * @author MinhPA
 */
App::uses('exceptions', 'Cake/Error');

class FileAccessException extends CakeException{
    //put your code here
    public $file;
    public function __construct($file, $message) {
        $this->file = $file;
        parent::__construct($message, 600);
    }
}
