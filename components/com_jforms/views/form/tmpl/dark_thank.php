<?php
/**
* Thank you messege layout
*
* @version		$Id: default_thank.php 28 2008-12-09 07:14:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

echo '<div class="jform">';
echo '<h2>'.$this->form->title.'</h2>';
echo $this->form->thank;
echo '</div>';