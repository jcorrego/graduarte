<?php 
/**
* XLS Export plugin
*
* @version		$Id: Xls.php 158 2009-06-06 04:51:29Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

include 'excel.php';

class JFormXPluginXls{
	
	function onExport( $pluginParameters, $requestParameters, $data ){
		
		$records = $data['records'];
		$labels  = explode("\r\n", $requestParameters['labels']);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=exported-data.xls "); 
		header("Content-Transfer-Encoding: binary ");
	
		xlsBOF();
		for($i=0;$i<count($labels);$i++){
			xlsWriteLabel( 0, $i, $labels[$i] );
		}
		
		
		for($i=0;$i<count($records);$i++){
			for($j=0;$j<count($records[$i]);$j++){
				if(is_numeric($records[$i][$j]))xlsWriteNumber( $i+1, $j, $records[$i][$j] );
				else xlsWriteLabel( $i+1, $j, $records[$i][$j] );
			}
		}
		xlsEOF();
		exit();

	}
	
}