<?php
/**
* List Element plugin
*
* @version		$Id: list.php 306 2009-09-07 06:44:45Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();


class JFormEPluginList{



	function getSQL( $elementData, $criteria ){
		
		$db =& JFactory::getDBO();
		$f = $elementData->parameters['hash'];
		
		$mode = $criteria->mode=='or'?' OR ':' AND ';
		$keywordJoin = '';
		$kArray = null;
		switch($criteria->keyword_mode){
		
			case 'All':
				$keywordJoin = ' AND ';
				$kArray = explode(' ', $criteria->keywords );
			break;
			
			case 'Any':
				$keywordJoin = ' OR ';
				$kArray = explode(' ', $criteria->keywords );
			break;
			
			case 'Exact':
				$keywordJoin = ' ';
				$kArray = array( $criteria->keywords );
			break;
				
		}
		
		
		$fragments = array();
		foreach( $kArray as $k ){
			$k = $db->getEscaped( "$k", true );
			if( $k == '')continue;
			$fragments[] = '`'.$f.'` LIKE '."'%".$k."%'";
		}
		$sql = implode( $keywordJoin,  $fragments );
		if( trim( $sql ) != '' ){
			$sql = "($sql) $mode";
		}
		return $sql;
	}

	function beforeSave( $elementData, $input ){return $input?implode(',',$input):'';}
	function translate( $elementData, $input, $format='html' ){	return $input; }
	
	function render( $elementData ){
	
		$p = JArrayHelper::toObject($elementData->parameters);
		
		$htmlId = $p->hash.'_'.$elementData->id;
		
		$error   = property_exists($elementData,'validationError' )?$elementData->validationError:'';

		$css	    = property_exists($p,'css' )?$p->css:'';
		$inputClass = $css . (empty( $error )?'':' input-error');
		$labelClass = $css . (empty( $error )?'':' label-error');
		

		
		//Load the correct default value
		$default = null;
		if( property_exists($elementData,'defaultValue' ) ){
			if( is_array($elementData->defaultValue) ){
				$default = $elementData->defaultValue;
			}
			if( $elementData->defaultValue == null ){
				$default = array();
			}
		} else {
			$default = explode(',',$p->defaultValue);
		}
		//Done with default values
		
		$multi   = $p->multi?'multiple="multiple"':'';
		
		$p->label = htmlspecialchars($p->label, ENT_QUOTES);
		if( $p->required ) {
			$p->label = $p->label . '<span style="color:red"> * </span>';
		}
	
		$output  = '';
		$output .= _line("<div class='error-message' id='{$htmlId}_error'>$error</div>",2	);
		$output .= _line("<label class='$labelClass' id='{$htmlId}_label' for='{$htmlId}' style='float:left;width:{$p->lw}px;height:{$p->lh}px'>$p->label</label> ",2	);
		
		$style = $multi?"width:{$p->cw}px;height:{$p->ch}px;":"width:{$p->cw}px;";
		$output .= _line("<select class='$inputClass' $multi name='".$p->hash."[]' id='$htmlId' style='$style'>",2);
		
		
		$elements = explode("\n" ,$p->elements);
		

		foreach($elements as $e){
		  
			$e = htmlspecialchars($e, ENT_QUOTES);
			
			$selected = '';
			if( in_array( $e, $default ) ){
				$selected = 'selected="selected"';
			}
			$output .= _line("<option $selected>$e</option>",3);
		}
		
		$output .= _line('</select>',2);
		$output .= _line('<div class="clear"></div>',2);
		
		return $output;
		
	}
			 
	function jsClearErrors( $elementData ){
		
		$p = JArrayHelper::toObject($elementData->parameters);
		
		$htmlId = $p->hash.'_'.$elementData->id;
		$css	= property_exists($p,'css' )?$p->css:'';
		
		$output  = "\n";
		$output .= _line("var $p->hash = document.getElementById('$htmlId');" ,2);
		$output .= _line("var {$p->hash}_error = document.getElementById('{$htmlId}_error');" ,2);
		$output .= _line("var {$p->hash}_label = document.getElementById('{$htmlId}_label');" ,2);
		
		$output .= _line("{$p->hash}.className = '$css';",2);
		$output .= _line("{$p->hash}_label.className = '$css';",2);
		$output .= _line("{$p->hash}_error.innerHTML = '';",2);		
		return $output;
	}

	function jsValidation( $elementData ){
		
		$p = JArrayHelper::toObject($elementData->parameters);
		
		$htmlId = $p->hash.'_'.$elementData->id;
		$css	= property_exists($p,'css' )?$p->css:'';
		
		$output  = "\n";
		$output .= _line("var {$p->hash} = document.getElementById('$htmlId');" ,2);
		$output .= _line("var {$p->hash}_label = document.getElementById('{$htmlId}_label');" ,2);	
		$output .= _line("var {$p->hash}_error = document.getElementById('{$htmlId}_error');" ,2);	

		$p->required = $p->required?'true':'false';
		
		$output .= _line("var required = $p->required;" ,2);
		$output .= _line("if(required){" ,2);
		$output .= _line("if( {$p->hash}.multiple ){" ,3);
		$output .= _line("if( {$p->hash}.selectedIndex == -1 ){" ,4);
		$output .= _line("errorArray.push({id:$p->hash,msg:'error'});" ,5);
		$output .= _line("{$p->hash}.className ='input-error $css';",5);
		$output .= _line("{$p->hash}_label.className ='label-error $css';",5);		
		$output .= _line("{$p->hash}_error.innerHTML='".JText::_('Field Required')."';",5);	
		$output .= _line("}" ,4);
		$output .= _line("} else {" ,3);
		$output .= _line("if( {$p->hash}.selectedIndex == 0 ){" ,4);
		$output .= _line("errorArray.push({id:$p->hash,msg:'error'});" ,5);
		$output .= _line("{$p->hash}.className ='input-error $css';",5);
		$output .= _line("{$p->hash}_label.className ='label-error $css';",5);		
		$output .= _line("{$p->hash}_error.innerHTML='".JText::_('Field Required')."';",5);
		$output .= _line("}" ,4);
		$output .= _line("}" ,3);
		$output .= _line("}" ,2);
		
		
		
		return $output;
	}
	
	function validate( $elementData, $input ){
		
		$p = JArrayHelper::toObject($elementData->parameters);
		
		if( $input == null )$input = array();
		
		$elements = explode("\n" ,$p->elements);
		
		//Selected nothing in a required multi-select list
		if( $elementData->parameters['multi'] && $p->required && count( $input ) == 0){
			return JText::_('Field Required');	
		}
		
		//Selected the first element in a required single choice list
		if( !$elementData->parameters['multi'] && $p->required && $input[0] == $elements[0]  ) {	
			return JText::_('Field Required');
		}
		return '';
	}
}