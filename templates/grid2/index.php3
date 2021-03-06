<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');

$url = clone(JURI::getInstance());
$showRightColumn = $this->countModules('user1 or user2 or right or top');
$showRightColumn &= JRequest::getCmd('layout') != 'form';
$showRightColumn &= JRequest::getCmd('task') != 'edit'
?>


<?php echo '<?xml version="1.0" encoding="utf-8"?'.'>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
	<jdoc:include type="head" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/template.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/position.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/layout.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/print.css" type="text/css" media="Print" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/general.css" type="text/css" />
	<?php if($this->direction == 'rtl') : ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/template_rtl.css" type="text/css" />
	<?php endif; ?>
	<!--[if lte IE 6]>
		<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/ieonly.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if IE 7]>
		<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/ie7only.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/javascript/md_stylechanger.js"></script>
</head>
<body background="FONDOWEB.jpg" topmargin="0" leftmargin="0">

<div align="center">
	<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td align="center" bgcolor="#000000" height="50" style="color: #FFF">
			<table border="0" width="800" cellspacing="0" cellpadding="0">
				<tr>
					<td style="color: #FFF">			<jdoc:include type="modules" name="top" /></td>
					<td width="30" style="color: #FFF">&nbsp;</td>
					<td width="200" style="color: #FFF">			<jdoc:include type="modules" name="search" /></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td style="color: #FFF" >
			<div align="center">
				<table width="800" border="0" cellspacing="0" cellpadding="0" >
					<tr>
						<td style="color: #FFF">&nbsp;</td>
					</tr>
					<tr>
						<td style="color: #FFF">
						<table width="800" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="94" bgcolor="#999999" style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000">
								<img border="0" src="logovert.jpg" width="94" height="398"></td>
								<td  width="10">
											
																							&nbsp;</td>
								<td style="text-align: left; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000" valign="top" width="800">
											
																										
																													<?php if($this->countModules('advert1')) : ?>
															<div id="abovecontent1" style="width:<?php echo $$advert1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
																	<jdoc:include type="modules" name="advert1" style="xhtml" />
															</div>
																														<?php endif; ?>

											
											
											<br>
											
											
															<jdoc:include type="component" />
																										
																										</td>
							</tr>
							<tr>
								<td bgcolor="#666666" style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000">
								<p>&nbsp;<p>&nbsp;</td>
								<td style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td  style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000">
							</td>
								<td style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#666666" style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000">
								</td>
								<td bgcolor="#666666" style="text-align: center; font-family: Tahoma, Geneva, sans-serif; font-size: 16px; color: #000" height="25" colspan="2">
								<font color="#FFFFFF">CRA 67 No. 42 - 27&nbsp;&nbsp; 
								TELEFONO: 479 7339&nbsp;&nbsp;&nbsp; BOGOTA - 
								COLOMBIA - SURAMERICA</font></td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td style="color: #FFF">&nbsp;</td>
					</tr>
					<tr>
						<td style="color: #FFF">&nbsp;</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
	</table>
</div>

</body>




</html>
