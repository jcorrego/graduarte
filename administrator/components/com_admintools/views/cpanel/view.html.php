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
jimport('joomla.application.component.view');

class AdmintoolsViewCpanel extends JView
{
	function display()
	{
		// Is this the Professional release?
		jimport('joomla.filesystem.file');
		$isPro = (ADMINTOOLS_PRO == 1);
		$this->assign('isPro', $isPro);

		// Set the toolbar title
		if($isPro) {
			JToolBarHelper::title(JText::_('ADMINTOOLS_TITLE_DASHBOARD_PRO').' <small>'.ADMINTOOLS_VERSION.'</small>','admintools');
		} else {
			JToolBarHelper::title(JText::_('ADMINTOOLS_TITLE_DASHBOARD_CORE').' <small>'.ADMINTOOLS_VERSION.'</small>','admintools');
		}

		if(ADMINTOOLS_JVERSION == '16') {
			JToolBarHelper::preferences('com_admintools', '265', '400');
		} else {
			JToolBarHelper::preferences('com_admintools', '220', '400');
		}

		// Load the models
		$model =& $this->getModel();
		$updates = $this->getModel('jupdate');
		$adminpwmodel = $this->getModel('adminpw');
		$mpModel = $this->getModel('masterpw');

		// Decide on the Joomla! updates icon
		$updateinfo = $updates->getUpdateInfo();
		if(is_null($updateinfo->status)) {
			$jupdatestatus = 'manual';
			$jupdatesub = JText::_('');
		} else {
			$jupdatestatus = $updateinfo->status ? 'warning' : 'ok';
		}
		$this->assign('jupdatestatus',			$jupdatestatus );
		$this->assign('updateinfo',				$updateinfo );

		// Decide on the administrator password padlock icon
		$adminlocked = $adminpwmodel->isLocked();
		$this->assign('adminLocked',			$adminlocked);

		// Do we have to show a master password box?
		$this->assign('hasValidPassword',		$mpModel->hasValidPassword());

		// If the user doesn't have a valid master pw for some views, don't show
		// the buttons.
		$this->assign('enable_cleantmp',		$mpModel->accessAllowed('cleantmp'));
		$this->assign('enable_fixperms',		$mpModel->accessAllowed('fixperms'));
		$this->assign('enable_purgesessions',	$mpModel->accessAllowed('purgesessions'));
		$this->assign('enable_dbtools',			$mpModel->accessAllowed('dbtools'));
		$this->assign('enable_dbchcol',			$mpModel->accessAllowed('dbchcol'));
		
		$this->assign('pluginid',				$model->getPluginID());

		// Load CSS
		$document = JFactory::getDocument();
		$document->addStyleSheet(rtrim(JURI::base(),'/').'/../media/com_admintools/css/backend.css');
		
		JHTML::_('behavior.mootools');

		parent::display();
	}
}