<?php 
/**
*  Main Javascript functions for the WYSIWYG form editor
*
* @version		$Id: core.js 119 2009-04-04 14:11:29Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>

//The array that holds all the elements in the WYSIWYG area
var elementArray = new Array();

//Keeps track of the selectedElement
var selectedElement = null;

//Used to give each element a unique id
var autoIncrement   = 0;

var correctionPixels = Browser.Engine.trident?10:0;


//Holds ids of parameters , used for Multilingual support
var paramIdList = '';

//Holds a list of elements that need storage space
//The form shouldn't be created unless it has atleast one field that requires storage space "textbox,textarea,etc" and a submit button
//Will be filled by php
var obligatoryList = new Array();

var workspaceSortable = null;

function refreshSelectedElement(){
	if( selectedElement != null ){
		selectedElement.select();
	}
}

/**
 *  Retrieves the order of any given element within the WYSIWYG list,
 *
 * @param {Object} li : List item whose order is to be retrieved
 * @return{int} the 0-based order of the element within the list or -1 if the element couldn't be found
 */
function getOrder( li ) {
	
	var a = workspaceSortable.serialize();
	
	for(i=0;i<a.length;i++){
		if(a[i] == $(li).get('id')){
			return i;
		}
	}
	return -1;
}

 /**
 *  Retrieves the element found the given position within the WYSIWYG list.
 * 
 * @param {int} the 0-based order of the element within the list or -1 if the element couldn't be found
 * @return{Object} li : List item whose order is to be retrieved
 */
function getLiAt( index ){

	var a = workspaceSortable.serialize();
	
	if( a[index] )return a[index];
	return null;
	
}

/**
 *  Determines Where to insert new elements based on the coordinates where they were dropped
 * 
 * @param {int} x : X Coordinate "left"
 * @param {int} y: Y Coordinate "right"
 * @return{object} the element before which the new element should be inserted, null is returned if it should be inserted at the last position
 */
function beforeWhich( x, y){
	
	
	var e = $('clist').getChildren();
	for(i=0;i<e.length;i++){
		
	
		if(e[i].get('tag') == 'li'){
		
			var coords = e[i].getCoordinates();
		
			var xMatch = ( x >  coords.left && x < coords.right );
			var yMatch = ( y >  coords.top && y < coords.bottom );
			
			if( xMatch && yMatch ){
				
				var halfHeight = coords.height / 2;
				if( (coords.bottom - y) < halfHeight ){
					//Lower half?
					if( i+1 < e.length ){
						return e[i+1];
					} else {
						return null;
					}
				
				} else {
					//Upper half?
					return e[i]
				}
			}
		}
	}
	return null;
	
}
  
/**
 *  Retrieves the index of an element in  "elementArray" when given the "li" container element
 * 
 * @param {Object} li : li Container for the element
 * @return{int} the index within the elementArray list or -1 if the element is not found "deleted"
 */
function getIndexFromContainerElement(e){
	for(i=0;i<elementArray.length;i++){
		if( elementArray[i] == null )continue;
		if( elementArray[i].htmlContainer == e )return i;
	}
	return -1;
}



/**
 * Hides all Property pages.
 * 
 */
function hideAllPropertyPages(){

	//All property pages have .ppage css class
	propertyPages = $$(".ppage");
	
	//Loop through them all hide them
	for(i=0;i<propertyPages.length;i++)
		propertyPages[i].style.display = "none";

}

function alignControls(){

	highestWidth = 0;
	for(i=0;i<elementArray.length;i++){
		if( elementArray[i].htmlInput != null ){
			var size = elementArray[i].htmlInput.getSize()
			if(size.x > highestWidth)highestWidth = size.x;
		}
	}
	for(i=0;i<elementArray.length;i++){
		if( elementArray[i].setControlSize != null ){
			elementArray[i].setControlSize(highestWidth,-1);
		}
	}
}
function alignLabels(){

	highestWidth = 0;
	for(i=0;i<elementArray.length;i++){
		if( elementArray[i].htmlLabel != null ){
			var size = elementArray[i].htmlLabel.getSize()
			if(size.x > highestWidth)highestWidth = size.x;
		}
	}
	for(i=0;i<elementArray.length;i++){
		if( elementArray[i].setLabelSize != null ){
			elementArray[i].setLabelSize(highestWidth,-1);
		}
	}
	
}

/**
 * Deselects all elements in the WYSIWYG area
 * 
 */
function unselectAllEntries(){
	for(i=0;i<elementArray.length;i++){
		if( elementArray[i] == null )continue;
		elementArray[i].deselect();
	}
	selectedElement = null;
}




/**
 *  Invokes the "serialize" method on all objects on the WYSIWYG field and collects the output to be sent to the server
 *
 */
function serializeFieldInformation(){
	
	//Separator between each field information
	var separator = "|||";
	
	//$('Debug').setHTML("");
	
	//Cumulative buffer
	var buffer    = "";
	
	//Loop through all elements invoking the "serialize" method
	
	//For some reason, when I use "i" as a loop counter things become messed up, the loop exits prematurely if I change the order of the elements
	var counter = 0;
	for(counter=0;counter<elementArray.length;counter++){
		
		//If a deleted element is encountered skup it to the next one
		if(elementArray[counter] == null)continue;
		
		//Place serialized element data into the cumulative buffer
		buffer += elementArray[counter].serialize() + separator;
	}
	
	//Move data to HTML "form" field
	$('fieldInformation').value = buffer;
	$('paramIds').value = paramIdList;
	
}

/**
 *  Called when the user clicks the save button (i.e submits the adminform)
 */
function submitbutton(pressbutton)
{
	var form = document.adminForm;
	if( pressbutton == "cancel" ){
		submitform( pressbutton );
		return;
	}
	
	
	var hasSubmitButton      = false;
	var hasObligatoryElement = false;
	var counter = 0;
	for(counter=0;counter<elementArray.length;counter++){
		
		//If a deleted element is encountered skip it to the next one
		if(elementArray[counter] == null)continue;
		
		//Is this element on the obligatory list? "i.e. Element types of which at least 1 must be present in the form"
		if( obligatoryList.contains( elementArray[counter].type ) ){
			hasObligatoryElement = true;
		}
		
		//Yes , I know, This is too "hardcoded" , Using plugin specific parameters in core context, sorry for that :P
		if( elementArray[counter].type == 'button' && elementArray[counter].func == 'Submit' ){
			hasSubmitButton = true;
		}
	}
	
	if( !hasObligatoryElement ){
		alert("<?php echo JText::_("You must have atleast one element that allows user input");?>");
		displayToolbar();
		return false;
	}

	if( !hasSubmitButton ){
		alert("<?php echo JText::_("You must have atleast one submit button in the form");?>");
		displayToolbar();
		return false;
	}
	
	if( form.elements['params[title]'].value.length == 0 ){
		alert("<?php echo JText::_("Your form must have a title"); ?>");
		displayFormSettings();
		return false;		
	}
	
	
	serializeFieldInformation();
	submitform( pressbutton );
	
	
}

/**
 *  Checks if a given element has reached maximum allowed number per-form
 * 
 * @param {string} type : the element type to check
 *@return(boolean) : whether or not has the element reached its limit
*
 */
function reachedLimit( type ){

	//0 means no limit
	if( countLimit[type] == 0 )return false;
	
	var count = 0;
	for(i=0;i<elementArray.length;i++){
	
		if( elementArray[i] == null )continue;
		if( elementArray[i].type == type )count++;
	}
	
	if( countLimit[type] <= count )return true;
	return false;

}

/**
 *  Generates a uniqueId, used for creating Hash values
  * @param {int} count : number of characters of the desired unique value
 * @return(string) : unique value of "count" character length
 */
function uniqueId( count ){
     var dateObject = new Date();
     var uniqueId =
          dateObject.getFullYear() + '' +
          dateObject.getMonth() + '' +
          dateObject.getDate() + '' +
          dateObject.getTime();
	var randomnumber = Math.floor(Math.random()*21321)
    var uid =  "h"+hex_sha1(uniqueId + randomnumber);
	return uid.substr(0,count);
}

/**
 *  Show Toolbar in the design view and hide everything else
 */
function displayToolbar(){

	var btn1 = $('tabButton1');
	var btn2 = $('tabButton2');
	var btn3 = $('tabButton3');
	
	btn1.removeClass('activated-tab-button');
	btn2.removeClass('activated-tab-button');
	btn3.removeClass('activated-tab-button');
	btn1.removeClass('tab-button');
	btn2.removeClass('tab-button');
	btn3.removeClass('tab-button');

	btn1.addClass('activated-tab-button');
	btn2.addClass('tab-button');
	btn3.addClass('tab-button');
	
	
	var divProperties = $('properties-container');
	var divControls = $('controls');
	var divSettings = $('settings');
	
	divProperties.style.display = 'none';
	divControls.style.display   = 'block';
	divSettings.style.display   = 'none';

}

/**
 *  Show Form Settings in the design view and hide everything else
 */
function displayFormSettings(){

	var btn1 = $('tabButton1');
	var btn2 = $('tabButton2');
	var btn3 = $('tabButton3');
	
	btn1.removeClass('activated-tab-button');
	btn2.removeClass('activated-tab-button');
	btn3.removeClass('activated-tab-button');
	btn1.removeClass('tab-button');
	btn2.removeClass('tab-button');
	btn3.removeClass('tab-button');

	btn1.addClass('tab-button');
	btn2.addClass('activated-tab-button');
	btn3.addClass('tab-button');
	
	
	var divProperties = $('properties-container');
	var divControls = $('controls');
	var divSettings = $('settings');
	
	divProperties.style.display = 'none';
	divControls.style.display   = 'none';
	divSettings.style.display   = 'block';
}

/**
 *  Show Element Properties in the design view and hide everything else
 */
function displayElementProperties(){

	var btn1 = $('tabButton1');
	var btn2 = $('tabButton2');
	var btn3 = $('tabButton3');
	
	btn1.removeClass('activated-tab-button');
	btn2.removeClass('activated-tab-button');
	btn3.removeClass('activated-tab-button');
	btn1.removeClass('tab-button');
	btn2.removeClass('tab-button');
	btn3.removeClass('tab-button');

	btn1.addClass('tab-button');
	btn2.addClass('tab-button');
	btn3.addClass('activated-tab-button');
	
	
	var divProperties = $('properties-container');
	var divControls = $('controls');
	var divSettings = $('settings');
	
	divProperties.style.display = 'block';
	divControls.style.display   = 'none';
	divSettings.style.display   = 'none';

}

/**
 *  Handles clicks on the "convert" button, prepares data and sends it to adapt()
 * 
 * @param {Object} selectObject : <select> object whose "convert" button has been clicked
*
 */
function convert( selectList ){

	var destination = selectList.options[selectList.selectedIndex].value;
	var source      = selectedElement;
	
	if( source == null )return;
	
	//alert( source.type + ' -> ' + destination );
	adapt( source, destination );
}

/**
 *  Converts src element to destination element
 * 
 * @param {Object} src : Element Object that is to be converted
** @param {String} dest : The type of element to which src should be converted
*
 */
function adapt( src, dest ){
	
	//Create destination element
	var newElement = addElementEx( dest, getOrder(src.htmlContainer)  );
	//Copy source parameters
	newElement.adapt( src );

	elementArray[src.index].onDelete();
	elementArray[src.index] = null;
	
	hideAllPropertyPages();

	newElement.htmlContainer.fireEvent('click',newElement.htmlContainer,0);
	
	
}