<?php 
/**
* XML Export plugin
*
* @version		$Id: Xml.php 158 2009-06-06 04:51:29Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormXPluginXml{
	
	function _correctLabel( $label ){
		$label = str_replace(array("\r","\n"),'',$label);
		$label = str_replace('&#039;', '&apos;', htmlspecialchars($label, ENT_QUOTES));
		return $label;
	}
	
	function onExport( $pluginParameters,$requestParameters, $data ){
		
		$filename = 'exported-data.xml';
		header('Content-type: text/xml');
		
		if( $pluginParameters['saveToDisk'] )
			header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$records = $data['records'];
		$labels  = explode("\r\n", $requestParameters['labels']);
		$ids     = $data['loaded_fields'];
		
		$output = _line('<?xml version="1.0" encoding="UTF-8"?>',0);
		
		$output .= _line('<records>',0);
		for($i=0;$i<count($records);$i++){
			$output .= _line('<record>',1);
			for($j=0;$j<count($records[$i]);$j++){
				$correctedLabal = JFormXPluginXml::_correctLabel($labels[$j]);
				$output .= _line('<field id="'.$ids[$j].'" label="'.$correctedLabal.'">'.str_replace('<br />',"\n",$records[$i][$j]).'</field>',2);
			}
			$output .= _line('</record>',1);
		}
		$output .= _line('</records>',0);
		
		echo $output;
		die;

	}
	
}