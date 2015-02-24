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
 * The Control Panel model
 *
 */
class AdmintoolsModelCpanel extends JModel
{
	/**
	 * Constructor; dummy for now
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getPluginID()
	{
		if(ADMINTOOLS_JVERSION == '15') {
			$db = $this->getDBO();
			$sql = 'SELECT id'
				. ' FROM #__plugins'
				. ' WHERE published >= 1'
				. ' AND (folder = "system")'
				. ' AND (element = "admintools")'
				. ' ORDER BY ordering'
				. ' LIMIT 0,1';
			$db->setQuery( $sql );
			$id = $db->loadResult();			
		} else {
			$db = $this->getDBO();
			$sql = 'SELECT extension_id'
				. ' FROM #__extensions'
				. ' WHERE enabled >= 1'
				. ' AND (folder = "system")'
				. ' AND (element = "admintools")'
				. ' AND (type = "plugin")'
				. ' ORDER BY ordering'
				. ' LIMIT 0,1';
			$db->setQuery( $sql );
			$id = $db->loadResult();
		}
		return $id;
	}
	
	/**
	 * Automatically migrates settings from the component's parameters storage
	 * to our version 2.1+ dedicated storage table.
	 */
	public function autoMigrate()
	{
		// First, load the component parameters
		// FIX 2.1.13: Load the component parameters WITHOUT using JComponentHelper
		$db = JFactory::getDbo();
		if( version_compare(JVERSION,'1.6.0','ge') ) {
			$sql = 'SELECT '.$db->nameQuote('params').' FROM '.$db->nameQuote('#__extensions').
				' WHERE '.$db->nameQuote('type').' = '.$db->Quote('component').' AND '.
				$db->nameQuote('element').' = '.$db->Quote('com_admintools');
			$db->setQuery($sql);
		} else {
			$sql = 'SELECT '.$db->nameQuote('params').' FROM '.$db->nameQuote('#__components').
				' WHERE '.$db->nameQuote('option').' = '.$db->Quote('com_admintools').
				" AND `parent` = 0 AND `menuid` = 0";
			$db->setQuery($sql);
		}
		$rawparams = $db->loadResult();
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$cparams = new JRegistry();
			$cparams->loadJSON($rawparams);
		} else {
			$cparams = new JParameter($rawparams);
		}
		
		// Migrate parameters
		$allParams = $cparams->toArray();
		$safeList = array('liveupdate','downloadid','lastversion');
		$params = JModel::getInstance('Storage','AdmintoolsModel');
		$modified = 0;
		foreach($allParams as $k => $v) {
			if(in_array($k, $safeList)) continue;
			if($v == '') continue;
			
			$modified++;
			
			$cparams->setValue($k, null);
			$params->setValue($k, $v);
		}
		
		if($modified == 0) return;
		
		// Save new parameters
		$params->save();
		
		// Save component parameters
		$db =& JFactory::getDBO();
		$data = $cparams->toString();

		if( ADMINTOOLS_JVERSION != '15' )
		{
			// Joomla! 1.6
			$sql = 'UPDATE `#__extensions` SET `params` = '.$db->Quote($data).' WHERE '.
				"`element` = 'com_admintools' AND `type` = 'component'";
		}
		else
		{
			// Joomla! 1.5
			$sql = 'UPDATE `#__components` SET `params` = '.$db->Quote($data).' WHERE '.
				"`option` = 'com_admintools' AND `parent` = 0 AND `menuid` = 0";
		}

		$db->setQuery($sql);
		$db->query();
	}

}