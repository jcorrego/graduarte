<?php
/**
* Button Element plugin
*
* @version		$Id: button.php 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JFormEPluginButton{
	
	
	function render( $elementData ){

		$p = JArrayHelper::toObject($elementData->parameters);
		$p->label = htmlspecialchars($p->label, ENT_QUOTES);
		
		$output  = '';
		
		$css   = property_exists($p,'css' )?$p->css:'';
	
		switch( $p->func ){
			
			case 'Submit':
				$output .= _line("<input name='$p->hash' class='$css' type='submit' value='$p->label' style='width:{$p->cw}px;height:{$p->ch}px;' />",2);
				break;

			case 'Reset':
				$output .= _line("<input name='$p->hash' class='$css' type='reset' value='$p->label' style='width:{$p->cw}px;height:{$p->ch}px;' />",2);	
				break;

			case 'Button':
			
				$p->clickTrigger = htmlspecialchars($p->clickTrigger, ENT_QUOTES);
				$onClickScript = strlen(trim($p->clickTrigger))?"onclick=\"$p->clickTrigger\"":'';
				$output .= _line("<input name='$p->hash' type='button' class='$css' $onClickScript  value='$p->label' style='width:{$p->cw}px;height:{$p->ch}px;' />",2);	
				break;
				
		}
		$output .= _line('<div class="clear"></div>',2);

		return $output;

	}
}