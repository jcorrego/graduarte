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

class JElementJbtabs extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'jbtabs';

	function fetchElement($name, $value, &$node, $control_name)
	{
		require_once('zengrid.php');
		$allEqual = Zengrid::getParam('allEqual');
		$html = '<div id="jbtabs"><dl class="toptabs" id="myPane">
		<!------Appearance------><dt id="overview"><a href="#0.0" onclick="accordion.display(0)"><span class="overview">Overview</span></a></dt><dd>
			<ul class="toplevel"><li><a href="#0.0" class="overview"  onclick="accordion.display(0)">Overview</a></li>
				<li><a href="#0.27" class="overview"  onclick="accordion.display(27)">Documentation</a></li>
				<li><a class="modal positions" rel="{handler: \'iframe\', size: {x: 700, y: 600}}" href="http://www.joomlabamboo.com/images/stories/zengrid2/ZenGridFrameworkModulePositions.png">Module Positions</a></li>
			</ul></dd>
			<dt id="appearance"><a href="#1.2" onclick="accordion.display(2)"><span class="appearance">Appearance</span></a></dt><dd>
			<ul class="toplevel"><li><a href="#1.2" onclick="accordion.display(2)">Theme</a></li>
				<li><a href="#1.3" onclick="accordion.display(3)">Logo</a></li>
				<li><a href="#1.20" onclick="accordion.display(20)">Tagline</a></li>
				<li><a href="#1.4" onclick="accordion.display(4)">Fonts</a></li>
				<li><a href="#1.19" onclick="accordion.display(19)">CSS Overrides</a></li>
			</ul><dt id="Layout">
		<!------Layout------> <a href="#2.5" class="layout" onclick="accordion.display(5)"><span class="layout">Layout</span></a></dt><dd>
		<ul class="sub"><li><a href="#2.5" class="layout" onclick="accordion.display(5)">Settings</a></li>';
		
		if ($allEqual) { 
			$html .= '<li><a class="subtop inactive hasTip" href="" title="Top Disabled::This tab is not available as you have set the modules to have equal widths, if you wish to change widths please disable this in the settings.">Top</a></li>'; 
			$html .= '<li> <a class="subheader inactive hasTip" href="#" title="Header Disabled::This tab is not available as you have set the modules to have equal widths, if you wish to change widths please disable this in the settings.">Header</a></li>'; 
			$html .= '<li><a class="subnav" href="#2.8" onclick="accordion.display(8)">Nav</a></li>';
			$html .= '<li><a class="subtopgrid inactive hasTip" href="#" title="Grid 1-12 Disabled::This tab is not available as you have set the modules to have equal widths, if you wish to change widths please disable this in the settings.">Grid 1-12</a></li>'; 
		}
		else {
			$html .= '<li><a class="subtop" href="#2.6" onclick="accordion.display(6)">Top</a></li>';
			$html .= '<li><a class="subheader" href="#2.7" onclick="accordion.display(7)">Header</a></li>';
			$html .= '<li><a class="subnav" href="#2.8" onclick="accordion.display(8)">Nav</a></li>';
			$html .= '<li><a class="subtopgrid" href="#2.9" onclick="accordion.display(9)">Grid1-12</a></li>';
		}
		
		$html .= '<li><a class="submain" href="#2.10" onclick="accordion.display(10)">Main</a></li>
				  <li><a class="subadvert" href="#2.11" onclick="accordion.display(11)">Advert Positions</a></li>';
				  
		if ($allEqual) {
			$html .= '<li><a class="subbottomgrid inactive hasTip" href="#" title="Grid 13-24 Disabled::This tab is not available as you have set the modules to have equal widths, if you wish to change widths please disable this in the settings.">Grid 13-24</a></li>'; 
			$html .= '<li><a class="subbottommods inactive hasTip" href="#" title="Bottom Disabled::This tab is not available as you have set the modules to have equal widths, if you wish to change widths please disable this in the settings.">Bottom modules</a></li>'; 
		}
		else {
			$html .= '<li><a class="subbottomgrid" href="#2.12" onclick="accordion.display(12)">Grid13 -24</a></li>';
			$html .= '<li><a class="subbottommods" href="#2.13" onclick="accordion.display(13)">Bottom modules</a></li>';
		}
				  
		$html .= '<li><a href="#2.18" onclick="accordion.display(18)">Overrides</a></li></ul></dd><!------Extras------>
		<dt id="Extras"><a href="#3.17" onclick="accordion.display(17)"><span class="extras">Scripts and Extras</span></a></dt><dd><ul class="misc">
		<li> <a href="#3.17" onclick="accordion.display(17)">Performance</a>  </li>
		<li><a href="#3.14" onclick="accordion.display(14)">Scripts for menus</a></li>
		<li> <a href="#3.15" onclick="accordion.display(15)">Hidden Panel</a>  </li>
		<li><a href="#3.16" onclick="accordion.display(16)">Analytics</a></li>
		<li><a href="#3.28" onclick="accordion.display(28)">IE6 PNG Fix</a></li>
		<li><a href="#3.29" onclick="accordion.display(29)">Extra Scripts</a></li></ul></dd></dl></div>';
		return $html;
	}
	
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}

}
?>


