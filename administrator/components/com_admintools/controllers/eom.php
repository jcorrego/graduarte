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

/**
 * Emergency Off-Line Mode
 */
class AdmintoolsControllerEom extends AdmintoolsControllerDefault
{
	public function offline()
	{
		// CSRF prevention
		if(!JRequest::getVar(JUtility::getToken(), false, 'POST')) {
			JError::raiseError('403', JText::_('Request Forbidden'));
		}
		
		$model = $this->getThisModel();

		$status = $model->putOffline();
		$url = 'index.php?option=com_admintools';
		if($status)
		{
			$this->setRedirect($url,JText::_('ATOOLS_LBL_EOM_APPLIED'));
		}
		else
		{
			$this->setRedirect($url,JText::_('ATOOLS_ERR_EOM_NOTAPPLIED'),'error');
		}
	}

	public function online()
	{
		// CSRF prevention
		if(!JRequest::getVar(JUtility::getToken(), false, 'POST')) {
			JError::raiseError('403', JText::_('Request Forbidden'));
		}
		
		$model = $this->getThisModel();
		$status = $model->putOnline();
		$url = 'index.php?option=com_admintools';
		if($status)
		{
			$this->setRedirect($url,JText::_('ATOOLS_LBL_EOM_UNAPPLIED'));
		}
		else
		{
			$this->setRedirect($url,JText::_('ATOOLS_ERR_EOM_NOTUNAPPLIED'),'error');
		}
	}
}
