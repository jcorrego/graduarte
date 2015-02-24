<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.model');

/**
 * A feature to get rid of Joomla!'s default administrator user (ID 62/42)
 */
class AdmintoolsModelAdminuser extends JModel
{
	/**
	 * Determines if the default Super Administrator account is in use with a simple
	 * trick. If a user exists with an ID less than the default Joomla! Super User ID
	 * (42 in 1.6 or 62 in 1.5) then the default Super Administrator account is considered
	 * to not be in use.
	 * 
	 * @return bool
	 */
	public function hasDefaultAdmin()
	{
		if( ADMINTOOLS_JVERSION == '15' ) {
			$id = 62;
		} else {
			$id = 42;
		}
		
		// Check if a user with a low ID is present
		$db = $this->getDBO();
		$sql = 'SELECT COUNT(*) FROM `#__users` WHERE id < '.$db->Quote($id);
		$db->setQuery($sql);
		$isuser = $db->loadResult();
		
		if(!$isuser) {
			// If now low-ID user exists, check if a user with ID of 62/42 exists
			$sql = 'SELECT COUNT(*) FROM `#__users` WHERE id = '.$db->Quote($id);
			$db->setQuery($sql);
			$defaultuser = $db->loadResult();
			if($defaultuser) {
				// Is that user blocker?
				$user = JFactory::getUser($id);
				if($user->block) {
					// The user is blocked, therefore you're not using the default SA account.
					return false;
				} else {
					// The user is not blocked. You are sing the default SA account.
					return true;
				}
			} else {
				return false;
			}
		} else {
			// Low-ID user exists; no default admin is present ;)
			return false;
		}
	}
	
	/**
	 * Get the default user's username
	 * @return string
	 */
	public function getDefaultUsername()
	{
		if( ADMINTOOLS_JVERSION == '15' ) {
			$id = 62;
		} else {
			$id = 42;
		}
		
		$user = JFactory::getUser($id);
		return $user->username;
	}
	
	/**
	 * Creates a new Super Administrator with a low ID and swaps his privileges with the old administrator user
	 * @param $newid int The new ID to use. Leave null to use a random one (recommended!)
	 */
	public function swapAccounts($newid = null)
	{
		if( ADMINTOOLS_JVERSION == '15' ) {
			$maxid = 61;
		} else {
			$maxid = 41;
		}
		
		if(empty($newid)) {
			$newid = rand(1,$maxid);
		}
		
		// Load the existing user
		$db = $this->getDBO();
		$sql = 'SELECT * FROM `#__users` WHERE id = '.$db->Quote($maxid + 1);
		$db->setQuery($sql);
		$olduser = $db->loadAssoc();
		
		// Create a copy of the old user's data and update the ID
		$newuser = $olduser;
		$newuser['id'] = $newid;

		// Insert the new user to the database
		$sql = 'INSERT INTO `#__users` ';
		$keys = array(); $values = array();
		foreach($newuser as $k => $v)
		{
			$keys[] = $db->nameQuote($k);
			$values[] = $db->Quote($v);
		}
		$sql .= '('.implode(', ', $keys).') VALUES ('.implode(', ',$values).')';
		$db->setQuery($sql);
		$db->query();
		
		jimport('joomla.database.table.user');
		$userTable = JTable::getInstance('user');
		
		
		// Time to promote the new user to a Super Administrator!
		if(ADMINTOOLS_JVERSION == '16') {
			// Joomla! 1.6 -- Insert the user to group 8 (Super Administrators)
			$sql = "INSERT INTO `#__user_usergroup_map` (`user_id`,`group_id`) VALUES ('$newid','8')";
			$db->setQuery($sql);
			$db->query();
		} else {
			// Joomla! 1.5 -- Create #__core_acl_aro and #__core_acl_groups_aro_map entries
			$name = $newuser['name'];
			$sql = "INSERT INTO `#__core_acl_aro` (`section_value`,`value`,`order_value`,`name`,`hidden`) VALUES ('users', '$newid', '0', ".$db->Quote($name).", '0')";
			$db->setQuery($sql);
			$db->query();
			
			$aro_id = (int)$db->insertid();
			
			$sql = "INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES ('25', '', '$aro_id')";
			$db->setQuery($sql);
			$db->query();
		}

		// Reset the old user's password to something stupid and block his access completely!
		jimport('joomla.user.helper');
		$prefix = JUserHelper::genRandomPassword(4);
		$password = JUserHelper::genRandomPassword(32);
		$salt = JUserHelper::genRandomPassword(32);
		
		$olduser['username'] = $prefix.'_'.$olduser['username'];
		$olduser['password'] = JUserHelper::getCryptedPassword($password, $salt);
		$olduser['email'] = $prefix.'_'.$olduser['email'];
		$olduser['block'] = 1;
		$olduser['sendEmail'] = 0;
		$userTable->save($olduser);

	}
}