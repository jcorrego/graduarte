<?php 
/**
* Mail  plugin
*
* @version		$Id: Mail.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.mail.helper' );

class JFormSPluginMail{

	function searchRecords($form, $fields, $start, $rpp, $keyword ){
		//Do Nothing
	}
	
	function onFormCreate( &$form, $elementPlugins ){
		//Do Nothing
	}
	
	function onFormSave( &$form, $elementPlugins ){
		//Do Nothing
	}
	
	function onFormDelete( $form, $additionalParameters ){
		//Do Nothing
	}
	
	function deleteRecords( $form , $idsArray ){
		//Do Nothing
		return false;
	}
	
	function getRecords( $form, $ids ){
		//Do Nothing
		return null;
	}

	function saveRecord( $form, $data ){
			
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
			
		//Send out an E-mail to Administrators and User (Based on Form settings)
		$dataText = "<br />";
		$formName = $form->title;
			
		$pluginSettings  = $form->storagePluginParameters['Mail'];
			
		$fields = indexByHash( $form->fields );
			
		$adminMessage = $pluginSettings['AdminText'];
		$userMessage  = $pluginSettings['ConfrimText'];
			
		foreach($fields as $key => $f ){
				
			//If field has no storage requirments
			if( !count($pManager->element_plugins[$f->type]->storage) ){
				//Ignore it
				continue;
			}
				
			if( array_key_exists( $key, $data ) ){
				
				//Translate Raw data into readable format
				$d = $pManager->invokeMethod('translate',JFORM_PLUGIN_ELEMENT, 
											array($f->type), array( $f, $data[$key] ) );
				$dataText .= $f->parameters['label'] ." : ".$d."<br />";
				$fieldPlaceholder = '{FIELD='.strtoupper($f->parameters['label']).'}';
				$adminMessage = str_replace( $fieldPlaceholder, $d, $adminMessage );
				$userMessage  = str_replace( $fieldPlaceholder, $d, $userMessage  );	
			}			
		}
			
		//Look for user E-mail field
		$userEmail = '';
		foreach($form->fields as $f){
				
			if( array_key_exists('isUserEmail',$f->parameters) && $f->parameters['isUserEmail'] == true ){
				$hash = $f->parameters['hash'];
				//Grab it from current record
				$userEmail = $data[$hash];
				break;
			}					
		}
			
		if( $pluginSettings['SendAdmin'] ){
			
			$AdminMails = explode(',',$pluginSettings['AdminMail']);
				
			$adminMessage = str_replace('{FORM_NAME}' ,$formName, $adminMessage );
			$adminMessage = str_replace('{ENTRY_DATA}',$dataText, $adminMessage );
			$adminMessage = str_replace("\r\n", "<br />", $adminMessage );
			$adminMessage = str_replace("\n"  , "<br />", $adminMessage );
			$adminMessage = str_replace("\r"  , "<br />", $adminMessage );
			
			$mail = JFactory::getMailer();
			$mail->IsHTML( true );
				
			foreach($AdminMails as $address ){
				$mail->AddRecipient( $address );
			}
				
			if( $userEmail ){
				$mail->AddReplyTo( array($userEmail,'') );
			}
			
			//$mail->setSender( array( $email, $name ) );
			$mail->SetSubject(JText::_('New entry added'));
			$mail->SetBody( $adminMessage );
			$mail->Send();
		
		}
		if( $pluginSettings['SendUser'] ){
			
			if( JMailHelper::isEmailAddress( $userEmail ) ){
			
				$userMessage = str_replace('{FORM_NAME}' ,$formName, $userMessage );
				$userMessage = str_replace('{ENTRY_DATA}',$dataText, $userMessage );
				$userMessage = str_replace("\r\n", "<br />", $userMessage );
				$userMessage = str_replace("\n"  , "<br />", $userMessage );
				$userMessage = str_replace("\r"  , "<br />", $userMessage );
		
				$mail = JFactory::getMailer();
				$mail->IsHTML( true );
					
				$mail->AddRecipient( $userEmail );
				
				//$mail->setSender( array( $email, $name ) );
				$mail->SetSubject(JText::_('Your entry has been received'));
				$mail->SetBody($userMessage);
				$mail->Send();
			}
		}
	}
}