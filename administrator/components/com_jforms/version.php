<?php
/**
* Version File
*
* @version		$Id: version.php 166 2009-07-04 10:33:39Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Version information
 *
 */
class JFormsVersion
{
	/** @var string Product */
	var $PRODUCT 	= 'JForms';
	
	/** @var int Main Release Level */
	var $RELEASE 	= '0.6';
	
	/** @var string Development Status */
	var $DEV_STATUS = 'RC3';
	
	//The following variables are filled during the automated build process
	
	/** @var int build Number */
	var $BUILD = '308';
	
	/** @var string Date */
	var $RELDATE = '07-September-2009';
	
	/** @var string Time */
	var $RELTIME = '12:54';
	
	/** @var string Timezone */
	var $RELTZ 	= 'GMT';
	
	/** @var string Copyright Text */
	var $COPYRIGHT 	= 'Copyright (C) 2008 - 2009 Mostafa Muhammad. All rights reserved.';
	
	/** @var string URL */
	var $URL 	= '<a href="http://jforms.mosmar.com">JForms</a> is Free Software released under the GNU General Public License.';

	/**
	 *
	 *
	 * @return string Long format version
	 */
	function getLongVersion()
	{
		return $this->PRODUCT .' '. $this->RELEASE .' '. $this->DEV_STATUS .' ('.$this->BUILD.')'
			.' [ '. $this->RELDATE .' '. $this->RELTIME .' '. $this->RELTZ.' ]';
	}

	/**
	 *
	 *
	 * @return string Short version format
	 */
	function getShortVersion() {
		return $this->RELEASE .'.'. $this->DEV_LEVEL;
	}
	
	function printFooter(){
		echo '<div style="text-align:right;font-size:x-small;font-weight:bold;color:green">';
		echo $this->getLongVersion();
		echo '</div>';
		
		echo '<div style="text-align:center;font-size:xx-small">';
		echo $this->URL;
		echo '</div>';

	}

}
