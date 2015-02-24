<?php
/**
* List View for Forms Component
*
* @version		$Id: view.html.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

/**
 * List View
 *
 * @package    Joomla
 * @subpackage JForms
 */
class BackendViewList extends JView
{
	/**
	 * List view display method
	 *
	 * Displays a list of all forms available in the database showing 
	 *   - id
	 *   - Title
	 *   - Storage plugins
	 *
	 * @return void
	 **/
	function display($tpl = null)
	{
	
		JHTML::_('stylesheet', 'css.css', 'administrator/components/com_jforms/views/list/');
	
		//Toolbar
		JToolBarHelper::title(   JText::_( 'JForms' ), 'generic.png' );
		JToolBarHelper::custom( 'upgradeDB', 'upgrade.png', 'upgrade_f2.png', 'Upgrade Database to 0.6',false,false );		
		JToolBarHelper::deleteList();
		JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );		
		JToolBarHelper::editListX();
		JToolBarHelper::addNew();

		//Get the model
	    $model =& $this->getModel();
        
		//Get a listing of all forms ( TODO : Add pagination )
		$response= $model->searchForms();
		$forms = $response['forms'];
	
		//Send data to the view
		$this->assignRef('forms', $forms);

		//Display the template
		parent::display($tpl);
	}
}
