<?php
/**
* @package		Joomla
* @subpackage	com_morfeoshow
* @copyright	Copyright (C) Vamba & Matthew Thomson. All rights reserved.
* @license		GNU/GPL.
* @author 		Vamba (.joomlaitalia.com) & Matthew Thomson (ignitejoomlaextensions.com)
* @based on  	com_morfeoshow
* @author 		Matthew Thomson (ignitejoomlaextensions.com)
* Joomla! and com_morfeoshow are free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed they include or
* are derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

function Svuota($dir)
{
		global $mainframe;
		//Pulisco la cartella Temporanea delle immagini
			if($objs = @glob($dir. JPATH_SITE .DS.'images'.DS.'morfeoshow'.DS.'temp_upload'.DS.'*'))
	{
        foreach($objs as $obj) 
		{
			@is_dir($obj)? Svuota($obj) : @unlink($obj);
		}
	}
		@rmdir($dir);
		//copio file index.html nella cartella temporanea
		$file 	= 'index.html';	
		$source = JPATH_ROOT . DS . 'images';	
		$dest 	= JPATH_ROOT . DS . 'images' . DS . 'morfeoshow' . DS . 'temp_upload' . DS;	
		@copy($source. DS .$file,$dest. DS .$file);
 
		$message = JText::_('Temporary Images Folder Cleared');
		$link = 'index.php?option=com_morfeoshow&task=showSettings';
		$mainframe->redirect( $link, $message);
}
?>