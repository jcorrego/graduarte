<?php
defined('_JEXEC') or die('Access Denied!');
### Copyright (C) 2006-2010 Joobi Limited. All rights reserved.
### http://www.gnu.org/copyleft/gpl.html GNU/GPL

if(!defined('JNEWS_JPATH_ROOT')){
	if ( defined('JPATH_ROOT') AND class_exists('JFactory')) {	// joomla 15
		$mainframe = JFactory::getApplication();
		define ('JNEWS_JPATH_ROOT' , JPATH_ROOT );
	}//endif
}//endif

require_once( JNEWS_JPATH_ROOT . '/components/com_jnews/defines.php');

if (file_exists(JNEWS_JPATH_ROOT . '/administrator/components/com_jnews/classes/class.jnews.php')) {
	require_once(JNEWS_JPATH_ROOT . '/administrator/components/com_jnews/classes/class.jnews.php');
} else {
	die ("jNews Module\n<br />This module needs the jNews component.");
}

$acaModule = new aca_module();
echo $acaModule->normal($params);
