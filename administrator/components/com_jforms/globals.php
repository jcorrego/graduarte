<?php
/**
* Global definitions and some useful functions
*
* @version		$Id: globals.php 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

//Debug
define('JFORMS_DEBUG_STATE',0);


jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');


define( 'JFORM_PLUGIN_STORAGE', 0 );
define( 'JFORM_PLUGIN_ELEMENT', 1 );
define( 'JFORM_PLUGIN_EXPORT' , 2 );

define( 'JFORMS_TYPE_NORMAL'  , 0 );
define( 'JFORMS_TYPE_PROFILE' , 1 );


define('FS_PATH', JPATH_ROOT.DS.'media'.DS.'com_jforms'.DS);
define('FS_URL' , JURI::root().'media/com_jforms/');
define('JFORMS_BACKEND_PATH' ,  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jforms');
define('JFORMS_FRONTEND_PATH',  JPATH_ROOT.DS.'components'.DS.'com_jforms');

/* Minor DB Upgrade (Ugly hack , removed in 0.7) */
if(!file_exists(JFORMS_BACKEND_PATH.DS.'upgraded')){

	$db    =& JFactory::getDBO();
	
	$sql = "UPDATE `#__jforms_parameters` SET `parameter_value` = REPLACE( `parameter_value`, '\\\\n','\\n' ) WHERE plugin_type=1";
	$db->setQuery( $sql );
	$db->query();
	
	$sql = "UPDATE `#__jforms_tparameters` SET `parameter_value` = REPLACE( `parameter_value`, '\\\\n','\\n' ) WHERE plugin_type=1";
	$db->setQuery( $sql ); 
	$db->query();
	
	fclose(fopen(JFORMS_BACKEND_PATH.DS.'upgraded', 'w'));
}
/*-----------------------------------------------*/

function get_include_contents($filename, $args) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}


//Create jforms file system directory
if( !JFile::exists( FS_PATH.DS.'index.html' ) ){
	if( !JFolder::exists(FS_PATH) ){
		JFolder::create(FS_PATH);
	}
	JFile::write( FS_PATH.DS.'index.html', '<html><head></head><body></body></html>' );
}

define('JFORM_SYSTEM_FIELDS','id');


if(JFORMS_DEBUG_STATE > 0){
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}

//Temporary debug function
function d($v){
	if(JFORMS_DEBUG_STATE>0){
		echo "<pre>";
		var_dump($v);
		echo "</pre>";
	}
}

if ( !function_exists( 'property_exists' ) ) {
    function property_exists( $class, $property ) {
        if ( is_object( $class ) ) {
            $vars = get_object_vars( $class );
        } else {
            $vars = get_class_vars( $class );
        }
        return array_key_exists( $property, $vars );
    }
}

if ((version_compare(phpversion(), '5.0') < 0) && !function_exists( 'clone' ) ) {
    eval('
    function clone($object) {
      return $object;
    }
    ');
}

function indexByHash( $fields ){
		
	$newArray = array();
	foreach( $fields as $f ){
		
		if( !isset( $f->parameters['hash'] ))continue;
		$hash = $f->parameters['hash'];
		$newArray[$hash] = $f;
	}
	return $newArray;

}

/**
 * A utility function that is used to output text that is properly indented for readability.
 *
 * @param string $line the text to be printed to a new line
 * @param int $level the level of indention of the line
 * @return string the passed text indented by "level" tabs
 */
function _line($line, $level)
{
	$tabs = str_repeat( "\t" , $level );
	return $tabs.$line."\n";
}