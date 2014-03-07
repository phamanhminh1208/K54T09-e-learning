<?php

App::uses('ExceptionRenderer', 'Error');
App::uses('Log', 'Lib/Log');

class ELearningExceptionRenderer extends ExceptionRenderer {

    public function missingController($error) {        
        $log = "ACCESS\t". $this->getCurrentUser() ."\t".
                Log::_OBJECT_LINK."[".$this->controller->here."]\tError404\tERROR";
        Log::write(Log::_TYPE_WARNING, $log);
        $this->controller->set('url', $this->controller->here);
        $this->controller->render('/Errors/error404');
        $this->controller->response->send();
    }

    public function missingAction($error) {
        $this->missingController($error);
    }

    public function notFound($error) {
        $this->missingController($error);
    }

    public function missingView($error) {
        $this->missingController($error);
    }
    
    public function pdoError(\PDOException $error) {           
        $sql = $this->replaceMessage($error->queryString);
        $log = "QUERY\t". $this->getCurrentUser() . "\t". 
                Log::_OBJECT_SQL ."[".$sql."]\t". $error->getMessage() ."\tERROR";
        Log::write(Log::_TYPE_ERROR, $log);
        
        $this->controller->set("title_for_layout", "エラー");
        $this->controller->render('/Errors/system_error');
        $this->controller->response->send();
    }
    
    public function fileAccess($error){
        $log = "ACCESS FILE\t". $this->getCurrentUser() . "\t".
                Log::_OBJECT_FILE."[".$error->file."]\t". $this->replaceMessage($error->getMessage()) ."\tERROR";
        Log::write(Log::_TYPE_ERROR, $log);
        $this->controller->set("title_for_layout", "エラー");
        $this->controller->render('/Errors/system_error');
        $this->controller->response->send();
    }
    
    public function getCurrentUser(){
        if($this->controller->Session->check('User.Username')){
            return $this->controller->Session->read('User.Username');
        }
        return "NULL[".$this->controller->request->clientIp."]";
    }
    
    public function replaceMessage($message){
        return preg_replace("/[\r\n\t ]+/", " ", $message);
    }
}

?>