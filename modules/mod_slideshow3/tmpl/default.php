<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php 
global $mainframe;   
$modbase = ''.JURI::base().'modules/mod_slideshow3/slideshow/';
$document =& JFactory::getDocument();
$modID 					= $params->get( 'moduleID', '1' );
$ssTheme				= $params->get( 'ssTheme', 'None');
$type 					= $params->get( 'type', 'slideshow' );
$display_ticker 		= $params->get( 'display_ticker', 'yes' );
$display_slideshow 		= $params->get( 'display_slideshow', 'yes' );
$ticker_transition 		= $params->get( 'ticker_transition', 'scrollDown' );
$ticker_title 			= $params->get( 'ticker_title', 'yes' );
$ticker_text 			= $params->get( 'ticker_text', 'yes' );
$title_class 			= $params->get( 'title_class', 'h2' );
$item_title 			= $params->get( 'item_title', 'yes' );
$title_link 			= $params->get( 'title_link', 'yes' );
$ticker_height 			= $params->get( 'ticker_height', '100' );
$ticker_width 			= $params->get( 'ticker_width', '670' );
$margin_top 			= $params->get( 'margin_top', '290' );
$margin_left 			= $params->get( 'margin_left', '0' );
$content_image			= $params->get(	'content_image','content');
$directory 				= $params->get( 'directory', 'images/stories' );
$slideshow_height		= $params->get( 'slideshow_height', '400' );
$slideshow_width		= $params->get( 'slideshow_width', '' );
$imageBorder			= $params->get( 'imgBorder','yes');
$image_top 				= $params->get( 'image_top', '290' );
$image_left 			= $params->get( 'image_left', '0' );
$fileType 				= $params->get( 'fileType', 'jpg' );
$lowercase 				= $params->get( 'lowercase', '1' );
$display_nav 			= $params->get( 'display_nav', 'indexNavButtons' );
$navTop 				= $params->get( 'navTop', '0' );
$navLeft 				= $params->get( 'navLeft', '0' );
$navButtons				= $params->get(	'navButtons', 'no');
$sstime					= $params->get( 'sstime', '10000' );
$ssSpeed				= $params->get( 'ssSpeed','1500');
$image1_pub 			= $params->get( 'image1_pub', 'yes' );
$image1 				= $params->get( 'image1', 'key.jpg' );
$title1					= $params->get( 'title1', 'Title1' );
$alt1 					= $params->get( 'alt1', 'Alt1' );
$image_number 			= $params->get( 'image_number', '3' );
$image_name 			= $params->get( 'image_name', 'header' );
$image_extension		= $params->get( 'image_extension', 'jpg' );
$time					= $params->get( 'time', '10000' );
$duration				= $params->get(  'duration', '400');
$jbIntroText			= $params->get( 'jbIntroText', 1 );
$words					= $params->get( 'words', '80' );
$ssNavWidth				= $params->get( 'navWidth', '200' );
$ssNavHeight			= $params->get( 'navHeight', '400' );
$prevNavText			= $params->get( 'navPrevText', 'Previous' );
$nextNavText			= $params->get( 'navNextText', 'Next' );
$bgOverlay				= $params->get( 'bgOverlay', 'no' );
$readMoreLink			= $params->get( 'readMoreLink', 'yes' );
$readMoreText			= $params->get( 'readMoreText', 'Read More ...' );
$imageResize			= $params->get( 'imageResize', 'yes' );
$tickerIntro			= $params->get( 'tickerIntro', '' );
$navItemWidth			= $params->get('navItemWidth','60');
$navItemHeight			= $params->get('navItemHeight','40');
$titleLimit				= $params->get('titleLimit','0');
$titleSuffix			= $params->get('titleSuffix','...');
$scrollNav				= $params->get('scrollNav','none');
$numVis					= $params->get('numVis','3');
if(sizeof($list) <= $numVis) $scrollNav = 'none';

if (!($display_nav == "thumbsNav" or $display_nav == "titleNav" or $display_nav == "thumbsTitleNav" or $display_nav == "titleThumbsNav"))
{
	$scrollNav = 'none';
}

$images = $image_number + 1;

// Image Size and container
$crop_height = $params->get( 'crop_height', '1');
$crop_width = $params->get( 'crop_width','2');
$image_width = $params->get( 'image_width','234');
$image_height = $params->get( 'image_height','100');
$colour = $params->get('colour', 'white');
$rightMargin = $params->get('rightMargin', '10');
$bottomMargin = $params->get('bottomMargin', '10');
$imageLink = $params->get('imageLink','yes');
$hoverTransition = $params->get('hoverTransition','yes');
$fadeEffect = $params->get('fadeEffect','1');
$wordCount	= $params->get( 'wordCount', '40' );
$stripTags = $params->get(	'striptags','yes');
$allowedTags = $params->get('tags','<a><ul><li><h1><h2><h3><h4><h5><h6><b><em><i><strong><blockquote><dd><dt><small><u><br>');

// Thumbnail size
$thumb_crop_height = $params->get('thumb_crop_height','1');
$thumb_crop_width= $params->get('thumb_crop_width','2');
$thumb_height = $params->get('thumb_height','40');
$thumb_width = $params->get('thumb_width','60');

$renderPlugin	= $params->get('renderPlugin','render');

//K2
$contentSource = $params->get('contentSource','article');
$showCommentCount	= $params->get('showCommentCount','yes');

//Description Text
$showDescriptionText = $params->get('showDescriptionText','yes');
$descriptionText = $params->get('descriptionText','');
$descriptionMarginTop = $params->get('descriptionMarginTop','0');
$descriptionMarginLeft = $params->get('descriptionMarginLeft','0');
$descriptionHeight = $params->get('descriptionHeight','50');
$descriptionWidth = $params->get('descriptionWidth','100');
$descriptionOverlay = $params->get('descriptionOverlay','no');
if(!function_exists('jb_get_dimensions')) {
	function jb_get_dimensions($dimension)
	{
		preg_match ('{(\d+)}',$dimension,$m)			;
		$numDim = $m[1];
		trim(strtolower($dimension));
		if(substr($dimension,-1,1) == "%")
		{
			return $numDim."%";
		}
		else
		{
			return $numDim."px";
		}		
	}
}

if(!function_exists('jb_get_px')) {
	function jb_get_px($dimension)
	{
		preg_match ('{((\+|-)?\d+)}',$dimension,$m)			;
		$numDim = $m[1];
		return $numDim."px";				
	}
}

if($slideshow_width == ""){
$slideshow_width = "100%";
}else{
$slideshow_width = jb_get_dimensions($slideshow_width);
}

$ticker_height = jb_get_px($ticker_height);
$ticker_width = jb_get_px($ticker_width);
$slideshow_height = jb_get_px($slideshow_height);
$margin_top = jb_get_px($margin_top);
$margin_left = jb_get_px($margin_left);
$image_top = jb_get_px($image_top);
$image_left = jb_get_px($image_left);
$navTop = jb_get_px($navTop);
$navLeft = jb_get_px($navLeft);
$ssNavWidth = jb_get_px($ssNavWidth);
$descriptionMarginTop = jb_get_px($descriptionMarginTop);
$descriptionMarginLeft = jb_get_px($descriptionMarginLeft);
$descriptionHeight = jb_get_px($descriptionHeight);
$descriptionWidth = jb_get_px($descriptionWidth);


if ($ticker_transition != "fade") {
// Load script references into the head
$document->addScript($modbase . "jquery.cycle.js");
$document->addStyleSheet($modbase.'slideshow.css'); 
}


elseif ($ticker_transition == "fade") {
// Load script references into the head
$document->addScript($modbase . "jquery.cycle.lite.js");
$document->addStyleSheet($modbase.'slideshow.css'); 
}


if($display_nav == "noNav"){
	$navStyle = 'none';
}
else
{
	$navStyle = 'inline';
	
}

$document->addStyleDeclaration('#slideShowNav'.$modID.'{position: absolute; float: left; z-index: 50;margin-top: '.$navTop.';margin-left:'.$navLeft.';display:'.$navStyle.'} li.navItem'.$modID.' a {display:block;width:'.$navItemWidth.'px;height:'.$navItemHeight.'px;overflow:hidden}');


if(!function_exists('jb_utf8_strtolower')) {
	function jb_utf8_strtolower($string) 
	{
		return utf8_encode(strtolower(utf8_decode($string)));
	}
}

if(!function_exists('string_limit_words')) {
		 function string_limit_words($introText, $wordCount) {
		     $id = explode(' ', $introText);
		     return implode(' ', array_slice($id, 0, $wordCount));
		   }
		}
	
	if ($type == "slideshow") {	
if ($fadeEffect)
{
	$document->addScriptDeclaration("jQuery(document).ready(function(){		
		jQuery.fn.cycle.updateActivePagerLink = function(pager, currSlideIndex) { 
		jQuery(pager).find('li').stop().fadeTo('slow', 0.3) 
        .filter('li:eq('+currSlideIndex+')').stop().fadeTo('fast', 1.0); 
		jQuery(pager).find('a').removeClass('activeSlide') 
        .filter('a:eq('+currSlideIndex+')').addClass('activeSlide');
		};
  });

	");
}
	}
	

if ($type == "slideshow") { 
?>


<!-- Start Joomla Bamboo Slideshow -->
<div id="slideShowContainer<?php echo $modID?>" class="slideShowContainer<?php echo $ssTheme?>" style="height:<?php echo $slideshow_height ?>;width:<?php echo $slideshow_width ?>;">
	<div id="slideShowDescription<?php echo $modID?>" class="slideShowDescription <?php echo $descriptionOverlay;?>" style="margin-left:<?php echo $descriptionMarginLeft ?>;margin-top:<?php echo $descriptionMarginTop ?>;height:<?php echo $descriptionHeight ?>;width:<?php echo $descriptionWidth ?>;display:<?php echo $showDescriptionText;?>;"><?php echo $descriptionText;?></div>
	<div id="slideShowNav<?php echo $modID?>" class="slideShowNav <?php echo $display_nav;?>" style="<?php if($scrollNav != 'horizontal') {?>width:<?php echo $ssNavWidth ?>;<?php }?><?php if($scrollNav != 'vertical') {?>height:<?php echo $ssNavHeight ?>;<?php }?>overflow:hidden">
		<?php if($scrollNav == 'vertical') {?>
			<div id="scrollPrevVertical<?php echo $modID?>" class="scrollButtonVertical scrollPrevious"></div>
			<div id="scrollNextVertical<?php echo $modID?>" class="scrollButtonVertical scrollNext"></div>
		<?php } elseif($scrollNav == 'horizontal'){?>
			<div id="scrollPrevHorizontal<?php echo $modID?>" class="scrollButtonHorizontal scrollPrevious"></div>
			<div id="scrollNextHorizontal<?php echo $modID?>" class="scrollButtonHorizontal scrollNext"></div>
		<?php }?>
		<?php if(($scrollNav == 'vertical') or ($scrollNav == 'horizontal')) {?>
			<div id="scrollContainer<?php echo $modID?>" class="scrollContainer" style="overflow:hidden">
		<?php }?>
		<div id="ssPager<?php echo $modID?>" class="ssPager<?php if($scrollNav == 'vertical') echo ' vertical';?><?php if($scrollNav == 'horizontal') echo ' horizontal';?>" style="<?php if($display_nav == 'indexNav'):?>float:left;<?php endif;?>"></div>
		<?php if(($scrollNav == 'vertical') or ($scrollNav == 'horizontal')) {?>
			</div>			
		<?php }?>
		<?php if($navButtons == 'yes' && count($list)>1):?>
		<div class="ssNavButtons"><span id="ssPrev<?php echo $modID?>" class="ssPrev"><?php echo $prevNavText;?></span> | <span id="ssNext<?php echo $modID?>" class="ssNext"><?php echo $nextNavText;?></span></div>
		<?php endif;?>
	</div>
	<span class="tickerLabel" style="margin-top:<?php echo $margin_top ?>;"><?php echo $tickerIntro ?></span>
	<div id="news-ticker<?php echo $modID?>" style="height:<?php echo $slideshow_height ?>;width:100%;z-index:10">
	
		<?php // Start the loop
			if($list){
				$numItems = sizeof($list);
				
			foreach ($list as $item) :  
			$imagePath = "";
			if (($content_image == 'content') or ($content_image == 'k2content')) {
				if(isset($item->firstimage)) $html= $item->firstimage;
				$html .= "alt='...' title='...' />";
				$pattern = '/<img[^>]+src[\\s=\'"]';
				$pattern .= '+([^"\'>]+)/is';
				$firstImage = '';
			
				if(preg_match(
				$pattern,
				$html,
				$match))
				$firstImage = "$match[1]";
								
				$imagePath = $firstImage;
				
			}
			if (($contentSource == "k2") and ($content_image == "k2item")){
				if(isset($item->firstimage)) $imagePath = $item->firstimage;
			}
			if(($content_image == 'directory'))
			{
				// remove the spaces in the file name
				$imageName = $item->title; 
				$imageName = str_replace (" ", "", $imageName);
		
				if ($lowercase) {
				$imageName = jb_utf8_strtolower($imageName);
				}
				$imageName = htmlspecialchars($imageName,ENT_COMPAT,'UTF-8');
				$directory = rtrim(ltrim($directory,'/'),'/');
				$imagePath = $directory.'/'.$imageName.'.'.$fileType;
			}
			
			$thumbsTitle = $item->title;
			if($titleLimit > 0)
			{
				if(strlen($thumbsTitle) > $titleLimit)
				{
					$thumbsTitle = substr( $thumbsTitle, 0, strrpos(substr($thumbsTitle, 0, $titleLimit), ' ')).$titleSuffix;
				}
				
			}
			
			// Plugin processing code from Joomlaworks.gr
			if ($renderPlugin == 'render'){
				/*
				* Process the prepare content plugins
				*/
				$plgparams 	   =& $mainframe->getParams('com_content');
				$dispatcher	   =& JDispatcher::getInstance();
				JPluginHelper::importPlugin('content');
				$results = $dispatcher->trigger('onPrepareContent', array (& $item, & $plgparams));


			} elseif ($renderPlugin == 'strip') {
				$item->text = preg_replace('/{([a-zA-Z0-9\-_]*)\s*(.*?)}/i','', $item->text);
			}
			
		 ?>
		
		<div class="scroller" style="height:<?php echo $slideshow_height?>;width:100%;">
			<?php if ($display_nav == "thumbsNav" or $display_nav == "titleNav" or $display_nav == "thumbsTitleNav" or $display_nav == "titleThumbsNav") : ?>
				<div class="slideThumbs<?php echo $modID?>" style="display:none">
					<?php if ($display_nav == "titleNav") { ?>
						<span class="thumbtitle"><?php echo $thumbsTitle ?></span><?php if(($contentSource == 'k2') and ($showCommentCount == 'yes')) {?><span class="ssComment"><?php echo $item->numOfComments ?> comments</span><?php }?>
					<?php }else { ?>
						<?php if (!($imagePath == "")) { ?>
							<?php if ($display_nav == "titleThumbsNav") { ?><span class="thumbtitleright"><?php echo $thumbsTitle ?></span><?php if(($contentSource == 'k2') and ($showCommentCount == 'yes')) {?><span class="ssComment"><?php echo $item->numOfComments ?> comments</span><?php }?><?php }?><img class="navThumb<?php if($imageBorder == 'yes') echo ' border'?> <?php if($display_nav == "titleThumbsNav") echo 'thumbRight'?>" src="modules/mod_slideshow3/image.php?width=<?php echo $thumb_width ?>&amp;height=<?php echo $thumb_height ?>&amp;cropratio=<?php echo $thumb_crop_width ?>:<?php echo $thumb_crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $imagePath ?>" alt="<?php echo $item->title; ?>" /> <?php if ($display_nav == "thumbsTitleNav") { ?><span class="thumbtitle"><?php echo $thumbsTitle ?></span><?php if(($contentSource == 'k2') and ($showCommentCount == 'yes')) {?><span class="ssComment"><?php echo $item->numOfComments ?> comments</span><?php }?><?php }?>

								<?php }else { ?>
									<?php if ($display_nav == "titleThumbsNav") { ?><span class="thumbtitleright"><?php echo $thumbsTitle ?></span><?php if(($contentSource == 'k2') and ($showCommentCount == 'yes')) {?><span class="ssComment"><?php echo $item->numOfComments ?> comments</span><?php }?><?php }?><img class="navThumb<?php if($imageBorder == 'yes') echo ' border'?> <?php if($display_nav == "titleThumbsNav") echo 'thumbRight'?>" src="modules/mod_slideshow3/image.php?width=<?php echo $thumb_width ?>&amp;height=<?php echo $thumb_height ?>&amp;cropratio=<?php echo $thumb_crop_width ?>:<?php echo $thumb_crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/modules/mod_slideshow3/images/spacer.png" alt="<?php echo $item->title; ?>" /> <?php if ($display_nav == "thumbsTitleNav") { ?><span class="thumbtitle"><?php echo $thumbsTitle ?><?php if(($contentSource == 'k2') and ($showCommentCount == 'yes')) {?><span class="ssComment"><?php echo $item->numOfComments ?> comments</span><?php }?></span><?php }?>					
								<?php }?>
					<?php }?>
				</div>
			<?php endif; ?>
			<?php if ($display_slideshow == "yes") : ?>
				<div class="slideshowImage" style="z-index:15<?php if ($imageResize == "yes") { ?>;width=<?php echo $image_width; ?>px;height=<?php echo $image_height; ?>px<?php }?>">
					<?php if (!($imagePath == "")) { ?> 
						<?php if ($imageLink == "yes") :?>
							<a href="<?php echo $item->link; ?>">
						<?php endif;
						
						 if ($imageResize == "yes") { ?>
							<img  <?php if($imageBorder == 'yes') :?>class="border"<?php endif?> src="modules/mod_slideshow3/image.php?width=<?php echo $image_width ?>&amp;height=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $imagePath ?>"  alt="<?php echo $item->title; ?>"  style="margin-top:<?php echo $image_top ?>;margin-left:<?php echo $image_left?>"/>
							
						<?php }  if ($imageResize == "no") { ?>
						
						<img  <?php if($imageBorder == 'yes') :?>class="border"<?php endif?> src="<?php echo JURI::root( true ) ?>/<?php echo $imagePath ?>"  alt="<?php echo $item->title; ?>"  style="margin-top:<?php echo $image_top ?>;margin-left:<?php echo $image_left?>"/>
						
						<?php }
						
						 if ($imageLink == "yes") :?>
							</a>
						<?php endif;?>
					<?php }else {?>
						<?php if ($imageLink == "yes") :?>
							<a href="<?php echo $item->link; ?>">
						<?php endif;?>
							<img <?php if($imageBorder == 'yes') :?>class="border"<?php endif?> src="modules/mod_slideshow3/image.php?width=<?php echo $image_width ?>&amp;height=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/modules/mod_slideshow3/images/spacer.png"  alt="<?php echo $item->title; ?>"  style="margin-top:<?php echo $image_top ?>;margin-left:<?php echo $image_left?>"/>
						<?php if ($imageLink == "yes") :?>
							</a>
						<?php endif;?>
					<?php }?>
				</div>
			<?php endif; ?>
			<?php if ($display_ticker == "yes") : ?>
			<div class="slideshowContent <?php if($bgOverlay != 'no')echo $bgOverlay;?>" style="margin-top:<?php echo $margin_top ?>;margin-left:<?php echo $margin_left?>;width:<?php echo $ticker_width?>;height:<?php echo $ticker_height?>;z-index:20;">
				<?php if ($item_title == "yes") : ?>
				<<?php echo $title_class ?>>
				<?php if ($title_link == "yes") : ?>
					<a href="<?php echo $item->link; ?>">
				<?php endif; ?>
			<?php echo $item->title; ?>
			<?php if ($title_link == "yes") : ?>
					</a>
			<?php endif; ?>
			</<?php echo $title_class ?>>
		<?php endif; ?>
		<?php if ($ticker_text == "yes") : ?>
			<div>
			<?php echo string_limit_words( $item->text, $wordCount); ?>
			<?php if($readMoreLink == 'yes') :?>			
			<a href="<?php echo $item->link; ?>"><span class="readmore"><?php echo $readMoreText; ?></span></a>			
			<?php endif;?>
			</div>
		<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
<?php endforeach; } ?>
	
	</div>
	
	

</div>
<script type="text/javascript">
<!--//--><![CDATA[//><!-- 
jQuery.noConflict();
jQuery(function() {

	 jQuery('#slideShowContainer<?php echo $modID?>').show();
	 
	 	 jQuery('.slideshowImage').css({'background':'none'});
		 jQuery('#news-ticker<?php echo $modID?>').cycle({ 
			fx:    '<?php echo $ticker_transition ?>', 
			requeueOnImageNotLoaded: true,
			cleartype:	1,		 
			timeout: <?php echo $sstime ?>,
			speed: <?php echo $ssSpeed ?>,
			pager:  '#ssPager<?php echo $modID?>',
			prev: '#ssPrev<?php echo $modID?>',
			next: '#ssNext<?php echo $modID?>'<?php if ($hoverTransition == 'yes') : ?>,
			pagerEvent: 'mouseover'<?php endif;?><?php if ($display_nav == "thumbsNav" or $display_nav == "titleNav" or $display_nav == "thumbsTitleNav" or $display_nav == "titleThumbsNav") : ?>,
			pagerAnchorBuilder: function(idx, slide) {
				return '<li class="navItem<?php echo $modID?>"><a href="#">'+jQuery('div.slideThumbs<?php echo $modID?>',slide).html()+'</a></li>';
			}
			<?php endif; ?>
		});
		
	<?php if($scrollNav != 'none') :?>
		var navItemHeight = parseInt(jQuery('li.navItem<?php echo $modID?>').css('marginBottom')) + parseInt(jQuery('li.navItem<?php echo $modID?>').css('marginTop')) + parseInt(jQuery('li.navItem<?php echo $modID?>').height());
		var navItemWidth = parseInt(jQuery('li.navItem<?php echo $modID?>').css('marginLeft')) + parseInt(jQuery('li.navItem<?php echo $modID?>').css('marginRight')) + parseInt(jQuery('li.navItem<?php echo $modID?>').width());
		var scrollOffset = 0;
		var scrollFrame = 1;
		var scrollCount = <?php echo $numItems?>-<?php echo $numVis?>+1;
		<?php if($scrollNav == 'vertical') {?>
			var scrollAreaWidth = navItemWidth;
			var scrollAreaHeight = parseInt(<?php echo $numVis > $numItems ? $numItems:$numVis;?>) * navItemHeight;
			var scrollTotalHeight = parseInt(<?php echo $numItems?>) * navItemHeight;
			var scrollButtonHeight = 20;
			var scrollButtonWidth = navItemWidth;
			var scrollBy = navItemHeight;
			jQuery('div#scrollPrevVertical<?php echo $modID?>, div#scrollNextVertical<?php echo $modID?>').css('height',scrollButtonHeight).css('width',scrollButtonWidth);
			jQuery('div#scrollPrevVertical<?php echo $modID?>').css('top',0);
			jQuery('div#scrollNextVertical<?php echo $modID?>').css('top',scrollAreaHeight+20);
			jQuery('div#slideShowNav<?php echo $modID?>').css('height',scrollAreaHeight+40);
			jQuery('div#scrollContainer<?php echo $modID?>').css('marginTop',scrollButtonHeight);
			jQuery('div#ssPager<?php echo $modID?>').css('height',scrollTotalHeight).css('width',scrollAreaWidth);
			jQuery('div#scrollContainer<?php echo $modID?>').css('width',scrollAreaWidth+2).css('height',scrollAreaHeight);
			jQuery(document).ready(function(){
				jQuery('div#scrollPrevVertical<?php echo $modID?>').click(function(){
					newFrame = (scrollFrame/1)-1;
					newOffset = scrollOffset+scrollBy;
					newOffsetAttr = newOffset + "px";
					if(newFrame > 0){
						jQuery('div#ssPager<?php echo $modID?>').stop().animate({top : newOffsetAttr}, 800);
						scrollFrame = newFrame;
						scrollOffset = newOffset;

					}
				});
				jQuery('div#scrollNextVertical<?php echo $modID?>').click(function(){
					newFrame = (scrollFrame/1)+1;
					newOffset = scrollOffset-scrollBy;
					newOffsetAttr = newOffset + "px";
					if(newFrame <= scrollCount){
						jQuery('div#ssPager<?php echo $modID?>').stop().animate({top : newOffsetAttr}, 800);
						scrollFrame = newFrame;
						scrollOffset = newOffset;

					}
				});
			});
			
		<?php } elseif($scrollNav == 'horizontal'){?>
			var scrollAreaWidth = parseInt(<?php echo $numVis > $numItems ? $numItems:$numVis;?>) * navItemWidth;
			var scrollAreaHeight = navItemHeight;
			var scrollTotalWidth = parseInt(<?php echo $numItems?>) * navItemWidth;
			var scrollButtonHeight = navItemHeight;
			var scrollButtonWidth = 20;
			var scrollBy = navItemWidth;	
			jQuery('div#scrollPrevHorizontal<?php echo $modID?>, div#scrollNextHorizontal<?php echo $modID?>').css('height',scrollButtonHeight).css('width',scrollButtonWidth);
			jQuery('div#scrollPrevHorizontal<?php echo $modID?>').css('left',0);
			jQuery('div#scrollNextHorizontal<?php echo $modID?>').css('left',scrollAreaWidth+20);
			jQuery('div#slideShowNav<?php echo $modID?>').css('width',scrollAreaWidth+40);
			jQuery('div#scrollContainer<?php echo $modID?>').css('marginLeft',scrollButtonWidth);
			jQuery('div#ssPager<?php echo $modID?>').css('height',scrollAreaHeight).css('width',scrollTotalWidth);
			jQuery('div#scrollContainer<?php echo $modID?>').css('width',scrollAreaWidth).css('height',scrollAreaHeight+2);
			jQuery(document).ready(function(){
				jQuery('div#scrollPrevHorizontal<?php echo $modID?>').click(function(){
					newFrame = (scrollFrame/1)-1;
					newOffset = scrollOffset+scrollBy;
					newOffsetAttr = newOffset + "px";
					if(newFrame > 0){
						jQuery('div#ssPager<?php echo $modID?>').stop().animate({left : newOffsetAttr}, 800);
						scrollFrame = newFrame;
						scrollOffset = newOffset;

					}
				});
				jQuery('div#scrollNextHorizontal<?php echo $modID?>').click(function(){
					newFrame = (scrollFrame/1)+1;
					newOffset = scrollOffset-scrollBy;
					newOffsetAttr = newOffset + "px";
					if(newFrame <= scrollCount){
						jQuery('div#ssPager<?php echo $modID?>').stop().animate({left : newOffsetAttr}, 800);
						scrollFrame = newFrame;
						scrollOffset = newOffset;

					}
				});
			});
		<?php }?>
		
	<?php endif;?>
	
	
		
	
	
	
});
 //--><!]]> 
</script> 

<div class="jbclear"></div>

<!-- Joomla Bamboo  Slideshow 3 ends here -->

<?php }  ?>