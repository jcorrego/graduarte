<?php
/**
 * @package Plugin Image Scroller FX for Joomla! 1.5
 * @version $Id: mod_imagescrollerfx.php 8 July 2010 $
 * @author FlashXML.net
 * @copyright (C) 2010 FlashXML.net
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent('onPrepareContent', 'plgcontentimagescrollerfx');
$imagescrollerfx_embed_codes_count = 0;
$imagescrollerfx_swfobject_embedded = false;

function plgcontentimagescrollerfx(&$row, &$params, $page=0) {
	if (is_object($row)) {
		return plgimagescrollerfx($row->text, $params);
	}
	return plgimagescrollerfx($row, $params);
}

function plgimagescrollerfx(&$text, &$params) {
	if (JString::strpos($text, '{imagescrollerfx') === false) {
		return true;
	}

	$text = preg_replace_callback('|{imagescrollerfx\s*(settings="([^\]]+)")?\s*}(.*){/imagescrollerfx}|i', 'plgimagescrollerfxembedcode', $text);
	return true;
}

function plgimagescrollerfxembedcode($params) {
	$pluginParams = new JParameter(JPluginHelper::getPlugin('content', 'imagescrollerfx')->params);
	$imagescroller_path = $pluginParams->get('imagescrollerfx_path');
	if (strpos($imagescroller_path, '/') !== 0) {
		$imagescroller_path = '/' . $imagescroller_path;
		$pluginParams->def('imagescrollerfx_path', $path);

	}
	$swf = 'FXImageScroller.swf';
	$settings = !empty($params[2]) ? $params[2] : 'settings.xml';

	if (file_exists(JPATH_SITE.$imagescroller_path.$settings) && function_exists('simplexml_load_file')) {
		global $imagescrollerfx_swfobject_embedded;
		if (empty($imagescrollerfx_swfobject_embedded)) {
			global $mainframe;
			$mainframe->addCustomHeadTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>');
			$imagescrollerfx_swfobject_embedded = true;
		}

		$xml = simplexml_load_file(JPATH_SITE.$imagescroller_path.$settings);
		$imagescrollerfx_width = $xml->General_Properties->width->attributes()->value;
		$imagescrollerfx_height = $xml->General_Properties->height->attributes()->value;

		global $imagescrollerfx_embed_codes_count;
		$imagescrollerfx_embed_codes_count++;

		$joomla_install_dir_in_url = rtrim(JURI::root(true), '/');
		if (!empty($joomla_install_dir_in_url) && strpos($joomla_install_dir_in_url, '/') !== 0) {
			$joomla_install_dir_in_url = '/' . $joomla_install_dir_in_url;
		}

		return '<div id="imagescrollerfx'.$imagescrollerfx_embed_codes_count.'">'.$params[3].'</div><script type="text/javascript">'."swfobject.embedSWF('{$joomla_install_dir_in_url}{$imagescroller_path}{$swf}', 'imagescrollerfx{$imagescrollerfx_embed_codes_count}', '{$imagescrollerfx_width}', '{$imagescrollerfx_height}', '9.0.0.0', '', { folderPath: '{$joomla_install_dir_in_url}{$imagescroller_path}'".($settings != 'settings.xml' ? ", settingsXML: '{$settings}'" : '')." }, { scale: 'noscale', salign: 'tl', wmode: 'transparent', allowScriptAccess: 'sameDomain', allowFullScreen: true }, {});</script>";
	}
}
