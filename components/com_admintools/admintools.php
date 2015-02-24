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

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

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
	return JError::raise(E_ERROR, 500, 'PHP 4 is not supported by Akeeba Backup');
}

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

// Joomla! 1.6 detection
if(!defined('ADMINTOOLS_JVERSION'))
{
	if(!version_compare( JVERSION, '1.6.0', 'ge' )) {
		define('ADMINTOOLS_JVERSION','15');
	} else {
		define('ADMINTOOLS_JVERSION','16');
	}
}

// Get the view and controller from the request, or set to default if they weren't set
JRequest::setVar('view', JRequest::getCmd('view','cpanel'));
JRequest::setVar('c', JRequest::getCmd('view','cpanel')); // Get controller based on the selected view

// Merge the default translation with the current translation
$jlang =& JFactory::getLanguage();
// Live Update translation
$jlang->load('liveupdate', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_admintools'.DS.'liveupdate', 'en-GB', true);
$jlang->load('liveupdate', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_admintools'.DS.'liveupdate', $jlang->getDefault(), true);
$jlang->load('liveupdate', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_admintools'.DS.'liveupdate', null, true);
// Back-end translation
$jlang->load('com_admintools', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_admintools', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_admintools', JPATH_ADMINISTRATOR, null, true);

// Load our JSON compatibility layer
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_admintools'.DS.'helpers'.DS.'jsonlib.php';

// Load the appropriate controller
$c = JRequest::getCmd('c','cpanel');
$path = JPATH_COMPONENT.DS.'controllers'.DS.$c.'.php';
if(JFile::exists($path))
{
	// The requested controller exists and there you load it...
	require_once($path);
}
else
{
	JError::raiseError(404,JText::_('COMPONENT NOT FOUND'));
	return;
}

// Instanciate and execute the controller
jimport('joomla.utilities.string');
$c = 'AdmintoolsController'.ucfirst($c);
$controller = new $c();
$controller->execute(JRequest::getCmd('task','display'));

// Redirect
$controller->redirect();