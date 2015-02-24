<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2011 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id$
 * @since 3.3.b1
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.view');

/**
 * MVC View for Profiles management
 *
 */
class AdmintoolsViewPostsetup extends JView
{
	public function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('COM_ADMINTOOLS').': <small>'.JText::_('COM_ADMINTOOLS_POSTSETUP_TITLE').'</small>','admintools');
		
		// Add a spacer, a help button and show the template
		JToolBarHelper::spacer();
		
		$this->_setAutoupdateStatus();
		$this->_setJAutoupdateStatus();
		
		$document = JFactory::getDocument();
		$document->addStyleSheet( rtrim(JURI::base(),'/').'/../media/com_admintools/css/backend.css');

		parent::display($tpl);
	}
	
	private function _setAutoupdateStatus()
	{
		$db = JFactory::getDBO();
		
		if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE element='oneclickaction' AND folder='system'");
		} else {
			$db->setQuery("SELECT `published` FROM `#__plugins` WHERE element='oneclickaction' AND folder='system'");
		}
		$enabledOCA = $db->loadResult();
		
		if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE element='atoolsupdatecheck' AND folder='system'");
		} else {
			$db->setQuery("SELECT `published` FROM `#__plugins` WHERE element='atoolsupdatecheck' AND folder='system'");
		}
		$enabledAUC = $db->loadResult();
		
		if(!ADMINTOOLS_PRO) {
			$enabledAUC = false;
			$enabledOCA = false;
		}
		
		$this->assign('enableautoupdate', $enabledAUC && $enabledOCA);
	}
	
	private function _setJAutoupdateStatus()
	{
		$db = JFactory::getDBO();
		
		if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE element='oneclickaction' AND folder='system'");
		} else {
			$db->setQuery("SELECT `published` FROM `#__plugins` WHERE element='oneclickaction' AND folder='system'");
		}
		$enabledOCA = $db->loadResult();
		
		if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$db->setQuery("SELECT `enabled` FROM `#__extensions` WHERE element='atoolsjupdatecheck' AND folder='system'");
		} else {
			$db->setQuery("SELECT `published` FROM `#__plugins` WHERE element='atoolsjupdatecheck' AND folder='system'");
		}
		$enabledJUC = $db->loadResult();
		
		if(!ADMINTOOLS_PRO) {
			$enabledJUC = false;
			$enabledOCA = false;
		}
		
		$this->assign('enableautojupdate', $enabledJUC && $enabledOCA);
	}
}