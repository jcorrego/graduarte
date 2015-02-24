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

class AdmintoolsViewAcl extends AdmintoolsViewBase
{
	protected function onDisplay()
	{
		// Set toolbar title
		$subtitle_key = 'ADMINTOOLS_TITLE_'.strtoupper(JRequest::getCmd('view','cpanel'));
		JToolBarHelper::title(JText::_('ADMINTOOLS_TITLE_DASHBOARD').' &ndash; <small>'.JText::_($subtitle_key).'</small>','admintools');
		
		// Add some buttons
		JToolBarHelper::back((ADMINTOOLS_JVERSION == '15') ? 'Back' : 'JTOOLBAR_BACK', 'index.php?option='.JRequest::getCmd('option'));

		// Get the users from manager and above
		$model = JModel::getInstance('Acl','AdmintoolsModel');
		$list =& $model->getUserList();
		$this->assignRef('userlist', $list);
		$this->assign('minacl', $model->getMinGroup());
	}
}