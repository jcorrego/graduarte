<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @Type        Core Framework Files
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class Zengrid
{
	private $manifest;
	private $template;
	
	public function getTemplate()
	{
		if (!isset($this->template))
		{
			$request = JRequest::get();
			$this->template = $request['cid'][0];
		}
			
		return $this->template;
	}
	
	public function getFramework()
	{
		return 'zengridframework';
	}
	
	public function getManifest()
	{
		if (!isset($this->manifest))
		{
			$this->manifest = simplexml_load_file(JPATH_ROOT.DS.'templates'.DS.self::getTemplate().DS.'templateDetails.xml');
		}
		return $this->manifest;
	}
	
	public function getParam($param)
	{
		if (isset($this->_parent->_registry['_default']['data']->$param)) {
			return $this->_parent->_registry['_default']['data']->$param;
		}
		else {
			return false;
		}
	}

}