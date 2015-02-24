<?php 
defined('_JEXEC') or die();

/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @Type        Core Framework Files
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

$doc = JFactory::getDocument();

// Style Variables
$fontStackBody = $this->params->get("fontStackBody", "cambria");
$fontStackHeading = $this->params->get("fontStackHeading", "palatino");
$fontStackNav = $this->params->get("fontStackNav", "helvetica");
$fontSize = $this->params->get("fontSize", "82%");
$style = $this->params->get("style", "default");
$customStyle = $this->params->get("customStyle", "custom");
$pngfix = $this->params->get("pngfix", "1");
$pngfixrules = $this->params->get("pngfixrules", ".pathway img,#logo a img");
$extraScripts = $this->params->get("extraScripts", "");

$paneltype = $this->params->get("paneltype", "width");
$doc->addScriptDeclaration("var paneltype = '".$paneltype."';");
// Analytics
$analytics = $this->params->get("analytics","");
$csscompress = $this->params->get("csscompress","0");
$removeMootools = $this->params->get("removeMootools","0");
$combinescripts = $this->params->get("combinescripts","1");
$removeJgen = $this->params->get("removeJgen","1");
$hilite = $this->params->get("hilite","");
$colours = $this->params->get("colours","1");

// Logo Variables
$logoLocation = $this->params->get("logoLocation", "templates/".$this->template."/images/logo");
$logoFile = $this->params->get("logoFile", "logo.png");
$logoLink = $this->params->get("logoLink", "index.php");
$logoPosition = $this->params->get("logoPosition", "below");
$enableTagline = $this->params->get("enableTagline", "1");
$tagline = $this->params->get("tagline", "");
$taglineTop = $this->params->get("taglineTop", "0");
$taglineLeft = $this->params->get("taglineLeft", "0");

// CSS and Heading Colours
$overwriteCSS = $this->params->get("overwriteCSS", "");
$openb = '{';
$closeb = '}';
$bodyColour = $this->params->get("bodyColour", "");
$h1Colour = $this->params->get("h1Colour", "");
$h2Colour = $this->params->get("h2Colour", "");
$h3Colour = $this->params->get("h3Colour", "");
$h4Colour = $this->params->get("h4Colour", "");
$h5Colour = $this->params->get("h5Colour", "");
$h6Colour = $this->params->get("h6Colour", "");
$aColour = $this->params->get("aColour", "");
$ahoverColour = $this->params->get("ahoverColour", "");
$taglineCSS = $this->params->get("taglineCSS", "");
$extraCSS = $this->params->get("extraCSS", "");
$bodyColour = $this->params->get("bodyColour", "#f9f9f9");

// Layout Variables
$tWidth = $this->params->get("tWidth","960");
$gutter = $this->params->get("gutter","40");
$containerGutter = $this->params->get("containerGutter","0");
$halfgutter = $gutter/2;
$cols = $this->params->get("cols","12");
$position = $this->params->get("position","left");
$containerMargin = $this->params->get("containerMargin","280px");

$allEqual = $this->params->get("allEqual","1");
$headerEqual = $this->params->get("headerEqual","1");
$topEqual = $this->params->get("topEqual","1");
$grid1Equal = $this->params->get("grid1Equal","1");
$grid2Equal = $this->params->get("grid2Equal","1");
$grid3Equal = $this->params->get("grid3Equal","1");
$grid4Equal = $this->params->get("grid4Equal","1");
$grid5Equal = $this->params->get("grid5Equal","1");
$grid6Equal = $this->params->get("grid6Equal","1");
$bottomEqual = $this->params->get("bottomEqual","1");
$panelEqual = $this->params->get("panelEqual","1");

// Menu Variables
$panelMenu = $this->params->get("panelMenu", 0); 
$superfish = $this->params->get("superfish", 1);
$sfEffect = $this->params->get("sfEffect", "5");


// Panel Variables
$panelWidth = $this->params->get("panelWidth", "800");
$panelHeight = $this->params->get("panelHeight", "600");
$openPanel = $this->params->get("openPanel", "Open Panel");
$closePanel = $this->params->get("closePanel", "Close Panel");
$panel1Cols = $this->params->get("panel1Width", "four");
$panel2Cols = $this->params->get("panel2Width", "four");
$panel3Cols = $this->params->get("panel3Width", "two");
$panel4Cols = $this->params->get("panel4Width", "four");

// Variables for the top, grid, advert and bottom modules
$header1Cols = $this->params->get("header1Width", "three");
$header2Cols = $this->params->get("header2Width", "three");
$header3Cols = $this->params->get("header3Width", "three");
$header4Cols = $this->params->get("header4Width", "three");
$top1Cols = $this->params->get("top1Width", "three");
$top2Cols = $this->params->get("top2Width", "three");
$top3Cols = $this->params->get("top3Width", "three");
$top4Cols = $this->params->get("top4Width", "three");
$grid1Cols = $this->params->get("grid1Width", "three");
$grid2Cols = $this->params->get("grid2Width", "three");
$grid3Cols = $this->params->get("grid3Width", "three");
$grid4Cols = $this->params->get("grid4Width", "three");
$grid5Cols = $this->params->get("grid5Width", "four");
$grid6Cols = $this->params->get("grid6Width", "four");
$grid7Cols = $this->params->get("grid7Width", "four");
$grid8Cols = $this->params->get("grid8Width", "four");
$grid9Cols = $this->params->get("grid9Width", "six");
$grid10Cols = $this->params->get("grid10Width", "six");
$grid11Cols = $this->params->get("grid11Width", "six");
$grid12Cols = $this->params->get("grid12Width", "six");
$grid13Cols = $this->params->get("grid13Width", "six");
$grid14Cols = $this->params->get("grid14Width", "six");
$grid15Cols = $this->params->get("grid15Width", "three");
$grid16Cols = $this->params->get("grid16Width", "six");
$grid17Cols = $this->params->get("grid17Width", "four");
$grid18Cols = $this->params->get("grid18Width", "four");
$grid19Cols = $this->params->get("grid19Width", "four");
$grid20Cols = $this->params->get("grid20Width", "four");
$grid21Cols = $this->params->get("grid21Width", "three");
$grid22Cols = $this->params->get("grid22Width", "three");
$grid23Cols = $this->params->get("grid23Width", "three");
$grid24Cols = $this->params->get("grid24Width", "three");
$advert1Cols = $this->params->get("advert1Width", "two");
$advert2Cols = $this->params->get("advert2Width", "two");
$advert3Cols = $this->params->get("advert3Width", "two");
$advert4Cols = $this->params->get("advert4Width", "two");
$advert5Cols = $this->params->get("advert5Width", "two");
$advert6Cols = $this->params->get("advert6Width", "two");
$bottom1Cols = $this->params->get("bottom1Width", "four");
$bottom2Cols = $this->params->get("bottom2Width", "four");
$bottom3Cols = $this->params->get("bottom3Width", "four");
$bottom4Cols = $this->params->get("bottom4Width", "four");

// Variables for Main Width with left module only
$leftCols2L = $this->params->get("leftCols2L", "six");
$midCols2L = $this->params->get("midCols2L", "six");

// Variables for the mainwidth with right column only
$rightCols2R = $this->params->get("rightCols2R", "three");
$midCols2R = $this->params->get("midCols2R", "nine");

// Variables for the main width with left and right
$leftCols3LR = $this->params->get("leftCols3LR", "three");
$midCols3LR = $this->params->get("midCols3LR", "six");
$rightCols3LR = $this->params->get("rightCols3LR", "three");

// Variables for the main width with left and right and center
$leftCols4LRC = $this->params->get("leftCols4LRC", "three");
$midCols4LRC = $this->params->get("midCols4LRC", "six");
$rightCols4LRC = $this->params->get("rightCols4LRC", "three");
$centerCols4LRC = $this->params->get("centerCols4LRC", "three");

// Variables for the main width with left and right and center
$leftCols3LC = $this->params->get("leftCols3LC", "three");
$midCols3LC = $this->params->get("midCols3LC", "six");
$centerCols3LC = $this->params->get("centerCols3LC", "three");

// Variables for the main width with left and right and center
$rightCols3RC = $this->params->get("rightCols3RC", "three");
$midCols3RC = $this->params->get("midCols3RC", "six");
$centerCols3RC = $this->params->get("centerCols3RC", "three");

// Width for the logo and navigation
$mainLayout = $this->params->get("mainLayout", 2);
$logoCols = $this->params->get("logoWidth", "four");
$navCols = $this->params->get("navWidth", "twelve");
$navLeft = $this->params->get("navLeft", "1");


// Logic for the superfish
if ($sfEffect == "1") {
$sfType = 'height:"show"';
}
else if ($sfEffect == "2") {
$sfType = 'width:"show"';
}
else if ($sfEffect == "3") {
$sfType = 'opacity:"show"';
}
else if ($sfEffect == "4") {
$sfType = 'width:"show", opacity:"show"';
}
else if ($sfEffect == "5") {
$sfType = 'height:"show", opacity:"show"';
}
else if ($sfEffect == "6") {
$sfType = 'height:"show", width:"show", opacity:"show" ';
}
else if ($sfEffect == "7") {
$sfType = 'height:"show", width:"show"';
}

// Logic for selecting a custom style sheet
if ($style =="custom") {
	$style = $customStyle;
}

// logic for grid widths
$contentWidth = $tWidth-($gutter*2);
$gutters = $cols - 1;
$margins = $gutter * $gutters;
$colWidths = ($contentWidth-$margins)/$cols;


// widths of each grid div
$two = (2*$colWidths) + (1*$gutter);
$three = (3*$colWidths) + (2*$gutter);
$four = (4*$colWidths) + (3*$gutter);
$five = (5*$colWidths) + (4*$gutter);
$six = (6*$colWidths) + (5*$gutter);
$seven = (7*$colWidths) + (6*$gutter);
$eight = (8*$colWidths) + (7*$gutter);
$nine = (9*$colWidths) + (8*$gutter);
$ten = (10*$colWidths) + (9*$gutter);
$eleven = (11*$colWidths) + (10*$gutter);
$twelve = (12*$colWidths) + (11*$gutter);
$thirteen = (13*$colWidths) + (12*$gutter);
$fourteen = (14*$colWidths) + (13*$gutter);
$sixteen = (16*$colWidths) + (15*$gutter);


		
// Code to test whether or not to print the rows
if ($logoPosition=="above") {
$header = ($this->countModules('header2')?1:0)+ ($this->countModules('header3')?1:0)+ ($this->countModules('header4')); 
}
elseif ($logoPosition=="below" or $logoPosition=="left" or $logoPosition=="none") {
$header = ($this->countModules('header1')?1:0) + ($this->countModules('header2')?1:0)+ ($this->countModules('header3')?1:0)+ ($this->countModules('header4')); 
}

$grid1 = ($this->countModules('grid1')?1:0)+ ($this->countModules('grid2')?1:0)+ ($this->countModules('grid3')?1:0)+ ($this->countModules('grid4')?1:0); 
$grid2 = ($this->countModules('grid5')?1:0)+ ($this->countModules('grid6')?1:0)+ ($this->countModules('grid7')?1:0)+ ($this->countModules('grid8')?1:0); 
$grid3 = ($this->countModules('grid9')?1:0)+ ($this->countModules('grid10')?1:0)+ ($this->countModules('grid11')?1:0)+ ($this->countModules('grid12')?1:0); 
$grid4 = ($this->countModules('grid13')?1:0)+ ($this->countModules('grid14')?1:0)+ ($this->countModules('grid15')?1:0)+ ($this->countModules('grid16')?1:0); 
$grid5 = ($this->countModules('grid17')?1:0) + ($this->countModules('grid18')?1:0) + ($this->countModules('grid19')?1:0) + ($this->countModules('grid20')?1:0); 
$grid6 = ($this->countModules('grid21')?1:0)+ ($this->countModules('grid22')?1:0)+ ($this->countModules('grid23')?1:0)+ ($this->countModules('grid24')?1:0);
$top = ($this->countModules('top1')?1:0)+ ($this->countModules('top2')?1:0)+ ($this->countModules('top3')?1:0)+ ($this->countModules('top4')?1:0);
$bottom = ($this->countModules('bottom1')?1:0)+ ($this->countModules('bottom2')?1:0)+ ($this->countModules('bottom3')?1:0)+ ($this->countModules('bottom4')?1:0);
$slides = ($this->countModules('slide1')?1:0)+ ($this->countModules('slide2')?1:0)+ ($this->countModules('slide3')?1:0)+ ($this->countModules('slide4')?1:0); 
$advert1 = ($this->countModules('advert1')?1:0)+ ($this->countModules('advert2')?1:0)+ ($this->countModules('advert3')?1:0); 
$advert2 = ($this->countModules('advert4')?1:0)+ ($this->countModules('advert5')?1:0)+ ($this->countModules('advert6')?1:0); 
$panel = ($this->countModules('panel1')?1:0)+ ($this->countModules('panel2')?1:0)+ ($this->countModules('panel3')?1:0)+ ($this->countModules('panel4')?1:0);
$footer = ($this->countModules('footer')?1:0); 



// Controls the file overrides and tests whether to use the override file or not

// Set to false unless found and enabled
$openFile = false;
$topFile = false;
$headerFile = false;
$navFile = false;
$bannerFile = false;
$grid1File = false;
$grid2File = false;
$grid3File = false;
$frontpageFile = false;
$mainFile = false;
$grid4File = false;
$grid5File = false;
$grid6File = false;
$bottomFile = false;
$panelFile = false;
$footerFile = false;
$closeFile = false;

// Check for the openContainer file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/openContainer.php") && $this->params->get('openContainer')) 
{ 
	$openFile = "templates/$this->template/layout/openContainer.php"; 
}

// Check for the top file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/top.php") && $this->params->get('top')) 
{ 
	$topFile = "templates/$this->template/layout/top.php"; 
}

// Check for the header file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/header.php") && $this->params->get('header')) 
{ 
	$headerFile = "templates/$this->template/layout/header.php";
}

// Check for the nav file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/nav.php") && $this->params->get('nav')) 
{ 
	$navFile = "templates/$this->template/layout/nav.php";
}

// Check for the banner file	
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/banner.php") && $this->params->get('banner'))
{ 
	$bannerFile = "templates/$this->template/layout/banner.php"; 
}

// Check for the grid1 file	
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/grid1.php") && $this->params->get('grid1')) 
{ 
	$grid1File = "templates/$this->template/layout/grid1.php"; 
}

// Check for the grid2 file	
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/grid2.php") && $this->params->get('grid2')) 
{ 
	$grid2File = "templates/$this->template/layout/grid2.php"; 
}

// Check for the grid3 file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/grid3.php") && $this->params->get('grid3')) 
{ 
	$grid3File = "templates/$this->template/layout/grid3.php"; 
}

// Check for the frontpage file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/frontpage.php") && $this->params->get('frontpage'))
{ 
	$frontpageFile = "templates/$this->template/layout/frontpage.php";
}
	
// Check for main file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/main.php") && $this->params->get('main')) 
{ 
	$mainFile = "templates/$this->template/layout/main.php"; 
}
				
// Check for grid4 file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/grid4.php") && $this->params->get('grid4')) 
{ 
	$grid4File = "templates/$this->template/layout/grid4.php"; 
}

// Check for grid5 file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/grid5.php") && $this->params->get('grid5')) 
{ 
	$grid5File = "templates/$this->template/layout/grid5.php"; 
}

// Check for grid6 file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/grid6.php") && $this->params->get('grid6')) 
{ 
	$grid6File = "templates/$this->template/layout/grid6.php"; 
}

// Check for bottom file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/bottom.php") && $this->params->get('bottom')) 
{ 
	$bottomFile = "templates/$this->template/layout/bottom.php"; 
}

// Check for panel file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/panel.php") && $this->params->get('panel')) 
{ 
	$panelFile = "templates/$this->template/layout/panel.php"; 
}
	
// Check for footer file	
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/footer.php") && $this->params->get('footer')) 
{ 
	$footerFile = "templates/$this->template/layout/footer.php"; 
}

// Check for close file
if(file_exists( JPATH_ROOT."/templates/$this->template/layout/closeContainer.php") && $this->params->get('closeContainer'))
{ 
	$closeFile = "templates/$this->template/layout/closeContainer.php";
}


$ie7CSS = "";
$ie6CSS = "";
$extraJS = "";
// Check for ie7 css override
if(file_exists( JPATH_ROOT."/templates/$this->template/css/ie7.css")) 
{ 
	$ie7CSS = "1"; 
}


// Check for ie6 css override
if(file_exists( JPATH_ROOT."/templates/$this->template/css/ie6.css")) 
{ 
	$ie6CSS = "1"; 
}

// Check for extra template js
if(file_exists( JPATH_ROOT."/templates/$this->template/js/template.js")) 
{ 
	$extraJS = "1"; 
}
	
	

// Determines equal columns calculations
$numbers=array("zero","one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve","thirteen","fourteen","sixteen","sixteen");

if($header!=0 && $headerEqual && $logoPosition=="below" || $allEqual && $header!=0 && $headerEqual && $logoPosition=="below"  || $header!=0 && $headerEqual && $logoPosition=="left" || $allEqual && $header!=0 && $logoPosition=="left") {
$headerModules = $cols/$header;
$header1Cols = $header2Cols = $header3Cols = $header4Cols = $numbers[$headerModules];
} 

if($header!=0 && $headerEqual && $logoPosition=="above" || $allEqual && $header!=0 && $logoPosition=="above"){
$headerModules = $cols/($header+1);
$logoCols = $header2Cols = $header3Cols = $header4Cols = $numbers[$headerModules];
} 

if($top!=0 && $topEqual || $top!=0 && $allEqual) {				
$topModules = $cols/$top;
$top1Cols = $top2Cols = $top3Cols = $top4Cols = $numbers[$topModules];
}

if($bottom!=0 && $bottomEqual || $bottom!=0 && $allEqual) {
$bottomModules = $cols/$bottom;
$bottom1Cols = $bottom2Cols = $bottom3Cols = $bottom4Cols = $numbers[$bottomModules];
}

if($grid1!=0 && $grid1Equal || $grid1!=0 && $allEqual) {
	$grid1Modules = $cols/$grid1;
	$grid1Cols = $grid2Cols = $grid3Cols = $grid4Cols = $numbers[$grid1Modules];
}

if($grid2!=0 && $grid2Equal || $grid2!=0 && $allEqual) {
	$grid2Modules = $cols/$grid2;
	$grid5Cols = $grid6Cols = $grid7Cols = $grid8Cols = $numbers[$grid2Modules];
}


if($grid3!=0 && $grid3Equal || $grid3!=0 && $allEqual) {
	$grid3Modules = $cols/$grid3;
	$grid9Cols = $grid10Cols = $grid11Cols = $grid12Cols = $numbers[$grid3Modules];
}

if($grid4!=0 && $grid4Equal || $grid4!=0 && $allEqual) {
	$grid4Modules = $cols/$grid4;
	$grid13Cols = $grid14Cols = $grid15Cols = $grid16Cols = $numbers[$grid4Modules];
}

if($grid5!=0 && $grid5Equal || $grid5!=0 && $allEqual) {
	$grid5Modules = $cols/$grid5;
	$grid17Cols = $grid18Cols = $grid19Cols = $grid20Cols = $numbers[$grid5Modules];
}

if($grid6!=0 && $grid6Equal || $grid6!=0 && $allEqual) {
	$grid6Modules = $cols/$grid6;
	$grid21Cols = $grid22Cols = $grid23Cols = $grid24Cols = $numbers[$grid6Modules];
}

if($panel!=0 && $panelEqual || $panel!=0 && $allEqual) {
	$panelModules = $cols/$panel;
	$panel1Cols = $panel2Cols = $panel3Cols = $panel4Cols = $numbers[$panelModules];
}


// Main Width Logic
if (($this->countModules( 'left' )) && ($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'threeLR';} 
elseif (($this->countModules( 'left' )) && !($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'twoL';}
elseif (!($this->countModules( 'left' )) && ($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'twoR';}
elseif (!($this->countModules( 'left' )) && !($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'one';}
elseif (!($this->countModules( 'left' )) && !($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'one';}
elseif (($this->countModules( 'left' )) && ($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'fourLRC';}
elseif (($this->countModules( 'left' )) && !($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'threeLC';}
elseif (!($this->countModules( 'left' )) && ($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'threeRC';}


if ($mainWidth == "one") {
	$midCols = "twelve";
	$midColFloat = "float:left";
	$midColMargin ="margin-right: 0";
}

if ($mainWidth == "twoR") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: 0";
	$midCols = $midCols2R;
	$rightCols = $rightCols2R;
}
if ($mainWidth == "twoL") {
	$midColFloat = "float:right";
	$midColMargin ="margin-right: 0";
	$midCols = $midCols2L;
	$leftCols = $leftCols2L;
}
if ($mainWidth == "threeLR") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: $gutter";
	$midCols = $midCols3LR;
	$leftCols = $leftCols3LR;
	$rightCols = $rightCols3LR;
}	

if ($mainWidth == "fourLRC") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: $gutter";
	$midCols = $midCols4LRC;
	$leftCols = $leftCols4LRC;
	$rightCols = $rightCols4LRC;
	$centerCols = $centerCols4LRC;
}	

if ($mainWidth == "threeLC") {
	$midColFloat = "float:right";
	$midColMargin ="margin-right: 0";
	$midCols = $midCols3LC;
	$leftCols = $leftCols3LC;
	$centerCols = $centerCols3LC;
}

if ($mainWidth == "threeRC") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: $gutter";
	$midCols = $midCols3RC;
	$rightCols = $rightCols3RC;
	$centerCols = $centerCols3RC;
}


// Logic for the alignment of the site
if ($position =="left") {$containerOffset = "margin: 0 0 0 $containerMargin";}
if ($position =="right") {$containerOffset = "margin: 0 $containerMargin 0 0";}
if ($position =="center") {$containerOffset = "";}



// Custom CSS that gets loaded into the template head as inline css
$jbHeadingcolours = "body $openb$bodyColour$closeb h1$openb$h1Colour$closeb h2$openb$h2Colour$closeb h3,.moduletable h3$openb$h3Colour$closeb a$openb$aColour$closeb a$openb$aColour$closeb a:hover$openb$ahoverColour$closeb #tagline span$openb$taglineCSS$closeb$extraCSS";

// Removes Mootools
// Kinesphère "Mootools Control" Plugin for Joomla! 1.5.x - Version 0.1
// License: http://www.gnu.org/copyleft/gpl.html
// Copyright (c) 2009 Kinesphère
// More info at http://www.kinesphere.fr

if ($removeMootools == '1') {
	$doc =& JFactory::getDocument();
	$headerstuff = $doc->getHeadData();

	foreach ($headerstuff['scripts'] as $file => $type) {
		if (preg_match("#mootools.js#s", $file)) unset($headerstuff['scripts'][$file]);
		if (preg_match("#caption.js#s",  $file)) unset($headerstuff['scripts'][$file]);
	}				
}

// Removes the Joomla Metagenerator Tag
if ($removeJgen == '1') {
	$this->setGenerator('');
}
	
	
// Page Class Suffix 
$menus      = &JSite::getMenu();
   $menu      = $menus->getActive();
   $pageclass   = "";
   
   if (is_object( $menu )) : 
   $params = new JParameter( $menu->params );
   $pageclass = $params->get( 'pageclass_sfx' );
   endif;
   
   
   if(file_exists( JPATH_ROOT."/templates/$this->template/includes/templateVariables.php")) 
{ 
	include_once (JPATH_ROOT."/templates/$this->template/includes/templateVariables.php");
}
   if(file_exists( JPATH_ROOT."/templates/$this->template/css/extracss.php")) 
{ 
	$getExtraCSS = "1";
} else {
	$getExtraCSS = "0";
}

// Tests for iPhone
$iphone = "";
$iphoneTemplate = "";
$browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
   if(file_exists( JPATH_ROOT."/templates/$this->template/layout/iphone.php"))
{ 
	$iphoneTemplate = "1";
}

if ($browser == false && $iphoneTemplate) { 
	$iphone == 1;
}

?>
