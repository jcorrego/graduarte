<?php
// MiniMoo2
defined('_JEXEC') or die('Restricted access');

global $mainframe;
$config =& JFactory::getConfig();
$url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_minimoo2/';
$subpath = JURI::root( true );
// PrettyPhoto Settings
$prettyPhoto = $params->get('prettyPhoto','1');
$padding = $params->get('padding','40');
$resize = $params->get('resize','true');
$theme = $params->get('theme','dark_rounded');
$prettyBoxTitle = $params->get('prettyBoxTitle','false');
$opacity = $params->get('opacity','0.6');
$prettyBoxSpeed = $params->get('prettyBoxSpeed','normal');

// General Module Settings
$height = $params->get('height','300');
$width = $params->get('width','600');
$moduleID = $params->get('module_id','1');
// Transitions
$transition = $params->get('transition','Swing');
$duration = $params->get('duration','400');

// Image Settings
$directory = $params->get('directory','images/stories');
$link = $params->get('link',1);

// Lightbox Options
$pngFix = $params->get('pngFix','yes');

// Thumb Settings
$thumbs = $params->get('thumbs','block');
$thumbWidth = $params->get('thumbWidth','60');
$thumbHeight = $params->get('thumbHeight','60');
$cropThumbWidth = $params->get('cropThumbWidth','2');
$cropThumbHeight = $params->get('cropThumbHeight','1');

// Full Image Settings
$imageWidth = $params->get('imageWidth','400');
$imageHeight = $params->get('imageHeight','300');
$cropWidth = $params->get('cropImageWidth','2');
$cropHeight = $params->get('cropImageHeight','1');

// Nav Display
$nav = $params->get('nav','yes');

$document->addScript($modbase . "js/jquery.flow.1.2.js");
$document->addScript($modbase . "js/jquery.easing.min.js");
$document->addStyleSheet($modbase.'css/minimoo2.css');

if ($link == "1") {
	$document->addScript($modbase . "prettyPhoto/js/jquery.prettyPhoto.js");
	$document->addStyleSheet($modbase.'prettyPhoto/css/prettyPhoto.css');
}

	if ($link) { 
	// prettyPhoto Scripts
	$document->addScript($modbase . "prettyPhoto/js/jquery.prettyPhoto.js");
	$document->addStyleSheet($modbase.'prettyPhoto/css/prettyPhoto.css');
	
	$document->addScriptDeclaration("jQuery(document).ready(function(){
		 jQuery('a[rel^=\'prettyOverlay\'],a[rel^=\'prettyPhoto$moduleID\']').prettyPhoto({
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


?>

<script language="javascript">
jQuery.noConflict();
		jQuery(document).ready(function(){

	jQuery("#minimooThumbs<?php echo $moduleID;?>").jFlow({
		slides: "#minimooSlides<?php echo $moduleID;?>",
		controller: ".minimooControl<?php echo $moduleID;?>", // must be class, use . sign
		slideWrapper : "#minimooSlide<?php echo $moduleID;?>", // must be id, use # sign
		selectedWrapper: "minimooSelected",  // just pure text, no sign
		width: "<?php echo $width+20 ?>px",
		height: "<?php echo $height ?>px",
		easing: "<?php echo $transition ?>",
		duration: <?php echo $duration ?>,
		prev: ".minimooPrev<?php echo $moduleID;?>", // must be class, use . sign
		next: ".minimooNext<?php echo $moduleID;?>" // must be class, use . sign
	});
	

});
</script>


<?php
//Remove Slashes from directory
$directory = ltrim($directory,'/');
$directory = rtrim($directory,'/');

// Script that pulls images from a folder
$separator ="   ";
$imgdir = ''.$directory.''; // the directory, where your images are stored
$allowed_types = array('png','jpg','jpeg','gif'); // list of filetypes you want to show

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

?>
<!-- Start Minimoo2 by Joomla Bamboo -->
<div>
<div class="minimoo" style="width:<?php echo $width ?>px">
	
		<div id="minimooThumbs<?php echo $moduleID;?>" class="minimooThumbs" style="display:<?php echo $thumbs ?>">
			<?php
				for($x=0; $x < $totimg; $x++)
					{
			?>	

			<span class="minimooControl<?php echo $moduleID;?>"><img src="<?php echo $subpath ?>/modules/mod_minimoo2/image.php?cropratio=<?php echo $cropThumbWidth ?>:<?php echo $cropThumbHeight ?>&amp;width=<?php echo$thumbWidth ?>&amp;height=<?php echo $thumbHeight ?>&amp;image=<?php echo$subpath?>/<?php echo $directory ?>/<?php echo $a_img[$x] ?>" longdesc="<?php echo$longdesc[$x] ?>" alt="<?php echo $a_img[$x] ?>" title="<?php echo $a_img[$x] ?>"/></span>

			<?php 
					}
			?>
	</div>

	<div id="minimooSlides<?php echo $moduleID;?>" class="minimooSlides">
<?php
for($x=0; $x < $totimg; $x++)
{
	
// Strips the file extension
$file_name = "$a_img[$x]";
$file_name = array(".jpg","",".png",".",".gif");
$new_file_name = str_replace($file_name, "", "$a_img[$x]");

// Creates new variables from the file name
$string = "$new_file_name";
list($title) = split('[-.-]', $string);


// Link Behaviour for when the larger image is clicked.
// No Link
if ($link == "0") {
$lightbox = '';
$openlink = '';
$closelink = '';
}
// Pretty Photo
elseif ($link == "1") {
$lightbox = 'rel="prettyPhoto'.$moduleID.'[gallery]"';
$openlink ='<a href="'.$url.''.$directory.'/'.$a_img[$x].'" '.$lightbox.' title="'.$title.' ">';
$closelink = '</a>';
}

		
// Larger images
?>
<div><?php echo $openlink ?><img src="<?php echo  $subpath ?>/modules/mod_minimoo2/image.php?cropratio=<?php echo $cropWidth ?>:<?php echo $cropHeight ?>&amp;width=<?php echo $imageWidth ?>&amp;height=<?php echo $imageHeight ?>&amp;image=<?php echo $subpath?>/<?php echo $directory ?>/<?php echo $a_img[$x] ?>"  alt="<?php echo $a_img[$x] ?>" title="<?php echo $a_img[$x] ?>"/><?php echo $closelink ?></div>
  
  <?php 
  }
?>
</div>
	<?php if ($nav == "yes") : ?>
		<span class="minimooPrev<?php echo $moduleID;?> minimooPrev">Prev</span> - <span class="minimooNext<?php echo $moduleID;?> minimooNext">Next</span>
	<?php endif; ?>
</div>
</div>
<div class="jbclear"></div>
<!-- End Mini moo2 by Joomla Bamboo -->