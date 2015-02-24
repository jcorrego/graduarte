<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid4 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Fourth Row Grid -->
<div class="outerWrapper grid4Row">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
			<div class="containerBG">
				<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">								
								
						
								<div class="gridWrap4">
									
											<?php if($this->countModules('grid13')) : ?>
													<div id="grid13" style="width:<?php echo $$grid13Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid13" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid14')) : ?>
													<div id="grid14" style="width:<?php echo $$grid14Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid14" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid15')) : ?>
													<div id="grid15" style="width:<?php echo $$grid15Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid15" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid16')) : ?>
													<div id="grid16" style="width:<?php echo $$grid16Cols; ?>px">
															<jdoc:include type="modules" name="grid16" style="xhtml" />
													</div>
											<?php endif; ?>
									
								</div>
				
					</div>
			</div>
		</div>
</div><!-- Fourth Grid -->