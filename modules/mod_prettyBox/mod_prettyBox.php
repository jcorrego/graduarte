<?php
/**
* mod_prettyBox.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;
$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_prettyBox/';
$config =& JFactory::getConfig();
$url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

// Load script references into the head
$document->addScript($modbase . "prettyPhoto/js/jquery.prettyPhoto.js");
$document->addStyleSheet($modbase.'prettyPhoto/css/prettyPhoto.css');

// General Settings and Layout
$directory = $params->get('directory', 'images/stories');
//Remove Slashes from directory
$directory = ltrim($directory,'/');
$directory = rtrim($directory,'/');

$subfolder = $params->get('subfolder', '');
$subfolderDisplay = $params->get('subfolderDisplay', 'no');
$output = $params->get('output', 3); // Selects the type of layout for the gallery
$imgdir = $directory; // the directory, where your images are stored
$allowed_types = array('png','jpg','jpeg','gif'); // list of filetypes you want to show
$link = $params->get('link',1);
$id = $params->get('id',1);
$items = $params->get('items', '1');
$rightMargin = $params->get('right_margin','0');
// PrettyPhoto Settings
$prettyPhoto = $params->get('prettyPhoto','1');
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

if ($prettyPhoto) { 
	// prettyPhoto Scripts
	$document->addScript($modbase . "prettyPhoto/js/jquery.prettyPhoto.js");
	$document->addStyleSheet($modbase.'prettyPhoto/css/prettyPhoto.css');
	
	$document->addScriptDeclaration("jQuery(document).ready(function(){
		 jQuery('a[rel^=\'prettyOverlay\'],a[rel^=\'prettyPhoto$id\']').prettyPhoto({
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

$document->addStyleDeclaration('.prettyBox div.prettydiv'.$id.' {width:'.$img_width.'px;height:'.$height.'px;float: left;margin-right:'.$rightMargin.'px;}');	

		
// Selects images from the nominated folder
?>

<div class="prettyBox">
<?php	

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
$string = "$new_file_name";

if ($items == "1" ){
list($title) = split('[-.-]', $string);
$description = "";
}

if ($items == "2" ){
list($title, $description) = split('[-.-]', $string);

}

if ($items == "3" ){
list($title, $description, $date) = split('[-.-]', $string);
}

if ($items == "4" ){
list($title, $description, $date, $author) = split('[-.-]', $string);
}

if ($items == "5" ){
list($title, $description, $date, $author, $articleid) = split('[-.-]', $string);
}

if ($items == "6" ){
list($title, $description, $date, $author, $articleid, $itemid) = split('[-.-]', $string);
}



// Link Behaviour
// No Link
if ($link == "0") {
$lightbox = '';
$openlink = '';
$closelink = '';
}
// Pretty Photo
elseif ($link == "1") {
$lightbox = 'rel="prettyPhoto'.$id.'[gallery]"';
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
// Content Item
elseif ($link == "4") {
$lightbox = '';
$openlink ='<a href="index.php?option=com_content&amp;view=article&id='.$articleid.'&amp;Itemid='.$itemid.'">';
$closelink = '</a>';
}
// Blog Category
elseif ($link == "5") {
$lightbox = '';
$openlink ='<a href="index.php?option=com_content&view=category&layout=blog&id='.$articleid.'&amp;Itemid='.$itemid.'">';
$closelink = '</a>';
}

// Subfolder if needed

$subpath = JURI::root( true );


// Output options for the gallery
// No Details
if ($output == "0") {
$image_output = '<div class="prettydiv'.$id.'">'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'</div>';
}

// Title Above Image
if ($output == "1") {
$image_output = '<div class="prettydiv'.$id.'"><p class="prettyTitle">'.$title.' </p>'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'</div>';
}
// Title Below Image
if ($output == "2") {
$image_output = '<div class="prettydiv'.$id.'">'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'<p class="prettyTitle">'.$title.' </p></div>';
}
// Title above plus details
elseif ($output == "3") {
$image_output = '<div class="prettydiv'.$id.'"><p class="prettyTitle">'.$title.' </p>'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'<p class="prettyDescription">'.$description.'</p><p class="prettyDate">'.$date.'</p><p class="prettyDescription">'.$author.'</p></div>';
}
// Title Below plus all details
elseif ($output == "4") {
$image_output = '<div class="prettydiv'.$id.'">'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'<p class="prettyTitle">'.$title.' </p><p class="prettyDescription">'.$description.'</p><p class="prettyDate">'.$date.'</p><p class="prettyDescription">'.$author.'</p></div>';
}
// Description Date Author
elseif ($output == "5") {
$image_output = '<div class="prettydiv'.$id.'">'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'<p class="prettyDescription">'.$description.'</p><p class="prettyDate">'.$date.'</p><p class="prettyAuthor">'.$author.'</p></div>';
}
// Date Author
elseif ($output == "6") {
$image_output = '<div class="prettydiv'.$id.'">'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'<p class="prettyDate">'.$date.'</p><p class="prettyAuthor">'.$author.'</p></div>';
}
// Author
elseif ($output == "6") {
$image_output = '<div class="prettydiv'.$id.'">'.$openlink.'<img class="prettyBox" src="'.$subpath.'/modules/mod_prettyBox/image.php?width='. $img_width .'&amp;height='. $img_height .'&amp;cropratio='. $crop_width .':'. $crop_height .'&amp;image='.$subpath.'/'.$directory.'/'.$a_img[$x].'"  alt="'.$a_img[$x].'" title="'.$title.' - '.$description.'" />'.$closelink.'<p class="prettyAuthor">'.$author.'</p></div>';
}

echo ''.$image_output.'';

}
?>
</div>
<div class="clear"></div>
