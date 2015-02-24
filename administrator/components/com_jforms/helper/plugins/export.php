<?php
/**
* Export PluginManager class
*
* @version		$Id: export.php 124 2009-04-04 21:37:00Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

class JFormsXPluginManager{
	
	var $loaded_plugins = array();
	
	function invokeMethod( $name, $which, $params ){
		
		//Error checking
		if( $which == null || count( $which ) != 1 )return null;
		$response = array();
		foreach( $this->loaded_plugins as $p ){
			
			if( !is_null( $which ) && !in_array( $p->name, $which ) )continue;
			require_once $p->php;
			$className = 'JFormXPlugin'.ucfirst($p->name);
			//PHP 4 fix
			$methodExists = false;
			eval( '$x = new '.$className.'();$methodExists = method_exists($x,"'.$name.'");$x=null;' );
			//End of PHP 4 Fix
			
			if( !$methodExists )return '';
			
			
			return call_user_func_array(array($className,$name),$params);
		}
	}
		
	/**
	 *  Loads the active element plugins "listed in plugins/plugin.list" 
	 *
	 * @return void
	 */
	function loadPlugins()
	{
		//Performance check
		if( !empty($this->loaded_plugins)){
			return;
		}
		
		$path = JFORMS_BACKEND_PATH.DS."plugins".DS."export".DS;
		$plugins = $this->_getPlugins();
		foreach($plugins as $plugin){
			$p = $this->_loadPlugin( $plugin );
			if($p != null){
				$this->loaded_plugins[$plugin] = $p;
			}
		}
	}


	
	/**
	 *  Loads a single Element plugin from XML file
	 *
	 * @return object : an object that holds information that was loaded from the XML file
	 */
	function _loadPlugin( $name )
	{
	
		$xml = new JSimpleXML();
		$pluginPath = JFORMS_BACKEND_PATH.DS.'plugins'.DS.'export'.DS.$name.DS;
		$filename = $pluginPath.$name.".xml";
		
		$xml->loadFile($filename);
		$root = $xml->document;

		$a = $root->attributes();
		if( $a['type'] != 'export' ){
			unset($xml);
			return null;
		}
		
		$pluginURI  = JURI::base()."components/com_jforms/plugins/export/$name/";
		
		$plugin = new stdClass();
		$plugin->name = $root->name[0]->data();
		$plugin->description = $root->description[0]->data();
		$plugin->format = $root->format[0]->data();
		$plugin->php = $pluginPath . $name . '.php';
		$plugin->paramXML = $pluginPath . 'param.xml';
				
		//Load language files
		$lang =& JFactory::getLanguage();
		$lang->load('export.'.ucfirst($name),JFORMS_BACKEND_PATH,null,false);

		return $plugin;

	}

	/**
	 *  Reads the "plugins.list" file and returns an array containing the names of element plugions 
	 *
	 * @return array : Element plugins to be loaded
	 */
	function _getPlugins()
	{
		$plugins = file(JFORMS_BACKEND_PATH.DS."plugins".DS."export".DS."plugins.list" );
		for($i=0;$i<count($plugins);$i++){
			$plugins[$i] = trim($plugins[$i]);
		}
		return $plugins;
	}
}