<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id: seoandlink.php 178 2011-02-16 08:43:23Z nikosdion $
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class AdmintoolsModelStorage extends JModel
{
	/** @var JRegistry */
	private $config = null;
	
	public function getValue($key, $default = null)
	{
		if(is_null($this->config)) $this->load();
		
		return $this->config->getValue($key, $default);
	}
	
	public function setValue($key, $value, $save = false)
	{
		if(is_null($this->config)) $this->load();
		
		$x = $this->config->setValue($key, $value);
		if($save) $this->save();
		return $x;
	}
	
	public function load()
	{
		$db = JFactory::getDBO();
		$sql = 'SELECT '.$db->nameQuote('value').' FROM '.$db->nameQuote('#__admintools_storage').
			' WHERE '.$db->nameQuote('key').' = '.$db->quote('cparams');
		$db->setQuery($sql);
		$res = $db->loadResult();
		
		$this->config = new JRegistry('admintools');
		if(!empty($res)) {
			$res = json_decode($res, true);
			$this->config->loadArray($res);
		}
	}
	
	public function save()
	{
		if(is_null($this->config)) $this->load();
		
		$db = JFactory::getDBO();
		$data = $this->config->toArray();
		$data = json_encode($data);
		
		$sql = 'REPLACE INTO '.$db->nameQuote('#__admintools_storage').' (' .
			$db->nameQuote('key').', '.$db->nameQuote('value').') VALUES('.
			$db->quote('cparams').', '.$db->quote($data).')';
		$db->setQuery($sql);
		$db->query();
	}
}