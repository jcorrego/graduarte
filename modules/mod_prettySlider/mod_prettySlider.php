<?php
/**
* mod_prettyBox.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<?php
global $mainframe;
$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_prettySlider/';
$config =& JFactory::getConfig();
$url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

// Load cycle script references into the head
$document->addStyleSheet($modbase.'css/prettySlider.css');
$document->addScript($modbase . "js/jquery.cycle.js");

// General Settings and Layout
$directory = $params->get('directory', 'images/stories');
//Remove Slashes from directory
$directory = ltrim($directory,'/');
$directory = rtrim($directory,'/');

$module_id = $params->get('module_id','1');
$ssDescription = $params->get('ssDescription', 'Welcome to the JB Image Slideshow');
$ssnav = $params->get('ssnav', 'yes');
$sspag = $params->get('sspag', 'no');
$navTop = $params->get('navTop', '0');
$navLeft = $params->get('navLeft', '0');
$buttonStyle = $params->get('navStyle', 'Clean');

$output = $params->get('output', 3); // Selects the type of layout for the gallery
$imgdir = $directory; // the directory, where your images are stored
$allowed_types = array('png','jpg','jpeg','gif'); // list of filetypes you want to show
$link = $params->get('link',1);

// PrettyPhoto Settings
$prettyPhoto = $params->get('prettyPhoto','1');
$prettyPhotoScripts = $params->get('prettyPhotoScripts','1');
$padding = $params->get('padding','40');
$resize = $params->get('resize','true');
$theme = $params->get('theme','dark_rounded');
$prettyBoxTitle = $params->get('prettyBoxTitle','false');
$opacity = $params->get('opacity','0.6');
$prettyBoxSpeed = $params->get('prettyBoxSpeed','normal');

// Image Size and container
$crop_height = $params->get( 'crop_height', '100');
$crop_width = $params->get( 'crop_width','2');
$img_width = $params->get( 'img_width','150');
$img_height = $params->get( 'img_height','100');
$height = $params->get( 'height','200');

$transition = $params->get( 'transition','fade');
$speed = $params->get( 'slow','slow');
$time = $params->get( 'time','10000');


	if ($sspag == "yes") { 
		$pager = "pager:  '#ssnav".$module_id."'";
	}
	elseif ($sspag == "no") {
		$pager = "pager:  'null'";
	}
	
	if ($ssnav == "yes") { 
		$next = "next:   '#ssnext".$module_id."',";
		$prev = "prev:   '#ssprev".$module_id."',";
	}
	elseif ($ssnav == "no") {
		$next = "next:   'null',";
		$prev = "prev:   'null',";
	}
	
if ($prettyPhotoScripts) {
	$document->addScript($modbase . "prettyPhoto/js/jquery.prettyPhoto.js");
	$document->addStyleSheet($modbase.'prettyPhoto/css/prettyPhoto.css');
}
		

if ($prettyPhoto) { 
	$document->addScriptDeclaration("jQuery(document).ready(function(){
		 jQuery('a[rel^=\'prettyOverlay\'],a[rel^=\'prettyPhoto$module_id\']').prettyPhoto({
    		animationSpeed: '$prettyBoxSpeed',
    		padding:  $padding ,
    		showTitle: $prettyBoxTitle,
    		opacity:  $opacity ,
    		allowresize: $resize,
    		counter_separator_label: '/',
    		theme:  '$theme'
    	});
    
    });
  
	");

	} 

$document->addScriptDeclaration("jQuery(document).ready(function(){
	jQuery('#ss$module_id').show();
	jQuery('#ss$module_id').cycle({ 
		fx:     '$transition', 
		requeueOnImageNotLoaded: true,
		speed:  '$speed', 
		timeout: $time,
		fit:	1,
		height: $img_height,
		width:	$img_width,
		$prev
		$next
		$pager
	});
  
});");


	
?>

<div>
<!-- Start Joomla Bamboo Image Gallery -->
<div id='ss<?php echo $module_id;?>' class='ss pics' style="height:<?php echo $img_height ?>px">
<?php		
// Selects images from the nominated folder
$dimg = opendir($imgdir);
while($imgfile = readdir($dimg))
{
 if(in_array(strtolower(substr($imgfile,-3)),$allowed_types))
 {
  $a_img[] = $imgfile;
  sort($a_img);
  reset ($a_img);
 } 
}

$totimg = count($a_img); // total image number

for($x=0; $x < $totimg; $x++)
{

// Strips the file extension

$file_name = "$a_img[$x]";
$file_name = array(".jpg","",".png",".",".gif");
$new_file_name = str_replace($file_name, "", "$a_img[$x]");

// Creates new variables from the file name
$title = "$new_file_name";

// Link Behaviour
// No Link
if ($link == "0") {
$lightbox = '';
$openlink = '';
$closelink = '';
}
// Pretty Photo
elseif ($link == "1") {
$lightbox = 'rel="prettyPhoto'.$module_id.'[gallery]"';
$openlink ='<a href="'.$url.''.$directory.'/'.$a_img[$x].'" '.$lightbox.' title="'.$title.' ">';
$closelink = '</a>';
}

// Same Window
elseif ($link == "2") {
$lightbox = '';
$openlink ='<a href="'.$url.''.$directory.'/'.$a_img[$x].'">';
$closelink = '</a>';
}
// New Window
elseif ($link == "3") {
$lightbox = '';
$openlink ='<a href="'.$url.''.$directory.'/'.$a_img[$x].'" target="_blank">';
$closelink = '</a>';
}

// Subpath
$subpath = JURI::root( true );

// Slideshow Format
$image_output = ''.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettySlider/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$title.'" title="'.$title.'" />'.$closelink.'';

// Outputs the slideshow
echo ''.$image_output.'';
}
?>

</div>


<div id="ssNavWrap<?php echo $module_id;?>" class="ssNavWrap">
<div id="ssControls<?php echo $module_id;?>" class="ssControls <?php echo $buttonStyle ?>" style="width: <?php echo $img_width ?>px;margin-top:<?php echo $navTop?>px;margin-left:<?php echo $navLeft?>px">
	<?php if ($ssnav =="yes") { ?>
		<div id="ssprev<?php echo $module_id;?>" class="ssprev"></div>
	<?php } ?>
	<?php if ($sspag) { ?>
		<div id="ssnav<?php echo $module_id;?>" class="ssnav"></div>
	<?php } ?>
	<?php if ($ssnav =="yes") { ?>
		<div id="ssnext<?php echo $module_id;?>" class="ssnext"></div>
	<?php } ?>
</div>
</div>
</div>
<!-- End Joomla Bamboo Image Gallery -->