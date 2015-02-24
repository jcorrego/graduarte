<?php
/**
* Translatable parameters table class
*
* @version		$Id: tparameters.php 29 2008-12-09 07:13:01Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * parameters Table Class
 *
 * @package    Joomla
 * @subpackage JForms
 */
class TableTparameters extends JTable
{

	/**
	 * @var int
	 */
	var $id = null;
	
	
	/**
	 * @var int
	 */
	var $fid = null;

	/**
	 * @var int
	 */
	var $pid = null;

	/**
	 * @var string
	 */
	var $plugin_name = null;

	/**
	 * @var int
	 */
	var $plugin_type = null;

	/**
	 * @var int
	 */
	var $parameter_name = null;
	
	/**
	 * @var string
	 */
	var $parameter_value = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableTparameters(& $db) {
		parent::__construct('#__jforms_tparameters', 'id', $db);
	}

	/**
	 * Inserts a new row if id is zero or updates an existing row in the database table
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @param boolean If false, null object variables are not updated
	 * @return null|string null if successful otherwise returns and error message
	 */
	function store( $updateNulls=false )
	{
		$k = $this->_tbl_key;

		$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		if( !$ret )
		{
			$this->setError(get_class( $this ).'::store failed - '.$this->_db->getErrorMsg());
			return false;
		}
		else
		{
			return true;
		}
	}

}
