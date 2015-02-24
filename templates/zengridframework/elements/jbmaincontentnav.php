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

class JElementJbmaincontentnav extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jbmaincontentnav';

	function fetchElement($name, $value, &$node, $control_name)
	{
		return '<div class="maincontentnav"><ul>
			<li><a href="#2.10" onclick="accordion.display(10)">Center</a></li>
			<li><a href="#2.21" onclick="accordion.display(21)">2 Cols L</a></li>
			<li><a href="#2.22" onclick="accordion.display(22)">2 Cols R</a></li>
			<li><a href="#2.23" onclick="accordion.display(23)">3 Cols</a></li>
			<li><a href="#2.24" onclick="accordion.display(24)">4 Cols</a></li>
			<li><a href="#2.25" onclick="accordion.display(25)">3 Cols L + C</a></li>
			<li><a href="#2.26" onclick="accordion.display(26)">3 Cols C + R</a></li>
			</ul></div>';
	}
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>