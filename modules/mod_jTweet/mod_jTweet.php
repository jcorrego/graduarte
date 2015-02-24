<?php
/**
* @version $Id: mod_jTweet.php 6087 2006-12-24 18:59:57Z robs $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;
$document =& JFactory::getDocument();
$modbase = ''.JURI::base().'modules/mod_jTweet/';


$css	= $params->get( 'css', '1' );



$moduleID	= $params->get( 'moduleID', '1' );

$type	= $params->get( 'type', 'query' );
$twitterBird	= $params->get( 'twitterBird', 'bird1' );
$joinText	= $params->get( 'joinText', 'auto' );
$tweetSource		= $params->get('tweetSource','yes');
$twitterName = $params->get('twitterName','yes');
$noReplies = $params->get('noReplies','no');
$tweetTemplate = $params->get('tweetTemplate','1');
$userName	= $params->get( 'userName', 'joomlabamboo' );
$query	= $params->get( 'query', 'joomlabamboo' );
$avatar	= $params->get( 'avatar', 'no' );
$avatarSize	= $params->get( 'avatarSize', '48' );
$count	= $params->get( 'count', 5 );
$autoDefault	= $params->get( 'autoDefault', 1 );
$autoEd	= $params->get( 'autoEd', 1 );
$autoIng	= $params->get( 'autoIng', 1 );
$autoReply	= $params->get( 'autoReply', 1 );
$autoUrl	= $params->get( 'autoUrl', 1 );
$loadingText	= $params->get( 'loadingText', 1 );
$introText	= htmlspecialchars($params->get( 'introText', 1 ),ENT_QUOTES);
$popup = $params->get('popup','yes');
$popupIntro = htmlspecialchars($params->get('popupIntro','I am on Twitter!'),ENT_QUOTES);
$moreInfo = htmlspecialchars($params->get('moreInfo','More Info'),ENT_QUOTES);
$follow	= $params->get( 'follow', 'yes' );
$followMeText	= $params->get( 'followText', "Follow me on twitter" );
$twitterAction = htmlspecialchars($params->get('twitterAction','tweeted'),ENT_QUOTES);
$sourcePre = htmlspecialchars($params->get('sourcePre','from'),ENT_QUOTES);

$userName = str_replace(" ","",$userName);

// Load script references into the head
$document->addScript($modbase . "js/jquery.tweet.js");

if($css) {
$document->addStyleSheet($modbase.'css/jTweet.css');
}

if($type == "query") {
	$popup = 'no';
}

if ($type == "multi") {
	$popup = 'no';
	$multiUsers = explode(",",$userName);
	$userName = $multiUsers[0];
	$userNameList = implode("+from:",$multiUsers);
}
if($type == "tweets") {
	$multiUsers = explode(",",$userName);
	$userName = $multiUsers[0];
}
$tweetScript = "jQuery.noConflict();jQuery(document).ready(function(){jQuery('.tweet$moduleID').tweet({";
if ($avatar == 'yes') { 
	$tweetScript .= "avatar_size: ".$avatarSize.",";
}
$tweetScript .= "count: ".$count.",";
$tweetScript .= "popup_intro: '".$popupIntro."',";
$tweetScript .= "popup_info: '".$popup."',";
$tweetScript .= "tweet_source: '".$tweetSource."',";
$tweetScript .= "twitter_name: '".$twitterName."',";
$tweetScript .= "suppress_replies: '".$noReplies."',";
$tweetScript .= "tweet_template: '".$tweetTemplate."',";
$tweetScript .= "twitter_action: '".$twitterAction."',";
$tweetScript .= "source_pre: '".$sourcePre."',";
if ($type == 'query') {
	$tweetScript .= "query: '".$query."',";
} 
elseif ($type == 'tweets') {
	$tweetScript .= "username: '".$userName."',";
}
else{
	$tweetScript .= "multiuser: '".$userNameList."',";
}
if ($joinText == 'auto') {
	$tweetScript .= "join_text: '".$joinText."',auto_join_text_default: '".$autoDefault."',auto_join_text_ed: '".$autoEd."',auto_join_text_ing: '".$autoIng."',auto_join_text_reply: '".$autoReply."',auto_join_text_url: '".$autoUrl."',";
}
$tweetScript .= "loading_text: '".$loadingText."'});})"; 


$document->addScriptDeclaration($tweetScript);
$document->addScriptDeclaration("jQuery(document).ready(function () {
  jQuery('.bubbleInfo').each(function () {
    // options
    var distance = 10;
    var time = 250;
    var hideDelay = 500;

    var hideDelayTimer = null;

    // tracker
    var beingShown = false;
    var shown = false;
    
    var trigger = jQuery('.trigger', this);
    var popup = jQuery('.popup', this).css('opacity', 0);

    // set the mouseover and mouseout on both element
    jQuery([trigger.get(0), popup.get(0)]).mouseover(function () {
      // stops the hide event if we move from the trigger to the popup element
      if (hideDelayTimer) clearTimeout(hideDelayTimer);

      // don't trigger the animation again if we're being shown, or already visible
      if (beingShown || shown) {
        return;
      } else {
        beingShown = true;

        // reset position of popup box
        popup.css({
          top: -20,
          left: 90,
          display: 'block' // brings the popup back in to view
        })

        // (we're using chaining on the popup) now animate it's opacity and position
        .animate({
          top: '-=' + distance + 'px',
          opacity: 1
        }, time, 'swing', function() {
          // once the animation is complete, set the tracker variables
          beingShown = false;
          shown = true;
        });
      }
    }).mouseout(function () {
      // reset the timer if we get fired again - avoids double animations
      if (hideDelayTimer) clearTimeout(hideDelayTimer);
      
      // store the timer so that it can be cleared in the mouseover if required
      hideDelayTimer = setTimeout(function () {
        hideDelayTimer = null;
        popup.animate({
          top: '-=' + distance + 'px',
          opacity: 0
        }, time, 'swing', function () {
          // once the animate is complete, set the tracker variables
          shown = false;
          // hide the popup entirely after the effect (opacity alone doesn't do the job)
          popup.css('display', 'none');
        });
      }, hideDelay);
    });
  });
});");
?>




<div class="jTweet">
	<?php if ($popup == "yes") :?>
	<div class="jTweetInfo">
		<div class="bubbleInfo">
			<div class="trigger">
					<?php if(!($twitterBird == "none")) :?>
						<img src="modules/mod_jTweet/images/<?php echo $twitterBird ?>.png" alt="twitter Bird" />
					<?php endif;?>
					<span class="triggerDetail"><?php echo $moreInfo ?></span>
			</div>
			<div class="popup"></div>
		</div>
	</div>
	<?php endif;?>
		
	<div class="tweet tweet<?php echo $moduleID;?>">
	</div>
	<?php if (!($popup == "yes")) :?>
		<div class="noPopup">
			<?php if(!($twitterBird == "none")) :?>
			<img src="modules/mod_jTweet/images/<?php echo $twitterBird ?>.png" alt="twitter Bird" />
			<?php endif;?>
			<?php if($follow == "yes") :?>
				<span class="triggerDetail"><a target="_blank" href="http://twitter.com/<?php echo $userName ?>/"><?php echo $followMeText ?></a></span>
			<?php endif;?>
		</div>
		<?php endif;?>
</div>
<div class="jTweetClear"></div>
