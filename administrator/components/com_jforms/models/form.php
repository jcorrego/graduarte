<?php
/**
* Model for JForms Component (Backend)
*
* @version		$Id: form.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

//Clean up is left to the bottom teir , I.E plugins , not the best design choice but helps avoid confusion

jimport('joomla.application.component.model');

/**
 * JFroms "Form" Model
 *
 * @package    Joomla
 * @subpackage JForms
 */
class BackendModelForm extends JModel
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
	
	/**
	 * searches through forms
	 * 
	 * @access	public
	* @param int $start starting records
	 * @param int $count number of records to return
	 * @param string $keyword keywords used for the LIKE clause
	  @param bool $onlyPublished whether or not to return only the published forms
	 * @return array 'total' => total number the request returned
			       'forms' => list of forms
	 */
	function searchForms( $start=0, $count=0, $keyword='', $onlyPublished=false ){
	
		$db =& JFactory::getDBO();
		
		$start = intval( $start );
		$count = intval( $count );
		$onlyPublished = (bool) $onlyPublished;
		$keyword = $db->getEscaped( $keyword, true );
		
		$limit = '';
		if( $count != 0 ){
			$limit = "LIMIT $start, $rpp ";
		}
		
		$whereFragments = array();
		
		if( $keyword != ''){
			$whereFragments[] = "f.name LIKE '%$keyword%'";
		}
		
		if( $onlyPublished ){ 
			$jnow =& JFactory::getDate();
			$now = $jnow->toMySQL();
			$nullDate = $db->getNullDate();
			$whereFragments[]	= ' ( f.state = 1 OR f.state = -1)' .
			 	 ' AND ( f.publish_up = '.$db->Quote($nullDate).' OR f.publish_up <= '.$db->Quote($now).' )' .
				 ' AND ( f.publish_down = '.$db->Quote($nullDate).' OR f.publish_down >= '.$db->Quote($now).' )';
		}
		
		$where = '';
		if( count($whereFragments)){
			$where = 'WHERE'.implode( ' AND ', $whereFragments );
		}
		
		$sql =  
		"SELECT f.* FROM #__jforms_forms as f"
		."\n".$where;
		$db->setQuery($sql);
		$count = $db->loadResult();

		$sql = 
		 "SELECT f.*,p.parameter_value as table_name, v.name as editor, u.name as author"
		."\nFROM #__jforms_forms as f "
		."\nLEFT JOIN #__users AS u on f.created_by = u.id "
		."\nLEFT JOIN #__users AS v ON f.checked_out= v.id " 
		."\nLEFT JOIN #__jforms_parameters as p on (p.fid = f.id AND `plugin_name` = 'Database' AND `parameter_name`='tableName')"
		."\n".$where
		."\n"."ORDER BY id ASC"
		."\n".$limit;


		$db->setQuery( $sql );

		return array('total' => $count,
					 'forms' =>  $db->loadObjectList() );
		
	}
	
	/**
	 * Searches through records
	 * 
	 * @access	public
	 
	 * @param int $fid Form id 
	 * @param array $fields fields to load 
	 * @param int $start starting row
	 * @param int  $count number of records to load
	  @param string $keyword Keywords used for the LIKE clause
	 * @return string formated as follows "X;Y" where X=Total Record count for this request and Y=JSON Encoded records, null on failure
	 */
	function searchRecords( $fid, $fields=null, $start=-1, $count=-1, $criteria=null,$translationMode='html', $rawData=false ){
	
		global $JFormGlobals;
		
		require_once (JPATH_COMPONENT.DS.'helper'.DS.'JSON.php');
		
		//Load storage and element plugins
		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		//For data retrieval
		$pManager->loadStoragePlugins();
		
		//For data translation
		$pManager->loadElementPlugins();
		
		//Load form data from the DB
		$form = $this->getForm( $fid );
	
		if( $form == null ){
			if( $rawData )return null;
			else return '0;';
		}
		
		//Send work to the Database plugin
		$response = $pManager->invokeMethod('searchRecords', JFORM_PLUGIN_STORAGE, array('Database'), 
											array( $form, $fields, $start, $count, $criteria ) );
											
		//Use response coming from Database plugin
		$result = $response['Database'];
		
		if( $result['total'] == 0 ){
			if( $rawData )return null;
			else return '0;';
		}
		
		//We need to pass the data received from the DB to element Data translator to make them human-readable
		// The data received from the plugin is a non-indexed plain array where fields are arranged in the same order of $_GET['fields']
		// I use this fact to identify the type of each array element and pass it to its translation handler
		//That's exactly what the next loop does, Needs clean up?, totally agreed!
		
		//Index this form fields by hash value (Field name)
		$indexedFields = indexByHash ( $form->fields );
		
		$fieldsLoaded = $result['loaded_fields'];
		
		//Match each field with its element
		for( $i=0; $i<count($result['records']); $i++){
			for( $j=0; $j<count($fieldsLoaded); $j++ ){
		
				$f = $fieldsLoaded[$j];
				if( array_key_exists($f, $indexedFields) ){
					$type = $indexedFields[$f]->type;
					$result['records'][$i][$j] = $pManager->invokeMethod('translate', JFORM_PLUGIN_ELEMENT, array($type), 
													array( $indexedFields[$f], $result['records'][$i][$j], $translationMode ) );
				}
			}
		}

		if( $rawData ){
			$result['form'] = $form;
			return $result;
		} else{ 
			$json = new Services_JSON();
			return $result['total'].';'.$json->encode( $result['records']);
		}
	}
	
	/**
	 * Returns a selected group  of records based on IDs
	 * 
	 * @access	public
	 
	 * @param int $fid Form id 
	 * @param array $ids ids of the records to be returned 
	 * @return object form object that has "records" property loaded with requested records,null on failure
	 */
	function getRecords( $fid, $ids=null ){
		
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadStoragePlugins();

		$form = $this->getForm( $fid );
		
		if( $form == null ){
			return null;
		}
		
		$response = $pManager->invokeMethod('getRecords', JFORM_PLUGIN_STORAGE, array('Database'), 
											array( $form, $ids ) );
		//Use response coming from Database plugin
		$form->records = $response['Database'];
		
		return $form;
	
	}
	
	/**
	 * Returns all data about one form  based on ID
	 * 
	 * @access	public
	 
	 * @param int $fid Form id 
	 * @return object form object loaded with all data from the 3 core tables, null on failure
	 */
	function getForm( $fid )
	{
		$db   = & JFactory::getDBO();
		$form  = & JTable::getInstance('Forms','Table');
		$form->load($fid);
		
		if( $form == null ){
			return null;
		}

		//Load Related Fields
		$db->setQuery('SELECT * FROM #__jforms_fields WHERE pid=' . $fid.' ORDER BY position ASC');
		$form->fields = $db->loadObjectList();

		if( $form->fields == null ){
			return null;
		}
		
		//Load normal Paramters
		$db->setQuery('SELECT * FROM #__jforms_parameters WHERE fid=' . $fid);
		$nParameters = $db->loadObjectList();
	
		//Load Translated paramters
		$db->setQuery('SELECT * FROM #__jforms_tparameters WHERE fid=' . $fid);
		$tParameters = $db->loadObjectList();
		
		if( $nParameters == null && $tParameters == null ){
			return null;
		}
		
		$parameters 	  = array_merge( $tParameters, $nParameters );
		$parametersIdList = array(); 
		
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
								//Make sure we have storage for these parameters
								$form->fields[$i]->parameters   = array();
								$form->fields[$i]->parametersId = array();
							}
							//Assign this parameter to the field
							$form->fields[$i]->parameters  [$p->parameter_name] = $p->parameter_value;
							$form->fields[$i]->parametersId[$p->parameter_name] = $p->id;
							
							//$form->fields[$i]->parameters[$p->parameter_name] = new stdClass();
							//$form->fields[$i]->parameters[$p->parameter_name]->id    = $p->id;
							//$form->fields[$i]->parameters[$p->parameter_name]->value = $p->parameter_value;
							
							break;
						}
					}
					break;
			}
		}
		return $form;
	}
	
	/**
	 * "Checks" in the form when the user clicks "cancel"
	 *
	 * @access	public
	 * @param int $fid Form id 
	* @return	void
	 */
	function close( $fid )
	{
		if( $fid ){
			$row  = & JTable::getInstance('Forms','Table');
			$row->load( $fid );
			$row->checkin();
		}
	}
	
	/**
	 * stores form meta information in core tables,this will trigger "onFormSave" event for the selected storage plugins 
	 *
	 * @access	public
	  * @param object $data Form Data to be saved 
	 * @return	form ID on success , 0 on failure
	 */
	function save( $data )
	{
	
		global $JFormGlobals;
		
		// TODO : Make save process Atomic
		$user = & JFactory::getUser();
		$db   = & JFactory::getDBO();
		$row  = & JTable::getInstance('Forms','Table');
		$nullDate = $db->getNullDate();

		$pManager =& $JFormGlobals['JFormsPlugin'];

		
		if (!$row->bind($data)) {
			JError::raiseError( 500, $db->stderr() );
			return 0;
		}
		$row->id = intval($row->id);
		
		$newEntry = $row->id?false:true;
		//Copied directly from com_content saveContent()  
		
		// Are we saving from an item edit?
		if (!$newEntry) {
			$datenow =& JFactory::getDate();
			$row->modified 		= $datenow->toMySQL();
			$row->modified_by 	= $user->get('id');
		}

		$row->created_by 	= $row->created_by ? $row->created_by : $user->get('id');

		if ($row->created && strlen(trim( $row->created )) <= 10) {
			$row->created 	.= ' 00:00:00';
		}

		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($row->created, $tzoffset);
		$row->created = $date->toMySQL();

		// Append time if not added to publish date
		if (strlen(trim($row->publish_up)) <= 10) {
			$row->publish_up .= ' 00:00:00';
		}

		$date =& JFactory::getDate($row->publish_up, $tzoffset);
		$row->publish_up = $date->toMySQL();

		// Handle never unpublish date
		if (trim($row->publish_down) == JText::_('Never') || trim( $row->publish_down ) == '')
		{
			$row->publish_down = $nullDate;
		}
		else
		{
			if (strlen(trim( $row->publish_down )) <= 10) {
				$row->publish_down .= ' 00:00:00';
			}
			$date =& JFactory::getDate($row->publish_down, $tzoffset);
			$row->publish_down = $date->toMySQL();
		}


		$row->groups = implode( ',', $data['groups']);
		
		// Make sure the data is valid
		if (!$row->check()) {
			JError::raiseError( 500, $db->stderr() );
			return 0;
		}

		// Store the content to the database
		if (!$row->store()) {
			JError::raiseError( 500, $db->stderr() );
			return 0;
		}
		
		// Check the form
		$row->checkin();
		//End of faithful copy
		
		if($newEntry){
			$row->id = $this->_lastInsertId();
		}

		
		if(!$newEntry){
			
			//Delete fields of this form
			$db->setQuery('DELETE FROM #__jforms_fields WHERE pid=' . $row->id);
			if (!$db->query()){
				JError::raiseError( 500, $db->getErrorMsg() );
				return 0;
			}
		
			//Delete parameters for this form
			$db->setQuery('DELETE FROM #__jforms_parameters WHERE fid=' . $row->id);
			if (!$db->query()){
				JError::raiseError( 500, $db->getErrorMsg() );
				return 0;
			}	
			
			//Delete parameters for this form
			$db->setQuery('DELETE FROM #__jforms_tparameters WHERE fid=' . $row->id);
			if (!$db->query()){
				JError::raiseError( 500, $db->getErrorMsg() );
				return 0;
			}	
		}
		//TODO :Should be placed in controller , not here
		if( $newEntry ){
			$data['id'] = $row->id;
			$pManager->invokeMethod('onFormCreate', JFORM_PLUGIN_STORAGE, null,
									 array( &$data, $pManager->element_plugins ) );
		} else {
			$pManager->invokeMethod('onFormSave', JFORM_PLUGIN_STORAGE, null,
									array( &$data, $pManager->element_plugins ) );	
		}
		
		
		//Start saving Fields and their paramters
		
		//Start with saving Storage Plugin parameters
		//TODO : Multilingual support
		foreach( $data['storagePluginParameters'] as $plugin_name => $plugin_object ){
		
			foreach( $plugin_object as $param_name => $param_value ){
			
				$parameterRow  = & JTable::getInstance('Parameters','Table');
				$parameterRow->fid = $row->id;
				
				//Storage Plugins are not realted to a certain field
				$parameterRow->pid = 0;
				
				$parameterRow->plugin_name = $plugin_name;
				$parameterRow->plugin_type = JFORM_PLUGIN_STORAGE;
				$parameterRow->parameter_name  = $param_name;
				$parameterRow->parameter_value = $param_value;
				
				// Make sure the data is valid
				if (!$parameterRow->check()) {
					JError::raiseError( 500, $db->stderr() );
					return 0;
				}

				// Store the content to the database
				if (!$parameterRow->store()) {
					JError::raiseError( 500, $db->stderr() );
					return 0;
				}
			}
		}

		//Now Saving Fields and the their paramters
		foreach( $data['fieldInformation'] as $f ){
			
			$fieldsRow  = & JTable::getInstance('Fields','Table');
			$fieldsRow->pid = $row->id;
			$fieldsRow->type = $f->type;
			$fieldsRow->position = $f->position;

			// Make sure the data is valid
			if (!$fieldsRow->check()) {
				JError::raiseError( 500, $db->stderr() );
				return 0;
			}

			// Store the field to the database
			if (!$fieldsRow->store()) {
				JError::raiseError( 500, $db->stderr() );
				return 0;
			}
			
			$pid = $this->_lastInsertId();
			$plugin_name = $f->type;
			$plugin_type = JFORM_PLUGIN_ELEMENT;
			
			//PHP 5 call
			//To avoid affecting the $form reference passed from controller we create a shallow copy of the current field
			//More info , here http://acko.net/node/54
			$tempField = clone($f);
			
			
			unset($tempField->position);
			unset($tempField->type);
			
			$parameters = JArrayHelper::fromObject($tempField);
			
			
			
			$idList = null;
			if( $data['paramListId'] ){
				$idList = $data['paramListId'][$parameters['hash']];
			}

			
			//Now store the field's parameters
			foreach($parameters as $name => $value){
			
				$parameterRow = null;
				//If the parameters is translatable , put it in the translated table
				if( $pManager->element_plugins[$plugin_name]->parameters[$name]->translate ) {
					$parameterRow  = & JTable::getInstance('Tparameters','Table');
				} else {
					$parameterRow  = & JTable::getInstance('Parameters','Table');
				}	
				
				if($idList){
					$parameterRow->id  = $idList[$name] ;
				}
				
				$parameterRow->fid = $row->id;
				$parameterRow->pid = $pid;
				$parameterRow->plugin_name = $plugin_name;
				$parameterRow->plugin_type = $plugin_type;
				$parameterRow->parameter_name = $name;
				$parameterRow->parameter_value = $value;		
				
				// Make sure the data is valid
				if (!$parameterRow->check()) {
					JError::raiseError( 500, $db->stderr() );
					return 0;
				}

				// Store the parameter to the database
				if (!$parameterRow->store()) {
					JError::raiseError( 500, $db->stderr() );
					return 0;
				}
				
			}
		}
		
		return $row->id;
	}
	
	/**
	 * Deletes a form.
	 *
	 * @access	public
	 * @param array$ids list of form IDs to delete 
	 * @return	bool true on success , false on failure
	 */
	function delete( $ids )
	{
		$db   = & JFactory::getDBO();

		JArrayHelper::toInteger( $ids );

		$additionalParameters = array();			
		
		if( !is_array( $ids ) || !count( $ids ) ){
			return false;
		}
		
		$idText = implode( ',', $ids );
		
		//Delete From the main Forms table
		$db->setQuery('DELETE FROM #__jforms_forms WHERE id IN (' . $idText  . ')');
		if (!$db->query()){
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		
		//Delete From the Fields table
		$db->setQuery('DELETE FROM #__jforms_fields WHERE pid IN (' . $idText  . ')');
		if (!$db->query()){
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		
		//Delete parameters for this form
		$db->setQuery('DELETE FROM #__jforms_parameters WHERE fid IN (' . $idText . ')');
		if (!$db->query()){
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		
		return true;
	}
	
	/**
	 * Unpublishes the forms whose IDs are passed 
	 *
	 * @access	public
	* @param array$ids list of form IDs to unpublish 
	 * @return	bool true on success , false on failure
	 */
	function unpublish($ids){
		
		JArrayHelper::toInteger( $ids );
		if( !is_array( $ids ) || !count( $ids ) ){
			return false;
		}
		$idText = implode( ',', $ids );
	
		$db   = & JFactory::getDBO();
			
		//Delete From the main Forms table
		$db->setQuery('UPDATE #__jforms_forms SET state=0 WHERE id IN (' . $idText . ') ');
		if (!$db->query()){
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		return true;
	}
	/**
	 * Publishes the forms whose IDs are passed 
	 *
	 * @access	public
	  * @param array$ids list of form IDs to publish 
	 * @return	bool true on success , false on failure
	 */
	function publish($ids){
	
		JArrayHelper::toInteger( $ids );
		if( !is_array( $ids ) || !count( $ids ) ){
			return false;
		}
		$idText = implode( ',', $ids );
		
		$db   = & JFactory::getDBO();
			
		//Delete From the main Forms table
		$db->setQuery('UPDATE #__jforms_forms SET state=1 WHERE id IN (' . $idText . ') ');
		if (!$db->query()){
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		return true;
	}
	
	/**
	 * Deletes records from a form table
	 *
	 * @access	public
	 * @param int $fid Form id 
	 * @param array $rids ids of records to delete
	 * @return bool , true on success, false on failure
	 */
	function deleteRecords( $fid, $rids ){

		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		$pManager->loadStoragePlugins();
		
		$db   = & JFactory::getDBO();
		
		$form = $this->getForm( $fid );
		
		if( $form == null ){
			JError::raiseError( 500, 'Form not found' );
			return false;
		}

		$response = $pManager->invokeMethod('deleteRecords', JFORM_PLUGIN_STORAGE, null, 
											array( $form, $rids ) );	
		
		return $response['Database'];
		
	
	}
	
	function _getNextInsertID( $tableName ){
		
		$db =& JFactory::getDBO();
				
		$db->setQuery('SHOW CREATE TABLE `'.$tableName.'`');
		$result = $db->loadRow();
		
		$nextAutoIndex = 1;
		$matches = array();
		preg_match('/AUTO_INCREMENT=(\d+)/', $result[1], $matches );
		if( count( $matches ) ){
			$nextAutoIndex = intval( $matches[1] );
		}
		return $nextAutoIndex;
	}
	
	function _setNextAutoIndex( $tableName, $id ){
		
		$db =& JFactory::getDBO();
		$db->setQuery('ALTER TABLE `'.$tableName.'` auto_increment='.intval($id));
		$db->query();
	}
	
	/**
	 * gets lastInsertId
	 *
	 * @access	private
	 * @return int mySQL last insert ID
	 */
	function _lastInsertId(){
		
		$db   = & JFactory::getDBO();
		$db->setQuery( "SELECT LAST_INSERT_ID()" );
		return intval( $db->loadResult() );
	
	}
	
	function copy( $cids, $newName ){
		
		$id = intval($cids[0]);
		$newName = str_replace( array("\"","'",",",";"),"",$newName);

		$db = & JFactory::getDBO();
		$query = 
		"INSERT INTO #__jforms_forms" 
		."\n(`title`, `type`, `plugins`, `state`, `created`, `created_by`, `modified`,"
		."\n`modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `groups`, `hits`, `thank`)"
		."\n(SELECT"
		."\n'$newName',`type`, `plugins`, `state`, `created`, `created_by`, `modified`,"
		."\n`modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `groups`, `hits`, `thank`"
		."\nFROM #__jforms_forms WHERE id=$id)";
		$db->setQuery($query);
		$db->query();
	
		$newFormId = $this->_lastInsertId();
		$oldFormId = $id;
		
		//Form parameters
		$query = 
		"INSERT INTO #__jforms_parameters"
		."\n(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`)"
		."\n(SELECT"
		."\n$newFormId, 0, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value` FROM #__jforms_parameters WHERE pid=0 AND fid=$oldFormId)";
		$db->setQuery($query);
		$db->query();
		
		$query = 
		"INSERT INTO #__jforms_tparameters"
		."\n(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`)"
		."\n(SELECT"
		."\n$newFormId, 0, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value` FROM #__jforms_parameters WHERE pid=0 AND fid=$oldFormId)";
		$db->setQuery($query);
		$db->query();

		//Field Parameters
		$query = "SELECT `id`  FROM #__jforms_fields WHERE pid=$oldFormId";
		$db->setQuery($query);
		$result = $db->loadResultArray(0);
		foreach( $result as $oldFieldId ){
			$query = 
			"INSERT INTO #__jforms_fields"
			."\n(`pid`, `type`, `position`)"
			."\n(SELECT"
			."\n$newFormId, `type`, `position` FROM #__jforms_fields WHERE id=$oldFieldId)";
			$db->setQuery($query);
			$db->query();


			$newFieldId = $this->_lastInsertId();
			
			$query = 
			"INSERT INTO #__jforms_parameters"
			."\n(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`)"
			."\n(SELECT"
			."\n$newFormId, $newFieldId, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value` FROM #__jforms_parameters WHERE pid=$oldFieldId)";
			$db->setQuery($query);
			$db->query();

			
			$query = 
			"INSERT INTO #__jforms_tparameters"
			."\n(`fid`, `pid`, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`)"
			."\n(SELECT"
			."\n$newFormId, $newFieldId, `plugin_name`, `plugin_type`, `parameter_name`, `parameter_value`"
			."\nFROM #__jforms_tparameters WHERE pid=$oldFieldId)";
			$db->setQuery($query);
			$db->query();
			
			
		}
		$query = "SELECT parameter_value FROM #__jforms_parameters WHERE parameter_name='tableName' AND fid=$oldFormId";
		$db->setQuery($query);
		
		$oldTableName = $db->loadResult();
		$newTableName = substr( md5(uniqid(rand(), true)), 0, 5 );


		$query = "CREATE TABLE #__jforms_$newTableName LIKE #__jforms_$oldTableName";
		$db->setQuery($query);
		$db->query();

		
		$query = "UPDATE #__jforms_parameters SET parameter_value='$newTableName' WHERE parameter_name='tableName' AND fid=$newFormId";
		$db->setQuery($query);
		$db->query();
	
		
		return true;

	}
}