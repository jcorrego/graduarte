<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );
/**JFlickr is a port of the Jquery Flickr Script by Project Atomic http://www.projectatomic.com/2008/04/jquery-flickr/
Released as a free module to the Joomla community by Joomla Bamboo. http://www.joomlabamboo.com
**/

global $mainframe;
$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_JFlickr/';
 

 $number		= $params->get( 'number', '8' );
 $size			= $params->get( 'size', 'original' );
 $tsize			= $params->get( 'tsize', 's' );
 $type			= $params->get( 'type', 'photoset' );
 $photoset_id	= $params->get( 'photoset_id', '981332' );
 $text			= $params->get( 'text', '' );
 $user_id		= $params->get( 'user_id', '' );
 $group_id		= $params->get( 'group_id', '' );
 $sort	    	= $params->get( 'sort', 'relevance' );
 $tags	    	= $params->get( 'tags', '' );
 $random       	= $params->get( 'random', 'false' );
 $fancyBox		= $params->get( 'fancybox', 'yes' );
 $fancyBoxScript= $params->get( 'fancyboxScript', 'yes' );
 $fancyEasing	= $params->get( 'fancyEasing', 'yes' );
 $fancyOverlayShow = $params->get('fancyOverlayShow','true');
 $fancyOverlay 	= $params->get('fancyOverlay','0.6');
 $fancyPadding 	= $params->get('fancyPadding','20');
 $moduleID		= $params->get( 'moduleID', '1' );
 $apiKey		= $params->get( 'apiKey', 'f28804be7a09c5845676349c7e47d636' );

if ($type =="user") {
    $type1 ="search";
}    
if ($type =="group") {
    $type1 ="search";
}

$zoomClass = 'flickrZoom';

$document->addStyleDeclaration('.gallery-flickr ul li {list-style-type:none;float:left;background: none;margin-left:0}.gallery-flickr ul {margin: 0} #right .gallery-flickr ul li a,#left .gallery-flickr ul li a,.gallery-flickr ul li a {float:left;margin:0 4px 4px 0;padding: 0;background:none;border: 0;} .gallery-flickr ul li a:hover {background: #ddd} #gallery-flickr {padding: 0;line-height: 0;margin: 0} .clearfix {clear:both}');	
$document->addScript($modbase . "js/JFlickr.js");
if (($fancyBoxScript == "yes") && ($fancyBox == "yes")){
	$document->addScript($modbase . "js/jquery.fancybox/jquery.fancybox-1.2.1.pack.js");
	if ($fancyEasing == "yes"){
	$document->addScript($modbase . "js/jquery.easing.1.3.js");
	}
	$document->addStyleSheet($modbase.'js/jquery.fancybox/jquery.fancybox.css');
	$zoomClass .= $moduleID;
	
}
?>


 <script type="text/javascript"> 
	jQuery(document).ready(function(){   
		jQuery(".gallery-flickr-<?php echo $moduleID ?>").flickr({    
			api_key: "<?php echo $apiKey ?>", 
			thumb_size: '<?php echo $tsize ?>',
			size: '<?php echo $size ?>',  
			per_page: <?php echo $number ?>,
			randomise: '<?php echo $random ?>',
			<?php if ($type == "photoset") : ?>
			type: '<?php echo $type ?>',
			sort: '<?php echo $sort ?>',
			photoset_id: '<?php echo $photoset_id ?>',
			<?php endif; ?>
			<?php if ($type == "search") : ?>
			type: '<?php echo $type ?>',
			sort: '<?php echo $sort ?>',
			tags: '<?php echo $tags ?>',
			text: '<?php echo $text ?>',
			<?php endif; ?>
			<?php if ($type == "user") : ?>
			type: '<?php echo $type1 ?>',
			sort: '<?php echo $sort ?>',
			tags: '<?php echo $tags ?>',
			user_id: '<?php echo $user_id ?>',
			<?php endif; ?>
			<?php if ($type == "group") : ?>
			type: '<?php echo $type1 ?>',
			sort: '<?php echo $sort ?>',
			tags: '<?php echo $tags ?>',
			group_id: '<?php echo $group_id ?>',
			<?php endif; ?>			
			module_id: '<?php echo $moduleID ?>',
			zoom_class: '<?php echo $zoomClass ?>',			
			callback: fancyboxCallback
					}); 
	function fancyboxCallback(){
	<?php if ($fancyBox == "yes") : ?>				
	jQuery("a[rel='<?php echo $zoomClass?>']").fancybox({
	zoomOpacity: false,
		padding: <?php echo $fancyPadding ?>,
		overlayOpacity: <?php echo $fancyOverlay ?>,
		'overlayShow'			: <?php echo$fancyOverlayShow ?>,
		'zoomSpeedIn'			: 600,
		'zoomSpeedOut'			: 500,
		<?php if ($fancyEasing == "yes") : ?>
		'easingIn'				: 'easeOutBack',
		'easingOut'				: 'easeInBack',
		<?php endif; ?>
		'hideOnContentClick'	: false
		
});
	<?php endif; ?>
	}
});
</script>
<div class="gallery-flickr gallery-flickr-<?php echo $moduleID ?>">&nbsp;</div>
<div class="clearfix"></div>
