<?php
$doc = JFactory::getDocument();
$logopath ="templates/$this->template/images/logo";
$panelType = $this->params->get("panelType", "opacity");
$panelColor = $this->params->get("panelColor", "light");
$doc->addScriptDeclaration("var paneltype = '".$panelType."';");
$leftBG = $this->params->get("leftBG", "stone.png");
$OpenImage = $this->params->get("panelOpenImage", "panelTabBrown");
$CloseImage = $this->params->get("panelCloseImage", "panelTabGreenClose");
$displayPanelText = $this->params->get("displayPanelText", "0");
$backgroundImage = $this->params->get("backgroundImage", "");
$backgroundRepeat = $this->params->get("backgroundRepeat", "");
$backgroundOptions = $this->params->get("backgroundOptions", "1");
$backgroundPosition = $this->params->get("backgroundPosition", "left top");
$backgroundColor = $this->params->get("backgroundColor", "#fff");
$topNavImage = $this->params->get("topNavImage", "");
$leftBackgroundImage = $this->params->get("leftBackgroundImage", "");
$leftLinkColor = $this->params->get("leftLinkColor", "");
$linkHoverColor = $this->params->get("linkHoverColor", "");
$linkColor = $this->params->get("linkColor", "");
$activeMenuBackground = $this->params->get("activeMenuBackground", "");
$activeMenuColor = $this->params->get("activeMenuColor", "");
$menuHoverColor = $this->params->get("menuHoverColor", "");
$bottomBackgroundImage = $this->params->get("bottomBackgroundImage", "");
$custombackgroundContrast = $this->params->get("custombackgroundContrast", "override");
$preset = $this->params->get("preset", "white");
$logoDivHeight = $this->params->get("logoDivHeight", "200");


if (!($backgroundOptions)) {
if ( $hilite =="Light" or $hilite=="Graph1" or $hilite=="Graph2" or $hilite=="Graph3" or $hilite=="White_Squares_Light" or $hilite=="White_Squares" or $hilite=="Blue_Scratches" or $hilite=="Board_Scratches" or $hilite=="Brown_Scratches" or $hilite=="Dark_Scratches" or $hilite=="Graph_simple" or $hilite=="Graph_simple2" or $hilite=="Graph1" or $hilite=="Graph2" or $hilite=="Graph3" or $hilite=="Light_Scratches") {
	$backgroundContrast ="light";
}

if ($hilite =="Dark" or $hilite =="Original_Grid_Icon_Texture" or $hilite =="Original_Grid_Wall" or $hilite =="Original_Grid_Wall_purple" or $hilite =="Original_Wall_Texture" or $hilite =="Original_Grid_Dark_Wall" or $hilite =="Blue_Squares" or $hilite =="Black_Squares") {
	$backgroundContrast ="dark";
}
}

if ($backgroundOptions) {
	$hilite ="";
if ($custombackgroundContrast =="light") {
	$backgroundContrast ="light";
}

if ($custombackgroundContrast =="dark") {
	$backgroundContrast ="dark";
}

}


if (($this->countModules( 'left' )) && ($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'twoL';} 
elseif (($this->countModules( 'left' )) && !($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'twoL';}
elseif (!($this->countModules( 'left' )) && ($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'one';}
elseif (!($this->countModules( 'left' )) && !($this->countModules( 'right' )) && !($this->countModules( 'center' ))) { $mainWidth = 'one';}
elseif (!($this->countModules( 'left' )) && !($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'one';}
elseif (($this->countModules( 'left' )) && ($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'twoL';}
elseif (($this->countModules( 'left' )) && !($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'twoL';}
elseif (!($this->countModules( 'left' )) && ($this->countModules( 'right' )) && ($this->countModules( 'center' ))) { $mainWidth = 'one';}


if ($mainWidth == "one") {
	$midCols = "twelve";
	$midColFloat = "float:left";
	$midColMargin ="margin-right: 0";
}

if ($mainWidth == "twoR") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: 0";
	$midCols = $midCols2L;
	$rightCols = "";
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
	$midCols = $midCols2L;
	$leftCols = $leftCols2L;
	$rightCols = "";
}	

if ($mainWidth == "fourLRC") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: $gutter";
	$midCols = $midCols2L;
	$leftCols = $leftCols2L;
	$rightCols = "";
	$centerCols = "";
}	

if ($mainWidth == "threeLC") {
	$midColFloat = "float:right";
	$midColMargin ="margin-right: 0";
	$midCols = "";
	$leftCols = $leftCols2L;
	$centerCols = "";
}

if ($mainWidth == "threeRC") {
	$midColFloat = "float:left";
	$midColMargin ="margin-right: $gutter";
	$midCols = "";
	$rightCols = "";
	$centerCols = "";
}

if ($mainWidth == "one") {
$leftCols = "noleft";	
}


?>