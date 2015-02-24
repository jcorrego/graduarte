<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');
?>

<?php if(is_null($this->updateinfo->status)): ?>
<div id="joomla-no-update-information">
	<p>
		<?php echo JText::_('ATOOLS_LBL_JUPDATE_NO_AUTOUPDATE') ?>
	</p>
	<p>
		<?php echo JText::_('ATOOLS_LBL_JUPDATE_YOURVERSION') ?>:
		<?php echo $this->updateinfo->version ?>
	</p>

</div>

<div id="joomla-update-buttonbar">
	<a class="button" href="index.php?option=com_admintools&view=jupdate&task=force">
		<?php echo JText::_('ATOOLS_LBL_UPDATE_FORCE') ?>
	</a>
</div>

<?php else: ?>

<div id="joomla-update-information">
	<table cellspacing="0" border="0" width="100%">
		<tr>
			<td class="label"><?php echo JText::_('ATOOLS_LBL_JUPDATE_YOURVERSION') ?></td>
			<td><?php echo $this->updateinfo->current ?></td>
		</tr>
		<tr>
			<td class="label"><?php echo JText::_('ATOOLS_LBL_JUPDATE_LATESTVERSION') ?></td>
			<td><?php echo $this->updateinfo->version ?></td>
		</tr>
		<?php if(!empty($this->updateinfo->update)): ?>
		<tr>
			<td class="label"><?php echo JText::_('ATOOLS_LBL_JUPDATE_UPGRADEPACKAGEURL') ?></td>
			<td>
				<a href="<?php echo $this->updateinfo->update ?>"><?php echo $this->updateinfo->update ?></a>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td class="label"><?php echo JText::_('ATOOLS_LBL_JUPDATE_FULLPACKAGEURL') ?></td>
			<td>
				<a href="<?php echo $this->updateinfo->full ?>"><?php echo $this->updateinfo->full ?></a>
			</td>
		</tr>
	</table>
</div>

<div id="joomla-update-buttonbar">
	<?php if(version_compare(JVERSION, '1.6.5', 'ge') && version_compare(JVERSION, '1.7.0', 'lt')): ?>
	<!-- Joomla! 1.6.x to 1.7.0 upgrade -->
	<a class="button" href="index.php?option=com_admintools&view=jupdate&task=download&item=17">
		<?php echo JText::sprintf('ATOOLS_LBL_JUPDATE_UPGRADE','1.7.0') ?>
	</a>
	<?php endif; ?>
	
	<?php if(!empty($this->updateinfo->update)): ?>
	<a class="button" href="index.php?option=com_admintools&view=jupdate&task=download&item=upgrade">
		<?php echo JText::sprintf('ATOOLS_LBL_JUPDATE_UPGRADE',$this->updateinfo->version) ?>
	</a>
	<?php endif; ?>

	<a class="button" href="index.php?option=com_admintools&view=jupdate&task=download&item=full">
		<?php echo JText::sprintf('ATOOLS_LBL_JUPDATE_REINSTALL',$this->updateinfo->version) ?>
	</a>

	<a class="button" href="index.php?option=com_admintools&view=jupdate&task=force">
		<?php echo JText::_('ATOOLS_LBL_UPDATE_FORCE') ?>
	</a>

</div>

<?php endif; ?>