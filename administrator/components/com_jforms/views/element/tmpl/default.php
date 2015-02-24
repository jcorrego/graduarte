<?php
/**
* Default layout for element view
*
* @version		$Id: default.php 170 2009-08-12 07:29:38Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
	
?>
<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th>
				<?php echo JText::_( 'Title' ); ?>
			</th>
			<th width="100">
				<?php echo JText::_( 'Author' ); ?>
			</th>
			<th width="50">
				<?php echo JText::_( 'Date' ); ?>
			</th>		
		</tr>			
	</thead>
	<?php
	$k = 0;
	
	for ($i=0, $n=count( $this->forms ); $i < $n; $i++){
			$row = &$this->forms[$i];
		
		$onClick = "window.parent.jSelectForm('$row->id', '".htmlspecialchars(addSlashes($row->title), ENT_QUOTES)."', 'id')";
		
		$date		= JHTML::_('date',  $row->created, JText::_('DATE_FORMAT_LC4') );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<a href='#' onclick="<?php echo $onClick; ?>"><?php echo $row->title; ?></a>
			</td>
			<td align="center">
				<?php echo $row->author; ?>
			</td>
			<td align="center">
				<?php echo JHTML::_('date',  $row->created, JText::_('DATE_FORMAT_LC4') ); ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
</table>
<?php
$version = new JFormsVersion();
$version->printFooter();