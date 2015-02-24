<?php
/**
 * Yireo Template Helper for Joomla! 1.5
 *
 * @author Yireo (info@yireo.com)
 * @package Yth
 * @copyright Copyright 2010
 * @license GNU Public License
 * @link http://www.yireo.com
 * @version 0.8
 */

// Check to ensure this file is included in Joomla!  
defined('_JEXEC') or die();

/*
 * Yireo template class
 *
 * @static
 * @package Yth
 */
class Yth 
{

    /*
     * Method to get the HTML of a splitmenu
     *
     * @static
     * @access public
     * @param string $menu 
     * @param int $startLeve
     * @param int $endLevel
     * @param bool $show_children
     * @return string
     */
    public function getSplitMenu( $menu = 'mainmenu', $startLevel = 0, $endLevel = 1, $show_children = false ) 
    {
        // Import the module helper
        jimport('joomla.application.module.helper');

        // Get a new instance of the mod_mainmenu module
        $module =& JModuleHelper::getModule( 'mod_mainmenu', 'mainmenu' );
        if(!empty($module) && is_object($module)) {

            // Construct the module parameters (as a string)
            $params = "menutype=".$menu."\n" 
                . "showAllChildren=".$show_children."\n"
                . "startLevel=".$startLevel."\n"
                . "endLevel=".$endLevel;
            $module->params = $params;

            // Construct the module options
            $options = array( 'style' => 'raw' );

            // Render this module
            $document =& JFactory::getDocument();
            $renderer = $document->loadRenderer('module');
            $output = $renderer->render($module, $options);
            return $output;
        }

        return null;
    }

    /*
     * Method to determine whether a certain module is loaded or not
     *
     * @static
     * @access public
     * @param string $name
     * @return bool
     */
    public function hasModule($name = '') 
    {
        // Import the module helper
        jimport('joomla.application.module.helper');

        $instance = JModuleHelper::getModule($name);
        if(is_object($instance)) {
            return true;
        }

        return false;
    }

    /*
     * Method to get the parent Menu-Item of the current page
     *
     * @static
     * @access public
     * @param int $level
     * @return string
     */
    public function getActiveParent($level = 0) 
    {
        // Fetch the active menu-item
        $menu = JSite::getMenu();
        $active = $menu->getActive();

        // Get the parent (at a certain level)
        $parent = $active->tree[$level];

        // Return the title of this Menu-Item
        return $menu->getItem($parent)->name;
    }

    /*
     * Method to determine whether the current page is the Joomla! homepage
     *
     * @static
     * @access public
     * @param null
     * @return bool
     */
    public function isHome() 
    {
        // Fetch the active menu-item
        $menu = JSite::getMenu();
        $active = $menu->getActive();

        // Return whether this active menu-item is home or not
		if (isset($active))
        return (boolean)$active->home;
		else return false;
    }

    /*
     * Method to add a global title to every page title
     *
     * @static
     * @access public
     * @param string $global_title
     * @return null
     */
    public function addGlobalTitle( $global_title = null ) 
    {
        // Get the current title
        $document = JFactory::getDocument();
        $title = $document->getTitle();

        // Add the global title to the current title
        $document->setTitle( $title . '' . $global_title );
    }

    /*
     * Method to detect a certain browser type
     *
     * @static
     * @access public
     * @param string $shortname
     * @return string
     */
    public function isBrowser($shortname = 'ie6')
    {
        jimport('joomla.environment.browser'); 
        $browser = JBrowser::getInstance(); 
        $name = $browser->getBrowser(); 

        $rt = false;
        switch($shortname) {
            case 'ie6':
                $rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '6.0') ? true : false;
                break;

            case 'ie7':
                $rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '7.0') ? true : false;
                break;

            case 'ie8':
                $rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '8.0') ? true : false;
                break;
        }

        return $rt;
    }

    /*
     * Method to construct the URL for the Yireo CSS/PHP-script
     *
     * @static
     * @access public
     * @param array $stylesheets
     * @param bool $system_css
     * @return string
     */
    public function addCssPhp($stylesheets, $system_css = false) 
    {
        $template = JFactory::getApplication()->getTemplate();
        $path = 'templates/zengridframework/'.Yth::loadCssPhp($stylesheets, $system_css);
        echo '<link rel="stylesheet" href="'.$path.'" type="text/css" />';
    }

    /*
     * Method to construct the URL for the Yireo CSS/PHP-script
     *
     * @static
     * @access public
     * @param array $extra
     * @return string
     */
    public function loadCssPhp($sheets = array(), $system_css = false) 
    {
        // The actual file
        $css_php = 'css/css.php';

        // Detect component CSS automatically
        $option = JRequest::getCmd('option');
        if(is_file(dirname(__FILE__).'/css/'.$option.'.css')) {
            $sheets[] = $option;
        }

        // Load the sheet options
        $options = array();
        if(!empty($sheets) && is_array($sheets)) {
            $options[] = 's='.implode(',', $sheets);
        }

        // Add a SSL-flag
        if(JURI::getInstance()->isSsl()) {
            $options[] = 'ssl=1';
        }

        // Add the system CSS flag
        if($system_css == true) {
            $options[] = 'system=1';
        }

        if(!empty($options)) {
            $css_php .= '?'.implode('&amp;', $options);
        }
        return $css_php;
    }
}
