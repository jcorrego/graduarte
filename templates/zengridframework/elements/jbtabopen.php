<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @Type        Core Framework Files
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a editors element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementJbtabopen extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	
	var	$_name = 'Jbtabopen';

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe;
		jimport('joomla.environment.browser');
		require_once('zengrid.php');
		
		
		
$script = "
var accordion;
window.addEvent('domready', function() { 

var fieldsets = $$('fieldset.adminform');
var menuassign = fieldsets[1];
var newassign = new Element('li');
newassign.adopt(menuassign);
newassign.injectInside('zgf_overview');

if (readCookie('jbtabs')) tab = readCookie('jbtabs').split('.');
else tab = ['0','0'];

accordion = new Accordion('h3.atStart', 'div.atStart', {
	opacity: false,
	onActive: function(toggler, element){
		toggler.addClass('active');
	},
 
	onBackground: function(toggler, element){
		toggler.removeClass('active');
	}
}, $('jbtemplate'));

$$('#jbtabs a').addEvent('click', function() {
	$$('#jbtabs a').each(function(e) {
		e.removeClass('active');
	});
	this.addClass('active');
	id = this.getProperty('href').substr(1);
	createCookie('jbtabs',id,'1');
});

$$('dl.toptabs').each(function(tabs){ 
	tabs = new JTabs(tabs, {}); 
	tabs.display(tab[0]);
});


if (tab !== null) {
	accordion.display(tab[1]);
}

});

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = '; expires='+date.toGMTString();
	}
	else var expires = '';
	document.cookie = name+'='+value+expires+'; path=/';
}

function readCookie(name) {
	var nameEQ = name + '=';
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

		";
		$document =& JFactory::getDocument();
		$document->addStylesheet(JURI::root(true).'/templates/'.Zengrid::getFramework().'/elements/jbtabs.css'); 
		$document->addScript(JURI::root(true).'/templates/'.Zengrid::getFramework().'/elements/tabs.js');
		$document->addScriptDeclaration($script);
		
		$browser = JBrowser::getInstance();
		if (substr_count(strtolower($browser->getBrowser()), 'msie') && $browser->getVersion() < 8) $document->addStylesheet(JURI::root(true).'/templates/'.Zengrid::getFramework().'/elements/jtabs_ie.css');
		
		JHTML::_('behavior.modal', 'a.modal');
		
		return '</td></tr></table><div id="jbtemplate"><h3 class="toggler atStart">'. $value .'</h3><div class="element atStart"><table class="adminlist">';
	}

	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
?>

 