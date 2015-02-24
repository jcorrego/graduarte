<?php
/**
* JUser Element plugin
*
* @version		$Id: juser.php 170 2009-08-12 07:29:38Z dr_drsh $
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

class JFormEPluginJuser{


	function validate( $elementData, $input ){return '';}
	function getSQL( $elementData, $keywords ){return '';}
	function jsValidation( $elementData ){return '';}
	function jsClearErrors( $elementData ){return '';}

	function render( $elementData ){ 	
	
		$p = JArrayHelper::toObject($elementData->parameters);
		return _line("<input type='hidden' value='' name='{$p->hash}' />",2);
	
	}

	function translate ( $elementData, $input, $format='html' ){

		$object =  unserialize(base64_decode( $input ));
		
		$output  = '';
		switch( $format ){
		
		 case 'raw':
			//A guest?
			if( $object == null ){
				$output = JText::_('Guest');
				break;
			}
			//Otherwise
			$output .= JText::_('ID').':'.$object->id;
			$output .= "\n".JText::_('Username').':'.$object->username; 
			$output .= "\n".JText::_('Name').':'.$object->name;
			$output .= "\n".JText::_('User type').':'.$object->type;
			$output .= "\n".JText::_('E-mail').':'.$object->email;
			break;

		 default:
		 case 'html':
			//A guest?
			if( $object == null ){
				$output = JText::_('Guest');
				break;
			}
			//Otherwise
			$output .= '<strong>'.JText::_('ID').'</strong>: ' . $object->id.'<hr />';
			$output .= "\n".'<strong>'.JText::_('Username').'</strong>: ' . $object->username .'<hr />';
			$output .= "\n".'<strong>'.JText::_('Name').'</strong>: ' . $object->name.'<hr />';
			$output .= "\n".'<strong>'.JText::_('User type').'</strong>: ' . $object->type.'<hr />';
			$output .= "\n".'<strong>'.JText::_('E-mail').'</strong>: ' . $object->email.'<hr />';
			break;
		}
		return $output;

	}	
	
	function beforeSave( $elementData, $input ){
	
		//We don't need any input
		$input = null;
		
		$user =& JFactory::getUser();
		
		if( $user->guest ){
			return base64_encode(serialize(null));
		}
		
		$output = new stdClass();
		$output->id = $user->id;
		$output->name = $user->name;
		$output->username = $user->username;
		$output->email = $user->email;
		$output->type = $user->usertype;
		
		return base64_encode(serialize($output));

	}
}
			 