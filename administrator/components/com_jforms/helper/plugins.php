<?php
/**
* PluginManager class
*
* Active element plugins are retrieved from "com_jforms/plugins/elements/plugins.list" 
* each plugin is stored in a separate directory with the same name as the plugin
* for more details about the structure please view the "com_jforms/plugins/elements/" directory
*
* @version		$Id: plugins.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

jimport('joomla.utilities.simplexml');

include 'plugins'.DS.'element.php';
include 'plugins'.DS.'export.php';
include 'plugins'.DS.'storage.php';


class JFormsPluginManager{

	//Holds loaded element plugins
	var $element_plugins = array();
	
	//Holds loaded storage plugins
	var $storage_plugins = array();
	
	//Holds loaded export plugins
	var $export_plugins = array();
	
	var $exportPluginManager  = null; 
	var $storagePluginManager = null;
	var $elementPluginManager = null;
	
	function elementHasStorageRequirements( $e ){
		
		$this->loadElementPlugins();
		if(
			property_exists($this->elementPluginManager->loaded_plugins[$e->type],'storage') && 
			$this->elementPluginManager->loaded_plugins[$e->type]->storage == null 
		   )return false;
		return true;

	}
	
	function JFormsPluginManager(){
		$this->__construct();
	}
	
	function __construct(){
		
		$this->exportPluginManager  = new JFormsXPluginManager(); 
		$this->storagePluginManager = new JFormsSPluginManager();
		$this->elementPluginManager = new JFormsEPluginManager();
	
	}
	
	function invokeMethod( $name, $type, $which, $params ){
	
		switch( $type ){
			
			case JFORM_PLUGIN_ELEMENT:
				return $this->elementPluginManager->invokeMethod( $name, $which, $params );
				
			case JFORM_PLUGIN_STORAGE:
				return $this->storagePluginManager->invokeMethod( $name, $which, $params );

			case JFORM_PLUGIN_EXPORT:
				return $this->exportPluginManager->invokeMethod( $name, $which, $params );
				
		}
	}

	/**
	 *  Loads the active element plugins "listed in plugins/plugin.list" 
	 *
	 * @return void
	 */
	function loadElementPlugins(){
		$this->elementPluginManager->loadPlugins();
		$this->element_plugins = $this->elementPluginManager->loaded_plugins;		
	}


	
	function getElementPluginsCategories(){
		return $this->elementPluginManager->getCategories();
	}
	
		
	/**
	 * Loads the active storage plugins "listed in plugins/plugin.list" 
	 *
	 * @return void
	 */
	function loadStoragePlugins(){
		$this->storagePluginManager->loadPlugins();
		$this->storage_plugins = $this->storagePluginManager->loaded_plugins;
	}

	/**
	 * Loads the active export plugins "listed in plugins/plugin.list" 
	 *
	 * @return void
	 */
	function loadExportPlugins(){
		$this->exportPluginManager->loadPlugins();
		$this->export_plugins = $this->exportPluginManager->loaded_plugins;
	}

}