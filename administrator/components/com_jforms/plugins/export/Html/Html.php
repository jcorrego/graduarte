<?php 
/**
* HTML Export plugin
*
* @version		$Id: Html.php 168 2009-07-20 05:43:17Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormXPluginHtml{
	
	function onExport( $pluginParameters,$requestParameters, $data ){
		
		$filename = 'exported-data.html';
		header('Content-type: text/html');
		
		if( $pluginParameters['saveToDisk'] )
			header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$records = $data['records'];
		$title   = JText::_('Exported Data');
		
		$labels  = explode("\r\n", $requestParameters['labels']);

		
		$body  = _line('<table>',1);
		$body .= _line('<tr>',2);
		foreach( $labels as $l ){
			$body .= _line('<th>'.$l.'</th>',3);
		}
		$body .= _line('</tr>',2);
		
		$k = true;
		foreach( $records as $r ){
			$class = $k?'odd':'even';
			$body .= _line('<tr class="'.$class.'">',2);
			foreach($r as $f){
				$cellWidth = sprintf("%2.2f",100/count($r));
				$body .= _line('<td width="'.$cellWidth.'%">'.$f.'</td>',3);
			}
			$body .= _line('</tr>',2);
			$k = !$k;
		}
		$body .= _line('</table>',1);
		
		$html = file_get_contents(JPATH_COMPONENT_ADMINISTRATOR.DS.'plugins'.DS.'export'.DS.'Html'.DS.'tmpl.html');
		$html = str_replace('{PAGE_TITLE}', $title, $html);
		$html = str_replace('{BODY}'      , $body , $html);
		echo $html;
		die;

	}
	
}