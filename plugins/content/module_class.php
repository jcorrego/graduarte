<?php

//no direct access
if(!defined('_VALID_MOS') && !defined('_JEXEC')){
	die('Restricted access');
}

class plugin_module_class{ 	

	var $db;	
	
	//constructor
	function plugin_module_class(){
		global $database;
		
		//get database
		if( defined('_JEXEC') ){
			//joomla 1.5
			$this->db = JFactory::getDBO();
		}else{
			//joomla 1.0.x
			$this->db = $database;
		}		
	}	

	function load_module($module_id, $module_class, $module_style){
	
		require_once(dirname(__FILE__).'/../../libraries/joomla/application/module/helper.php');
		$JModuleHelper = new JModuleHelper; 				
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		
		$contents = '';
			
		//get module as an object
		$this->db->setQuery("SELECT * FROM #__modules WHERE id='$module_id' ");
		$modules = $this->db->loadObjectList();
		$module = $modules[0];
		
		//just to get rid of that stupid php warning
		$module->user = '';
		
		$params = array('style'=>$module_style);
		
		$contents = $renderer->render($module, $params);
		
		return $contents;		
	}
	
	
}

?>