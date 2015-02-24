<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die();

// Check for PHP4
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	// No version info. I'll lie and hope for the best.
	$version = '5.0.0';
}

// Old PHP version detected. EJECT! EJECT! EJECT!
if(!version_compare($version, '5.0.0', '>='))
{
	return JError::raise(E_ERROR, 500, 'PHP 4 is not supported by Admin Tools');
}

jimport('joomla.application.component.model');

// Timezone fix; avoids errors printed out by PHP 5.3.3+ (thanks Yannick!)
if(function_exists('date_default_timezone_get') && function_exists('date_default_timezone_set')) {
	if(function_exists('error_reporting')) {
		$oldLevel = error_reporting(0);
	}
	$serverTimezone = @date_default_timezone_get();
	if(empty($serverTimezone) || !is_string($serverTimezone)) $serverTimezone = 'UTC';
	if(function_exists('error_reporting')) {
		error_reporting($oldLevel);
	}
	@date_default_timezone_set( $serverTimezone);
}

// Load version.php
jimport('joomla.filesystem.file');
$version_php = JPATH_COMPONENT_ADMINISTRATOR.DS.'version.php';
if(!defined('ADMINTOOLS_VERSION') && JFile::exists($version_php)) {
	require_once $version_php;
}

// Fix Pro/Core
$isPro = (ADMINTOOLS_PRO == 1);
if(!$isPro) {
	jimport('joomla.filesystem.folder');
	$pf = JPATH_BASE.DS.'plugins'.DS.'system'.DS.'admintools'.DS.'pro.php';
	if(JFile::exists($pf)) JFile::delete($pf);
	
	$pf = JPATH_BASE.DS.'plugins'.DS.'system'.DS.'admintools'.DS.'admintools'.DS.'pro.php';
	if(JFile::exists($pf)) JFile::delete($pf);
	
	$files = array('controllers/geoblock.php','controllers/htmaker.php','controllers/log.php','controllers/redires.php',
		'controllers/wafconfig.php','helpers/geoip.php','models/badwords.php','models/geoblock.php','models/htmaker.php',
		'models/ipbl.php','models/ipwl.php','models/log.php','models/redirs.php','models/wafconfig.php');
	$dirs = array('assets/geoip','views/badwords','views/geoblock','views/htmaker','views/ipbl','views/ipwl',
		'views/log','views/masterpw','views/redirs','views/waf','views/wafconfig');
	
	foreach($files as $fname) {
		$file = JPATH_ADMINISTRATOR.DS.$fname;
		if(JFile::exists($file)) {
			JFile::delete($file);
		}
	}
	
	foreach($dirs as $fname) {
		$dir = JPATH_ADMINISTRATOR.DS.$fname;
		if(JFolder::exists($dir)) {
			JFolder::delete($dir);
		}
	}
}

// Joomla! 1.6 detection
if(!defined('ADMINTOOLS_JVERSION'))
{
	if(!version_compare( JVERSION, '1.6.0', 'ge' )) {
		define('ADMINTOOLS_JVERSION','15');
	} else {
		define('ADMINTOOLS_JVERSION','16');
	}
}

// If JSON functions don't exist, load our compatibility layer
if( (!function_exists('json_encode')) || (!function_exists('json_decode')) )
{
	require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonlib.php';
}

jimport('joomla.application.component.model');
require_once JPATH_COMPONENT_ADMINISTRATOR.'/models/storage.php';

// Access Control - Default is to allow only Super Administrators
if(ADMINTOOLS_JVERSION == '15')
{
	// Setup ACL, Joomla! 1.5-style
	jimport('joomla.application.component.model');
	$params = JModel::getInstance('Storage','AdmintoolsModel');
	$acl =& JFactory::getACL();
	if(method_exists($acl, 'addACL'))
	{
		$min_acl = $params->getValue('minimum_acl_group','super administrator');
		$acl->addACL('com_admintools', 'manage', 'users', 'super administrator' );
		switch($min_acl)
		{
			case 'administrator':
				$acl->addACL('com_admintools', 'manage', 'users', 'administrator' );
				break;

			case 'manager':
				$acl->addACL('com_admintools', 'manage', 'users', 'administrator' );
				$acl->addACL('com_admintools', 'manage', 'users', 'manager' );
				break;
		}
	}
}
else
{
	// Access check, Joomla! 1.6 style.
	if (!JFactory::getUser()->authorise('core.manage', 'com_admintools')) {
		return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	}
}

// Get the view and controller from the request, or set to default if they weren't set
JRequest::setVar('view', JRequest::getCmd('view','cpanel'));
JRequest::setVar('c', JRequest::getCmd('view','cpanel')); // Get controller based on the selected view

// Merge the default translation with the current translation
$jlang =& JFactory::getLanguage();
// Live Update translation
$jlang->load('liveupdate', JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate', 'en-GB', true);
$jlang->load('liveupdate', JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate', $jlang->getDefault(), true);
$jlang->load('liveupdate', JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate', null, true);
// Back-end translation
$jlang->load('com_admintools', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_admintools', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_admintools', JPATH_ADMINISTRATOR, null, true);

// Handle Live Update requests
require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'liveupdate'.DS.'liveupdate.php';
if(JRequest::getCmd('view','') == 'liveupdate') {
	LiveUpdate::handleRequest();
	return;
}

// Load the appropriate controller
$c = JRequest::getCmd('c','cpanel');
$path = JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.$c.'.php';
$alt_path = JPATH_COMPONENT_ADMINISTRATOR.DS.'plugins'.DS.'controllers'.DS.$c.'.php';
if(JFile::exists($path))
{
	// The requested controller exists and there you load it...
	require_once($path);
}
elseif(JFile::exists($alt_path))
{
	require_once($alt_path);
}
else
{
	$view = JRequest::getCmd('view','');
	$viewFolder = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.$view;
	if(!JFolder::exists($viewFolder))
	{
		// Hmm... an invalid controller was passed
		JError::raiseError('500',JText::_('Unknown controller').' '.$c);
	}
	require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'default.php';
	$c = 'default';
}

// Instanciate and execute the controller
jimport('joomla.utilities.string');
$c = 'AdmintoolsController'.ucfirst($c);
$controller = new $c();
if(ADMINTOOLS_JVERSION == 'j15')
{
	$controller->setAccessControl('com_admintools','manage'); // Enforce Joomla!'s ACL
}
$controller->execute(JRequest::getCmd('task','display'));

// Redirect
$controller->redirect();