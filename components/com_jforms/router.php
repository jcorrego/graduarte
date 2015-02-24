<?php
/**
* Router for JForms
*
* @version		$Id: router.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

//Known issue:
//	When Itemid doesn't correpsond to form id the router will redirect request to the form id associated with the menu item
//	Example behaviour
// itemid = 5 ; form_id = 1
// They are not matching because itemid = 5 refers to form_id=4
// When the user access this url (itemid = 5 - fid = 1) , he will be presented with form (1) , however, when the user
// Submits the form he will be redirected to thank you msg for form (4)
// This bug is present only when SEF URLs are enabled 
function JformsBuildRoute(&$query){

	
	$menu = &JSite::getMenu();
	if (empty($query['Itemid'])) {
		$menuItem = &$menu->getActive();
	} else {
		$menuItem = &$menu->getItem($query['Itemid']);
	}
	
	if( $menuItem && $menuItem->component == 'com_jforms' ){
		$id	= (empty($menuItem->query['id'])) ? 0 : $menuItem->query['id'];
	} else {
		$id = $query['id'];
	}
	
	$segments = array();

	if( isset($query['task']) ){
		$segments[] = $query['task'];
		unset($query['task']);
	} 
	
	$segments[] = $id;
	if(isset($query['id']))unset($query['id']);
	
	if(isset($query['Itemid'])){
		$segments[] = $query['Itemid'];
		unset($query['Itemid']);
	}
	return $segments;
}

function JformsParseRoute($segments)
{
	$vars = array();

	switch( count($segments)){
	
		case 1:
			$vars['id'] = $segments[0];
			//var_dump($vars);die;
			return $vars;
			
		case 2:
			$vars['id']     = $segments[0];
			$vars['Itemid'] = $segments[1];
			//var_dump($vars);die;
			return $vars;
			
		case 3:
			$vars['task']   = $segments[0];
			$vars['id']     = $segments[1];
			$vars['Itemid'] = $segments[2];
			//var_dump($vars);die;
			return $vars;
	}
	

}

