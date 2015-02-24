<?php
/**
* File Element plugin
*
* @version		$Id: file.php 306 2009-09-07 06:44:45Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

define( 'RAW_BINARY_EXPORT', 0);

class JFormEPluginFile{
	
	function getSQL( $elementData, $keywords ){
		return '';
	}
	
	function translate( $elementData, $input, $format='html' ){
		
		
		if( empty( $input ))return '';
		switch( $format ){
			default:
			case 'html':
				$obj = unserialize(base64_decode( $input ));
				$linkText = $obj->name. '( '. $obj->size .' ' .JText::_('Bytes') .' )';
				return '<a target="_blank" href="'.$obj->link.'">'.$linkText.'</a>';
			
			case 'raw':
				if(RAW_BINARY_EXPORT){
					//TODO : Export raw binary data base64 encoded
					return '';
				} else {
					$obj = unserialize(base64_decode( $input ));
					$linkText = $obj->name. '( '. $obj->size .' ' .JText::_('Bytes') .' )';
					$output = '';
					$output .= JText::_('File URL')   .':'. $obj->link."\n";
					$output .= JText::_('File Name')  .':'. $obj->name."\n";
					$output .= JText::_('File Size')  .':'. $obj->size."\n";
					return $output;
				}
				
			
		}
		
	}
	
	function render( $elementData ){
	
		$p = JArrayHelper::toObject($elementData->parameters);
		$error   = property_exists($elementData,'validationError' )?$elementData->validationError:'';
		
		$css	    = property_exists($p,'css' )?$p->css:'';
		$inputClass = $css . (empty( $error )?'':' input-error');
		$labelClass = $css . (empty( $error )?'':' label-error');
		

		$htmlId = $p->hash.'_'.$elementData->id;
		
		$p->label = htmlspecialchars($p->label, ENT_QUOTES);
		if( $p->required ) {
			$p->label = $p->label . '<span style="color:red"> * </span>';
		}
		
		$output  = '';
		$output .= _line("<div class='error-message' id='{$htmlId}_error'>$error</div>",2	);
		$output .= _line("<label class='$labelClass' id='{$htmlId}_label' for='$p->hash' style='width:{$p->lw}px;height:{$p->lh}px'>$p->label</label> ",2	);
		$output .= _line("<input class='$inputClass' name='$p->hash' type='file' id='$htmlId' style='' />",2);
		$output .= _line('<div class="clear"></div>',2);
		return $output;
		
	}
			 
	function jsValidation( $elementData ){
	
		global $veryBadExtensions;
		
		$p = JArrayHelper::toObject($elementData->parameters);
	
		$p->required = $p->required?'true':'false';
		
		
		$htmlId = $p->hash.'_'.$elementData->id;
		$css	= property_exists($p,'css' )?$p->css:'';
				
		$output  = "\n";
		$output .= _line("var $p->hash = document.getElementById('$htmlId');" ,2);
		$output .= _line("var {$p->hash}_label = document.getElementById('{$htmlId}_label');" ,2);
		$output .= _line("var {$p->hash}_error = document.getElementById('{$htmlId}_error');" ,2);
		$output .= _line("if($p->hash.value.length == 0){" ,2);
		$output .= _line("var required = $p->required;" ,3);
		$output .= _line("if(required){" ,3);
	
		$output .= _line("errorArray.push({id:$p->hash,msg:'error'});" ,4);
		$output .= _line("{$p->hash}.className ='input-error $p->css';",4);
		$output .= _line("{$p->hash}_label.className ='label-error $p->css';",4);
		$output .= _line("{$p->hash}_error.innerHTML='".JText::_('Field required')."';",4);	
		$output .= _line("}" ,3);
		
		$output .= _line("} else {" ,2);
		
		$tmp = str_replace( ',' , '|\.', $p->veryBadExtensions );
		$validationRule = '('.$tmp.')$';
		$output .= _line("var regEx = /$validationRule/i" ,3);
		$output .= _line("if(regEx.test($p->hash.value)){ " ,3);
		$output .= _line("errorArray.push({id:$p->hash,msg:'error'});" ,4);
		$output .= _line("{$p->hash}.className ='input-error $p->css';",4);
		$output .= _line("{$p->hash}_label.className ='label-error $p->css';",4);
		$output .= _line("{$p->hash}_error.innerHTML='".JText::_('Unsupported extension')."';",4);	
		if( !empty( $p->extensions ) ){ 
	
			$output .= _line("} else {" ,3);
			$tmp = str_replace( ',' , '|\.', $p->extensions );
			$validationRule = '('.$tmp.')$';
			
			$output .= _line("var regEx = /$validationRule/i" ,4);
			$output .= _line("if(!regEx.test($p->hash.value)){ " ,4);
		
			$output .= _line("errorArray.push({id:$p->hash,msg:'error'});" ,5);
			$output .= _line("{$p->hash}.className ='input-error $p->css';",5);
			$output .= _line("{$p->hash}_label.className ='label-error $p->css';",5);
			$output .= _line("{$p->hash}_error.innerHTML='".JText::_('Unsupported extension')."';",5);	
			
			$output .= _line("}" ,4);
		}
		$output .= _line("}" ,3);
		
		$output .= _line("}" ,2);
		return $output;
	
	
	}
	function jsClearErrors( $elementData ){

		$p = JArrayHelper::toObject($elementData->parameters);
		$output  = "";
		
		$htmlId = $p->hash.'_'.$elementData->id;
		$css	= property_exists($p,'css' )?$p->css:'';
		
		$output .= _line("var $p->hash = document.getElementById('$htmlId');" ,2);
		$output .= _line("var {$p->hash}_label = document.getElementById('{$htmlId}_label');" ,2);
		$output .= _line("var {$p->hash}_error = document.getElementById('{$htmlId}_error');" ,2);
	
		$output .= _line("{$p->hash}.className ='$p->css';",2);
		$output .= _line("{$p->hash}_label.className ='$p->css';",4);
		$output .= _line("{$p->hash}_error.innerHTML='';",2);	
		
		return $output;
	}
	
	function _getExtension( $filename ){ return strtolower( JFile::getExt( $filename ) ); }
	
	function validate( $elementData, $input ){
		
		$p = JArrayHelper::toObject($elementData->parameters);
		
		if( !array_key_exists( $p->hash, $_FILES ) || empty( $_FILES[$p->hash]['name'] ) ){
			if( $p->required ){
				return JText::_("Field Required");
			}
		} else {
	
			$file = $_FILES[$p->hash];
			
			//Override user settings if it allows php file uploads
			if( in_array( JFormEPluginFile::_getExtension($file['name']),explode(',', $p->veryBadExtensions ))){
				JFile::delete($file['tmp_name']);
				return JText::_('Invalid file extension');		
			}	
			
			if( !in_array( JFormEPluginFile::_getExtension($file['name']), explode(',', $p->extensions ))){
				JFile::delete($file['tmp_name']);
				return JText::_('Invalid file extension');
			}	
	
			if ($file['size']  >  ((float)$p->maxSize * 1024 * 1024)  ){
				JFile::delete($file['tmp_name']);
				return JText::_("Huge file!");
			}
		}
		return "";	
	}
	
	function beforeSave( $elementData, $input, $fsInfo ){

		
		$p = JArrayHelper::toObject($elementData->parameters);
		$file = $_FILES[$p->hash];
		
		//No file was uploaded
		if( $file['error'] == 4 )return '';
		
		$shortName = substr( md5( $file['tmp_name'].time()),0,4 ).'.'.JFormEPluginFile::_getExtension($file['name']);
		if( $file['error'] ){
			JError::raiseError( 500, JTEXT::_('Error occured while uploading file (Error code )') .$file['error']);						
		}
		
		$fsPath = $fsInfo['path'];
		$fsUrl  = $fsInfo['url'];
	
		if( !JFile::upload( $file['tmp_name'], $fsPath.DS.$shortName )){
			JError::raiseError( 500, JTEXT::_('Error occured while moving uploaded file. )'));							
		}
		$dbData = new stdClass();
		
		$dbData->path = $fsPath.DS.$shortName;
		$dbData->link = $fsUrl .'/'.$shortName;
		$dbData->name = $file['name'];
		$dbData->size = filesize( $fsPath.DS.$shortName );
		
		/*
		* Save reference to the uploaded file in serialized form
		*/
		
		return base64_encode(serialize( $dbData ));

	}
}