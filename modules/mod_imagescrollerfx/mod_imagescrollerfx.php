<?php
/**
 * @package Module Image Scroller FX for Joomla! 1.5
 * @version $Id: mod_imagescrollerfx.php 8 July 2010 $
 * @author FlashXML.net
 * @copyright (C) 2010 FlashXML.net
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
**/

defined('_JEXEC') or die('Restricted access');

$imagescrollerfx_path = $params->get('imagescrollerfx_path');
if (strpos($imagescrollerfx_path, '/') !== 0) {
	$imagescrollerfx_path = '/'.$imagescrollerfx_path;
	$params->def('imagescrollerfx_path', $imagescrollerfx_path);

}
$imagescrollerfx_swf = 'FXImageScroller.swf';


if (file_exists(JPATH_BASE.$imagescrollerfx_path.'settings.xml') && function_exists('simplexml_load_file')) {
	$xml = simplexml_load_file(JPATH_BASE.$imagescrollerfx_path.'settings.xml');
	$imagescrollerfx_width = $xml->General_Properties->width->attributes()->value;
	$imagescrollerfx_height = $xml->General_Properties->height->attributes()->value;

	$joomla_install_dir_in_url = rtrim(JURI::root(true), '/');
	if (!empty($joomla_install_dir_in_url) && strpos($joomla_install_dir_in_url, '/') !== 0) {
		$joomla_install_dir_in_url = '/' . $joomla_install_dir_in_url;
	}

	global $mainframe;
	$mainframe->addCustomHeadTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>');
	echo '<div id="imagescrollerfx"></div><script type="text/javascript">'."swfobject.embedSWF('{$joomla_install_dir_in_url}{$imagescrollerfx_path}{$imagescrollerfx_swf}', 'imagescrollerfx', '{$imagescrollerfx_width}', '{$imagescrollerfx_height}', '9.0.0.0', '', { folderPath: '{$joomla_install_dir_in_url}{$imagescrollerfx_path}' }, { scale: 'noscale', salign: 'tl', wmode: 'transparent', allowScriptAccess: 'sameDomain', allowFullScreen: true }, {});</script>";
}
