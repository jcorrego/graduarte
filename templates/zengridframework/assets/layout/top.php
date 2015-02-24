<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the top layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<div class="outerWrapper topRow"> <!-- Top Wrapper -->
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<div id="topWrapper">
								
								
								<?php if($this->countModules('top1')) : ?>
									<div id="top1" style="width:<?php echo $$top1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
												<jdoc:include type="modules" name="top1" style="xhtml" />
									</div>
									<?php endif; ?>
									
									<?php if($this->countModules('top2')) : ?>
									<div id="top2" style="width:<?php echo $$top2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
												<jdoc:include type="modules" name="top2" style="xhtml" />
									</div>
									<?php endif; ?>
									
									<?php if($this->countModules('top3')) : ?>
									<div id="top3" style="width:<?php echo $$top3Cols; ?>px;margin-right: <?php echo $gutter ?>px">
												<jdoc:include type="modules" name="top3" style="xhtml" />
									</div>
									<?php endif; ?>
									
									<?php if($this->countModules('top4')) : ?>
									<div id="top4" style="width:<?php echo $$top4Cols; ?>px">
												<jdoc:include type="modules" name="top4" style="xhtml" />
									</div>
								<?php endif; ?>

									
								</div> 
						</div>
				</div>
		</div>
</div> <!-- Top Wrapper -->