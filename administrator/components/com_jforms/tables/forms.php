<?php
/**
* Forms table class
*
* @version		$Id: forms.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * Forms Table Class
 *
 * @package    Joomla
 * @subpackage JForms
 */
class TableForms extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $title = null;

	/**
	 * @var int
	 */
	var $type = null;
	
	/**
	 * @var string
	 */
	var $plugins = null;

	/**
	 * @var string
	 */
	var $theme = null;

	/**
	 * @var int
	 */
	var $state;
	
	/**
	 * @var datetime
	 */
    var $created;
	
	/**
	 * @var int
	 */
	var $created_by;
	
	/**
	 * @var datetime
	 */
	var $modified;
	
	/**
	 * @var int
	 */
	var $modified_by;
	
	/**
	 * @var int
	 */
	var $checked_out;
	
	/**
	 * @var datetime
	 */
	var $checked_out_time;
	
	/**
	 * @var datetime
	 */
    var $publish_up;
	
	/**
	 * @var datetime
	 */
    var $publish_down;
	
	/**
	 * @var int
	 */
	var $hits;
	
	/**
	 * @var string
	 */
	var $thank = null;

	/**
	 * @var string
	 */
	var $groups = null;

	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableForms(& $db) {
		parent::__construct('#__jforms_forms', 'id', $db);
	}

	/**
	 * Loads a row from the database and binds the fields to the object properties
	 *
	 *
	 * @access	public
	 * @param	mixed	 primary key.
	 * @param	mixed	Optional only Published and checked in items	 
	 * @return	boolean	True if successful
	 */
	function load( $oid, $onlyPublished=false )
	{
		$k = $this->_tbl_key;

		if ($oid !== null) {
			$this->$k = $oid;
		}

		$oid = $this->$k;

		if ($oid === null) {
			return false;
		}
		$this->reset();

		$db =& $this->getDBO();
		$jnow =& JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $this->_db->getNullDate();

		$where = $this->_tbl_key.' = '.$db->Quote($oid);
		
		if( $onlyPublished ){
		
			$where .= 
			 ' AND ( state = 1 OR state = -1)' .
			 ' AND ( publish_up = '.$db->Quote($nullDate).' OR publish_up <= '.$db->Quote($now).' )' .
			 ' AND ( publish_down = '.$db->Quote($nullDate).' OR publish_down >= '.$db->Quote($now).' )';
		}

		$query = 'SELECT *'
		. ' FROM '.$this->_tbl
		. ' WHERE '.$where;
		$db->setQuery( $query );

		if ($result = $db->loadAssoc( )) {
			return $this->bind($result);
		}
		else
		{
			$this->setError( $db->getErrorMsg() );
			return false;
		}
	}
}
