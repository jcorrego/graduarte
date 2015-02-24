<?php
/*
 *  Administrator Tools
 *  Copyright (C) 2010-2011  Nicholas K. Dionysopoulos / AkeebaBackup.com
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

// Make sure Admin Tools is installed, otherwise bail out
if(!file_exists(JPATH_ADMINISTRATOR.'/components/com_admintools')) {
	return;
}

// PHP version check
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	$version = '5.0.0'; // all bets are off!
}
if(!version_compare($version, '5.0.0', '>=')) return;

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

jimport('joomla.filesystem.file');
if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
	$target_include = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'admintools'.DS.'main.php';
} else {
	$target_include = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'admintools'.DS.'main.php';
}

if(JFile::exists($target_include)) {
	require_once $target_include;
} else {
	$target_include = $target_include = JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'admintools'.DS.'admintools'.DS.'main.php';
	if(JFile::exists($target_include)) {
		require_once $target_include;
	}
}