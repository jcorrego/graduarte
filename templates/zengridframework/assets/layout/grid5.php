<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid5 layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
 
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<!-- Fifth Row Grid -->
<div class="outerWrapper grid5Row">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
			<div class="containerBG">
				<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">

								
									<div class="gridWrap5">
												
											<?php if($this->countModules('grid17')) : ?>
													<div id="grid17" style="width:<?php echo $$grid17Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid17" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid18')) : ?>
													<div id="grid18" style="width:<?php echo $$grid18Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid18" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid19')) : ?>
													<div id="grid19" style="width:<?php echo $$grid19Cols; ?>px;margin-right: <?php echo $gutter ?>px">
															<jdoc:include type="modules" name="grid19" style="xhtml" />
													</div>
											<?php endif; ?>
											<?php if($this->countModules('grid20')) : ?>
													<div id="grid20" style="width:<?php echo $$grid20Cols; ?>px">
															<jdoc:include type="modules" name="grid20" style="xhtml" />
													</div>
											<?php endif; ?>
									
								</div>

						<div class="clear"></div>
					
				</div>
		</div>
	</div>
</div>
<!-- Fifth Row Grid -->
