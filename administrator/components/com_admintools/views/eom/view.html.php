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

class AdmintoolsViewEom extends JView
{
	function display()
	{
		// Set the toolbar title
		JToolBarHelper::title(JText::_('ADMINTOOLS_TITLE_EOM'),'admintools');
		JToolBarHelper::back((ADMINTOOLS_JVERSION == '15') ? 'Back' : 'JTOOLBAR_BACK','index.php?option=com_admintools');

		$model = $this->getModel();
		
		$isOffline = $model->isOffline();
		$htaccess = $model->getHtaccess();
		
		$this->assign('offline', $isOffline);
		$this->assign('htaccess', $htaccess);

		$this->setLayout('default');

		// Load CSS
		$document = JFactory::getDocument();
		$document->addStyleSheet(rtrim(JURI::base(),'/').'/../media/com_admintools/css/backend.css');
		
		JHTML::_('behavior.mootools');

		parent::display();
	}
}