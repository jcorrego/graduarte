<?php
/**
* @version		$Id: mod_latestnews.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');
$contentSource = $params->get('contentSource','article');
if($contentSource == "k2")
{
	$list = modSSK2ContentHelper::getList($params);
}
else
{
	$list = mod_slideshow3Helper::getList($params);
}


require(JModuleHelper::getLayoutPath('mod_slideshow3'));
?>


