<?php
/**
* Storage PluginManager class
*
* @version		$Id: storage.php 114 2009-03-22 12:41:43Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

class JFormsSPluginManager{

	var $loaded_plugins = array();
	
	function invokeMethod( $name, $which, $params ){
		
		$response = array();
		foreach( $this->loaded_plugins as $p ){

			if( !is_null( $which ) && !in_array( $p->name, $which ) )continue;
			
			require_once $p->php;
			
			$className = 'JFormSPlugin'.$p->name;
		
			$response[$p->name] = call_user_func_array(array($className,$name),$params);
	
		}
		return $response;
	}
	

	/**************************************************************************************************************/
	
	/**
	 *  Loads the active storage plugins "listed in plugins/plugin.list" 
	 *
	 * @return void
	 */
	function loadPlugins()
	{
		//Performance check
		if( !empty($this->loaded_plugins)){
			return;
		}
		
		$path = JFORMS_BACKEND_PATH.DS."plugins".DS."elements".DS;
		$plugins = $this->_getPlugins();
		foreach($plugins as $plugin){
			$p = $this->_loadPlugin( $plugin );
			if($p != null){
				$this->loaded_plugins[$plugin] = $p;
			}
		}
	}


	
	/**
	 *  Loads a single Storage plugin from XML file
	 *
	 * @return object : an object that holds information that was loaded from the XML file
	 */
	function _loadPlugin( $name )
	{
		$xml = new JSimpleXML();
		$pluginPath = JFORMS_BACKEND_PATH.DS.'plugins'.DS.'storage'.DS.$name.DS;
		$filename = $pluginPath.$name.".xml";
		
	
		$xml->loadFile($filename);
		$root = $xml->document;
	
		
		$a = $root->attributes();
		if( $a['type'] != 'storage' ){
			unset($xml);
			return null;
		}
		
		$plugin = new stdClass();
		$plugin->name = $root->name[0]->data();
		$plugin->php = $pluginPath . $name . '.php';
		$plugin->paramXML = $pluginPath . 'param.xml';

		//Load language files
		$lang =& JFactory::getLanguage();
		$lang->load('storage.'.ucfirst($name),JFORMS_BACKEND_PATH,null,false);

		
		return $plugin;
	}

	/**
	 *  Reads the "plugins.list" file and returns an array containing the names of storage plugions 
	 *
	 * @return array : storage plugins to be loaded
	 */
	function _getPlugins()
	{
		$plugins = file(JFORMS_BACKEND_PATH.DS."plugins".DS."storage".DS."plugins.list");
		for($i=0;$i<count($plugins);$i++){
			$plugins[$i] = trim($plugins[$i]);
		}
		return $plugins;
	}

}