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
 

	

class JElementJboverridecheck extends JElement
{
	

	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jboverridecheck';

	function fetchElement($name, $value, &$node, $control_name)
	{
		return '<h4 class="jbtitle overridecheck">Style Overrides</h4><p>The following list highlights which files are being overriden by a child theme in your template. If you see a tick next to the template area then you will find an override file in the child theme folder. If you changed the style without saving, first apply the changes before changing these values.</p>';
	}
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>