<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid2 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 

// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Second Row Grid -->
<div class="outerWrapper grid2Row">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">		
		
								<div class="gridWrap2">
									
											<?php if($this->countModules('grid5')) : ?>
													<div id="grid5" style="width:<?php echo $$grid5Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid5" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid6')) : ?>
													<div id="grid6" style="width:<?php echo $$grid6Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid6" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid7')) : ?>
													<div id="grid7" style="width:<?php echo $$grid7Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid7" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid8')) : ?>
													<div id="grid8" style="width:<?php echo $$grid8Cols; ?>px">
															<jdoc:include type="modules" name="grid8" style="xhtml" />
													</div>
											<?php endif; ?>
										
								</div>
								<div class="clear"></div>
								
						</div>
				</div>
		</div>
</div>
<!-- Second Row Grid -->
