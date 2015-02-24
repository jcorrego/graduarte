<?php
/**
* Javascript object for list plugin
*
* @version		$Id: list.js.php 298 2009-09-05 12:20:10Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
ob_start();


function getExtension( $filename ){return strtolower( array_pop( explode('.', $filename ) ));}
$dir = './common_lists/';
$lists = array();
if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false) {
		if(is_dir( $dir . $file ))continue;
		if( getExtension( $file ) != 'list')continue;
		$index = basename( $file, '.list' );
		$list = str_replace( "\r\n" , "\n" , file_get_contents( $dir . $file ));
		$lists[$index] = explode("\n", $list );
    }
    closedir($dh);
}
$buffer = "var commonLists = {\n";
$listEntries = array();
foreach( $lists as $name => $list ){
		
		$l = implode("\\n",$list);
		$listEntries[] = "'$name' : \"$l\"";	
		
}
$buffer .= "\t".implode(",\n\t",$listEntries)."\n";
$buffer .= "};\n\n";
 
echo $buffer;
?>
var list = new Class({
	
	Extends : CLabeledElement,
    adapt : function( from ){
	
		this.position=from.position?from.position:this.position;
		this.hash=from.hash?from.hash:this.hash;
		this.label=from.label?from.label:this.label;
		this.css=from.css?from.css:this.css;
		this.lw=from.lw?from.lw:this.lw;
		this.lh=from.lh?from.lh:this.lh;
		this.cw=from.cw?from.cw:this.cw;
		this.ch=from.ch?from.ch:this.ch;
		this.required=from.required?from.required:this.required;
		this.elements=from.elements?from.elements:this.elements;
		this.multi=from.multi?from.multi:this.multi;
		this.commonList=from.commonList?from.commonList:this.commonList;
		this.defaultValue=from.defaultValue?from.defaultValue:this.defaultValue;
		this.onUpdate();
		
	},
	
	initialize: function( parent, id, beforeObject, params ) {
	
		this.type	       = "list";

		//Call super class constructor "I understand it is inproperly called "as it should be first call in the method"
		this.parent($(parent), id, $(beforeObject), params);
	
		this.elements   = params.elements;
		this.multi      = params.multi;
		this.ch	   	    = params.ch;
		this.cw	   	    = params.cw;
		this.commonList = params.commonList;
		this.css        = params.css;
		var brClear = new Element('br', {'clear':'all'});
		
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
		//Input element Resize handle	
		this.htmlControlResize = new Element('img',{
			'src': './corner.png',
			'id': 'resizeHandle_control_' + this.type + this.index,
			'class': 'resize-handle'
		});
		this.htmlControlResize.inject( this.htmlContainer );
	
		this.htmlInput  = new Element('select', {
			'name':'input_' + this.type + this.index,
			'id':'input_' + this.type + this.index,
			'styles':{
				'width': this.cw + 'px',
				'height':this.ch + 'px'
			},
			'multiple' : this.multi
		});
	
	
		if(this.multi){
			this.htmlInput.makeResizable({
				handle:this.htmlControlResize,
				onDrag:dispatch_onResizeDrag,
				onComplete:dispatch_onResizeEnd,
				limit:{x:[50,200],y:[20,200]}
			});	
		} else {
			this.htmlInput.makeResizable({
				handle:this.htmlControlResize,
				onDrag:dispatch_onResizeDrag,
				onComplete:dispatch_onResizeEnd,
				modifiers: {x: 'width', y: false},
				limit:{x:[50,200]}
			});	
		}
	
		var e = null;
		
		
		if(this.elements.length == 0){
			e = new Array();
		} else {
			e = this.elements.split("\n");
		}
		
		this.defaultValueArray = params.defaultValue.split(',');
		
		//Clear this list
		this.htmlInput.options.length = 0;
		//Reload it
		for(i=0;i<e.length;i++){
			
			var o = new Option( e[i], i);

			o.selected = false;			
			for( j=0; j<this.defaultValueArray.length; j++ ){
				
				//Fix for IE
				if( Browser.Engine.trident4 )c=e[i-1]
				else c=e[i];
				
				if(this.defaultValueArray[j] == c ){
					o.selected = true;
				}
			}
			this.htmlInput.options[i] = o;
			
		}
		
		if( this.commonList != "Manual" ){
			$('ppage_list_elements').disabled = true;
		} else {
			$('ppage_list_elements').disabled = false;
		}
	
		this.htmlInput.inject( this.htmlContainer );
		brClear.inject( this.htmlContainer );
			
		this._alignControlResizeHandle();
	
	},
	
	onUpdate : function(){
	
		this._updateDefault();

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

		if( this.commonList != "Manual" ){
			this.elements = commonLists[this.commonList];
			$('ppage_list_elements').disabled = true;
			$('ppage_list_elements').value = this.elements;
		} else {
			$('ppage_list_elements').disabled = false;
		}
		

		var e = this.elements.split("\n");
		this.htmlInput.options.length = 0;
		this.htmlInput.multiple = this.multi;
		for(i=0;i<e.length;i++){
		
			var o = new Option( e[i], i);
			o.selected = false;
			for(j=0;j<this.defaultValueArray.length;j++){
				if(this.defaultValueArray[j] == e[i] ){
					o.selected = true;
					break;
				}
			}
			this.htmlInput.options[i] = o;
		}
	
		//Modify resize options based on list "mult select" property
		if(this.multi){
			this.htmlInput.makeResizable({
				handle:this.htmlControlResize,
				onDrag:dispatch_onResizeDrag,
				onComplete:dispatch_onResizeEnd,
				limit:{x:[50,400],y:[50,400]}
			});		
		} else {
			this.htmlInput.makeResizable({
				handle:this.htmlControlResize,
				onDrag:dispatch_onResizeDrag,
				onComplete:dispatch_onResizeEnd,
				modifiers: {x: 'width', y: false},
				limit:{x:[50,400]}
			});	
			this.htmlInput.set('styles', {'height':'auto'});
		}
		this._alignControlResizeHandle();

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
		
			case 'label':
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

		var controlCoordinates = this.htmlInput.getCoordinates();
		
		var imgSize = this.htmlControlResize.getSize();
		
		var x =  controlCoordinates.right   + this.pixelCorrection;
	
		//A fix for very long lists , control top is being reported to be MUCH beyond -10000px on FF , it is reported correctly if the element has "multiple" turned on
		var y =  controlCoordinates.bottom - imgSize.y + this.pixelCorrection;
		if(  y < -10000 ){
			var lblCoords = this.htmlLabel.getCoordinates();
			y = lblCoords.top + 20 - imgSize.y + this.pixelCorrection;
		}
		
		
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

		if( this.commonList != "Manual" ){
			$('ppage_list_elements').disabled = true;
		} else {
			$('ppage_list_elements').disabled = false;
		}
	
	},

	_updateDefault: function(){
  		
		this.defaultValueArray = new Array();
		for(i=0;i<this.htmlInput.options.length;i++){
			if(this.htmlInput.options[i].selected){
				this.defaultValueArray.push(this.htmlInput.options[i].text);
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
		
		this.defaultValue	= this.defaultValueArray.join(',');
		
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
			elements:this.elements, 
			multi:this.multi,
			commonList:this.commonList,
			defaultValue:this.defaultValue
		});
	}
  
});
<?php
$fileData = ob_get_contents();
ob_end_clean();
header('Content-type: application/javascript');
header('Content-Length: '.strlen($fileData));
echo $fileData;
