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

<?php if($this->hasDefaultAdmin): ?>
<?php
if( ADMINTOOLS_JVERSION == '15' ) {
	$id = 62;
} else {
	$id = 42;
}
?>
<div class="admintools-warning">
	<p><?php echo JText::sprintf('ATOOLS_LBL_ADMINUSER_DEFAULTINUSE', $id) ?></p>
</div>

<div id="disclaimer">
<h3><?php echo JText::_('ATOOLS_LBL_ADMINUSER_THINGS') ?></h3>
<ul>
	<li><?php echo JText::_('ATOOLS_LBL_ADMINUSER_THING1') ?></li>
	<li><?php echo JText::_('ATOOLS_LBL_ADMINUSER_THING2') ?></li>
	<li><?php echo JText::_('ATOOLS_LBL_ADMINUSER_THING3') ?></li>
	<li><?php echo JText::_('ATOOLS_LBL_ADMINUSER_THING4') ?></li>
	<li><?php echo JText::_('ATOOLS_LBL_ADMINUSER_THING5') ?></li>
</ul>
</div>

<br/>

<form name="adminForm" action="index.php" method="post">
	<input type="hidden" name="option" value="com_admintools" />
	<input type="hidden" name="view" value="adminuser" />
	<input type="hidden" name="task" value="change" />
	<input type="submit" value="<?php echo JText::_('ATOOLS_LBL_ADMINUSER_CHANGEID'); ?>" />
</form>

<?php else: ?>
<div class="disclaimer">
	<p><?php echo JText::_('ATOOLS_LBL_ADMINUSER_NODEFAULT'); ?></p>
</div>
<?php endif; ?>