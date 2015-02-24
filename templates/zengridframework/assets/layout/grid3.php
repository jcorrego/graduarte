<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid3 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 

// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Third Row Grid -->
<div class="outerWrapper grid3Row">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								
								
								<div class="gridWrap3">
									
										<?php if($this->countModules('grid9')) : ?>
												<div id="grid9" style="width:<?php echo $$grid9Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="grid9" style="xhtml" />
												</div>
										<?php endif; ?>
										<?php if($this->countModules('grid10')) : ?>
												<div id="grid10" style="width:<?php echo $$grid10Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="grid10" style="xhtml" />
												</div>
										<?php endif; ?>
										<?php if($this->countModules('grid11')) : ?>
												<div id="grid11" style="width:<?php echo $$grid11Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="grid11" style="xhtml" />
												</div>
										<?php endif; ?>
										<?php if($this->countModules('grid12')) : ?>
												<div id="grid12" style="width:<?php echo $$grid12Cols; ?>px">
														<jdoc:include type="modules" name="grid12" style="xhtml" />
												</div>
										<?php endif; ?>
									
								</div>
								
						</div>
				</div>
		</div>
</div>
<!-- Third Row Grid -->

