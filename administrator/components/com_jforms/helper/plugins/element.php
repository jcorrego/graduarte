<?php
/**
* Storage PluginManager class
*
* @version		$Id: element.php 114 2009-03-22 12:41:43Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');




class JFormsEPluginManager{


	var $loaded_plugins = array();

	function invokeMethod( $name, $which, $params ){
		
		//Error checking
		if( $which == null || count( $which ) != 1 )return null;
		$response = array();
		foreach( $this->loaded_plugins as $p ){
			
			if( !is_null( $which ) && !in_array( $p->name, $which ) )continue;
			require_once $p->php;
			$className = 'JFormEPlugin'.ucfirst($p->name);
			//PHP 4 fix
			$methodExists = false;
			eval( '$x = new '.$className.'();$methodExists = method_exists($x,"'.$name.'");$x=null;' );
			//End of PHP 4 Fix
			
			if( !$methodExists )return '';
			
			
			return call_user_func_array(array($className,$name),$params);
		}
	}

	function getCategories(){
		
		$this->loadPlugins();
		
		$categories = array();
		
		foreach( $this->loaded_plugins as $e ){
			
			if( !array_key_exists($e->group, $categories)){
				$categories[$e->group]   = array();
			}
			$categories[$e->group][$e->name] = $e;
		}
		return $categories;
		
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
	 *  Loads a single Element plugin from XML file
	 *
	 * @return object : an object that holds information that was loaded from the XML file
	 */
	function _loadPlugin( $name )
	{
	
		$xml = new JSimpleXML();
		$pluginPath = JFORMS_BACKEND_PATH.DS.'plugins'.DS.'elements'.DS.$name.DS;
		$filename = $pluginPath.$name.".xml";
		
	
		$xml->loadFile($filename);
		$root = $xml->document;
	
		
		$a = $root->attributes();
		if( $a['type'] != 'element' ){
			unset($xml);
			return null;
		}
		
		$pluginURI  = JURI::base()."components/com_jforms/plugins/elements/$name/";
		
		$plugin = new stdClass();
		$plugin->name = $root->name[0]->data();
		$plugin->description = $root->description[0]->data();
		$plugin->limit = isset($a['limit'])?$a['limit']:0;
		$plugin->group = isset($a['group'])?$a['group']:'basic';
		$plugin->paramXML = $pluginPath . 'param.xml';

		
		//Read <files>
		foreach( $root->files[0]->children() as $child ){
		
			$a = $child->attributes();
			$type = $a['type'];
			switch( $type ){
				
				case 'jsEntryPoint':
					$plugin->js = $pluginURI . $child->data();
					break;

				case 'phpEntryPoint':
					$plugin->php = $pluginPath . $child->data();
					break;

				case 'icon':
					$plugin->button = $pluginURI . $child->data();
					break;

				default:
					break;
			
			}
			
			
		}
		//Read <paramteres>
		$plugin->parameters    = array();
		foreach( $root->parameters[0]->children() as $child ){
			
			$a = $child->attributes();
			$parameterName = $a['name'];
			$plugin->parameters[$parameterName] = new stdClass();
			$plugin->parameters[$parameterName]->name = $parameterName;

			$plugin->parameters[$parameterName]->valueType = $a['valuetype'];
			
			if( $a['control'] != 'none' ){
				$plugin->parameters[$parameterName]->label = $a['label'];
			}

			
			if( array_key_exists('translate',$a) && $a['translate'] == '1' ){
				$plugin->parameters[$parameterName]->translate = true;
			} else {
				$plugin->parameters[$parameterName]->translate = false;
			}
			
			$plugin->parameters[$parameterName]->control = $a['control'];
			if( $a['control']  == 'list' ){
				$plugin->parameters[$parameterName]->options = array();
				foreach( $child->children() as $op ){
					$o = $op->attributes();
					$optionName = $op->data();
					$optionValue= $o['value'];
					$plugin->parameters[$parameterName]->options[$optionName] = $optionValue;
				}	
			}
			$plugin->parameters[$parameterName]->default = $a['default'];
		}
		
		
		//Read <storage>
		if( !isset( $root->storage ) ){
			$plugin->storage = null;
		} else {
			$a = $root->storage[0]->attributes();
			
			$plugin->storage = new stdClass();
			$plugin->storage->type = $a['type'];
			
			$plugin->storage->size = 0;
			if( isset($a['size']))
				$plugin->storage->size = $a['size'];
			
			$plugin->storage->requirefs = false;
			if( isset( $a['requirefs'] ))
				$plugin->storage->requirefs = strtolower($a['requirefs'])=='true'?true:false;
			
		}
	
		//Load language files
		$lang =& JFactory::getLanguage();
		$lang->load('element.'.ucfirst($name),JFORMS_BACKEND_PATH,null,false);

		
		return $plugin;

	}
	
	function getPluginsCategories(){
		
		$this->loadPlugins();
		
		$categories = array();
		
		foreach( $this->loaded_plugins as $e ){
			
			if( !array_key_exists($e->group, $categories)){
				$categories[$e->group]   = array();
			}
			$categories[$e->group][$e->name] = $e;
		}
		return $categories;
		
	}
	
	/**
	 *  Reads the "plugins.list" file and returns an array containing the names of element plugions 
	 *
	 * @return array : Element plugins to be loaded
	 */
	function _getPlugins()
	{
		$b = file_get_contents(JFORMS_BACKEND_PATH.DS."plugins".DS."elements".DS."plugins.list");
		$plugins = explode( "\r\n", $b );
		for($i=0;$i<count($plugins);$i++){
			$plugins[$i] = trim($plugins[$i]);
		}
		return $plugins;
	}

}