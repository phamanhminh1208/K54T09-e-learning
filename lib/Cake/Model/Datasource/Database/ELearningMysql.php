<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomMysql
 *
 * @author MinhPA
 */
App::uses('Mysql', 'Model/Datasource/Database');
App::uses('Log', 'Lib/Log');

class ELearningMysql extends Mysql{    
    function execute($sql, $options = array(), $params = array()) {
        try{
            $result = parent::execute($sql, $options, $params);
            if(strtolower(substr($sql, 0, 6)) != "select"){
                $sql = preg_replace("/[\r\n\t ]+/", " ", $sql);
                $log = "QUERY\tNULL\t". Log::_OBJECT_SQL ."[".$sql."]\tNULL\tSUCCESS";
                Log::write(Log::_TYPE_INFO, $log);
            }
            return $result;
        }catch(PDOException $e){            
            throw $e;
        }
    }
}
