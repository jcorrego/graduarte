<?php
/**
* Form View for JForms Component
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

/**
 * Form View
 *
 * @package    Joomla
 * @subpackage JForms
 */
class FrontendViewForm extends JView
{

	function display_thank( $form , $tpl = null ){
	
		$document =& JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_jforms/views/form/'.$form->theme.'.css');
		
		$this->assignRef('form', $form );
		
		//Display the template
		parent::display($tpl);
		
	}

	/**
	 * Form view display method
	 *
	 * Displays requested form
	 *
	 * @return void
	 **/
	function display($form, $tpl = null)
	{
		global $JFormGlobals,$Itemid;
		
		$document =& JFactory::getDocument();
		
		$document->addStyleSheet(JURI::base().'components/com_jforms/views/form/'.$form->theme.'.css');

		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		//Load Element Plugins
		$pManager->loadElementPlugins();

		$jsCode = '';
		$jsValidationFunction = '';
		$jsClearErrorFunction = '';
		
		foreach( $form->fields as $f ){
			$jsClearErrorFunction .= $pManager->invokeMethod('jsClearErrors', JFORM_PLUGIN_ELEMENT, 
									array($f->type), array( $f ) ) . "\n";
			
			$jsValidationFunction .= $pManager->invokeMethod('jsValidation', JFORM_PLUGIN_ELEMENT, 
									array($f->type), array( $f ) ) . "\n";
		}
		
		$id=$form->id;
		$jsCode .= _line('<script type="text/javascript">',1);
		$jsCode .= _line('//<![CDATA[',1);
		$jsCode .= _line('function clearErrors_'.$id.'( form ){',1);
		$jsCode .= $jsClearErrorFunction;
		$jsCode .= _line('}',1);
		$jsCode .= _line('function validateForm_'.$id.'( form ){',1);
		$jsCode .= _line('var errorArray = new Array();',2);
		$jsCode .= _line('clearErrors_'.$id.'();',2);
		$jsCode .= $jsValidationFunction;
		$jsCode .= _line('if(errorArray.length){',2);
		$jsCode .= _line('for(i=0;i<errorArray.length;i++){',3);
		$jsCode .= _line('',4);
		$jsCode .= _line('',4);
		$jsCode .= _line('',4);
		$jsCode .= _line('}',3);
		$jsCode .= _line('return false;',3);
		$jsCode .= _line('}',2);
		$jsCode .= _line('return true;',2);
		$jsCode .= _line('}',1);
		
		$jsCode .= _line('//]]>',1);
		$jsCode .= _line('</script>',1);
		echo $jsCode;
		
		$user   =& JFactory::getUser();
		
		$this->assignRef('row'     , $form );
		$this->assignRef('pManager', $pManager );
		$this->assignRef('uid'     , $user->id );
		$this->assignRef('Itemid'  , $Itemid );
		
		//Display the template
		parent::display($tpl);
	}

}