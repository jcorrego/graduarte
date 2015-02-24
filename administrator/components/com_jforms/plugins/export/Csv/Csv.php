<?php 
/**
* HTML Export plugin
*
* @version		$Id: Csv.php 158 2009-06-06 04:51:29Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormXPluginCsv{
	
	function onExport( $pluginParameters,$requestParameters, $data ){
		
		$filename = 'exported-data.csv';
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		$records = $data['records'];
		$labels  = explode("\r\n", $requestParameters['labels']);

		
		echo '"'.implode('","',$labels)."\"\r\n";
	
		foreach( $records as $r ){
			echo '"'.implode('","',$r)."\"\r\n";
		}
		die;

	}
	
}