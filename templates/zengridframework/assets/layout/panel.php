<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the panel layout override is enabled and is placed in the templates/[your template name]/layout folder. 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

				<!-- Panel -->
					<div id="toppanel">
					<!-- The tab on top -->	
							<div class="tab">
								<a id="open" rel="#panelInner" href="#"><?php echo $openPanel ?></a>
							</div> <!-- / top -->
						<div id="panelInner"  style="width:<?php echo $contentWidth ?>px;height: <?php echo $panelHeight ?>px" class="overlay">
							<div id="panel">
								<?php if($this->countModules('panel1')) : ?>
									<div id="panel1" style="width:<?php echo $$panel1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="panel1" style="xhtml"/>
									</div>
								<?php endif; ?> 
								<?php if($this->countModules('panel2')) : ?>
									<div id="panel2" style="width:<?php echo $$panel2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="panel2" style="xhtml"/>
									</div>
								<?php endif; ?> 
								<?php if($this->countModules('panel3')) : ?>
									<div id="panel3" style="width:<?php echo $$panel3Cols; ?>px">
										<jdoc:include type="modules" name="panel3" style="xhtml"/>
									</div>
								<?php endif; ?> 
								<?php if($this->countModules('panel4')) : ?>
									<div id="panel4" style="width:<?php echo $$panel4Cols; ?>px">
										<jdoc:include type="modules" name="panel4" style="xhtml"/>
									</div>
								<?php endif; ?> 
							</div> <!-- /login -->	
							
							<div class="close"></div>
						</div>
						<div id="backgroundPopup"></div>
					</div> <!--panel -->