<?php
/**
* Default layout for design view
*
* @version		$Id: default.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

//Loaded Manually now
//JHTML::_('behavior.tooltip');

JFormsDesignHelper::loadCoreJSFiles($this);
echo $this->jsBlock;
?>

				

<?php echo JFormsDesignHelper::doSessionStatus(); ?>
<table id='main-table' width='100%' cellpadding='1' cellspacing='2' border='0'>
<tr>
	<td id='side-bar'>
	<div id='tabButton1' onclick='javascript:displayToolbar(this);' class='activated-tab-button'><?php echo JText::_('Toolbar')?></div>
	<div id='tabButton2' onclick='javascript:displayFormSettings(this);' class='tab-button'><?php echo JText::_('Form...')?></div>
	<div id='tabButton3' onclick='javascript:displayElementProperties();' class='tab-button'><?php echo JText::_('Element...')?></div>
	<br clear='all' />
	<div id='controls'>
		<?php JFormsDesignHelper::doButtons() ?>
	</div>
	<div id='properties-container' style='display:none'>
		<div id='properties'>
			<?php JFormsDesignHelper::doPropertyPages(); ?>
		</div>
	</div>
	
	<div id='settings' style='display:none'>
		<?php echo $this->settingsPane ?>
	</div>
	
	</td>

	<td id='workarea-td'>
		<input onclick='alignLabels()' type='button' value='<?php echo JText::_('Align Labels') ?>' style='float:left;margin-bottom:10px;font-size:12px' />
		<input onclick='alignControls()' type='button' value='<?php echo JText::_('Align Controls') ?>' style='float:left;margin-bottom:10px;font-size:12px' />
		<br clear='all' />
		<div id='workarea' class='workarea'>
		<form id="cvForm">
			<ul id='clist'></ul>
		</form>
		</div>
	</td>
</tr>
</table>
<?php
$version = new JFormsVersion();
$version->printFooter();