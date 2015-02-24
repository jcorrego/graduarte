<?php
/**
* Element View for Forms Component
*
* @version		$Id: view.html.php 29 2008-12-09 07:13:01Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

/**
 * Element View
 *
 * @package    Joomla
 * @subpackage JForms
 */
class BackendViewElement extends JView
{
	/**
	 * Element view display method
	 *
	 * Displays a list of all forms available in the database
	 *
	 * @return void
	 **/
	function display($tpl = null)
	{


		//Get the model
	    $model =& $this->getModel();
        
		//Get a listing of all forms ( TODO : Add pagination )
		$response= $model->searchForms(0,0,'',true);
		$forms = $response['forms'];

		//Send data to the view
		$this->assignRef('forms', $forms);

		//Display the template
		parent::display( $tpl );
	}
}
