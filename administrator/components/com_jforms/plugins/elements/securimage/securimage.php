<?php
/**
* Securimage Element plugin
*
* @version		$Id: securimage.php 136 2009-04-14 21:02:05Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*
* Slightly modified version from the original file written by my mentor "Jui-Yu Tsai"
*
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormEPluginSecurimage{

	function render( $elementData ){
	    
		$p = JArrayHelper::toObject($elementData->parameters);
		
		$error   = isset($elementData->validationError)?$elementData->validationError:'';
	
		$htmlId = $p->hash.'_'.$elementData->id;

		$output  = '';

		$css	    = property_exists($p,'css' )?$p->css:'';
		
		$output .= _line('<p style="margin-top:10px;">'.JText::_("Type the characters you see in the picture below").'</p>',2);           
		$output .= _line('<img class="'.$css.'" src="'.JURI::root().'administrator/components/com_jforms/plugins/elements/securimage/'.'securimage_show.php?sid='. session_id().'" /><br />',2);       
		$output .= _line('<br /><input name="'.$p->hash.'" class="'.$css.'" />',2);       
		$output .= _line("<div class='error-message' id='{$htmlId}_error'>$error</div>",2	);
		$output .= _line('<div class="clear"></div>',2);

		return $output;

	}
	
	function validate( $elementData, $input ){
		
		$p = JArrayHelper::toObject($elementData->parameters);
		include("securimagelib.php");
		$session =& JFactory::getSession();
		$correctValue = $session->get('securimage_code_value');
		if( strtolower($input) == strtolower($correctValue) ){
			return '';
		} else {
			return JText::_("The text you have entered didn't match the image");	
		}
	}
}