<?php
/* JB JBLibrary - loads Jquery and the png fix into the head of your template
 
*
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die( "Direct Access Is Not Allowed" );
global $mainframe;

$mainframe->registerEvent( 'onAfterInitialise', 'plgJBLibrary' );

function plgJBLibrary() {
	global $mainframe;
		$plg_name               = "plg_jbLibrary";
	  	$plugin =& JPluginHelper::getPlugin('system',$plg_name);
		$pluginParams = new JParameter( $plugin->params );
		$source					= $pluginParams->get('source','google');	
		$jQueryVersion = $pluginParams->get('jQueryVersion','1.3.2');
		$ie6Warning = $pluginParams->get('ie6Warning',1); 
		$scrolltop = $pluginParams->get('scrollTop',1);
		$lazyLoad = $pluginParams->get('lazyLoad',1);
		$scrollStyle = $pluginParams->get('scrollStyle','dark');
		$scrollText = $pluginParams->get('scrollText','^ Back To Top');
		$llSelector = $pluginParams->get('llSelector','img');
		
		if($llSelector == "") $llSelector = "img";
		
		
	//module base
	$modbase = ''.JURI::root (true).'/plugins/system/jbLibrary/';
	$document =& JFactory::getDocument();

	//Dont Add Jquery in Admin
	if($mainframe->isAdmin()){return;}
   
   	// Load Mootools first
   	JHTML::_(' behavior.mootools');
   	
   	
   	if ($jQueryVersion == "1.2.6") {
			
			if ($source == "local") {
				$document->addScript($modbase . "jquery-1.2.6.pack.js"); 
				$document->addScriptDeclaration("jQuery.noConflict();");
			}
			
			if ($source == "google") {
				$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js");
				$document->addScriptDeclaration("jQuery.noConflict();");
			}
	
   	}
   	
   	if ($jQueryVersion == "1.3.2") {
			
			if ($source == "local") {
				$document->addScript($modbase . "jquery-1.3.2.min.js"); 
				$document->addScriptDeclaration("jQuery.noConflict();");
			}
			
			if ($source == "google") {
				$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js");
				$document->addScriptDeclaration("jQuery.noConflict();");
			}
	
   	}

	if ($jQueryVersion == "1.4.2") {
			
			if ($source == "local") {
				$document->addScript($modbase . "jquery-1.4.2.min.js"); 
				$document->addScriptDeclaration("jQuery.noConflict();");
			}
			
			if ($source == "google") {
				$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
				$document->addScriptDeclaration("jQuery.noConflict();");
			}
	
   	}
   	
   	
   	if ($ie6Warning) { 
   		
   			$jbLib = '
   			
   			<!--[if lte IE 6]>
   			<script type="text/javascript" src="'.$modbase.'jquery.badBrowser.js"></script> 
   			 <![endif]-->
   			 ';
			$mainframe->addCustomHeadTag($jbLib);		
   			 
   			
	 }
   	
   	

		
   	
   	//Detect Browser
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$browser = substr("$browser", 25, 8);
	
	//Load Scroll To Top if Not IE6
	if ($scrolltop and ($browser != "MSIE 6.0")){
		$document->addScriptDeclaration("jQuery(document).ready(function(){
			jQuery(function () {
		var scrollDiv = document.createElement('div');
		jQuery(scrollDiv).attr('id', 'toTop').html('".$scrollText."').appendTo('body');    
		jQuery(window).scroll(function () {
		        if (jQuery(this).scrollTop() != 0) {
		            jQuery('#toTop').fadeIn();
		        } else {
		            jQuery('#toTop').fadeOut();
		        }
		    });
		    jQuery('#toTop').click(function () {
		        jQuery('body,html').animate({
		            scrollTop: 0
		        },
		        800);
		    });
		});
		
		});
		");
		
		
		if($scrollStyle == "dark")
		{
			$document->addStyleDeclaration("#toTop {width:100px;z-index: 10;border: 1px solid #333; background:#121212; text-align:center; padding:5px; position:fixed; bottom:0px; right:0px; cursor:pointer; display:none; color:#fff;text-transform: lowercase; font-size: 0.9em;}");
		}
		if($scrollStyle == "light")
		{
			$document->addStyleDeclaration("#toTop {width:100px;z-index: 10;border: 1px solid #eee; background:#f7f7f7; text-align:center; padding:5px; position:fixed; bottom:0px; right:0px; cursor:pointer; display:none;  color:#333;text-transform: lowercase; font-size: 0.9em;}");
		}
	}
	
	if ($lazyLoad){
		$document->addScript($modbase . "jquery.lazyload.js");
		$document->addScriptDeclaration('jQuery(document).ready(function(){jQuery("'.$llSelector.'").lazyload({ 
	    effect : "fadeIn" 
	    });
	});');
	}
	
}  
?>