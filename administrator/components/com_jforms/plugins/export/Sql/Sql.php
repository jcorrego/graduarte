<?php 
/**
* SQL Export plugin
*
* @version		$Id: Sql.php 128 2009-04-05 06:14:28Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormXPluginSql{
	
	function _getSQLField( $s, $n ){
		
		switch($s->type){
			
			case 'textfield':
				if( intval( $s->size ) > 255 ){
					$sql = ' `'.$n.'` TEXT NOT NULL';
				} else {
					$sql = ' `'.$n.'` VARCHAR( '.$s->size.' ) NOT NULL';
				}
				break;
			
			case 'datetime':
				$sql = ' `'.$n.'` DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00"';
				break;
			
			case 'number':
				$sql = ' `'.$n.'` INT( '.$s->size.' ) NOT NULL';
				break;
		}
		return $sql;
	}
	
	function _createTable( $form ){
		
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadElementPlugins();
		$dbFields = unserialize(base64_decode($form->storagePluginParameters['Database']['fields'])));
		$sql  = 'CREATE TABLE `#__jforms_'.$tableName.'` ('.
				' `id` INT(11) NOT NULL AUTO_INCREMENT ,'
			   .' `uid` INT(11) UNSIGNED NOT NULL DEFAULT "0",';
 
		$columnSQL = array();
		
		$hashes = array();
		
		foreach( $form['fieldInformation'] as $f ){
			
			//Never mind fields with no storage requirments
			if($elementPlugins[$f->type]->storage == null)continue;
			
			//Will take the first storage field from XML paramters for now
			$storage = $elementPlugins[$f->type]->storage;
			$columnSQL[] = JFormSPluginDatabase::_getSQLField($storage, $f->hash);
			
		}
		$sql .= implode( ',', $columnSQL );
		$sql .= ' ,PRIMARY KEY ( `id` )'.
				' )  TYPE=InnoDB;';	
		
		
		$fields = array();
		
		foreach( $form->fields as $f ){
			$fields[$f->parameters]->hash = $f;
		}
		return $form;
	}
	
	function onExport( $pluginParameters, $requestParameters, $data ){
		
		$tableSQL = JFormXPluginSql::_createTable( $data['form'] );
		d( $tableSQL );
	}
	
}