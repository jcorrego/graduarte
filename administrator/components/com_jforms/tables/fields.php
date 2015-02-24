<?php
/**
* Fields table class
*
* @version		$Id: fields.php 29 2008-12-09 07:13:01Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * Fields Table Class
 *
 * @package    Joomla
 * @subpackage JForms
 */
class TableFields extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var int
	 */
	var $pid = null;

	/**
	 * @var string
	 */
	var $type;

	/**
	 * @var int
	 */
	var $position = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableFields(& $db) {
		parent::__construct('#__jforms_fields', 'id', $db);
	}

}
