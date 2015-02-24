<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid6 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
// This file is called if the grid6 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Sixth Row Grid -->
<div class="outerWrapper grid6Row">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
						
								<div class="gridWrap6">
									
											<?php if($this->countModules('grid21')) : ?>
													<div id="grid21" style="width:<?php echo $$grid21Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid21" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid22')) : ?>
													<div id="grid22" style="width:<?php echo $$grid22Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid22" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid23')) : ?>
													<div id="grid23" style="width:<?php echo $$grid23Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid23" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid24')) : ?>
													<div id="grid24" style="width:<?php echo $$grid24Cols; ?>px">
															<jdoc:include type="modules" name="grid24" style="xhtml" />
													</div>
											<?php endif; ?>
									
								</div>

						</div>
				</div>
		</div>
</div>
<!-- Sixth Row Grid -->

