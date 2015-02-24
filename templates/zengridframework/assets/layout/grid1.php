<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid1 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
  
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- First Row Grid -->
<div class="outerWrapper grid1Row">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<div class="gridWrap1">
									
										<?php if($this->countModules('grid1')) : ?>
												<div id="grid1" style="width:<?php echo $$grid1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="grid1" style="xhtml" />
												</div>
										<?php endif; ?>
										<?php if($this->countModules('grid2')) : ?>
												<div id="grid2" style="width:<?php echo $$grid2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="grid2" style="xhtml" />
												</div>
										<?php endif; ?>
										<?php if($this->countModules('grid3')) : ?>
												<div id="grid3" style="width:<?php echo $$grid3Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="grid3" style="xhtml" />
												</div>
										<?php endif; ?>
										<?php if($this->countModules('grid4')) : ?>
												<div id="grid4" style="width:<?php echo $$grid4Cols; ?>px">
														<jdoc:include type="modules" name="grid4" style="xhtml" />
												</div>
										<?php endif; ?>
									
								</div>
						</div>
				</div>
		</div>
</div>
<!-- First Grid -->