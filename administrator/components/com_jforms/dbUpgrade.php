<?php
/**
* Database update routine
*
* @version		$Id: dbUpgrade.php 157 2009-06-06 03:53:36Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die();


function dbUpToDate(){
	$db =& JFactory::getDBO();
	$fields = $db->getTableFields( '#__jforms_forms' );
	if (array_key_exists('theme', $fields['#__jforms_forms']))return true;
	else return false;
}

function upgradeForm( $id ){
	
	$db =& JFactory::getDBO();
	
	$fid = intval($id);
	
	$sql = 'SELECT `parameter_name`,`parameter_value` FROM `#__jforms_parameters` WHERE
	`plugin_name` = "Database" AND fid='.$fid;
	$db->setQuery( $sql );
	$dbPluginParameters = $db->loadAssocList('parameter_name');
	$tableName = $dbPluginParameters['tableName']['parameter_value'];
			
	$fields = unserialize(base64_decode( $dbPluginParameters['fields']['parameter_value']));
	$fields['Date'] = new stdClass();
	$fields['IP']   = new stdClass();
			
	$fields['Date']->type	    = 'datetime';
	$fields['Date']->size 		= 0;
	$fields['Date']->requirefs	= false;
			
	$fields['IP']->type		    = 'number';
	$fields['IP']->size 		= 4;
	$fields['IP']->requirefs	= false;
	$fieldsString = base64_encode(serialize( $fields ));
	
	$sql = 'UPDATE `#__jforms_parameters` SET `parameter_value`="'.$fieldsString.'" WHERE
	`plugin_name` = "Database" AND `parameter_name`="fields" AND fid='.$fid;
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
		
	$sql = 
	'ALTER TABLE `#__jforms_'.$tableName.'` ADD '
	.'`uid` INT( 11 ) UNSIGNED NOT NULL DEFAULT "0" AFTER `id` ,ADD INDEX ( uid )';
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
			
	$sql =  'INSERT INTO `#__jforms_fields` '
			.' (`pid` ,`type` ,`position`) '
			.' VALUES '
			."($fid, 'entrydate', '998')";
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
	$lastInsertId = $db->insertid();
	$sql = 'INSERT INTO `#__jforms_parameters` '
		   .'(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`) VALUES '
		   ."($fid, $lastInsertId, 'entrydate', 1, 'hash', 'Date')";
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
	
	$sql = 'INSERT INTO `#__jforms_parameters` '
		   .'(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`) VALUES '
		   ."($fid, $lastInsertId, 'entrydate', 1, 'label', 'Entry Date')";
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
	
	$sql =  'INSERT INTO `#__jforms_fields` '
			.' (`pid` ,`type` ,`position`) '
			.' VALUES '
			."($fid, 'ip', '999')";
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
	
	$lastInsertId = $db->insertid();
			
	$sql = 'INSERT INTO `#__jforms_parameters` '
		   .'(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`) VALUES '
		   ."($fid, $lastInsertId, 'ip', 1, 'hash', 'IP')";
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}		
			
	$sql = 'INSERT INTO `#__jforms_parameters` '
		   .'(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`) VALUES '
		   ."($fid, $lastInsertId, 'entrydate', 1, 'label', 'IP Address')";
	$db->setQuery( $sql );
	$db->query();
	if ($db->getErrorNum()) {
		JError::raiseError( 500, $db->stderr() );
		return;
	}
		
	//Convert IPs from Strings to Integers
	$sql = 'SELECT id,IP FROM `#__jforms_'.$tableName.'`';
	$db->setQuery( $sql );
	$entries = $db->loadObjectList();

	foreach($entries as $entry){
		$newIP = ip2long($entry->IP);
		$sql = "UPDATE `#__jforms_{$tableName}` SET IP='$newIP' WHERE id=$entry->id";
		$db->setQuery( $sql );
		$db->query();
	}
	
	$sql = 'ALTER TABLE `#__jforms_'.$tableName.'` CHANGE `IP` `IP` INT( 4 ) NOT NULL';
	$db->setQuery( $sql );
	$db->query();
}

function upgradeDB( $step, $param ){
		
	$token =JUtility::getToken();
	
	$db =& JFactory::getDBO();
	switch( $step ){
		default:
		case 1:
			if(dbUpToDate())return '';
			$sql = 'ALTER TABLE `#__jforms_forms` ADD `theme` VARCHAR( 100 ) NOT NULL DEFAULT "default" AFTER `plugins`';
			$db->setQuery( $sql );
			$db->query();
			if ($db->getErrorNum())JError::raiseError( 500, $db->stderr() );
			return ('index.php?'.$token.'=1&option=com_jforms&task=upgradeDB&step=2&param=');
			break;
		
		case 2:
			$sql = 'SELECT id FROM `#__jforms_forms`';
			$db->setQuery( $sql );
			$forms = implode(',', $db->loadResultArray(0));
			if ($db->getErrorNum())JError::raiseError( 500, $db->stderr() );
			return ('index.php?'.$token.'=1&option=com_jforms&task=upgradeDB&step=3&param='.$forms);
			break;
	
		case 3:
			$formsArray  = explode(',', $param );
			$currentForm = array_pop( $formsArray );
			upgradeForm( $currentForm );
			$formsString = implode( ',', $formsArray );
			if( empty( $formsArray ) )return '';
			return ('index.php?'.$token.'=1&option=com_jforms&task=upgradeDB&step=3&param='.$formsString);
			break;
			
	}
	
}