<?php
/**
* Model for JForms Component (Frontend)
*
* @version		$Id: form.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

//Data are assumed to be clean when reaching the model

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');
JTable::addIncludePath(JFORMS_BACKEND_PATH.DS.'tables');
/**
 * JFroms "Form" Model
 *
 * @package    Joomla
 * @subpackage JForms
 */
class FrontendModelForm extends JModel
{
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();
	}
	function getRecordByUid( $form, $uid ){
		
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadElementPlugins();
		$pManager->loadStoragePlugins();
		
		
		$fields = array('uid');
		foreach( $form->fields as $f ){
			if( $pManager->element_plugins[$f->type]->storage ){		
				$fields[] = $f->parameters['hash'];
			}
		}
		
		$start = 0;
		$rpp   = 1;
		$criteria = new stdclass();
		$criteria->uid = new stdclass();
		$criteria->uid->numbers = array( intval( $uid ) );
		$criteria->uid->mode    = 'or';
		$response = $pManager->invokeMethod('searchRecords', JFORM_PLUGIN_STORAGE, array('Database'), array( $form, $fields, $start, $rpp, $criteria ) );
		$record   = array();
		
		$fields   = $response['Database']['loaded_fields'];
		$records  = $response['Database']['records'];
		
		for($i=0;$i<count($fields);$i++){
			for($j=0;$j<count($records);$j++){
				$record[$fields[$i]] = $records[$j][$i];
			}
		}
		return $record;
	}
	/**
	 * Returns the Title and "Thank you" message  for the given form "based on id"
	 *
	 * @access	public
	 * @return	Thank you message or null if $id is invalid
	 */
	function getThankMessage( $id ){
	
		$db = & JFactory::getDBO();
		$jnow =& JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $this->_db->getNullDate();

		$where = ' a.id='.$id.
				 ' AND ( a.state = 1 OR a.state = -1)' .
			 	 ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )' .
				 ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )';
		
		$db->setQuery('SELECT title,theme,thank FROM #__jforms_forms as a WHERE '.$where );
		
		return $db->loadObject();
		
	}
	
	/**
	 * Returns all the data about one form "based on id"
	 *
	 * @access	public
	 * @return	form object or null if not found/published
	 */
	function getForm( $id )
	{
		$db   = & JFactory::getDBO();
		$form  = & JTable::getInstance('Forms','Table');
		
		if( !$form->load($id, true) ){
			return null;
		}
		

		//Load Related Fields
		$db->setQuery('SELECT * FROM #__jforms_fields WHERE pid=' . $id.' ORDER BY position ASC');
		$form->fields = $db->loadObjectList();
		
		//Load normal Paramters
		$db->setQuery('SELECT * FROM #__jforms_parameters WHERE fid=' . $id);
		$nParameters = $db->loadObjectList();
	
		//Load Translated paramters
		$db->setQuery('SELECT * FROM #__jforms_tparameters WHERE fid=' . $id);
		$tParameters = $db->loadObjectList();
		
		if( $nParameters == null && $tParameters == null ){
			return null;
		}
		
		$parameters 	  = array_merge( $tParameters, $nParameters );
			
		$form->storagePluginParameters = array();
		
		//Join each field or plugin with its parameters
		foreach( $parameters as $p ){
			
			switch( $p->plugin_type ){

				case JFORM_PLUGIN_STORAGE :
					$form->storagePluginParameters[$p->plugin_name][$p->parameter_name] = $p->parameter_value;
					break;
					
				case JFORM_PLUGIN_ELEMENT :
					//Loop through fields
					for($i=0; $i<count($form->fields); $i++){
						//Does this parameter belong to this field?
						if( $p->pid == $form->fields[$i]->id ){
							//First cycle for this field?
							if(!isset($form->fields[$i]->parameters) || !is_array($form->fields[$i]->parameters)){
								//Make sure its Parameters element is array
								$form->fields[$i]->parameters = array();
							}
							//Assign this parameter to the field
							$form->fields[$i]->parameters[$p->parameter_name] = $p->parameter_value;
							break;
						}
					}
					break;
			}
		}
		return $form;
	}

	
	/**
	 * Validates and stores record
	 *
	 * @access	public
	 * @return	TBD
	 */
	function save( $form, $data )
	{
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadStoragePlugins();
		$pManager->invokeMethod('saveRecord', JFORM_PLUGIN_STORAGE, explode(',', $form->plugins), array( $form, $data ) );
	}			

	
	function _lastInsertId(){
		
		$db   = & JFactory::getDBO();
		$db->setQuery( "SELECT LAST_INSERT_ID()" );
		return intval( $db->loadResult() );
	
	}
}