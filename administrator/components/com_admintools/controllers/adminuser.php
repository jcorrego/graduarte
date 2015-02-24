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
 * A feature to change the site's database prefix - Controller
 */
class AdmintoolsControllerAdminuser extends AdmintoolsControllerDefault
{
	function change()
	{
		$model = $this->getThisModel();
		
		$result = $model->swapAccounts();
		$url = 'index.php?option=com_admintools&view=adminuser';
		$this->setRedirect($url, JText::sprintf('ATOOLS_LBL_ADMINUSER_OK'));
		
		$this->redirect();
	}
}