<?php
/**
* Entry date Element plugin
*
* @version		$Id: entrydate.php 114 2009-03-22 12:41:43Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormEPluginEntrydate{

	function render( $elementData ){
	
		$p = JArrayHelper::toObject($elementData->parameters);
		$htmlId = $p->hash.'_'.$elementData->id;
		return _line("<input type='hidden' value='' name='$p->hash' id='$htmlId' />",2);
	}
	
	function translate( $elementData, $input, $format='html' ){return $input;}
	
	function getSQL( $elementData, $criteria ){
		
		$db =& JFactory::getDBO();
		$from = $criteria->from;
		$to   = $criteria->to;
		$mode = $criteria->mode=='or'?' OR ':' AND ';
		$fragments = array();
		$field= $elementData->parameters['hash'];
		
		if($from != '' )
			$fragments[] = "`$field` >= '$from'";
		if($to != '' )
			$fragments[] = "`$field` <= '$to'";
		$sql = implode( ' AND ', $fragments );
		
		if( trim( $sql ) != '' ){
			$sql = "($sql) $mode";
		}
		return $sql;
		
	}
	
	function beforeSave($elementData, $input){
		
		$config	=& JFactory::getConfig();
		$now	=& JFactory::getDate();
		$now->setOffset($config->getValue('config.offset'));
		return $now->toMySQL();

	}
}