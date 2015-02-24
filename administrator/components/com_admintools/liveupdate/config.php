<?php
/**
 * @package LiveUpdate
 * @copyright Copyright ©2011 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 */

defined('_JEXEC') or die();

/**
 * Configuration class for your extension's updates. Override to your liking.
 */
class LiveUpdateConfig extends LiveUpdateAbstractConfig
{
	var $_extensionName			= 'com_admintools';
	var $_versionStrategy		= 'different';
	/**
	var $_storageAdapter		= 'component';
	var $_storageConfig			= array(
			'extensionName'	=> 'com_admintools',
			'key'			=> 'liveupdate'
		);
	*/
	
	function __construct()
	{
		jimport('joomla.filesystem.file');
		$isPro = (ADMINTOOLS_PRO == 1);

		// Determine the appropriate update URL based on whether we're on Core or Professional edition
		if($isPro)
		{
			$this->_updateURL = 'http://nocdn.akeebabackup.com/updates/atpro.ini';
			$this->_extensionTitle = 'Admin Tools Professional';
		}
		else
		{
			$this->_updateURL = 'http://nocdn.akeebabackup.com/updates/atcore.ini';
			$this->_extensionTitle = 'Admin Tools Core';
		}
		
		$this->_requiresAuthorization = $isPro;
		$this->_cacerts = dirname(__FILE__).'/../assets/cacert.pem';
		
		parent::__construct();		
	}
}