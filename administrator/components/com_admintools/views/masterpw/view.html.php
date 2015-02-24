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

class AdmintoolsViewMasterpw extends AdmintoolsViewBase
{
	protected function onDisplay()
	{
		// Add toolbar buttons
		JToolBarHelper::save();
		JToolBarHelper::divider();
		JToolBarHelper::back((ADMINTOOLS_JVERSION == '15') ? 'Back' : 'JTOOLBAR_BACK', 'index.php?option='.JRequest::getCmd('option'));
		
		$model = JModel::getInstance('Masterpw','AdmintoolsModel');
		$masterpw = $model->getMasterPassword();
		
		$this->assign('masterpw',			$masterpw);

		parent::onDisplay();
	}
}