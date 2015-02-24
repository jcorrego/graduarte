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

class JElementJbtabsplit extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jbtabsplit';

	function fetchElement($name, $value, &$node, $control_name)
	{
		//return '</td></tr></table></div><div id="tab2" class="mootabs_panel"><table class="adminlist"><tr><td>';
		return '</td></tr></table></div><h3 class="toggler atStart">'. $value . '</h3><div class="elements atStart"><table class="adminlist">';
	}

	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>