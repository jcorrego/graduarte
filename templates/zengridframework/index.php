<?php
/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @Type        Core Framework Files
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );

if ($this->template == "zengridframework") { ?>
<body style="background:#f9f9f9">
<div style="width:600px;margin:140px auto;height:110px;background:#fffbcc;padding:20px;border:1px solid #ddd;color:#444;line-height:2em;font-size:18px">You are attempting to use the Zen Grid Framework as your default template.<br /> <span style="font-size:15px">Please install and enable a Zen Grid Framework compatible template in order to use the Zen Grid Framework. Please refer to the Zen Grid2 framework documentation for more information.</span></div>
</body>

<?php } 

else {

// Loads the vars file
define( 'YOURBASEPATH', dirname(__FILE__) );
require(YOURBASEPATH .DS."includes/vars.php");

// Include the library itself
include_once (dirname(__FILE__).DS.'includes/yth.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">

<?php if ($removeMootools) {
	$doc->setHeadData($headerstuff);
}

?>
<head>
<jdoc:include type="head" />
<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/favicon.ico" />
 
<!-- Import Style Sheets-->
<?php if ($csscompress) {
$stylesheets = array('template_css,joomla,theme'); 
Yth::addCssPhp($stylesheets, true); }
else { ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link href="templates/zengridframework/css/joomla.css" rel="stylesheet" type="text/css" media="screen" />
<link href="templates/zengridframework/css/template_css.css" rel="stylesheet" type="text/css" media="screen" />
<?php } ?>

<link href="templates/<?php echo $this->template ?>/css/theme.css" rel="stylesheet" type="text/css" media="screen" />
<?php if ($hilite !== '') : ?>
<link href="templates/<?php echo $this->template ?>/css/hilites/<?php echo $hilite ?>.css" rel="stylesheet" type="text/css" media="screen" />
<?php endif; ?>

<?php if ($ie7CSS) { ?>
<!--[if IE 7]>
<link href="templates/<?php echo $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->

<?php } 

if ($ie6CSS) { ?>
<!--[if IE 6]>
<link href="templates/<?php echo $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->

<?php } 

		if ($combinescripts) { 
				if	($combinescripts =="2") { ?>
						<script type="text/JavaScript" src="<?php echo $this->baseurl ?>/templates/zengridframework/js/jquery.zengrid.combined.gzip.php"></script>	
						<?php } 
						else { ?>
						<script type="text/JavaScript" src="<?php echo $this->baseurl ?>/templates/zengridframework/js/jquery.zengrid.combined.js"></script>
				<?php }
		}	
		else { 
			
				if ($superfish == 'yes') { ?>
				<script type="text/JavaScript" src="<?php echo $this->baseurl ?>/templates/zengridframework/js/superfish.js"></script>
				<?php } 
				
				if($this->countModules('panel1') or $this->countModules('panel2') or $this->countModules('panel3') or $this->countModules('panel4')) { ?>
				<script type="text/JavaScript" src="<?php echo $this->baseurl ?>/templates/zengridframework/js/jquery.popup.js"></script>
				<?php } 
				
				if ($panelMenu = 'yes') { ?>
				<!-- Panel Menu-->
				<script type="text/JavaScript" src="<?php echo $this->baseurl ?>/templates/zengridframework/js/accordionMenu.js"></script>
				
				<?php } 
		}
		
		
if	($extraJS) { ?>
<script type="text/JavaScript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/template.js"></script>	
<?php } 

if ($pngfix) { ?>
<!--[if lte IE 6]>
	<script src="<?php echo $this->baseurl ?>/templates/zengridframework/js/DD_belatedPNG0.0.8a-min.js"></script>
<script>
    DD_belatedPNG.fix('<?php  echo $pngfixrules ?>'); 
</script>
<![endif]-->

<?php } ?>


<?php if ($superfish == "yes" or $extraTemplateScript !="") : ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	
			jQuery(".moduletable-superfish ul,#nav ul")
			.superfish({
				animation : {<?php echo $sfType ?>},
				delay : 1000
			});	
						
});
</script>
<?php endif; ?>

<?php 
if ($navLeft) { ?>
<style type="text/css" media="screen">
.moduletable-superfish,#nav ul  {float: left;}
.moduletable-superfish ul,#nav ul  {float: left;margin: 8px 20px 0 0;}
.moduletable-superfish ul li,#nav ul li {margin: 0 20px 0 0}
</style>
<?php }

if ($extraScripts != "") {
	echo $extraScripts;
}

// Checks for the extracss.php file
if ($getExtraCSS) {
	include_once (JPATH_ROOT."/templates/$this->template/css/extracss.php");
}

// Checks if we are using an extracss.php file and if not prints the css overrides here.
if (!($getExtraCSS) || $overwriteCSS) { 
	echo '<style type="text/css" media="screen">';
	echo $jbHeadingcolours;
	echo '</style>';
	};

?>


</head>

<body class="<?php echo $fontStackBody ?> <?php if ($pageclass !='') { echo $pageclass;} ?>" style="font-size: <?php echo $fontSize ?>">
		<div id="fontHeadings" class="<?php echo $fontStackHeading ?>">
 		
<?php
/* 
 *  If open.php was found in the style folder, include it
 */
if ($openFile) : require("$openFile"); 
else : 
?>

<div class="fullWrap">

<?php 
endif; 

/* 
 *  If top.php was found in the style folder, include it
 */
if ($top > "0") {
	if ($topFile) : require("$topFile"); 
	else : ?>
<div class="outerWrapper topRow"> <!-- Top Wrapper -->
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<div id="topWrapper">
								
								
								<?php if($this->countModules('top1')) : ?>
									<div id="top1" style="width:<?php echo $$top1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
												<jdoc:include type="modules" name="top1" style="xhtml" />
									</div>
									<?php endif; ?>
									
									<?php if($this->countModules('top2')) : ?>
									<div id="top2" style="width:<?php echo $$top2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
												<jdoc:include type="modules" name="top2" style="xhtml" />
									</div>
									<?php endif; ?>
									
									<?php if($this->countModules('top3')) : ?>
									<div id="top3" style="width:<?php echo $$top3Cols; ?>px;margin-right: <?php echo $gutter ?>px">
												<jdoc:include type="modules" name="top3" style="xhtml" />
									</div>
									<?php endif; ?>
									
									<?php if($this->countModules('top4')) : ?>
									<div id="top4" style="width:<?php echo $$top4Cols; ?>px">
												<jdoc:include type="modules" name="top4" style="xhtml" />
									</div>
								<?php endif; ?>

									
								</div> 
						</div>
				</div>
		</div>
</div><!-- Top Wrapper -->	
<?php 
	endif;
}

/* 
 *  If header.php was found in the style folder, include it
 */	
if ($logoPosition == "above" or $header > "0") { 
	if ($headerFile) : require("$headerFile");
	else : ?>
<!-- Logo Wrapper -->
<div class="outerWrapper logoRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<?php if ($logoPosition =="above") { ?>
								<div id="logo" style="width:<?php echo $$logoCols; ?>px;margin-right: <?php echo $gutter ?>px">
										<a href="<?php echo $this->baseurl.'/'.$logoLink ?>"><img src="<?php echo $this->baseurl.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
										
										<?php if ($enableTagline) { ?>
								<div id="tagline">
										<span style="margin-left:<?php echo $taglineLeft ?>;margin-top:<?php echo $taglineTop ?>;"><?php echo $tagline ?></span>
								</div>
								
								<?php } ?>
								</div> 
								
								
								<?php 								
								} ?>
								
								<?php if ($logoPosition =="below" or $logoPosition =="none"  or $logoPosition =="left") { ?>
								<div id="header1" style="width:<?php echo $$header1Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="header1" style="xhtml" />
								</div> 								
								<?php } ?>
								
								<?php if($this->countModules('header2')) : ?>
								<div id="header2" style="width:<?php echo $$header2Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="header2" style="xhtml" />
								</div>
								<?php endif; ?>
								
								<?php if($this->countModules('header3')) : ?>
								<div id="header3" style="width:<?php echo $$header3Cols; ?>px;margin-right: <?php echo $gutter ?>px">
										<jdoc:include type="modules" name="header3" style="xhtml" />
								</div>
								<?php endif; ?>
								
								<?php if($this->countModules('header4')) : ?>
								<div id="header4" style="width:<?php echo $$header4Cols; ?>px">
										<jdoc:include type="modules" name="header4" style="xhtml" />
								</div>
								<?php endif; ?>
								
						</div>
				</div>
		</div>
</div>
<!-- Logo Wrapper -->
<?php 
endif;
} 

if($this->countModules('menu') or ($logoPosition =="below")) : 
/* 
 *  If nav.php was found in the style folder, include it
 */	
if ($navFile) : require("$navFile");
else : ?>
<!-- Nav Wrapper -->
<div class="outerWrapper navRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
								<div id="navWrapper">
										<?php if ($logoPosition =="below") { ?>
										<div id="logo" style="width:<?php echo $$logoCols; ?>px">
												<a href="<?php echo $this->baseurl.$logoLink ?>"><img src="<?php echo $this->baseurl.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
												
										<?php if ($enableTagline) { ?>
											<div id="tagline">
												<span style="margin-left:<?php echo $taglineLeft ?>;margin-top:<?php echo $taglineTop ?>;"><?php echo $tagline ?></span>
											</div>
										<?php 
								
											} ?>
										</div> 
																		
										<?php } ?>
										<div id="navWrap" <?php if ($logoPosition =="above" or $logoPosition == "none" or $navLeft) { ?> class="navLeft" <?php } ?>style="width:<?php echo $$navCols; ?>px">
												<div id="nav" class="<?php echo $fontStackNav ?>">
															<jdoc:include type="modules" name="menu" style="xhtml" />
												</div>	
										</div>
								</div>	
						</div>
				</div>
		</div>
</div>
<!-- Nav Wrapper -->
<?php
endif;
	endif;			
/* 
 *  If banner.php was found in the style folder, include it
 */				
if($this->countModules('banner')) { 
	if ($bannerFile) : require("$bannerFile");
	else : ?>
<!-- Banner Wrapper -->
<div class="outerWrapper bannerRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
				<div class="containerBG">
						<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
																
								
								<div id="banner" style="width:100%">
										<jdoc:include type="modules" name="banner" style="xhtml" />
								</div> 								
							
																
						</div>
				</div>
		</div>
</div>
<!-- Banner Wrapper -->
<?php
endif; 
}

/* 
 *  If grid1.php was found in the style folder, include it
 */
if ($grid1 > "0") {
	if ($grid1File) : require("$grid1File"); 
	else : ?>
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
<?php
endif; 
}
/* 
 *  If grid2.php was found in the style folder, include it
 */
if ($grid2 > "0") { 
	if ($grid2File) : require("$grid2File"); 
	else : ?>
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
<?php
endif; 
}

/* 
 *  If grid3.php was found in the style folder, include it
 */
if ($grid3 > "0") {
	if ($grid3File) : require("$grid3File");
	else : ?>
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
<?php
endif; 
}

/* 
 * If there is a frontpage.php file, and its the homepage, use it, otherwise if a main.php exists include it
 */
if (Yth::isHome() && ($frontpageFile)) require("$frontpageFile"); 
else {
	if ($mainFile) : require("$mainFile"); 
	else : ?>
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
									<div id="leftCol" style="margin-right: <?php echo $gutter ?>px">
											<div id="left" style="width:<?php echo $$leftCols; ?>px" class="<?php echo $mainWidth ?>">
											
											<?php if ($logoPosition =="left") { ?>
										<div id="logo" style="width:<?php echo $$logoCols; ?>px">
												<a href="<?php echo $logoLink ?>"><img src="<?php echo $this->baseurl.$logoLocation.'/'.$logoFile; ?>" alt="<?php echo $mainframe->getCfg('sitename');?>" /></a>
												<?php if ($enableTagline) { ?>
											<div id="tagline">
												<span style="margin-left:<?php echo $taglineLeft ?>;margin-top:<?php echo $taglineTop ?>;"><?php echo $tagline ?></span>
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
								
								
								<div class="clear"></div>
								
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
</div>
<?php
endif;
}
?>
		

			
			
<?php 
/* 
 *  If grid4.php was found in the style folder, include it
 */
if ($grid4 > "0") {
	if ($grid4File) : require("$grid4File");
	else : ?>
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
<?php
endif; 
}

/* 
 *  If grid5.php was found in the style folder, include it
 */
if ($grid5 > "0") { 
	if ($grid5File) : require("$grid5File"); 
	else : ?>
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
<?php
endif; 
}

/* 
 *  If grid6.php was found in the style folder, include it
 */
if ($grid6 > "0") {
	if ($grid6File) : require("$grid6File"); 
	else : ?>
	
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

						<div class="clear"></div>
					
				</div>
		</div>
	</div>
</div>
<!-- Sixth Row Grid -->
<?php
endif; 
}

/* 
 *  If bottom.php was found in the style folder, include it
 */
if ($bottom > "0") {
	if ($bottomFile) : require("$bottomFile"); 
	else : ?>
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
</div>
<!-- Bottom Row Grid -->
<?php 
endif; 
}
?>

<?php
/* 
 *  If footer.php was found in the style folder, include it
 */

	if ($footerFile) : require("$footerFile"); 
	else : ?>
<div class="outerWrapper footerRow">
		<div class="container <?php echo $position ?>" style="width:<?php echo $tWidth ?>px;<?php echo $containerOffset?>">
			<div class="containerBG">
				<div class="innerContainer" style="width:<?php echo $contentWidth ?>px;margin-left:<?php echo $gutter ?>px">
					
					
					
					<div id="footer">
					
					
							<div id="footerLeft" style="width:<?php echo $nine; ?>px;margin-right: <?php echo $gutter ?>px">
									<jdoc:include type="modules" name="footer" style="xhtml" />
							</div>
									
							<!-- Copyright -->				
					<div id="footerRight">
							<a href="http://www.joomlabamboo.com"><img class="jbLogo" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/jb.png" alt="Joomla Bamboo" /></a><div style="display:none"><a href="http://www.uniq-themes.ru/">joomla templates</a></div>
					</div>			
				</div>
					
						
	
		</div> <!-- innerContainer -->
	</div>	<!-- containerBG -->					
</div> <!-- Container -->

<?php
endif;

?>
			
<?php
/* 
 *  If panel.php was found in the style folder, include it
 */
if ($panel > "0") {
	if ($panelFile) : require("$panelFile");
	else : ?>
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
<?php
endif; 
}

/* 
 *  If closeContainer.php was found in the style folder, include it
 */
if ($closeFile) : require("$closeFile"); 
else : ?>

<?php
endif;
?>
</div>	<!-- Full Wrap -->	
</div>
<div class="clear"></div>
<jdoc:include type="modules" name="debug" style="xhtml" />
<?php echo $analytics ?>
</body>
</html>
<?php } ?>