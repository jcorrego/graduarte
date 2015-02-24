<?php
/**
* Entry point for JForms Component
*
* @version		$Id: jforms.php 28 2008-12-09 07:14:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'globals.php');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'helper'.DS.'plugins.php');

$GLOBALS['JFormGlobals'] = array();
$GLOBALS['JFormGlobals']['JFormsPlugin'] = new JFormsPluginManager();

// Create the controller "Frontend"
$classname	= 'FrontendController';
$controller = new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();