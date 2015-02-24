<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php
global $mainframe;
$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_bambooBox/';
$config =& JFactory::getConfig();
$url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
$count	= intval($params->get('count', 5));

$id = $params->get( 'id', '1');
// Image Size and container
$displayImages = $params->get( 'displayImages','article');
$resizeImage = $params->get('resizeImage',1);
$crop_height = (float)$params->get( 'crop_height', '1');
$crop_width = (float)$params->get( 'crop_width','2');
$image_width = (int)$params->get( 'image_width','234');
$image_height = (int)$params->get( 'image_height','100');
$colour = $params->get('colour', 'white');
$bottomMargin = (int)$params->get('bottomMargin', '10');
$rightMargin = (int)$params->get('rightMargin', '10');
$addMargin = $params->get('addMargin', '1');
$imagesPerRow = (int)$params->get('imagesPerRow', '3');
if ($imagesPerRow < 1) $imagesPerRow = 1;
// Fade Effects
$fadeEffect = $params->get('fadeEffect','1');

//Load Scripts Css
$loadScripts = $params->get( 'loadScripts', "1" );
$loadCaptify = $params->get( 'loadCaptify', "1" );
$loadBBcss = $params->get( 'loadBBcss', "1" );
$loadCBcss = $params->get( 'loadCBcss', 1 );
$cbTheme = $params->get( 'cbTheme', 1);

// ColorBox - Content Gallery Options
$colorBox	= $params->get( 'colorBox', '1' );
$popupGallery = $params->get('popupGallery','1');
$overlayOpacity =(float) $params->get('overlayOpacity','0.6');
$frameWidth = (int)$params->get('frameWidth','800');
$frameHeight = (int)$params->get('frameHeight','400');
$colorboxScrolling = $params->get('colorboxScrolling','false');

//Content Processing
$renderPlugin	= $params->get('renderPlugin','render');
$stripTags = $params->get('strip_tags',0);
$tags	= $params->get( 'allowed_tags', '10' );

// Meta Info links etc
$links = $params->get('links','1');
$titleBelow = $params->get('titleBelow','1');
$titleBelowLink = $params->get('titleBelowLink','1');
$linkBehaviour = $params->get('linkBehaviour','3');
$metaLinkBehaviour = $params->get('metaLinkBehaviour','2');
$displayLinkText = $params->get('displayLinkText','0');
$displayImageText = $params->get('displayImageText','1');
$linkText = $params->get('linkText','Full Details');
$imageText = $params->get('imageText','View Image');
$wordCount	= (int)$params->get( 'wordCount', '40' );

// Captify Parameters
$useCaptify = $params->get( 'useCaptify','0');
$speed = (int)$params->get( 'speed', '800');
$speedOut = (int)$params->get( 'speedOut', '800');
$transition = $params->get( 'transition', 'fade');
$opacity = (float)$params->get( 'opacity', '0.8');
$position = $params->get( 'position', 'bottom');

$colorbox = (($metaLinkBehaviour == 2) or ($linkBehaviour == 2) or ($linkBehaviour == 3)) ? 1 : 0;
if($contentSource == 'article') $displayImages = 'article';
//Functions to clean dimension values from parameters

$autoRightMargin = 0;
$imageNumber = 0;
$imgRightMargin = 0;
$itemWidth = "100%";
$startDiv = 0;

// Settings for the Column Widths in column display


	if ($imagesPerRow =="1") {
	$itemWidth ="100%";
	$autoRightMargin ="0";
	}
	
	if ($imagesPerRow =="2") {
	$itemWidth ="47%";
	$autoRightMargin = "5%";
	}

	if ($imagesPerRow =="3") {
	$itemWidth ="30%";
	$autoRightMargin = "5%";
	}

	if ($imagesPerRow =="4") {
	$itemWidth ="22%";
	$autoRightMargin = "3%";
	}
	
	if ($imagesPerRow =="5") {
	$itemWidth ="17%";
	$autoRightMargin = "3%";
	}
	if ($imagesPerRow =="6") {
	$itemWidth ="13%";
	$autoRightMargin = "4%";
	}
	
	if(!($addMargin)){
		$itemWidth = $image_width.'px';
	}

	if($loadCBcss and $colorbox){
		$document->addStyleSheet($modbase.'css/cbtheme'.$cbTheme.'.css');
		if($cbTheme == 1){
			$document->addStyleDeclaration(".cboxIE #cboxTopLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderTopLeft_1.png, sizingMethod='scale');}
			.cboxIE #cboxTopCenter{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderTopCenter_1.png, sizingMethod='scale');}
			.cboxIE #cboxTopRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderTopRight_1.png, sizingMethod='scale');}
			.cboxIE #cboxBottomLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderBottomLeft_1.png, sizingMethod='scale');}
			.cboxIE #cboxBottomCenter{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderBottomCenter_1.png, sizingMethod='scale');}
			.cboxIE #cboxBottomRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderBottomRight_1.png, sizingMethod='scale');}
			.cboxIE #cboxMiddleLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderMiddleLeft_1.png, sizingMethod='scale');}
			.cboxIE #cboxMiddleRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderMiddleRight_1.png, sizingMethod='scale');}");
		}
		if(($cbTheme == 4) or ($cbTheme == 'pred') or ($cbTheme == 'pbrown') or ($cbTheme == 'pred') or ($cbTheme == 'ppurple')){
			$document->addStyleDeclaration(".cboxIE #cboxTopLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderTopLeft_4.png, sizingMethod='scale');}
			.cboxIE #cboxTopCenter{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderTopCenter_4.png, sizingMethod='scale');}
			.cboxIE #cboxTopRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderTopRight_4.png, sizingMethod='scale');}
			.cboxIE #cboxBottomLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderBottomLeft_4.png, sizingMethod='scale');}
			.cboxIE #cboxBottomCenter{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderBottomCenter_4.png, sizingMethod='scale');}
			.cboxIE #cboxBottomRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderBottomRight_4.png, sizingMethod='scale');}
			.cboxIE #cboxMiddleLeft{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderMiddleLeft_4.png, sizingMethod='scale');}
			.cboxIE #cboxMiddleRight{background:transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=$modbase/images/borderMiddleRight_4.png, sizingMethod='scale');}");
		}
	}

if ($loadBBcss) {
$document->addStyleSheet($modbase.'css/bambooBox.css');
}

if ($loadScripts) {
// Load script references into the head
$document->addScript($modbase . "js/jquery.colorbox-min.js");
}
if ($loadCaptify) {
// Load script references into the head
$document->addScript($modbase . "js/captify.tiny.js");
}

if ($useCaptify) {
	$document->addScriptDeclaration("jQuery(document).ready(function(){
	jQuery('img.captify$id').captify({
		speedOver: '$speed',
		speedOut: '$speedOut',
		hideDelay: 500,	
		animation: '$transition',		
		prefix: '',		
		opacity: '$opacity',					
		className: 'caption-bottom',	
		position: '$position',
		spanWidth: '100%'
	});

 });
  
	");
}

if ($fadeEffect)
{
	$document->addScriptDeclaration("jQuery(document).ready(function(){
		jQuery('img.fade').fadeTo('slow', 1.0); // This sets the opacity of the thumbs to fade down to 60% when the page loads
		jQuery('img.fade').hover(function(){
			jQuery(this).fadeTo('slow', 0.6); // This should set the opacity to 100% on hover
		},function(){
			jQuery(this).fadeTo('slow', 1.0); // This should set the opacity back to 60% on mouseout
		});
  
    });
  
	");
}
if($colorbox){
	// ColorBox for detailed popup
	if($linkBehaviour == '3'){
		$colorboxGallery = $popupGallery ? 'bbgalleryb'.$id : 'nofollow';
		$document->addScriptDeclaration("jQuery(document).ready(function(){
			jQuery('a.cbDetailb$id').each(function(){
				var cbTarget = jQuery(this).attr('href');
				jQuery(this).colorbox({
					'inline': true,
					'href': cbTarget,
					'opacity': '$overlayOpacity',
					'scrolling': $colorboxScrolling,
					'rel': '$colorboxGallery',
					'innerWidth': '$frameWidth',
					'innerHeight': '$frameHeight'
				});			
		    
		    });
		});");
		if($colorboxScrolling == 'false'){
			$document->addScriptDeclaration("jQuery(document).bind('cbox_complete', function(){
			        jQuery.fn.colorbox.resize();
			});
				");
		}
	}
	if($metaLinkBehaviour == '2'){
		$colorboxGallery = $popupGallery ? 'bbgallerya'.$id : 'nofollow';
		$document->addScriptDeclaration("jQuery(document).ready(function(){
			jQuery('a.cbDetaila$id').each(function(){
				var cbTarget = jQuery(this).attr('href');
				jQuery(this).colorbox({
					'inline': true,
					'href': cbTarget,
					'opacity': '$overlayOpacity',
					'scrolling': $colorboxScrolling,
					'rel': '$colorboxGallery',
					'innerWidth': '$frameWidth',
					'innerHeight': '$frameHeight'
				});			
		    
		    });
		});");
		if($colorboxScrolling == 'false'){
			$document->addScriptDeclaration("jQuery(document).bind('cbox_complete', function(){
			        jQuery.fn.colorbox.resize();
			});
				");
		}
	}
	

	// ColorBox for image popup
	if(($linkBehaviour == '2') or ($displayImageText and $links)){
		$document->addScriptDeclaration("jQuery(document).ready(function(){
			jQuery('.cbImage$id').colorbox({
					'opacity': '$overlayOpacity',
					'current': ''
				
			});
		});");
	}
}
	// Function that limites the word count
	if(!function_exists('string_limit_words')) {
			 function string_limit_words($introText, $wordCount) {
			     $id = explode(' ', $introText);
			     return implode(' ', array_slice($id, 0, $wordCount));
			   }
			}
?>
 <!-- Start Joomla Bamboo Bamboo Box -->
<div id="bambooBox<?php echo $id;?>">
<?php	$numMB = sizeof($list);	
		foreach ($list as $item) :  
		
// Grabs the first image from the intro text		
		if($displayImages == "k2item")
		{
			$firstImage = $item->firstimage;
		}
		else
		{
			$html= $item->introtext;
			$html .= "alt='...' title='...' />";
			$pattern = '/<img[^>]+src[\\s=\'"]';
			$pattern .= '+([^"\'>\\s]+)/is';
	
			if(preg_match(
			$pattern,
			$html,
			$match))
			$firstImage = "$match[1]";
			else $firstImage = "";
		}
		
		// Plugin processing code from Joomlaworks.gr
		if ($renderPlugin == 'render'){
			$item->text = $item->introtext;
			/*
			* Process the prepare content plugins
			*/
			$plgparams 	   =& $mainframe->getParams('com_content');
			$dispatcher	   =& JDispatcher::getInstance();
			JPluginHelper::importPlugin('content');
			$results = $dispatcher->trigger('onPrepareContent', array (& $item, & $plgparams));
			$item->introtext = $item->text;


		} elseif ($renderPlugin == 'strip') {
			$item->introtext = preg_replace('/{([a-zA-Z0-9\-_]*)\s*(.*?)}/i','', $item->introtext);
		}
		
		// Strips the introtext of nominated tags
		if($stripTags) $item->introtext = strip_tags($item->introtext, $tags);

if (!($firstImage == "")) { 
	$imageNumber++;
	if($addMargin){
		$imgRightMargin = ($imageNumber % $imagesPerRow) ? $autoRightMargin : 0;
	}
	else{
		$imgRightMargin = ($imageNumber % $imagesPerRow) ? $rightMargin.'px' : '0px';
	}
	$rowFlag = ($imageNumber % $imagesPerRow) ? 0 : 1;
	
	if (($imageNumber == 1) or ($startDiv)) {
		$startDiv = 0;
		
	?>
	<div class="mbRow">
	<?php }?>

<div class="bbItem" style="width:<?php echo $itemWidth ?>;margin-right: <?php echo $imgRightMargin ?>;margin-bottom: <?php echo $bottomMargin ?>px">
			
			<?php 
			
			// No link attached to image
			if ($linkBehaviour == "0") { ?>
				<?php if($resizeImage) { ?><img src="modules/mod_bambooBox/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php }?>
				
			<?php } 
			
			
			 // Image clicked goes to content item
			if ($linkBehaviour == "1") { ?>
			<a rel="bbgallery<?php echo $id ?>" title="<?php echo $item->title; ?>"  href="<?php echo $item->link ?>">
				<?php if($resizeImage) { ?><img src="modules/mod_bambooBox/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php }?>
			</a>
			<?php } 
			
			
			// Image clicked creates popup and displays the first image
			if ($linkBehaviour == "2") { ?>
				<a class="cbImage<?php echo $id ?>" rel="bbimggallery<?php echo $id ?>" title="<?php echo $item->title; ?>" href="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>">
				<?php if($resizeImage) { ?><img src="modules/mod_bambooBox/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php }?>
			</a>
			<?php } 
			
			
			 // Image clicked opens full details in a popup
			if ($linkBehaviour == "3") { ?>
				<a class="cbDetailb<?php echo $id ?>" href="#bbpopup<?php echo $item->id.$id; ?>" rel="bbgalleryb<?php echo $id ?>" title="<?php echo $item->title; ?>" >
					<?php if($resizeImage) { ?><img src="modules/mod_bambooBox/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" class="bbox <?php if ($useCaptify) { ?>captify<?php echo $id ?><?php } ?> <?php if ($fadeEffect) { ?>fade<?php } ?>" alt="<?php echo $item->title; ?>" /><?php }?>
				</a>

			<?php } ?>
			
			<?php if ($links) { ?>
			<div class="bbMeta">
			
					<?php if ($titleBelow) { ?>
						<div class="bbTitleBelow">
								<?php if ($titleBelowLink) { ?>
										<a href="<?php echo $item->link ?>">
								<?php } ?>
								
								<?php echo $item->title; ?>
								<?php if ($titleBelowLink) { ?>
										</a>
								<?php } ?>
								
						</div>
						<div class="bbClear"></div>
					<?php } ?>
					
					
					
					<?php if ($metaLinkBehaviour == "1" && $displayLinkText) {  ?>
									
										<span class="articleLink">
											<a href="<?php echo $item->link; ?>"><?php echo $linkText ?></a>
										</span>  
					
					<?php 	}
					
					elseif ($metaLinkBehaviour == "2" && $displayLinkText) { ?>
						<span class="articleLink">
								<a rel="bbgallerya<?php echo $id ?>" class="cbDetaila<?php echo $id ?>" title="<?php echo $item->title; ?>" href="#bbpopup<?php echo $item->id.$id; ?>"  ><?php echo $linkText ?></a>
						</span>
					<?php 
							
					}
					
					if ($displayImageText) { ?>
					<span class="zoomImage">
							<a class="cbImage<?php echo $id ?>" style="margin-right:10px;margin-bottom:10px;float:right" href="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" title="<?php echo $item->title; ?>" rel="bbimggallery<?php echo $id ?>" ><?php echo $imageText ?></a>
					</span>
					<?php } ?>
				
				</div>
			<?php } ?> 
		
		
				<?php if ($metaLinkBehaviour == "2" or $linkBehaviour == "3") { ?>
				<!-- Start Bamboo Box Inline Content -->
				<div style="display:none">
					<div id="bbpopup<?php echo $item->id.$id; ?>">
							<h2 class="popupTitle"><?php echo $item->title; ?></h2>
							<div class="popupIntroText">
									<?php echo $item->introtext; ?>
							</div>
							<div class="bbClear"></div>
							<div class="popupFullText">
									<?php echo $item->fulltext ?>
							</div>
					</div>
				</div>
				<!-- End Bamboo Box Inline Content -->
				<?php } ?>
</div>
<?php 
if (($imageNumber == $numMB) or ($rowFlag))
{
	$startDiv = 1;
?>
	</div>
	<div class="bbClear"></div>
<?php }?>
<?php }?>
<?php endforeach; ?>

</div>





<div class="clear"></div>
 <!-- End Joomla Bamboo Bamboo Box -->





