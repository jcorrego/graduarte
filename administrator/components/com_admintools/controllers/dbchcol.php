<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'default.php';

class AdmintoolsControllerDbchcol extends AdmintoolsControllerDefault
{
	public function apply()
	{
		$model = $this->getThisModel();
		$collation = JRequest::getString('collation','utf8_general_ci');
		$model->changeCollation($collation);
		
		$msg = JText::_('ATOOLS_LBL_DBCHCOLDONE');
		$this->setRedirect('index.php?option=com_admintools&view=dbchcol', $msg);
	}	
}