<?php
/**
* @author MinhPA
* @website 
* @email phamanhminh1208@gmail.com
* @copyright by MinhPA
* @license 
**/

class ManagersController extends AppController {

	var $name= 'Managers';
	
	var $layout			=	"default";
	var $helpers		=	array("Session", "Cache");
	
	var $cacheAction = array(
         'homepage'  => array('callbacks' => true, 'duration' => "+1 day"),
    ); 
	
	function homepage() {
		
	}

	function backup() {
		
	}
	
	function cancelAccess(){
		
	}
}
?>