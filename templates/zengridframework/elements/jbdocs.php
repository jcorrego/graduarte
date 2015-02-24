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

class JElementJbdocs extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jbdocs';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$html = '<div id="documentation">';
		$html .= '<div class="width30"><p><strong>Appearance</strong></p><ul><li><a href="?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}"><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/template-overview-page?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Template Overview</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/zen-grid2-theme-options?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Theme Options</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/zen-grid2-logo-options?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Logo Settings</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/tagline-appearance?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Controlling the Tagline</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/assigning-font-stacks?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Using the font stacks</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/zen-grid2-css-overrides-appearance?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">CSS Overrides</a></li></ul></div><div class="width30"><p><strong>Layout Options</strong></p><ul><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/general-layout-settings?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">General Settings</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/exploring-template-overrides?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Template Overrides</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/controlliing-the-main-content-area?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Main Content Layout Options</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/controlling-module-layouts?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Controlling Module widths</a></li></ul></div>';
		$html .= '<div class="width30"><p><strong>Scripts and Extras</strong></p><ul><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/performance-scripts-and-extras?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Performance Tweaks</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/hidden-panel?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">The Hidden Panel</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/analytics?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Adding Analytics</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/enabling-menu-scripts?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Menu Scripts</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/ie6-png-fix?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">IE6 PNG Fix</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/extra-scripts?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Extra Scripts</a></li></ul></div><div class="clear"></div><div class="width30"><p><strong>Working with Joomla Bamboo Templates</strong></p><ul><li><a href="http://www.joomlabamboo.com/documentation/general-template-documentation/what-is-the-difference-between-a-joomla-template-and-the-quickstart-packages?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">The difference between the quickstart and the template.</a></li><li><a href="http://www.joomlabamboo.com/documentation/general-template-documentation/how-to-install-the-quickstart-package?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">How to install the quickstart package.</a></li><li><a href="http://www.joomlabamboo.com/documentation/general-template-documentation/how-to-install-the-jb-library-plugin?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">How to install the JB LIbrary plugin</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/setting-up-the-panel-menu?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Setting up the Panel Menu</a></li><li><a href="http://www.joomlabamboo.com/documentation/zen-grid-2-documentation/setting-up-the-superfish-menu?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Setting up the Superfish Menu</a></li></ul></div>';
		$html .= '<div class="width30"><p><strong>General Joomla Documentation</strong></p><ul><li><a href="?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Creating parent/child menu items</a></li><li><a href="http://www.joomlabamboo.com/documentation/joomla-tutorials/how-do-i-remove-the-welcome-to-the-front-page-text?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">How to change the welcome to frontpage text.</a></li><li><a href="http://www.joomlabamboo.com/documentation/general-template-documentation/how-to-install-a-joomla-module?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">How to install a Joomla module</a></li><li><a href="http://www.joomlabamboo.com/documentation/general-template-documentation/how-to-install-a-joomla-template?template=docs" class="modal positions" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">How to install a Joomla template</a></li></ul></div>';
		$html .= '</div>';
		
	
		
		
		return $html;
	}
	
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>