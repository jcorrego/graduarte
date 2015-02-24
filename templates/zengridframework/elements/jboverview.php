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

class JElementJboverview extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jboverview';

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe;
		
		require_once('zengrid.php');
		
		$logopath = str_replace('\\', '/', JPATH_ROOT.Zengrid::getParam('logoLocation').DS);
		$logo = false;
		
		if (is_dir($logopath)) {
			$logodir = opendir($logopath);
			while (($file = readdir($logodir)) !== false) {
        	    if ($file == Zengrid::getParam('logoFile')) $logo = true;
			}
			closedir($logodir);
        }
        
		
		if (!$logo) JError::raiseNotice('400', 'Logo does not exist. Please update your <a href="#" onclick="accordion.display(3)">Logo Settings</a>');

		$manifest = Zengrid::getManifest();
		
		$style = Zengrid::getParam('style');
		
		$path = JPATH_ROOT.DS.'templates'.DS.Zengrid::getTemplate().DS.'layout'.DS;
		
		$override['banner'] = 'Banner';
		$override['bottom'] = 'Bottom';
		$override['closeContainer'] = 'Close Container';
		$override['footer'] = 'Footer';
		$override['grid1'] = 'Grid 1';
		$override['grid2'] = 'Grid 2';
		$override['grid3'] = 'Grid 3';
		$override['grid4'] = 'Grid 4';
		$override['grid5'] = 'Grid 5';
		$override['grid6'] = 'Grid 6';
		$override['header'] = 'Header';
		$override['index'] = 'Entire Index';
		$override['main'] = 'Main Content';
		$override['nav'] = 'Navigation';
		$override['openContainer'] = 'Opening Container';
		$override['panel'] = 'Panel';
		$override['top'] = 'Top';
		
		$override_check = 'There are no overrides affecting your template.';
		foreach ($override as $name => $label) {
			if(file_exists($path.$name.".php")) { 
				$override_check = 'Your template has active overrides. Please view the active overrides <a href="#" onclick="accordion.display(18)">here</a>.';
			}
		}
		
		$html = '<h3 class="toggler atStart"></h3><div class="element atStart"></div><div class="intro"><p class="jboverview"><a href="http://www.joomlabamboo.com"><img src="'.JURI::root(true).'/templates/'.Zengrid::getTemplate().'/templateTeaser.jpg" alt="joomla Bamboo" style="float:left;margin: 0 20px 20px 0;width:607px;height:250px"/></a>This template is built upon the Zen Grid Framework which takes the core features of the flexible 960 Grid css system/framework and ports it to Joomla inside an elegant, easy to use template scaffold that gives you complete control over all aspects of layout and styling.</p>';
		$html .= '<div class="clear"></div><h3 class="intro">Current settings</h3><ul id="zgf_overview">';
		$html .= '<li><strong>Zen Grid Version:</strong> ' . $manifest->version . '</li>';
		$html .= '<li><strong>Current Logo:</strong> ' . Zengrid::getParam('logoLocation') . '/' . Zengrid::getParam('logoFile') . '</li>';
		$html .= '<li><strong>Core Template Overrides:</strong> ' . $override_check . '</li>';
		$html .= '</ul>';
		
		return $html;
	}
	
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>
