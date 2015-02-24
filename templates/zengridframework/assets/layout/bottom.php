<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the bottom layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Bottom Row Grid -->
<div class="outerWrapper bottomRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
			<div class="containerBG">
				<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">						
								<div class="bottomWrap">
									<div id="bottom">
											<?php if($this->countModules('bottom1')) : ?>
													<div id="bottom1" style="width:<?php echo $$bottom1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="bottom1" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('bottom2')) : ?>
													<div id="bottom2" style="width:<?php echo $$bottom2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="bottom2" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('bottom3')) : ?>
													<div id="bottom3" style="width:<?php echo $$bottom3Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="bottom3" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('bottom4')) : ?>
													<div id="bottom4" style="width:<?php echo $$bottom4Cols; ?>px">
															<jdoc:include type="modules" name="bottom4" style="xhtml" />
													</div>
											<?php endif; ?>
									</div>
								</div>

				</div>
		</div>
</div>
<!-- Bottom Row Grid -->
