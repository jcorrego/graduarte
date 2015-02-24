<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
?>

<div class="outerWrapper mainRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG width<?php echo $tWidth ?>">
					<div id="leftShadow">
						<div id="rightShadow">
									<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
										<?php if($this->countModules('panel1')) : ?>
										<!-- The tab on top -->	
										<div id="paneltab" class="tab <?php echo $backgroundContrast ?> width<?php echo $tWidth ?>">
												<div id="paneltabRight" class="tab">
													
													<a id="openPanel" rel="#panelInner" href="#"><?php echo $openPanel ?></a>
													<a id="closePanel" rel="#panelInner" href="#"><?php echo $closePanel ?></a>
													
												</div>
										</div>
										<!-- / top -->
										<?php endif; ?> 
										
									<?php if($this->countModules('panel1')) : ?>
									<div id="memberArea" class="<?php echo $panelColor ?> width<?php echo $tWidth ?>" style="height: <?php echo $panelHeight ?>px;width: <?php echo $panelWidth ?>px">
											<div id="memberAreaInner">
																	
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
												</div>
											
											</div>
								
									<?php endif; ?> 
			
											<div id="mainWrap" class="<?php echo $mainWidth ?>">
										<div id="mainWrapInner<?php echo $tWidth ?><?php echo $leftCols; ?>" class="leftStyle">
											<?php if($this->countModules('breadcrumb')) : ?>
											<!-- Breadcrumb -->
												<div id="breadcrumb" class="<?php echo $backgroundContrast ?>">
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
														<div id="logoInner" style="height:<?php echo $logoDivHeight; ?>px">
															<a href="<?php echo $logoLink ?>"><img src="<?php echo $this->baseurl.''.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
															<?php if ($enableTagline) { ?>
														<div id="tagline">
															<span style="margin-left:<?php echo $taglineLeft ?>;margin-top:<?php echo $taglineTop ?>;"><?php echo $tagline ?></span>
														</div>
													<?php } ?>
														</div>
													</div> 
													
													<?php
												
													} ?>
													
																<jdoc:include type="modules" name="left" style="xhtml" />
														</div>
												</div>
											<!-- End Left Column -->
											<?php endif; ?>
	
											<!-- Main Content -->
												<div id="midCol" style="width:<?php echo $$midCols; ?>px;;<?php echo $midColMargin ?>px" class="<?php echo $mainWidth ?>">
											
											<?php if ($advert1 > "0") : ?>
													<!-- Top Advert Row -->
													
															<?php if($this->countModules('advert1')) : ?>
															<div id="abovecontent1" style="width:<?php echo $$advert1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
																	<jdoc:include type="modules" name="advert1" style="xhtml" />
															</div>
															<?php endif; ?>
															
															<?php if($this->countModules('advert2')) : ?>
															<div id="abovecontent2" style="width:<?php echo $$advert2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
																	<jdoc:include type="modules" name="advert2" style="xhtml" />
															</div>
															<?php endif; ?>
															
															<?php if($this->countModules('advert3')) : ?>
															<div id="abovecontent3" style="width:<?php echo $$advert3Cols; ?>px">
																	<jdoc:include type="modules" name="advert3" style="xhtml" />
															</div>
															<?php endif; ?>
													
													<!-- Top Advert Row -->
													<?php endif; ?>
			
													<div class="clear"></div>
										</div>			
								</div>
								</div>
										
						</div>
				</div>
		</div>
		<div id="bottomShadow" class="width<?php echo $tWidth ?>"></div>
</div>
</div></div>
