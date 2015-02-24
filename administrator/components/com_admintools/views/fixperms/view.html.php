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

class AdmintoolsViewFixperms extends JView
{
	function display()
	{
		// Set the toolbar title
		JToolBarHelper::title(JText::_('ADMINTOOLS_TITLE_FIXPERMS'),'admintools');

		$task = JRequest::getCmd('task','default');
		$model = $this->getModel();

		switch($task)
		{
			case 'default':
			default:
				$state = $model->startScanning();
				break;

			case 'run':
				$state = $model->run();
				break;
		}

		$total = $model->totalFolders;
		$done = $model->doneFolders;

		if($state)
		{
			if($total > 0)
			{
				$percent = min(max(round(100 * $done / $total),1),100);
			}

			$more = true;
		}
		else
		{
			$percent = 100;
			$more = false;

			JToolBarHelper::back((ADMINTOOLS_JVERSION == '15') ? 'Back' : 'JTOOLBAR_BACK', 'index.php?option=com_admintools');
		}

		$this->assign('more', $more);
		$this->setLayout('default');

		// Load CSS
		$document = JFactory::getDocument();
		$document->addStyleSheet(rtrim(JURI::base(),'/').'/../media/com_admintools/css/backend.css');
		
		JHTML::_('behavior.mootools');

		$script = "window.addEvent( 'domready' ,  function() {\n";
		$script .= "$('progressbar-inner').setStyle('width', '$percent%');\n";
		if($more) {
			$script .= "document.forms.adminForm.submit();\n";
		}
		$script .= "});\n";
		$document->addScriptDeclaration($script);

		parent::display();
	}
}