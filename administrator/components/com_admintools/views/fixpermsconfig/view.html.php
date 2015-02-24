<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.view.html.php';

class AdmintoolsViewFixpermsconfig extends AdmintoolsViewBase
{
	protected function onDisplay()
	{
		$app = JFactory::getApplication();
		$hash = $this->getHash();

		// ...filter states
		$this->lists->set('fltPath', $app->getUserStateFromRequest($hash.'filter_path', 'string', null));

		// Default permissions
		$params = JModel::getInstance('Storage','AdmintoolsModel');

		$dirperms = '0'.ltrim(trim($params->getValue('dirperms', '0755')),'0');
		$fileperms = '0'.ltrim(trim($params->getValue('fileperms', '0644')),'0');

		$dirperms = octdec($dirperms);
		if( ($dirperms < 0600) || ($dirperms > 0777) ) $dirperms = 0755;
		$this->assign('dirperms', '0'.decoct($dirperms));

		$fileperms = octdec($fileperms);
		if( ($fileperms < 0600) || ($fileperms > 0777) ) $fileperms = 0755;
		$this->assign('fileperms', '0'.decoct($fileperms));

		// File lists
		$model = $this->getModel();
		$listing = $model->getListing();
		$this->assignRef('listing', $listing);

		$relpath = $model->getState('filter_path','');
		$this->assign('path', $relpath);

		// Load the helper
		require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'select.php';

		// Add toolbar buttons
		JToolBarHelper::back((ADMINTOOLS_JVERSION == '15') ? 'Back' : 'JTOOLBAR_BACK', 'index.php?option=com_admintools');

		// Run the parent method
		//parent::onDisplay();

		$subtitle_key = 'ADMINTOOLS_TITLE_'.strtoupper(JRequest::getCmd('view','cpanel'));
		JToolBarHelper::title(JText::_('ADMINTOOLS_TITLE_DASHBOARD').' &ndash; <small>'.JText::_($subtitle_key).'</small>','admintools');
	}
}