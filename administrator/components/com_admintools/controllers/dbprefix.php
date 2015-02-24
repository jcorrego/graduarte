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
class AdmintoolsControllerDbprefix extends AdmintoolsControllerDefault
{
	function change()
	{
		$prefix = JRequest::getString('prefix','jos_');
		$model = $this->getThisModel();
		
		$result = $model->performChanges($prefix);
		$url = 'index.php?option=com_admintools&view=dbprefix';
		if($result !== true) {
			$this->setRedirect($url, $result, 'error');
		} else {
			$this->setRedirect($url, JText::sprintf('ATOOLS_LBL_DBREFIX_OK', $prefix));
		}
		
		$this->redirect();
	}
}