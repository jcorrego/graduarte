<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * The Zen Grid Framework is a templating framework that uses the Joomla Content Manament System (http://www.joomla.org)
 * This file is called if the grid1 layout override is enabled and is placed in the templates/[your template name]/layout folder and if the active menu state is the default menu item. 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<div class="outerWrapper mainRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
										

								<div id="mainWrap" class="<?php echo $mainWidth ?>">
							
								<?php if($this->countModules('breadcrumb')) : ?>
								<!-- Breadcrumb -->
									<div id="breadcrumb">
											<jdoc:include type="modules" name="breadcrumb" style="xhtml" />
									</div>
									<div class="clear"></div>
								<!-- End Breadcrumb -->
								<?php endif; ?>
								
								<?php if($this->countModules('above')) : ?>
								<!--  above -->
									
											<div id="above" class="<?php echo $mainWidth ?>">
													<jdoc:include type="modules" name="above" style="xhtml" />
											</div>									
								
								<!-- End  above -->
								<div class="clear"></div>
								
								<?php endif; ?>
								
								<?php if($this->countModules('left')) : ?>
								<!-- Left Column -->
									<div id="leftCol">
											<div id="left" style="width:<?php echo $$leftCols; ?>px;margin-right: <?php echo $gutter ?>px" class="<?php echo $mainWidth ?>">
											
											<?php if ($logoPosition =="left") { ?>
										<div id="logo" style="width:<?php echo $$logoCols; ?>px">
												<a href="<?php echo $logoLink ?>"><img src="<?php echo $this->baseurl.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
												<?php if ($enableTagline) { ?>
											<div id="tagline">
												<?php echo $tagline ?>
											</div>
										<?php } ?>
										</div> 
										
										<?php
									
										} ?>
										
													<jdoc:include type="modules" name="left" style="xhtml" />
											</div>
									</div>
								<!-- End Left Column -->
								<?php endif; ?>
								
								<?php if ($mainLayout =="1") {
								 if($this->countModules('center')) : ?>
								<!-- Center Column -->
									<div id="centerCol">
											<div id="center" style="width:<?php echo $$centerCols; ?>px;margin-right: <?php echo $gutter ?>px" class="<?php echo $mainWidth ?>">
													<jdoc:include type="modules" name="center" style="xhtml" />
											</div>
									</div>
								<!-- End Center Column -->
								<?php endif; 
								} ?>

								<!-- Main Content -->
									<div id="midCol" style="width:<?php echo $$midCols; ?>px;<?php echo $midColFloat ?>;<?php echo $midColMargin ?>px" class="<?php echo $mainWidth ?>">
								
								<?php if ($advert1 > "0") : ?>
										<!-- Top Advert Row -->
										<div id="topAdvert">
												<?php if($this->countModules('advert1')) : ?>
												<div id="advert1" style="width:<?php echo $$advert1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="advert1" style="xhtml" />
												</div>
												<?php endif; ?>
												
												<?php if($this->countModules('advert2')) : ?>
												<div id="advert2" style="width:<?php echo $$advert2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="advert2" style="xhtml" />
												</div>
												<?php endif; ?>
												
												<?php if($this->countModules('advert3')) : ?>
												<div id="advert3" style="width:<?php echo $$advert3Cols; ?>px">
														<jdoc:include type="modules" name="advert3" style="xhtml" />
												</div>
												<?php endif; ?>
										</div>
										<!-- Top Advert Row -->
										<?php endif; ?>

										<div class="clear"></div>
										

										<div id="mainContent"  class="<?php echo $mainWidth ?>">
												<jdoc:include type="message" />
												<jdoc:include type="component" />
										</div>
										

										<div class="clear"></div>
										
										<?php if ($advert2 > "0") : ?>
										<!-- Bottom Advert Row -->
												<div id="bottomAdvert">
												<?php if($this->countModules('advert4')) : ?>
												<div id="advert4" style="width:<?php echo $$advert4Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="advert4" style="xhtml" />
												</div>
												<?php endif; ?>
												
												<?php if($this->countModules('advert5')) : ?>
												<div id="advert5" style="width:<?php echo $$advert5Cols; ?>px;margin-right: <?php echo $gutter ?>px">
														<jdoc:include type="modules" name="advert5" style="xhtml" />
												</div>
												<?php endif; ?>
												
												<?php if($this->countModules('advert6')) : ?>
												<div id="advert6" style="width:<?php echo $$advert6Cols; ?>px">
														<jdoc:include type="modules" name="advert6" style="xhtml" />
												</div>
												<?php endif; ?>
										</div>
										<?php endif; ?>
								</div>
								<!-- End Main Content -->
								
								
								<?php if ($mainLayout =="2") {
								if($this->countModules('center')) : ?>
								<!-- Center Column -->
									<div id="centerCol">
											<div id="center" style="width:<?php echo $$centerCols; ?>px;margin-right: <?php echo $gutter ?>px" class="<?php echo $mainWidth ?>">
													<jdoc:include type="modules" name="center" style="xhtml" />
											</div>
									</div>
								<!-- End Center Column -->
								<?php endif; 
								} ?>
								
								<?php if($this->countModules('right')) : ?>
								<!-- Right Column -->
									<div id="rightCol">
									
											<div id="right" style="width:<?php echo $$rightCols; ?>px"  class="<?php echo $mainWidth ?>">
													<jdoc:include type="modules" name="right" style="xhtml" />
											</div>
									</div>
								<!-- End Right Column -->
								<?php endif; ?>
								</div>
								
								<div class="clear"></div>
								
								<?php if($this->countModules('below')) : ?>
								<!-- Below -->
									
											<div id="below"  class="<?php echo $mainWidth ?>">
													<jdoc:include type="modules" name="below" style="xhtml" />
											</div>									
								
								<!-- End Below -->
								<div class="clear"></div>
								
								<?php endif; ?>
						</div>
				</div>
		</div>
</div>
