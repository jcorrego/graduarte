<?php
/**
* Design View for JForms Component
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
		
require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'helper'.DS.'design.php');

/**
 * Design View
 *
 * @package    Joomla
 * @subpackage JForms
 */
class BackendViewDesign extends JView
{
	/**
	 * Design view display method
	 *
	 * The WYSIWYG form design environment , Where all the magic is going to happen 
	 *
	 * @return void
	 **/
	function display($row, $form, $storagePluginForms, $tpl = null)
	{	
		global $JFormGlobals;

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
	
		//Toolbar
		JToolBarHelper::title(   JText::_( 'JForms' ), 'generic.png' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		$javascriptBlock = BackendViewDesign::_prepareJavascript( $row );
		$settingsPane 	 = BackendViewDesign::_prepareSettingsPane( $row, $form, $storagePluginForms );
		
		
		$this->assignRef('row', $row );
		$this->assignRef('settingsPane', $settingsPane);
		$this->assignRef('storage_form', $storagePluginForms);
		$this->assignRef('storagePlugins', $pManager->storage_plugins);
	
		$this->assignRef('jsBlock', $javascriptBlock);
		
		//Display the template
		parent::display($tpl);
	}
	function _prepareSettingsPane( $row, $settingsForm, $storagePluginForms){
		
		global $JFormGlobals;		
		$pManager =& $JFormGlobals['JFormsPlugin'];
	
		$pane	=& JPane::getInstance('sliders');

		$formId = $row?$row->id:'';
		
		$output  = _line('<form action="index.php" method="post" name="adminForm" id="adminForm">',1);
		$output .= _line('<input type="hidden" name="params[id]" value='.$formId.' />',2);
		$output .= _line('<input type="hidden" name="params[fieldInformation]" id="fieldInformation" value="" />',2);
		$output .= _line('<input type="hidden" name="params[paramIds]" id="paramIds" value="" />',2);
	
		$title   = JText::_( 'Form information' );
		$output .= $pane->startPane("form-pane");
		$output .= $pane->startPanel( $title, "form-page" );
		$output .= $settingsForm->render(); 
	
		$theme = 'default';
		if( $row )$theme  = strlen($row->theme)>0?$row->theme:'default';
	
		$output .= JFormsDesignHelper::doThemeList( $theme );
		$output .= JFormsDesignHelper::doACLList( $row?explode( ',', $row->groups ):null );
		$output .= $pane->endPanel();
		$output .= $pane->endPane();
	
		$title = JText::_( 'Active plugins' );
		$output .= $pane->startPane("storage-pane");
		$output .= $pane->startPanel( $title, "storage-page" );
	
		$activeStoragePlugins = $row?explode(',',$row->plugins):array();
	
		foreach($pManager->storage_plugins as $p){ 

			$checked = in_array($p->name,$activeStoragePlugins)?'checked="checked"':'';
			//Database plugin is turned on for all forms
			if( $p->name=='Database' ){	
				
				$output .= _line('<input name="params[plugins][]" value="'.$p->name.'" id="paramsPlugins'. $p->name .'" type="checkbox" checked="checked" disabled="disabled" />',2);
				$output .= _line('<label class="paramlist_key" style="font-size:120%" for="paramsStoragePlugins'. $p->name .'">'. JText::_($p->name) .'</label>',2);
				$output .= _line('<br />',2);
			
			} else {
			
				$output .= _line('<input '. $checked .' name="params[plugins][]" value="'. $p->name .'" id="paramsPlugins'. $p->name .'" type="checkbox"  />',2);
				$output .= _line('<label class="paramlist_key" style="font-size:120%" for="paramsStoragePlugins'. $p->name .'">'. JText::_($p->name) .'</label>',2);
				$output .= _line('<br />',2);
			
			}
		}	
		$output .= $pane->endPanel();
	
		foreach($pManager->storage_plugins as $p){ 
	
			$title = JText::_( $p->name );
			$output .= $pane->startPanel( $title, $p->name."-page" );
			$output .= $storagePluginForms[$p->name]->render('JFormSPlugin'.$p->name.'Parameters');
			$output .= $pane->endPanel();
		}	
	
	
		$output .= $pane->endPane();
	
	
		$output .= _line('<input type="hidden" name="option" value="com_jforms" />',2);
		$output .= _line('<input type="hidden" name="task" value="" />',2);
		$output .= _line(JHTML::_( 'form.token' ),2); 
		$output .= _line('</form>',1);
	
		return $output;
	}
	
	function _prepareJavascript($row){
	
		$output  = _line("<script type='text/javascript'>",2);
		$output .= _line('//<![CDATA[',2);
		$output .= _line('var JTooltips = null;',2);
		$output .= _line('window.addEvent("domready", function(){',2);
		$output .= _line('JTooltips = new Tips($$(".hasTip"), { maxTitleChars: 50, fixed: false});',3);
	//	$output .= _line('maintblSize = $("main-table").getSize();',3);
	//	$output .= _line('sidebarSize = $("side-bar").getSize();',3);
	//	$output .= _line('workareaWidth = (maintblSize.size.x - sidebarSize.x);',3);
	//	$output .= _line('$("workarea").setStyle("width", workareaWidth + "px");',3);
		$output .= _line('});',2);
		
		
		
		$output .= JFormsDesignHelper::doJEditorFunction();
		$output .= JFormsDesignHelper::fillObligatoryList();
		$output .= _line('function placeFormElements(){',2);
		if( !is_null( $row ) ){
			foreach($row->fields as $f ){
				$output .= JFormsDesignHelper::JSappendElement( $f );
			}
		}
		$output .= _line('}',2);
		$output .= _line('//]]>',2);
		$output .= _line('</script>',2);
		return $output;

	}
	
}