<?php
/**
* Default layout for records view
*
* @version		$Id: default.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');


 



$headers = explode( ',', JFORM_SYSTEM_FIELDS );

$hashes  = array_pad( array(), count($headers), '0' );
 

$pManager =& $this->pManager;
$pManager->loadElementPlugins();

foreach( $this->form->fields as $f  ){
	
	$needStorage = count($pManager->element_plugins[$f->type]->storage);
	//Fields with no storage requirements shouldn't get any headers in our table
	if( !$needStorage )continue;
	$headers[] = $f->parameters['label'];
	$hashes[]  = $f->parameters['hash'];
	
}
$headers[0] = JText::_($headers[0]);

if( count($this->form->records) ){
	echo JFormsRecordsHelper::loadCSS();
	echo JFormsRecordsHelper::loadJS($this);
}
?>


<table width='100%'>
<tr>
	<td valign='top' width='300'>
	<div id='tabButton1' onclick='javascript:displayFilters(this);' class='activated-tab-button'><?php echo JText::_('Filters')?></div>
	<div id='tabButton2' onclick='javascript:displayExport(this);' class='tab-button'><?php echo JText::_('Export')?></div>
	
	<div id='filters'>
	<br />
	<br />
	<form action='<?php echo JRoute::_("index.php");?>' id='filter_form' name='filter_form' method='post'>
	<h2><?php echo JText::_('Fields') ?></h2>	
	<?php
		echo $this->elementPluginFormsHTML;
		echo "<input value='' id='headers_filter' type='hidden' name='headers_filter'  />";
		?>
		<hr />
		<?php
		echo '<input type="button" value="'.JText::_('Show Database Mapping').'" onclick="toggleDBMapping(this)" style="margin-bottom:10px;float:right" /><br clear="all" />';
		echo '<div style="display:none;" id="db-mapping">';
		echo $this->dbMappingHTML;
		echo '</div>';
		?>
		<hr />
		<?php
		echo "<label for='record_per_page'>".JText::_('Records per page')."</label>";
		echo "<select id='record_per_page' name='record_per_page' onchange='refreshPageList()'>";
			echo "<option value='5'>5</option>";
			echo "<option value='20' selected='selected'>20</option>";
			echo "<option value='50'>50</option>";
			echo "<option value='100'>100</option>";
			echo "<option value='200'>200</option>";
		echo "</select><br clear='all' />";
		
		echo "<label for='current_page'>".JText::_('Current Page')."</label>";
		echo "<select id='current_page' name='current_page' >";
			echo "<option value='1'>1</option>";
		echo "</select><br clear='all' />";
		
		echo "<input id='reload-button' value='".JText::_('Reload')."' onclick='reload()' type='button' /><br />";		
		
		echo "<input id='delete-button' value='".JText::_('Delete Selected')."' onclick='deleteSelected()' type='button' /><br />";		
		
		
		echo '<hr />';
		
	
	?>
	</form>
	</div>
	<div id='export' style='display:none;padding-top:40px;'>

		<?php echo $this->exportPluginFormsHTML; ?>
 	</div>
	</td>
	<td  id='grid_container' valign='top'><div style='text-align:center;width:100%' id='loadingDiv'><?php echo JText::_('Processing...'); ?><br /><img alt='<?php echo JText::_('Processing...'); ?>' src='<?php echo JURI::base().'/components/com_jforms/views/records/ajax-loader.gif' ?>' /></div></td>
</tr>
</table>
<?php
$version = new JFormsVersion();
$version->printFooter();