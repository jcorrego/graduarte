<?php
/**
* Main backend controller for Forms Component
*
* @version		$Id: controller.php 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

jimport('joomla.application.component.controller');

/**
 * Main backend Controller
 *
 * @package    Joomla
 * @subpackage JForms
 */
 
 
class BackendController extends JController
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
		$this->registerTask( 'element', 'element');
		
		$this->registerTask( 'add', 'add');
		$this->registerTask( 'edit', 'edit');
		$this->registerTask( 'save', 'save');
		$this->registerTask( 'publish', 'publish');
		$this->registerTask( 'unpublish', 'unpublish');
		$this->registerTask( 'remove', 'remove');
		$this->registerTask( 'records', 'records');
		$this->registerTask( 'export' , 'export');
		$this->registerTask( 'copy'   ,  'copy');
		$this->registerTask( 'updateDB', 'updateDB');
		$this->registerTask( 'deleteRecords', 'deleteRecords');
		$this->registerTask( 'getRecords', 'getRecords' );
		
		$this->registerTask( 'upgradeDB', 'upgradeDB' );
		
		
		$this->registerTask( 'checkAdminSession', 'checkAdminSession' );
		
		$this->registerTask( 'cancel', 'cancel');
		$this->registerTask( 'back', 'back');
		
		
	}
	
	function upgradeDB(){
		
		JRequest::checkToken('get') or jexit( 'Invalid Token' );

		include_once 'dbUpgrade.php';

		$step	= JRequest::getInt( 'step' , 'get' );
		$param	= JRequest::getVar( 'param', 'get' );
		$url = upgradeDB( $step, $param );
		if( $url == '' ){
			$this->setRedirect( 'index.php?option=com_jforms', JText::_('Database was upgraded successfully'));			
		} else { 
			$this->setRedirect( $url );
		}
	}
	
	function copy(){
	
		JRequest::checkToken('get') or jexit( 'Invalid Token' );

		$cids	  = JRequest::getVar( 'cid', array(), 'get', 'array' );
		$newName  = JRequest::getVar( 'newName', null, 'get' );
		
		
		JArrayHelper::toInteger($cids);
		if ( !count($cids) ) {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Select an item to copy'), 'error');
		}

		$model = & $this->getModel('form');
		
		if( $newName == '' )$newName = 'Copy';
		
		if( $model->copy($cids,$newName) ){
			$this->setRedirect('index.php?option=com_jforms', JText::_('Copied successfuly'));
		} else {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Failed to copy form'), 'error');
		}
	}
	
	function export(){
	
		JRequest::checkToken('post') or jexit( 'Invalid Token' );
		
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadExportPlugins();
	
		$requestParameters = JRequest::getVar( 'params', null, 'post' );
		
		$name         = $requestParameters['name'];
		$fid          = $requestParameters['fid'];
		$rowStart     = $requestParameters['start'];
		$rowCount     = $requestParameters['rpp'];
		$fields       = $requestParameters['fields'];
		
		$requestParameters['labels'] = str_replace('\,',chr(34),$requestParameters['labels']);
		$requestParameters['labels'] = str_replace(",","\r\n",$requestParameters['labels']);
		$requestParameters['labels'] = str_replace(chr(34),",",$requestParameters['labels']);
		$labels = $requestParameters['labels'];
		
		$criteria     = $requestParameters['keyword'];
		$currentPage  = $requestParameters['page'];
		$pageCount    = $requestParameters['pageCount'];
		$totalRecords = $requestParameters['recordCount'];
		$selectedIds  = $requestParameters['ids'];
		

		$postVarName  = 'JFormXPlugin'.$name.'Parameters';
		$pluginParams =  JRequest::getVar( $postVarName, null, 'post' );
		
		require_once (JPATH_COMPONENT.DS.'helper'.DS.'JSON.php');
		//Decode JSON value
		$json = new Services_JSON();
		$criteria = $json->decode($criteria);	

		if( isset( $pluginParams['exportRange'] )){
			switch( $pluginParams['exportRange'] ){
			
			case 'selected':
				$criteria->id = new stdClass();
				$criteria->id->numbers = explode(',', $selectedIds);
				$criteria->id->mode = 'or';
				break;
				
			case 'visible':
				$selectedIds = null;
				break;
				
			case 'pages':
				$selectedIds = null;
				$rowStart = 0;
				$rowCount = $totalRecords;
				break;
				
			case 'all':
				$selectedIds = null;
				$rowStart = -1;
				$rowCount = -1;
				$keyword  = '';
				break;
			
			}
		}
		


		if( $fields ){
			$fields = explode(',', $fields);
		}
		
		if( !array_key_exists( $name, $pManager->export_plugins )){
			die(JText::_('Export plugin not found'));
		}
		
		//Translation mode is passed to the Element plugin to let it know in which format should it output the data
		//For instance, JUser element can output the data in HTML format or in raw format, the translation mode lets it know which to use
		$translationMode = $pManager->export_plugins[$name]->format;
		
		$model = & $this->getModel('form');		
		
		$response = $model->searchRecords( $fid, $fields, $rowStart, $rowCount, $criteria, $translationMode, true );

		$pManager->invokeMethod('onExport', JFORM_PLUGIN_EXPORT, array($name), array( $pluginParams, $requestParameters, $response ) );
		die;
		
	}
	
	function checkAdminSession(){
	
		$document =& JFactory::getDocument();
		$document->setCharset('utf-8');
		$document->setMimeEncoding('text/plain');
		
		//$session =& JFactory::getSession();
		//$session->getExpire();
		echo '';
	}	
	
	
	/**
	 * Task handler (Show Element dialog "used in menu manager")
	 *
	 * @return void
	 */
	function element()
	{
		$model	= &$this->getModel( 'form' );
		
		$view = & $this->getView( 'element', 'html', '', array( 'base_path'=>$this->_basePath));
		$view->setLayout('default');
		$view->setModel( $model, true );
		$view->display();
	}
	
	/**
	 * Task handler (Publish form)
	 *
	 * @return void
	 */
	function publish()
	{
		JRequest::checkToken('get') or jexit( 'Invalid Token' );
		
		$cids		= JRequest::getVar( 'cid', array(), 'get', 'array' );
		JArrayHelper::toInteger($cids);
		if ( !count($cid) ) {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Select an item to publish'), 'error');
		}

		$model = & $this->getModel('form');
	
		if( $model->publish($cids) ){
			$this->setRedirect('index.php?option=com_jforms', JText::_('Published successfuly'));
		} else {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Failed to publish selected form(s)'), 'error');
		}
	}
	
	/**
	 * Task handler (unpublish form)
	 *
	 * @return void
	 */
	function unpublish()
	{
		
		JRequest::checkToken('get') or jexit( 'Invalid Token' );
		
		$cids		= JRequest::getVar( 'cid', array(), 'get', 'array' );
		JArrayHelper::toInteger($cids);
		if (!count($cids)) {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Select an item to unpublish'), 'error');
		}

		
		$model = & $this->getModel('form');

		if( $model->unpublish($cids) ){
			$this->setRedirect('index.php?option=com_jforms', JText::_('Unpublished successfuly'));
		} else {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Failed to unpublish selected form(s)'), 'error');
		}
	}
	
	
	/**
	 * Task handler (Add new form)
	 *
	 * @return void
	 */
	function add()
	{
		global $JFormGlobals;
		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		//Load Element Plugins
		$pManager->loadElementPlugins();
		//Load Storage Plugins
		$pManager->loadStoragePlugins();
		
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= 'design';
		$viewLayout	= 'default';

		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		$form = new JParameter('', JPATH_COMPONENT.DS.'models'.DS.'form.xml');
		
		
		//Load Storage plugins and create form for each one using JParameters
		$storagePluginForms = array();
		foreach($pManager->storage_plugins as $p){
			$storagePluginForms[$p->name] = new JParameter('', $p->paramXML );
		}
		
		
		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display(null, $form, $storagePluginForms);
	}
	
	/**
	 * Task handler (Edit existing form)
	 *
	 * @return void
	 */
	function edit()
	{
		global $JFormGlobals;
		
		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$idArray = JRequest::getVar( 'cid', array(), 'get' );
		$id = intval( $idArray[0] );
	
		//Load Element Plugins
		$pManager->loadElementPlugins();
		//Load Storage Plugins
		$pManager->loadStoragePlugins();
		
		$document =& JFactory::getDocument();
		$user	= & JFactory::getUser();
		$db =& JFactory::getDBO();
		$nullDate = $db->getNullDate();
		
		$viewType	= $document->getType();
		$viewName	= 'design';
		$viewLayout	= 'default';
		
		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		
		// Get/Create the model
		$model = & $this->getModel('form');		
		$row   = $model->getForm( $id );
	
			
		if( $row == null ){
			$this->setRedirect('index.php?option=com_jforms', JText::_('Form not found'), 'error');
			return;
		}
		if ( JTable::isCheckedOut($user->get ('id'), $row->checked_out )){
			$msg = JText::sprintf(JText::_('DESCBEINGEDITTED'), JText::_('The item'), $row->title);
			$this->setRedirect('index.php?option=com_jforms', $msg, 'error');
			return;
		}
		//Check the field out
		$row->checkout($user->get('id'));
		
		//Create a JParamter object for the form settings "title,  description,etc"
		$form = new JParameter('', JPATH_COMPONENT.DS.'models'.DS.'form.xml');	
		//Since we're editing we should pre-set the form fields to the values from the DB
		$form->set('title', $row->title);
		$form->set('type', $row->type);
		$form->set('state', $row->state);
		$form->set('publish_up', JHTML::_('date', $row->publish_up, '%Y-%m-%d %H:%M:%S'));
		if (JHTML::_('date', $row->publish_down, '%Y') <= 1969 || $row->publish_down == $nullDate) {
			$form->set('publish_down', JText::_('Never'));
		} else {
			$form->set('publish_down', JHTML::_('date', $row->publish_down, '%Y-%m-%d %H:%M:%S'));
		}
		$form->set('thank', $row->thank);
		
		$groupArray = explode(',', $row->groups);
		$form->set('groups', implode(',',$groupArray) );
		$form->set('guests', in_array(0,$groupArray)?1:0);
		$form->set('theme' , $row->theme);
	
		//Now the storage Plugin settings
		$storagePluginForms = array();
		//Each storage Plugin has its own list paramters, so we create a form for each storage Plugins too
		
		foreach($pManager->storage_plugins as $p){
	
			$storagePluginForms[$p->name] = new JParameter('', $p->paramXML );
			if( array_key_exists($p->name, $row->storagePluginParameters)){
				$storagePluginForms[$p->name]->bind( $row->storagePluginParameters[$p->name] );
			}
		}
	
			
		// Set the layout
		$view->setLayout($viewLayout);

		//Sort elements
		$sortedElements = array();
		foreach( $row->fields as $f ){
			$sortedElements[$f->position] = $f;
		}
		$row->fields = $sortedElements;

		// Display the view
		$view->display($row,$form, $storagePluginForms);
	}
	
	/**
	 * Task handler (Save form to Database)
	 *
	 * @return void
	 */
	function save()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		global $JFormGlobals;
		
		$pManager =& $JFormGlobals['JFormsPlugin'];

		//Load Element Plugins
		$pManager->loadElementPlugins();
		//Load Storage Plugins
		$pManager->loadStoragePlugins();

		require_once (JPATH_COMPONENT.DS.'helper'.DS.'JSON.php');

		//Start preparing the data received via POST to be sent to the model for saving
		
		$params	= JRequest::getVar( 'params', array(), 'post', 'array');
		if( !array_key_exists('plugins',$params) ){
			$params['plugins'] = array();
		}
		
		$params['groups'] = JRequest::getVar( 'groups', array(), 'post', 'array');
		
		
		//Determine whether this is a new Entry or an already existant one "To be sent to StoragePlugin"
		$isNew = $params['id'] == 0?true:false;
		
		//Force Database plugin to be on
		array_push($params['plugins'],'Database');
		
		
		
		$params['storagePluginParameters'] = array();
		foreach( $pManager->storage_plugins as $p ){
			$params['storagePluginParameters'][$p->name] = 
				JRequest::getVar( 'JFormSPlugin'.$p->name.'Parameters', array(), 'post','array');
		}

		//Decode JSON value
		$json = new Services_JSON();
		$fieldInformation = trim($params['fieldInformation'],'|||');
		$jsonArray = explode( "|||" , $fieldInformation );
		$params['fieldInformation'] = array();
		
		foreach( $jsonArray as $entry ){
			$value = $json->decode($entry);	
			$params['fieldInformation'][] = $value;
		}

				
		$params['paramListId'] = null;	
		if( !$isNew ){
			//Param id list, for multilanguage support
			$pIdList = trim($params['paramIds'],'|');
			$tempList = explode( '|', $pIdList );
			$params['paramListId'] = array();
			foreach( $tempList as $entry ){
				list($hash,$data) = explode ( ';', $entry );
				$e = explode( ',', $data );
				$params['paramListId'][$hash] = array();
				foreach( $e as $parameter ){
					list($name,$id ) = explode('=>', $parameter );
					$params['paramListId'][$hash][$name] = intval( $id );
				}
			}
			//Ends here
		}
		$params['plugins'] = implode( ',' , $params['plugins'] );
		
		//Get/Create Our model
		$model = & $this->getModel('form');
		
		//Send to the model to for saving
		$id = $model->save($params);
		
		if( !$id ){
			$this->setRedirect('index.php?option=com_jforms', JText::_('Failed to save the form'), 'error');
		} else {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Form saved'));
		}
	}
	
	/**
	 * Task handler (Delete form)
	 *
	 * @return void
	 */
	function remove()
	{
		JRequest::checkToken('get') or jexit( 'Invalid Token' );
		
		global $JFormGlobals;
		
		$cids = JRequest::getVar( 'cid', array(), 'get', 'array' );
		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		$pManager->loadStoragePlugins();

		JArrayHelper::toInteger($cids);
		if (count($cids) ) {
			$this->setRedirect('index.php?option=com_jforms', JText::_('Select an item to delete'), 'error');
		}
		
		$model = & $this->getModel('form');
		
		foreach( $cids as $id ){			
	
			$form = $model->getForm( $id );
			if( !$form )continue;
	
			//Trigger onDelete event for storagePlugins
			$pManager->invokeMethod('onFormDelete', JFORM_PLUGIN_STORAGE, 
									null, array( $form, array() ) );

		}
		
		//Delete forms
		$model->delete( $cids );
		
		
		$this->setRedirect('index.php?option=com_jforms',  JText::_('Form(s) deleted'));
	}
	
	/**
	 * Task handler (View Records for forms)
	 *
	 * @return void
	 */
	function records()
	{
		global $JFormGlobals;		
		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		$id = JRequest::getInt( 'id', 0, 'get' );
	
		$document =& JFactory::getDocument();
		$db =& JFactory::getDBO();
		
		$viewType	= $document->getType();
		$viewName	= 'records';
		$viewLayout	= 'default';
		
		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		
		// Get/Create the model
		$model = & $this->getModel('form');		
		$form  = $model->getRecords( $id );
		
		
		$pManager->loadExportPlugins();
		$exportPluginForms = array();
		
		//Each export Plugin has its own list paramters, so we create a form for each export Plugin
		foreach($pManager->export_plugins as $p){
			$exportPluginForms[$p->name] = new JParameter('', $p->paramXML );
		}
		
		$pManager->loadElementPlugins();
		$elementPluginForms = array();
		
		//Each element Plugin has its own list of search paramters, so we create a form for each element Plugin
		foreach($form->fields as $f){
			$pluginType = $pManager->element_plugins[$f->type];
			if( $pluginType->storage ){
					$elementPluginForms[$f->parameters['hash']] = new JParameter('', $pluginType->paramXML );
					$elementPluginForms[$f->parameters['hash']]->label = $f->parameters['label'];
				}
		}
		
		
		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display($form ,$exportPluginForms, $elementPluginForms);
	
	}
	
	/**
	 * Task handler (Back)
	 *
	 * @return void
	 */
	function back()
	{
		$this->setRedirect('index.php?option=com_jforms');
	}
	
	/**
	 * Task handler (Cancel)
	 *
	 * @return void
	 */
	function cancel()
	{
		$params	= JRequest::getVar( 'params', array(), 'post', 'array');
		$id = intval( $params['id']);
		if( $id ){
			$model = & $this->getModel('form');
			$model->close($id);
		}
		$this->setRedirect('index.php?option=com_jforms',  JText::_('Action cancelled'), 'error');
	}
	
	/**
	 * Method to display the view, overrides base display method (Currently it is a faithful copy from the base)
	 *
	 * @access	public
	 */
	function display()
	{
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= 'list';
		$viewLayout	= 'default';
		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));
		
		
		// Get/Create the model
		$model = & $this->getModel('form');
		
		// Push the model into the view (as default)
		$view->setModel($model, true);
		

		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display();
	
	}

	function deleteRecords(){
		
		//TODO: Harden
		JRequest::checkToken('get') or jexit( 'Invalid Token' );
		
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		$document =& JFactory::getDocument();
		$document->setCharset('utf-8');
		$document->setMimeEncoding('text/plain');
		
		//Load Element Plugins
		$pManager->loadElementPlugins();
		$pManager->loadStoragePlugins();
		
	
		$ids   = JRequest::getVar( 'ids'  , array(), 'get' );
		$fid   = JRequest::getInt( 'fid'   , 0,'get' );
		$jsIds = JRequest::getVar( 'jsRows', array(), 'get' );
		
		//Sanitize incoming ids
		JArrayHelper::toInteger( $ids );
		JArrayHelper::toInteger( $jsIds );
		
		$model = & $this->getModel('form');		
		$res   = $model->deleteRecords( $fid, $ids );


		if( $res ){
			echo implode( ',', $jsIds );
		} else {
			echo '0';
		}
		
	}

	//Place holder, will be rewritten
	function getRecords(){
		
		$requestMode = 'get';
		//TODO: Harden
		JRequest::checkToken($requestMode) or jexit( 'Invalid Token' );
		
		$document =& JFactory::getDocument();
		$document->setCharset('utf-8');
		$document->setMimeEncoding('text/plain');

		
		global $JFormGlobals;
		$pManager =& $JFormGlobals['JFormsPlugin'];
		
		//Load Element Plugins
		$pManager->loadElementPlugins();
			
		
		
		
		$fid   	  = JRequest::getInt( 'fid', 0, $requestMode );
		$rowStart = JRequest::getInt( 'start', -1, $requestMode );
		$rowCount = JRequest::getInt( 'count', -1, $requestMode );
		$fields   = JRequest::getString( 'fields', null, $requestMode );
		$keywords = JRequest::getString( 'keyword', null, $requestMode ); 	
		$ids      = JRequest::getString( 'ids', null, $requestMode );
		
		require_once (JPATH_COMPONENT.DS.'helper'.DS.'JSON.php');
		//Decode JSON value
		$json = new Services_JSON();
		$criteria = $json->decode($keywords);	

		
		if( $fields ){
			$fields = explode(',', $fields);
		}
		
	
		
		if( $rowCount > 200 ){
			return;
		}
		$model = & $this->getModel('form');		
		
		$response = $model->searchRecords( $fid, $fields, $rowStart, $rowCount, $criteria );

		echo $response;
		
		
	}
}
