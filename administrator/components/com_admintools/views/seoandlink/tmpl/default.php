<?php
/**
 *  @package AdminTools
 *  @copyright Copyright (c)2010-2011 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 *  @version $Id$
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

$lang = JFactory::getLanguage();
?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
	<input type="hidden" name="option" value="com_admintools" />
	<input type="hidden" name="view" value="seoandlink" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="<?php echo JUtility::getToken();?>" value="1" />

	<fieldset>
		<legend><?php echo JText::_('ATOOLS_LBL_SEOANDLINK_OPTGROUP_MIGRATION') ?></legend>
		
		<div class="editform-row">
			<label for="linkmigration"><?php echo JText::_('ATOOLS_LBL_SEOANDLINK_OPT_LINKMIGRATION'); ?></label>
			<?php echo AdmintoolsHelperSelect::booleanlist('linkmigration', array(), $this->config['linkmigration']) ?>
		</div>
		<div class="editform2-row">
			<label for="migratelist" title="<?php echo JText::_('ATOOLS_LBL_SEOANDLINK_OPT_LINKMIGRATIONLIST_TIP') ?>"><?php echo JText::_('ATOOLS_LBL_SEOANDLINK_OPT_LINKMIGRATIONLIST'); ?></label>
			<textarea rows="5" cols="60" name="migratelist" id="migratelist"><?php echo $this->config['migratelist'] ?></textarea>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo JText::_('ATOOLS_LBL_SEOANDLINK_OPTGROUP_TOOLS') ?></legend>
		
		<div class="editform-row">
			<label for="httpsizer"><?php echo JText::_('ATOOLS_LBL_SEOANDLINK_OPT_HTTPSIZER'); ?></label>
			<?php echo AdmintoolsHelperSelect::booleanlist('httpsizer', array(), $this->config['httpsizer']) ?>
		</div>
	</fieldset>
</form>