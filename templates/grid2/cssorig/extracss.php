<?php
header("Content-type: text/css");
?>

<style type="text/css" media="screen">
<?php if ($backgroundOptions) {?>
body {background:<?php echo $backgroundColor; if (!($backgroundImage=="")) { ?> url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/background/<?php echo $backgroundImage; }?>) <?php echo $backgroundRepeat; echo ' '; echo $backgroundPosition ?>} <?php if (!($bottomBackgroundImage =="-1")) { ?>.fullWrap {background: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/background/<?php echo $bottomBackgroundImage ?>) left bottom repeat-x fixed} <?php } ?> .topRow {background: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/topnav/<?php echo $topNavImage ?>) repeat-x left top}  .leftStyle {background:  url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/leftbackground/<?php echo $leftBackgroundImage ?>) repeat-y left top} #leftCol .moduletable-border,#leftCol #logo {background:url(templates/<?php echo $this->template ?>/images/dividerDark.jpg) repeat-x left bottom} a,#leftCol .moduletable-slide h3:hover,#leftCol a:hover {color: <?php echo $linkColor ?>} 
#leftCol a {color: <?php echo $leftLinkColor ?>} a:hover {color: <?php echo $linkHoverColor ?>} .topRow ul li#current a,.topRow ul li.active a{background: <?php echo $activeMenuBackground ?>;color: <?php echo $activeMenuColor ?>} .topRow .moduletable-superfish ul li a:hover,.topRow .moduletable-superfish ul li li a:hover {color: <?php echo $menuHoverColor ?>} <?php } ?>
a#openPanel {background: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/panel/close/<?php echo $OpenImage ?>) no-repeat 16px 26px} a#closePanel.active {background: url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/panel/open/<?php echo $CloseImage ?>) no-repeat 16px 26px} 
<?php if ($overwriteCSS) { echo $jbHeadingcolours;}  ?>
<!--[if lte IE 7]>
#memberArea {margin-left: <?php echo $$leftCols ?>px !important}
<![endif]-->
</style>