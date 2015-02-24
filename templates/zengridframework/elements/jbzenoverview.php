<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @Type        Core Framework Files
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a editors element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementJbzenoverview extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jbzenoverview';

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe;
		jimport('joomla.environment.browser');
		require_once('zengrid.php');
		
		$document =& JFactory::getDocument();
		$document->addStylesheet(JURI::root(true).'/templates/'.Zengrid::getFramework().'/elements/jbtabs.css'); 
		
		$browser = JBrowser::getInstance();
		if (substr_count(strtolower($browser->getBrowser()), 'msie') && $browser->getVersion() < 8) $document->addStylesheet(JURI::root(true).'/templates/'.Zengrid::getFramework().'/elements/jtabs_ie.css');
		
		JHTML::_('behavior.modal', 'a.modal');
		
		return '</td></tr></table><div id="jbtemplate"><h3 class="toggler atStart">'. $value .'</h3><div class="element atStart"><table class="adminlist">';
	}

	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>

 