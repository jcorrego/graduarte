<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the header layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Logo Wrapper -->
<div class="outerWrapper logoRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<?php if ($logoPosition =="above") { ?>
								<div id="logo" style="width:<?php echo $$logoCols; ?>px;margin-right: <?php echo $gutter ?>px">
										<a href="<?php echo $logoLink ?>"><img src="<?php echo $this->baseurl.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
										
										<?php if ($enableTagline) { ?>
								<div id="tagline">
										<span style="margin-left:<?php echo $taglineLeft ?>;margin-top:<?php echo $taglineTop ?>;"><?php echo $tagline ?></span>
								</div>
								
								<?php } ?>
								</div> 
								
								
								<?php 								
								} ?>
								
								<?php if ($logoPosition =="below" or $logoPosition =="none") { ?>
								<div id="header1" style="width:<?php echo $$header1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="header1" style="xhtml" />
								</div> 								
								<?php } ?>
								
								<?php if($this->countModules('header2')) : ?>
								<div id="header2" style="width:<?php echo $$header2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="header2" style="xhtml" />
								</div>
								<?php endif; ?>
								
								<?php if($this->countModules('header3')) : ?>
								<div id="header3" style="width:<?php echo $$header3Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="header3" style="xhtml" />
								</div>
								<?php endif; ?>
								
								<?php if($this->countModules('header4')) : ?>
								<div id="header4" style="width:<?php echo $$header4Cols; ?>px">
										<jdoc:include type="modules" name="header4" style="xhtml" />
								</div>
								<?php endif; ?>
								
						</div>
				</div>
		</div>
</div>
<!-- Logo Wrapper -->