<?php
/**
* Main Frontend controller for Forms Component
*
* @version		$Id: controller.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

jimport('joomla.application.component.controller');

/**
 * Main Frontend Controller
 * 
 * @package    Joomla
 * @subpackage JForms
 */
class FrontendController extends JController
{

	/**
	 * constructor (registers additional tasks to methods)
	 *
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'form'  , 'form');
		$this->registerTask( 'thank' , 'thank');
		$this->registerTask( 'save'  , 'save');

	}
	
	
	/**
	 * Validates record and stores it
	 *
	 * @access	public
	 */
	function save()
	{
		JRequest::checkToken('post') or jexit( 'Invalid Token' );
		
		//Load element plugins
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadElementPlugins();
		$pManager->loadStoragePlugins();
			
		$id     = JRequest::getInt( 'id' );
		$itemid = JRequest::getInt( 'Itemid' );
		
		$model  = & $this->getModel('form');
		$form    = $model->getForm( $id );
		
		if( $form == null ){
				JError::raiseError( 404, JText::_("Page not found") );
		}
		
		//Check premissions
		$user   =& JFactory::getUser();
		$allowedGroups = explode(',', $form->groups);
		if( !in_array( $user->gid, $allowedGroups ) ){
				JError::raiseError( 403, JText::_("Access Forbidden") );
		}
		
		//If Profile mode form, Allow only registered users
		if( !$user->id && $form->type == JFORMS_TYPE_PROFILE ){
				JError::raiseError( 403, JText::_("Access Forbidden") );
		}
		
		//The record data
		$postVars = JRequest::get('post');
		
		
		$isValidationError = false;
		for($i=0;$i<count($form->fields);$i++ ){

			$field = $form->fields[$i];
					
			//Deal with checkboxes and radios, elements that aren't submitted to the server if they have no value "not checked radio box,etc."
			//This will set to null the fields that are present in form definition and not submitted to the server
			if( !array_key_exists( $field->parameters['hash'], $postVars ) ) {
				$postVars[$field->parameters['hash']] = null;
			}
			$data = $postVars[$field->parameters['hash']];
	
			//Validate
			$error = $pManager->invokeMethod('validate', JFORM_PLUGIN_ELEMENT, 
											 array($field->type), array( $field, $data ) );
			//If there's an error
			if( $error != '' ){
				//Raise error flag
				$isValidationError = true;
			}
				
			$form->fields[$i]->validationError = $error;
			$form->fields[$i]->defaultValue    = $data;		
		}
		
		/*
		*	Validation errors
		*/
		
		if(	$isValidationError ){
			//There has been a validation error, return to previous page and save error data in session
			if(array_key_exists( 'from_jforms_plugin', $postVars ) && 
			   intval($postVars['from_jforms_plugin'])){
			 
				//Use session to store form previous State
				$formStateInfo = array();
				for($i=0;$i<count($form->fields);$i++ ){
					$formStateInfo[$form->fields[$i]->parameters['hash']] = 
						array(
							$form->fields[$i]->validationError,
							$form->fields[$i]->defaultValue    
						);
				}
				$document   =& JFactory::getDocument();
				$_SESSION['JFormsSession']['FormState'][$form->id] = $formStateInfo;
				
				$uri = $postVars['url'];
				
				//Appends frmReturn=1 to the request URL to inform the plugin that we're returning form vaildation
				$jrouter =& JRouter::getInstance('site');
				$juri    =& JURI::getInstance( $uri );
				
				if( !$juri->isInternal( $uri ) ){
					die('Hacking attempt');
				}
				$urlFragments    = $jrouter->parse($juri);
				if( !array_key_exists( 'frmReturn', $urlFragments ))
					$urlFragments['frmReturn'] = '1';
	
				$redirectURL = 'index.php?';
				foreach( $urlFragments as $key => $value ){
					$redirectURL .= $key.'='.$value.'&';
				}
				$redirectURL =  JRoute::_($redirectURL, false);
		
				$this->setRedirect( $redirectURL );
				
			
			} else {
			
				//Running from com_jforms context
				if( 
					!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl'.DS.$form->theme.'.php') ||
					!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl'.DS.$form->theme.'_thank.php') ||
					!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.$form->theme.'.css')
				)$form->theme = 'default';
				
				$document   =& JFactory::getDocument();
				$viewType	= $document->getType();
				$viewName	= 'form';
				$viewLayout	= $form->theme;
				
				$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
				
				// Set the layout
				$view->setLayout($viewLayout);
				
				// Display the view
				$view->display($form);
			
			}
		} else {
		
			//Everything went okay?
			//Clear session Form states
			unset($_SESSION['JFormsSession']);
			
			$response = $pManager->invokeMethod('getNextInsertID', 
												JFORM_PLUGIN_STORAGE, 
												array('Database'), 
												array( $form ) );
			$nextInsertId = intval( $response['Database'] );
					
			//Everything is okay , proceed to save data
			for($i=0;$i<count($form->fields);$i++ ){
				
				//No longer needed
				unset( $form->fields[$i]->validationError );
				unset( $form->fields[$i]->defaultValue );		
				
				$field = $form->fields[$i];
				$data  = $postVars[$field->parameters['hash']];
				
				
				
				$storage = $pManager->element_plugins[$field->type]->storage;
				
				
				if( $storage && $storage->requirefs ){
					
					//Get Filesystem paths from  Database plugin
					$response = $pManager->invokeMethod('getFSPath', 
												JFORM_PLUGIN_STORAGE, 
												array('Database'), 
												array( $form, $field->parameters['hash'], $nextInsertId ) );
					$fsInfo  =  $response['Database'];
					
					//trigger the "onBeforeSave" event on plugin elements
					$postVars[$field->parameters['hash']] = 
					$pManager->invokeMethod('beforeSave', JFORM_PLUGIN_ELEMENT, 
											array($field->type), array( $field, $data, $fsInfo  ) );
				
				} else {
				
					//trigger the "onBeforeSave" event on plugin elements
					$postVars[$field->parameters['hash']] =
					$pManager->invokeMethod('beforeSave', JFORM_PLUGIN_ELEMENT, 
											array($field->type), array( $field, $data, null ) );

				}
			}
			$model->save($form, $postVars);
		
			
			$uri = JRoute::_( 'index.php?option=com_jforms&task=thank&id='.$form->id.'&Itemid='.$itemid, false );
			$this->setRedirect( $uri );
		}	
	
	}
	
	/**
	 * Displays the thank you page
	 *
	 * @access	public
	 */
	function thank()
	{
		$id	= JRequest::getInt( 'id' );

		$document =& JFactory::getDocument();
		
		
		$model  = & $this->getModel('form');
		$data   = $model->getThankMessage( $id );
		
		if( is_null( $data ) ){
			JError::raiseError( 404, JText::_("Page not found") );
		}
		

		if( 
			!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl'.DS.$data->theme.'.php') ||
			!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl'.DS.$data->theme.'_thank.php') ||
			!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.$data->theme.'.css')
		)$data->theme = 'default';

		$viewType	= $document->getType();
		$viewName	= 'form';
		$viewLayout	= $data->theme.'_thank';

		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		
		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display_thank( $data );
	}
	
	/**
	 * Method to display the view,  (Currently it is a faithful copy from the base)
	 *
	 * @access	public
	 */
	function display()
	{
		jimport('joomla.filesystem.file');
		
		$document =& JFactory::getDocument();
		$id	= JRequest::getInt( 'id' );

		$model = & $this->getModel('form');
		$form  = $model->getForm( $id );
		
		if( $form == null ){
			JError::raiseError( 404, JText::_("Page not found") );
		}
		
		//Check premissions
		$user   =& JFactory::getUser();
		$allowedGroups = explode(',', $form->groups);
		if( !in_array( $user->gid, $allowedGroups ) ){
				JError::raiseError( 403, JText::_("Access Forbidden") );
		}
		
		//If Profile mode form, Allow only non-guests
		if( !$user->id && $form->type == JFORMS_TYPE_PROFILE ){
			JError::raiseError( 403, JText::_("Access Forbidden") );
		}
		
		
		//Sort elements
		$sortedElements = array();
		foreach( $form->fields as $f ){
			$sortedElements[$f->position] = $f;
		}
		$form->fields = $sortedElements;
		
		//Load previously stored Data
		if( $user->id && $form->type == JFORMS_TYPE_PROFILE ){
			$record = $model->getRecordByUid( $form, $user->id );
			if( count($record) ){
				foreach( $form->fields as $key => $value ){
				//Fix for PHP4 since foreach doesn't return references.
					$f = &$form->fields[$key];
					if( array_key_exists( $f->parameters['hash'], $record  ))
						$f->parameters['defaultValue'] = $record[$f->parameters['hash']];
				}
			}
		}
		
		
		//Check the selected theme, if any file is missing, load default
		
		if( 
			!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl'.DS.$form->theme.'.php') ||
			!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl'.DS.$form->theme.'_thank.php') ||
			!JFile::exists( JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.$form->theme.'.css')
		)$form->theme = 'default';
		
		$viewType	= $document->getType();
		$viewName	= 'form';
		$viewLayout	= $form->theme;

		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		
		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display($form);
	}

}
