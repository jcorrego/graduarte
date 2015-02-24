<?php // no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;
$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_microblog/';
$id = $params->get( 'id', '1' );
$moduleID = $params->get('moduleID','1');
$type 		= intval( $params->get( 'type', 1 ) );
$count 		= intval( $params->get( 'count', 5 ) );
$wordCount	= $params->get( 'wordCount','');
$tags	= $params->get( 'allowed_tags', '10' );
$displayMore	= $params->get( 'displayMore', '1' );
$show_front	= $params->get( 'show_front', 1 );
$showintro	= $params->get( 'showintro', 1 );
$showdate	= $params->get( 'showdate', 1 );
$titlelink	= $params->get( 'titlelink', '1' );
$showtitle	= $params->get( 'showtitle', 'yes' );
$readonText	= $params->get( 'readonText', 'Click to read more.' );
$date = $params->get( 'dateFormat', "0" );
$loadScripts = $params->get( 'loadScripts', "0" );
$loadMBcss = $params->get( 'loadMBcss', "0" );
$loadCBcss = $params->get( 'loadCBcss', 1 );
$cbTheme = $params->get( 'cbTheme', 1);
$stripTags = $params->get('strip_tags',0);
$introSuffix = $params->get('introSuffix','...');

// ColorBox - Content Gallery Options
$colorBox	= $params->get( 'colorBox', '1' );
$popupGallery = $params->get('popupGallery','1');
$overlayOpacity = $params->get('overlayOpacity','0.6');
$frameWidth = $params->get('frameWidth','800');
$frameHeight = $params->get('frameHeight','400');
$colorboxScrolling = $params->get('colorboxScrolling','false');


// Fade Effect
$fadeEffect = $params->get('fadeEffect','1');

$layout	= $params->get( 'layout', 'intro' );

$resizeImage = $params->get('resizeImage',1);
$crop_height = $params->get( 'crop_height', '1');
$crop_width = $params->get( 'crop_width','2');
$image_width = $params->get( 'image_width','170');
$image_height = $params->get( 'image_height','85');

$displayImages = $params->get( 'displayImages','article');
$imagesPerRow = $params->get( 'imagesPerRow','3');
$rightMargin = '0';
$leftMargin = '0';

$imageNumber = 0;
$startDiv = 0;
$imgRightMargin = 0;
$floatImage = 'left';

//K2
$showCommentCount	= $params->get('showCommentCount','yes');

$renderPlugin	= $params->get('renderPlugin','render');

if($loadCBcss and $colorBox){
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


if ($loadMBcss) {
$document->addStyleSheet($modbase.'css/microblog.css');
}
if ($loadScripts) {
// Load script references into the head
$document->addScript($modbase . "js/jquery.colorbox-min.js");
}

// Fade Effect on thumbnail images
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

// Zoom Effects for Fancy Box
if ($colorBox) {
	$colorboxGallery = $popupGallery ? 'mbgallery'.$moduleID : 'nofollow';
	$document->addScriptDeclaration("jQuery(document).ready(function(){
		jQuery('a.cBox$moduleID, a.cBoxi$moduleID, a.cBoxr$moduleID').each(function(){
			var mbTarget = jQuery(this).attr('href');
			jQuery(this).colorbox({
				'inline': true,
				'href': mbTarget,
				'opacity': '$overlayOpacity',
				'scrolling': $colorboxScrolling,
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



// Settings for the Column Widths in column display


	if ($imagesPerRow =="1") {
	$colWidth ="100%";
	$rightMargin ="0";
	}
	
	if ($imagesPerRow =="2") {
	$colWidth ="47%";
	$rightMargin = "5%";
	}

	if ($imagesPerRow =="3") {
	$colWidth ="30%";
	$rightMargin = "5%";
	}

	if ($imagesPerRow =="4") {
	$colWidth ="22%";
	$rightMargin = "3%";
	}
	
	if ($imagesPerRow =="5") {
	$colWidth ="17%";
	$rightMargin = "3%";
	}
	if ($imagesPerRow =="6") {
	$colWidth ="13%";
	$rightMargin = "4%";
	}


// Date Variables
if ($date=="0") {
      $dateFormat="<span class='mbDay'>%d</span> <span class='mbMonth'>%b</span>, <span class='mbYear'>%y</span>";
}
elseif ($date=="1") {
      $dateFormat="<span class='mbMonth'>%b</span> <span class='mbDay'>%d</span>, <span class='mbYear'>%y</span>";
}
elseif ($date=="2") {
      $dateFormat="<span class='mbMonth'>%B</span> <span class='mbDay'>%d</span>, <span class='mbYear'>%y</span>";
}
elseif ($date=="3") {
      $dateFormat="<span class='mbDay'>%d</span> <span class='mbMonth'>%B</span>, <span class='mbYear'>%y</span>";
}
elseif ($date=="4") {
      $dateFormat="<span class='mbMonth'>%B</span> <span class='mbDay'>%d</span>, <span class='mbYear'>%Y</span>";
}
elseif ($date=="5") {
      $dateFormat="<span class='mbDay'>%d</span> <span class='mbMonth'>%B</span>, <span class='mbYear'>%Y</span>";
}
elseif ($date=="6") {
      $dateFormat="<span class='mbDay'>%d</span>/<span class='mbMonth'>%m</span>/<span class='mbYear'>%y</span>";
}
elseif ($date=="7") {
      $dateFormat="<span class='mbDayName'>%A</span> <span class='mbDay'>%d</span> <span class='mbMonth'>%B</span>, <span class='mbYear'>%Y</span>";
}
elseif ($date=="8") {
      $dateFormat="<span class='mbDayName'>%a</span> <span class='mbDay'>%d</span> <span class='mbMonth'>%b</span>, <span class='mbYear'>%y</span>";
}
elseif ($date=="9") {
      $dateFormat="<span class='mbMonth'>%b</span> <span class='mbDay'>%d</span> ";
}
elseif ($date=="10") {
      $dateFormat="<span class='mbDay'>%d</span> <span class='mbMonth'>%b</span>";
}

 

// Function that limites the word count
if(!function_exists('string_limit_words')) {
		 function string_limit_words($introText, $wordCount) {
		     $id = explode(' ', $introText);
		     return implode(' ', array_slice($id, 0, $wordCount));
		   }
		}
		if($list)
		{
		$numMB = sizeof($list);	
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
		
		if($wordCount == '0'){
			$item->introtext = "";
		}


// Assigns the last image in the row to have 0 margin		
		$imageNumber++;
		$imgRightMargin = ($imageNumber % $imagesPerRow) ? $rightMargin : 0;
		$rowFlag = ($imageNumber % $imagesPerRow) ? 0 : 1;
		
		
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
if($stripTags) {		
	$introText = strip_tags($item->introtext, $tags);
}else {$introText = $item->introtext;}

// Logic for link behaviour
if ($colorBox) {
$linkbehaviour ="id='inline$item->id$moduleID' class='cBox$moduleID' rel='mbgallery$moduleID' href='#mbpopup$item->id$moduleID' title='$item->title'";
$linkbehaviourImage ="id='inlineIMG$item->id$moduleID' class='cBoxi$moduleID' rel='mbgalleryi$moduleID' href='#mbpopup$item->id$moduleID' title='$item->title'";
$linkbehaviourReadon ="id='inlineRO$item->id$moduleID' class='cBoxr$moduleID readon' rel='mbgalleryr$moduleID' href='#mbpopup$item->id$moduleID' title='$item->title'";
} 

if (!($colorBox)) {
$linkbehaviour ="href='$item->link '";
$linkbehaviourReadon ="href='$item->link ' class='readon'";
$linkbehaviourImage ="href='$item->link '";
} 

$flatWidth = ""; 

if (!($displayMore or $showdate )) { 
$flatWidth = "full"; 	
 	
 }


// Flat Layout
if ($layout=="flat") {
?>
<div class="mbWrapFlat">
		<div class="mbitemFlat <?php echo $flatWidth ?>">
		
				<?php if ($displayImages != "no" ) {
					
							if (!($firstImage == "")) { ?>
								<a <?php echo $linkbehaviourImage ?>>
										<?php if($resizeImage) { ?><img src="modules/mod_microblog/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" alt="<?php echo $item->title; ?>" class="mbImageFlat fade" />
										<?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" alt="<?php echo $item->title; ?>" class="mbImageFlat fade" />
										<?php }?>
								</a>
							<?php } 
					}
				?>
				
				
				<?php if ($titlelink) { ?>
				<h2>
						<?php if ($titlelink == '2') { ?><a <?php echo $linkbehaviour ?>><?php }?>
									<?php echo $item->title; ?>
						<?php if ($titlelink == '2') { ?></a><?php }?>
				</h2>
				<br />
				<?php }?>
					
				<?php if ($showintro) { ?>
						<?php  if(is_numeric($wordCount)) {echo string_limit_words($introText, $wordCount);} else {echo $introText;} ?><?php echo $introSuffix; ?>
				<?php } ?>
		</div>
				<?php if ($displayMore or $showdate ) { ?>
				<div class="mbDetailsFlat">
							<?php if ($showdate) { ?>
					
									<div class="microdateFlat">
											<?php echo JHTML::Date($item->created, "$dateFormat"); ?>
									</div>
					
							<?php } ?>
							
							<?php if ($displayMore) { ?>
							<div class="mbMoreFlat">
									<a <?php echo $linkbehaviourReadon ?>><?php echo $readonText ?></a>
							</div>
							<?php } ?>
					</div>
					<?php } ?>

			</div>
<?php } 

// Columns Layout
elseif ($layout=="columns") { 
	if (($imageNumber == 1) or ($startDiv)) {
		$startDiv = 0;
		
	?>
	<div class="mbRow">
	<?php }?>
<div class="mbWrap<?php echo $imagesPerRow ?> mbWrap" style="width:<?php echo $colWidth ?>;margin-right:<?php echo $imgRightMargin ?>">
		<div class="item<?php echo $imageNumber ?>">
			<div class="mbitemCols">
		
				<?php if ($displayImages != "no" ) {
				
					  if (!($firstImage == "")) { ?>
						<div class="mbColImage">
								<a <?php echo $linkbehaviourImage ?>>
										<?php if($resizeImage) { ?><img src="modules/mod_microblog/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" alt="<?php echo $item->title; ?>" class="mbImage fade" />
										<?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" alt="<?php echo $item->title; ?>" class="mbImage fade" />
											<?php }?>	
								</a>
				</div>
						<?php } 
				}
				
				?>
							
				<div class="mbClear"></div>			
				
				<?php if ($titlelink) { ?>
				<h2>
						<?php if ($titlelink == '2') { ?><a <?php echo $linkbehaviour ?>><?php }?>
									<?php echo $item->title; ?>
						<?php if ($titlelink == '2') { ?></a><?php }?>
				</h2>
				<br />
				<?php }?>
				
				<div class="mbClear"></div>
				<?php if ($showdate) { ?>
							<div class="mbDateCols">
									<?php echo JHTML::Date($item->created, "$dateFormat"); ?>
							</div>
							
							<?php }?>
				<div class="mbClear"></div>			
				<?php if ($showintro) : ?>
				<div class="mbIntroCols">
						<?php  if(is_numeric($wordCount)) {echo string_limit_words($introText, $wordCount);} else {echo $introText;} ?><?php echo $introSuffix; ?>
				</div>
				<?php endif; ?>
		</div>
		<div class="mbClear"></div>
				<?php if ($displayMore) { ?>

				<div class="mbDetailsCols">
							
							<div class="mbMoreCols">
									<a <?php echo $linkbehaviourReadon ?>><?php echo $readonText ?></a>
							</div>
					</div>
					<?php }?>

			</div>
</div>

<?php 
if (($imageNumber == $numMB) or ($rowFlag))
{
	$startDiv = 1;
?>
	</div>
	<div class="mbClear"></div>
<?php 
}

} 

// Columns Layout
elseif ($layout=="dateTitle") { ?>
<ul class="mbList">
					<li>
						<a <?php echo $linkbehaviour ?>><span class='mbIntroLink'><?php echo $item->title; ?></span>
						<?php if ($showdate) { ?><span class='mbIntrolistdate'><?php echo JHTML::Date($item->created, "$dateFormat"); }?>
	 					</span></a>
							
					</li>
			</ul>


<?php } 



// Leading Layout
elseif ($layout=="intro") { ?>
<div class="mbWrapIntro">
<?php if ($imageNumber =="1") { ?>



		<div class="mbitemIntro">
		
				<?php if ($displayImages != "no") {
				
							if (!($firstImage == "")) { ?>
									<a <?php echo $linkbehaviourImage ?>>
										<?php if($resizeImage) { ?><img src="modules/mod_microblog/image.php?width=<?php echo $image_width ?>&amp;=<?php echo $image_height ?>&amp;cropratio=<?php echo $crop_width ?>:<?php echo $crop_height ?>&amp;image=<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" alt="<?php echo $item->title; ?>" class="mbImageIntro fade" />
										<?php } else {?><img src="<?php echo JURI::root( true ) ?>/<?php echo $firstImage ?>" alt="<?php echo $item->title; ?>" class="mbImageIntro fade" />
												<?php }?>
									</a>
							<?php } 
				} ?>
				
				
				<?php if ($titlelink) {?>
				<h2>
						<?php if ($titlelink == '2') { ?><a <?php echo $linkbehaviour ?>><?php }?>
									<?php echo $item->title; ?>
						<?php if ($titlelink == '2') { ?></a><?php }?>
				</h2>
				<br />
				<?php }?>
				
				<?php if ($showdate) { ?>
				<div class="mbdateIntro ">
						<span class="introDate"><?php echo JHTML::Date($item->created, "$dateFormat"); ?></span>
				</div>
				<?php } ?>
				
				<?php if ($showintro) { ?>
						<?php if(is_numeric($wordCount)) {echo string_limit_words($introText, $wordCount);} else {echo $introText;} ?><?php echo $introSuffix; ?>
				<?php } ?>
				<?php if ($displayMore) { ?>
				<div class="mbMoreIntro">
						<a <?php echo $linkbehaviourReadon ?>><?php echo $readonText ?></a>
				</div>
					<?php } ?>
				
				
		</div>
				

	<?php } 
	
	
	if ($imageNumber >"1") { ?>
	
			<ul class="mbList">
					<li>
							<a <?php echo $linkbehaviour ?>><?php echo $item->title; ?>
							<?php if ($showdate) { ?>
							<span class='mbIntrolistdate'><?php echo JHTML::Date($item->created, "$dateFormat"); ?></span>
							<?php } ?>
							</a>
					</li>
			</ul>

		<?php } ?>
		</div>
		<?php } 

		if ($colorBox) { ?>
				<!-- Start Joomla Bamboo Microblog Inline Content -->
				<div style="display:none">
				<div id="mbpopup<?php echo $item->id.$moduleID; ?>">
						<h2 class="popupTitle"><?php echo $item->title; ?></h2>
						<div class="popupIntroText">
								<?php echo $item->introtext ?>
						</div>
						<div class="mbClear"></div>
						<div class="popupFullText">
								<?php echo $item->fulltext ?>
						</div>
				</div>
				</div>
				<!-- End Joomla Bamboo Microblog Inline Content -->
	<?php } 



					
endforeach; }


?>
	<div class="mbClear"></div>
