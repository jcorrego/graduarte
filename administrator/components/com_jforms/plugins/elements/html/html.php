<?php
/**
* HTML Element plugin
*
* @version		$Id: html.php 300 2009-09-05 15:12:11Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormEPluginHtml{

	function render( $elementData ){
		$p = JArrayHelper::toObject($elementData->parameters);
		$p->htmlValue = base64_decode($p->htmlValue);
		$s =  $p->htmlValue;
		$css = property_exists($p,'css' )?$p->css:'';
		return "<div class='$css'>$s</div>";
	}
}