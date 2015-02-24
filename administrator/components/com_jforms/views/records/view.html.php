<?php
/**
* Records View for Forms Component
*
* @version		$Id: view.html.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');

require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'helper'.DS.'records.php');

/**
 * Records View
 *
 * @package    Joomla
 * @subpackage JForms
 */
class BackendViewRecords extends JView
{

	/**
	 * Records view display method
	 *
	 * Displays Records (Stored data)
	 *
	 * @return void
	 **/
	function display($form, $exportPluginForms, $elementPluginForms,  $tpl = null)
	{
		global $JFormGlobals;
		
		if( !count($form->records)){
			echo '<div style="font-size:150%;text-align:center;color:red;font-weight:bold">'.JText::_('No records stored yet').'<br /><br /><a href="javascript:history.back();">&lt;&lt; '.JText::_('Go Back').'</a></div>';
		} else {
		
			//Nasty hack warning [To get the component to work under 1.5 and 1.11 mootools]
			$doc = &JFactory::getDocument();
			$newScriptArray = array();
			foreach( $doc->_scripts as $k => $v ){
				if( strpos($k, 'media/system/js/mootools.js') === false ){
					$newScriptArray[$k] = $v;
				}
			}
			$newScriptArray[JURI::root().'administrator/components/com_jforms/JS/mootools.1_20.js'] = 'text/javascript' ;
			$doc->_scripts = $newScriptArray;
			//End of nasty hack
		
			//Disable top menu "Thanks Ercan :)"
			JRequest::setVar('hidemainmenu', 1);		
		
			$pManager =& $JFormGlobals['JFormsPlugin'];
		
			JToolBarHelper::title(   JText::_( 'JForms' ), 'generic.png' );

			JToolBarHelper::back();
			$exportPluginFormsHTML  = $this->_prepareExportPane( $form->id, $exportPluginForms);
			$elementPluginFormsHTML = $this->_prepareAdvancedSearchPane( $form, $elementPluginForms );
			$dbMappingHTML = $this->_prepareDBMappingPane( $form );
			
			$this->assignRef('form', $form);
			$this->assignRef('pManager', $pManager);
			$this->assignRef('exportPluginFormsHTML', $exportPluginFormsHTML);
			$this->assignRef('elementPluginFormsHTML', $elementPluginFormsHTML);
			$this->assignRef('dbMappingHTML', $dbMappingHTML);
			
			$this->assignRef('constructKeywordJS', $this->_prepareConstructKeywordJS($form));
			
			//Display the template
			parent::display($tpl);
		}
	}
	
	function _prepareConstructKeywordJS( $form ){
	
		$output = "\r\n";
		$output .= _line("function constructKeyword(){",1);
		$output .= _line("var KeywordsObject = new Object();",2);
		
			
		foreach( $form->fields as $f ){
			
			$hash = $f->parameters['hash'];
			$arrayBase = 'JFormEPlugin'.$hash.'Parameters';
			$output .= _line("var Children = getHTMLArrayChildren('$arrayBase',$('filter_form'));",2);
			$output .= _line("KeywordsObject.$hash = new Object();",2);
			$output .= _line("for(i=0;i<Children.length;i++){",2);
			$output .= _line("KeywordsObject.$hash [Children[i][1]]=$('filter_form').elements[Children[i][0]].value;",3);
			$output .= _line("}",2);
			
		}
		$output .= _line("var orderedKeywords = new Object();",2);
		$output .= _line("$$('#search-pane-list li').each(function(li) { var hash = li.get('title').split('|')[0];orderedKeywords[hash] = KeywordsObject[hash]; })",2);
		
		$output .= _line("return JSON.encode(orderedKeywords);",1);
		$output .= _line("}",1);

		
		return $output;
	}
	
	function _prepareDBMappingPane( $form ){
		
		global $JFormGlobals;		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadElementPlugins();
		
		$output  = _line('<table style="font-weight:bold;">',1);
		$output .= _line('<tr>',1);
		$output .= _line('<td>ID</td>',2);
		$output .= _line('<td style="color:green">id</td>',2);
		$output .= _line('</tr>',1);
		
		foreach($form->fields as $f){
			if( !$pManager->elementHasStorageRequirements( $f ) )continue;
			
			$output .= _line('<tr>',1);
			$output .= _line('<td>'.$f->parameters['label'].'</td>',2);
			$output .= _line('<td style="color:green">'.$f->parameters['hash'].'</td>',2);
			$output .= _line('</tr>',1);
		}
		$output .= _line('</table>',1);
		
		return $output;
		
	}
	
	function _prepareAdvancedSearchPane( $form, $searchPluginForms ){
		
		global $JFormGlobals;		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadElementPlugins();
		
		$pane	=& JPane::getInstance('sliders');
		$output = '';
	
		//Very dirty hack to fix the annoying issue with sliders where a slider is open, but too short to show its contents, now they all show up closed
		$output .= _line('<div style="display:none">',1);
		$output .= $pane->startPane('xyz');	
		$output .= $pane->startPanel( 'xyz-p', 'xyz-p' );
		$output .= $pane->endPanel();
		$output .= $pane->endPane();
		$output .= _line('</div>',1);
		//End of dirty hack
		
		
		$output .= $pane->startPane("search-pane");
		$output .= '<ul id="search-pane-list">';


		foreach($searchPluginForms as $hash => $f){
			
			$title   = $f->label;
			$output .= '<li title="'.$hash.'|'.$title.'">';
			$output .= '<div class="search-pane-list-handle"></div>';
			$output .= '<div class="search-pane-list-check"><input value="$hash|$title" type="checkbox" name="loaded_headers[]" checked="checked" id="header_'.$hash.'" /></div>';
			$output .= $pane->startPanel( $title, $hash."-page" );
			$output .= $f->render('JFormEPlugin'.$hash.'Parameters');
			$output .= $pane->endPanel();

		}	
		$output .= '</ul>';
		$output .= $pane->endPane();
		
		
		return $output;
	}
	
	
	function _prepareExportPane($id, $exportPluginForms){
		

		global $JFormGlobals;		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadExportPlugins();
		
		$pane	=& JPane::getInstance('sliders');
		$output = '';
	
		/*
		//Very dirty hack to fix the annoying issue with sliders where a slider is open, but too short to show its contents, now they all show up closed
		$output .= _line('<div style="display:none">',1);
		$output .= $pane->startPane('xyz');	
		$output .= $pane->startPanel( 'xyz', 'xyz' );
		$output .= $pane->endPanel();
		$output .= $pane->endPane();
		$output .= _line('</div>',1);
		//End of dirty hack
		*/
		
		$output .= $pane->startPane("export-pane");
		
		foreach($pManager->export_plugins as $p){
	
			$title   = JText::_( $p->name );
			$output .= $pane->startPanel( $title, $p->name."-page" );
			$output .= _line('<form action="index.php" method="post" name="exportForm'.$p->name.'" id="exportForm'.$p->name.'">',1);	
			$output .= _line('<input type="hidden" name="params[name]" value="'.$p->name.'" />'   ,2);
			$output .= _line('<input type="hidden" name="params[fid]" value="'.$id.'" />'   ,2);
			$output .= _line('<input type="hidden" name="params[keyword]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[fields]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[labels]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[start]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[rpp]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[page]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[pageCount]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[recordCount]"  value="" />',2);
			$output .= _line('<input type="hidden" name="params[ids]"  value="" />',2);

			$output .= _line('<input type="hidden" name="option" value="com_jforms" />',2);
			$output .= $exportPluginForms[$p->name]->render('JFormXPlugin'.$p->name.'Parameters');
			$output .= _line('<input type="hidden" name="task" value="export" />',2);
			$output .= _line(JHTML::_( 'form.token' ),2); 
			$output .= _line("<input type='button' onclick='doExport(\"exportForm".$p->name."\");' class='button' value='".JText::_('Export')."' />",2);
			$output .= _line('</form>',1);
			$output .= $pane->endPanel();
		}	
		$output .= $pane->endPane();
	
		
		return $output;
	}
}