<?php
/**
* JFormsRecordsHelper class 
*
*
* @version		$Id: records.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/


class JFormsRecordsHelper{

	/**
	 * Outputs Javascript/HTML required for session status indicators
	 *
	 * @return void
	 */
	function doSessionStatus(){;}
	
	
	/**
	 * Outputs Javascript required to load external Stylesheet for the records sheet area
	 *
	 * @return void
	 */
	function loadCSS(){
	
		$pathStandard = JURI::base().'components/com_jforms/views/records/style.css';
		$pathIE       = JURI::base().'components/com_jforms/views/records/style_ie.css';
		$output = '';
		
		$output .= _line('<script type="text/javascript">',1);
		$output .= _line('//<![CDATA[',1);
		//$output .= _line('function loadCSS(){',1);
		$output .= _line('var standardCSS = document.createElement("link");',2);
		$output .= _line('standardCSS.href = "'.$pathStandard.'";',2);
		$output .= _line('standardCSS.rel = "stylesheet";',2);
		$output .= _line('standardCSS.type = "text/css";',2);
		$output .= _line('document.head.appendChild(standardCSS);',2);
		$output .= _line('if(Browser.Engine.trident){',2);
		$output .= _line('var ieCSS = document.createElement("link");',3);
		$output .= _line('ieCSS.href = "'.$pathIE.'";',3);
		$output .= _line('ieCSS.rel = "stylesheet";',3);
		$output .= _line('ieCSS.type = "text/css";',3);
		$output .= _line('document.head.appendChild(ieCSS);',3);
		$output .= _line('}',2);
		//$output .= _line('}',1);
		//$output .= _line('window.addEvent("load",loadCSS);',1);
		$output .= _line('//]]>',1);
		$output .= _line('</script>',1);
		
	
		
		return $output;
	}
	
	/**
	 * Outputs HTML <script> tags that includes the javascript
	 *
	 * @return void
	 */
	function loadJS($template)
	{	

		$jsDirURI = JURI::base().'components/com_jforms/JS/';
		$output = '';

		$src = $jsDirURI.'utilities.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$output .= _line('<script type="text/javascript">',1);
		$output .= _line('//<![CDATA[',1);
		$output .= get_include_contents(JFORMS_BACKEND_PATH.DS.'JS'.DS.'records.js.php', $template);	
		$output .= _line('window.addEvent("load", reload);',2);
		$output .= _line('window.addEvent("load", initSearchList);',2);
		$output .= _line('//]]>',1);
		$output .= _line('</script>',1);

		
		$src = $jsDirURI.'dhtmlxcommon.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$src = $jsDirURI.'dhtmlxgrid.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$src = $jsDirURI.'dhtmlxgridcell.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);


		echo $output;
	}
	
}