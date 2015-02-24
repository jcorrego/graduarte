<?php
/**
* Date Element plugin
*
* @version		$Id: date.php 306 2009-09-07 06:44:45Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.filesystem.file');

class JFormEPluginDate{

	function getSQL( $elementData, $criteria ){
		
		$db =& JFactory::getDBO();
		$from = $criteria->from;
		$to   = $criteria->to;
		$mode = $criteria->mode=='or'?' OR ':' AND ';
		$fragments = array();
		$field= $elementData->parameters['hash'];
		
		if($from != '' )
			$fragments[] = "`$field` >= '$from'";
		if($to != '' )
			$fragments[] = "`$field` <= '$to'";
		$sql = implode( ' AND ', $fragments );
		
		if( trim( $sql ) != '' ){
			$sql = "($sql) $mode";
		}
		return $sql;
		
	}
	
	function beforeSave( $elementData, $input ){ return intval($input[2]) . '-' . intval($input[1]) . '-' . intval($input[0]);}
	function translate( $elementData, $input, $format='html' ){ return $input; }

	function render( $elementData ){
	
		$p = JArrayHelper::toObject($elementData->parameters);
		
		$default = property_exists($elementData,'defaultValue' )?$elementData->defaultValue:$p->defaultValue;
		$error   = property_exists($elementData,'validationError' )?$elementData->validationError:'';
	

		$css	    = property_exists($p,'css' )?$p->css:'';
		$inputClass = $css . (empty( $error )?'':' input-error');
		$labelClass = $css . (empty( $error )?'':' label-error');
		

		
		$htmlId = $p->hash.'_'.$elementData->id;
		
		if( is_array( $default )){
			list($d,$m,$y) = $default;
		} else {
			list($y,$m,$d) = explode('-', $default);
		}		
		
		
		$startYear = $p->startYear; 
		$endYear = 0;
		switch( $p->span ){
			case 0:
				$endYear = intval(date('Y'));
				break;
				
			case -1:
				$endYear = $p->startYear + $p->ospan;
				break;
				
			default:
				$endYear = $p->startYear + $p->span;
				break;
		}
		

		$p->label = htmlspecialchars($p->label, ENT_QUOTES);
		if( $p->required ) {
			$p->label = $p->label . '<span style="color:red"> * </span>';
		}

				
		$output  = '';
	
		$output .= _line("<div class='error-message' id='{$htmlId}_error'>$error</div>",2	);
		$output .= _line("<label class='$labelClass' id='{$htmlId}_label' for='{$htmlId}_d' style='width:{$p->lw}px;height:{$p->lh}px'>$p->label</label> ",2);
		
		$output .= _line( JFormEPluginDate::_intList( 1,31,1,
						  $p->hash.'[]', 
						  "class='$inputClass day' style='width:60px;margin:0px 5px 0px 5px;' ", 
						   $d, '', $htmlId.'_d' ), 2);
						   
		$output .= _line( JHTML::_('select.genericlist',JFormEPluginDate::_doMonthOptions(),
						  $p->hash.'[]', 
						  "class='$inputClass month' style='width:100px;margin:0px 5px 0px 5px;'"
						  ,'value','text', 
						   $m,$htmlId.'_m' ), 2);
						   
		$output .= _line( JFormEPluginDate::_intList( $startYear,$endYear,1,
						  $p->hash.'[]', 
						  " class='$inputClass year' style='width:60px;margin:0px 5px 0px 5px;' ",
						  $y, '', $htmlId.'_y' ), 2);
			
		$output .= _line('<div class="clear"></div>',2);
		

		return $output;
		
	}
	function _doMonthOptions(){
	
		$months = array();
		
		$months[] = JHTML::_('select.option', 1, JText::_('January'));
		$months[] = JHTML::_('select.option', 2, JText::_('February'));
		$months[] = JHTML::_('select.option', 3, JText::_('March'));
		$months[] = JHTML::_('select.option', 4, JText::_('April'));
		$months[] = JHTML::_('select.option', 5, JText::_('May'));
		$months[] = JHTML::_('select.option', 6, JText::_('June'));
		$months[] = JHTML::_('select.option', 7, JText::_('July'));
		$months[] = JHTML::_('select.option', 8, JText::_('August'));
		$months[] = JHTML::_('select.option', 9, JText::_('September'));
		$months[] = JHTML::_('select.option', 10, JText::_('October'));
		$months[] = JHTML::_('select.option', 11, JText::_('November'));
		$months[] = JHTML::_('select.option', 12, JText::_('December'));
		
		return $months;
		
	}
	function jsValidation( $elementData ){

		return '';
	}
	function _intList($start, $end, $inc, $name, $attribs = null, $selected = null, $format = "", $id = "" )
	{
		$start 	= intval( $start );
		$end 	= intval( $end );
		$inc 	= intval( $inc );
		$arr 	= array();

		for ($i=$start; $i <= $end; $i+=$inc)
		{
			$fi = $format ? sprintf( "$format", $i ) : "$i";
			$arr[] = JHTML::_('select.option',  $fi, $fi );
		}

		return JHTML::_('select.genericlist',   $arr, $name, $attribs, 'value', 'text', $selected, $id );
	}
	function jsClearErrors( $elementData ){

		$p = JArrayHelper::toObject($elementData->parameters);
		$output  = '';
		
		$htmlId = $p->hash.'_'.$elementData->id;
		$css	= property_exists($p,'css' )?$p->css:'';
				
		$output .= _line("var {$p->hash}_error = document.getElementById('{$htmlId}_error');" ,2);
		$output .= _line("var {$p->hash}_label = document.getElementById('{$htmlId}_label');" ,2);
		
		$output .= _line("{$p->hash}_label.className = '$css';",2);
		$output .= _line("{$p->hash}_error.innerHTML = '';",2);	
		
		return $output;
	}
	
	function validate( $elementData, $input ){
		
		$p = JArrayHelper::toObject($elementData->parameters);
	
		if( !checkdate( intval( $input[1] ),intval( $input[0] ),intval( $input[2] ))){
			return JText::_('Invalid date');
		}
		return '';
	}
}