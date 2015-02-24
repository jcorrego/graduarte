<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.controller');
require_once dirname(__FILE__).'/default.php';

class AdmintoolsControllerPostsetup extends AdmintoolsControllerDefault
{
	/**
	 * Displays the editor page
	 *
	 */
	public function display()
	{
		parent::display();
	}
	
	public function save()
	{
		$enableAutoupdate = JRequest::getBool('autoupdate', 0);
		$enableAutojupdate = JRequest::getBool('autojupdate', 0);
		
		$db = JFactory::getDBO();
		
		if($enableAutoupdate || $enableAutojupdate) {
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$query = "UPDATE #__extensions SET enabled=1 WHERE element='oneclickaction' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			} else {
				$query = "UPDATE #__plugins SET published=1 WHERE element='oneclickaction' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			}
		} else {
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$query = "UPDATE #__extensions SET enabled=0 WHERE element='oneclickaction' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			} else {
				$query = "UPDATE #__plugins SET published=0 WHERE element='oneclickaction' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			}
		}
		
		if($enableAutoupdate) {
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$query = "UPDATE #__extensions SET enabled=1 WHERE element='atoolsupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			} else {
				$query = "UPDATE #__plugins SET published=1 WHERE element='atoolsupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			}
		} else {
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$query = "UPDATE #__extensions SET enabled=0 WHERE element='atoolsupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			} else {
				$query = "UPDATE #__plugins SET published=0 WHERE element='atoolsupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			}
		}
		
		if($enableAutojupdate) {
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$query = "UPDATE #__extensions SET enabled=1 WHERE element='atoolsjupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			} else {
				$query = "UPDATE #__plugins SET published=1 WHERE element='atoolsjupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			}
		} else {
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$query = "UPDATE #__extensions SET enabled=0 WHERE element='atoolsjupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			} else {
				$query = "UPDATE #__plugins SET published=0 WHERE element='atoolsjupdatecheck' AND folder='system'";
				$db->setQuery($query);
				$db->query();
			}
		}
		
		// Update last version check. DO NOT USE JCOMPONENTHELPER!
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
			$params = new JRegistry();
			$params->loadJSON($rawparams);
		} else {
			$params = new JParameter($rawparams);
		}
		$params->setValue('lastversion', ADMINTOOLS_VERSION);
		if( version_compare(JVERSION,'1.6.0','ge') )
		{
			// Joomla! 1.6
			$data = $params->toString('JSON');
			$sql = 'UPDATE `#__extensions` SET `params` = '.$db->Quote($data).' WHERE '.
				"`element` = ".$db->Quote('com_admintools')." AND `type` = 'component'";
		}
		else
		{
			// Joomla! 1.5
			$data = $params->toString('INI');
			$sql = 'UPDATE `#__components` SET `params` = '.$db->Quote($data).' WHERE '.
				"`option` = ".$db->Quote('com_admintools')." AND `parent` = 0 AND `menuid` = 0";
		}
		$db->setQuery($sql);
		$db->query();
		
		// Even better, create the "admintools.lastversion.php" file with this information
		$fileData = "<"."?php\ndefined('_JEXEC') or die();\ndefine('ADMINTOOLS_LASTVERSIONCHECK','".
			ADMINTOOLS_VERSION."');";
		jimport('joomla.filesystem.file');
		$fileName = JPATH_COMPONENT_ADMINISTRATOR.'/admintools.lastversion.php';
		JFile::write($fileName, $fileData);
		
		// Force reload the Live Update information
		$dummy = LiveUpdate::getUpdateInformation(true);
		
		$url = 'index.php?option=com_admintools&view=cpanel';
		$app = JFactory::getApplication();
		$app->redirect($url);
	}
}