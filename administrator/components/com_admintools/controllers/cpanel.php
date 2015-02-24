<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'default.php';

class AdmintoolsControllerCpanel extends AdmintoolsControllerDefault
{
	public function display()
	{
		$model = $this->getModel('Jupdate',		'AdmintoolsModel');
		$model2 = $this->getModel('Cpanel',		'AdmintoolsModel');
		$model3 = $this->getModel('Adminpw',	'AdminToolsModel');
		$model4 = $this->getModel('Masterpw',	'AdminToolsModel');

		$view = $this->getThisView();
		$view->setModel($model,		true);
		$view->setModel($model3,	false);
		$view->setModel($model4,	false);

		$model2->autoMigrate();
		
		// Check the last installed version (only the Professional release)
		if(ADMINTOOLS_PRO) {
			$versionLast = null;
			if(file_exists(JPATH_COMPONENT_ADMINISTRATOR.'/admintools.lastversion.php')) {
				include_once JPATH_COMPONENT_ADMINISTRATOR.'/admintools.lastversion.php';
				if(defined('ADMINTOOLS_LASTVERSIONCHECK')) $versionLast = ADMINTOOLS_LASTVERSIONCHECK;
			}
			if(is_null($versionLast)) {
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
					$params = new JRegistry();
					$params->loadJSON($rawparams);
				} else {
					$params = new JParameter($rawparams);
				}

				$versionLast = $params->get('lastversion','');
			}
			if(version_compare(ADMINTOOLS_VERSION, $versionLast, 'ne') || empty($versionLast)) {
				$this->setRedirect('index.php?option=com_admintools&view=postsetup');
				return;
			}
		}

		parent::display();
	}

	public function login()
	{
		$model = $this->getModel('Masterpw');
		$password = JRequest::getVar('userpw','');
		$model->setUserPassword($password);

		$url = 'index.php?option=com_admintools';
		$this->setRedirect($url);
	}
}
