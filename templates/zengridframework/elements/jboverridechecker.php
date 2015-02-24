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
 

	

class JElementJboverridechecker extends JElement
{
	

	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jboverridechecker';

	function fetchElement($name, $value, &$node, $control_name)
	{
	
		require_once('zengrid.php');
	
		$style = Zengrid::getParam('style');
		
		$path =  JPATH_ROOT.DS.'templates'.DS.Zengrid::getTemplate().DS.'layout'.DS;
		
		if(file_exists($path.$name.".php")) { $html = '<img src="images/tick.png" /> Override Available';  }
		else { $html = '<img src="images/publish_x.png" /> Override Not Found'; }

		$options = array();
		$options[] = JHTML::_('select.option', '1', JText::_('Enabled'));
		$options[] = JHTML::_('select.option', '0', JText::_('Disabled'));

		return JHTML::_('select.radiolist', $options, ''.$control_name.'['.$name.']', '', 'value', 'text', $value, $control_name.$name ) . $html;
	}
	
}
?>