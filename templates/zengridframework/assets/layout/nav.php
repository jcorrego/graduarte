<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the nav layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Nav Wrapper -->
<div class="outerWrapper navRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<div id="navWrapper">
										<?php if ($logoPosition =="below") { ?>
										<div id="logo" style="width:<?php echo $$logoCols; ?>px">
												<a href="<?php echo $logoLink ?>"><img src="<?php echo $this->baseurl.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
												
										<?php if ($enableTagline) { ?>
											<div id="tagline">
													<span style="margin-left:<?php echo $taglineLeft ?>;margin-top:<?php echo $taglineTop ?>;"><?php echo $tagline ?></span>
											</div>
										<?php 
								
											} ?>
										</div> 
																		
										<?php } ?>
										<div id="navWrap" <?php if ($logoPosition =="above" or $logoPosition == "none" or $navLeft) { ?> class="navLeft" <?php } ?>style="width:<?php echo $$navCols; ?>px">
												<div id="nav" class="<?php echo $fontStackNav ?>">
															<jdoc:include type="modules" name="menu" style="xhtml" />
												</div>	
										</div>
								</div>	
						</div>
				</div>
		</div>
</div>
<!-- Nav Wrapper -->