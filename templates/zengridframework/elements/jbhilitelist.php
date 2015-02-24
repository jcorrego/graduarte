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
 * Renders a filelist element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementJbhilitelist extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Jbhilitelist';

	function fetchElement($name, $value, &$node, $control_name)
	{
		require_once('zengrid.php');
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );

		// path to images directory
		$path		= JPATH_ROOT.DS.'templates'.DS.Zengrid::getTemplate().DS.'css'.DS.'hilites'.DS;
		$filter		= $node->attributes('filter');
		$exclude	= $node->attributes('exclude');
		$stripExt	= $node->attributes('stripext');
		
		if (is_dir($path)) $files = JFolder::files($path, $filter); 
		else $files = false; 
		
		$options = array ();

		$options[] = JHTML::_('select.option', '', '- '.JText::_('No hilite').' -');

		if ( is_array($files) )
		{
			foreach ($files as $file)
			{
				if ($exclude)
				{
					if (preg_match( chr( 1 ) . $exclude . chr( 1 ), $file ))
					{
						continue;
					}
				}
				if ($stripExt)
				{
					$file = JFile::stripExt( $file );
				}
				$options[] = JHTML::_('select.option', $file, $file);
			}
		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value, $control_name.$name);
		}
		else 
		{
			return 'This theme does not have any hilites currently. You can add some by putting custom css files inside of /templates/'.Zengrid::getTemplate().'/css/hilites';
		}
		
	}
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='')
	{
		$output = '<label id="'.$control_name.$name.'-lbl" for="'.$control_name.$name.'"';
		if ($description) {
			$output .= ' class="hasTip" title="'.JText::_($label).'::'.JText::_(str_replace('[template]', Zengrid::getTemplate(), $description)).'">';
		} else {
			$output .= '>';
		}
		$output .= JText::_( $label ).'</label>';

		return $output;
	}
}
