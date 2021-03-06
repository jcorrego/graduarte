<?php
/**
* JFormsDesignHelper class , The Javascript generation workhorse
*
* Please note that all Javascript and HTML generated by this class are properly indented in the generated source, you can use your browser's "View Source"
* and you won't be disappointed
*
* A good starting point to read this file would be 
* - doPropertyPages();
* - doButtons()
*
* @version		$Id: design.php 295 2009-09-05 10:23:08Z dr_drsh $
* @package		Joomla
* @subpackage	JForms
* @copyright	Copyright (C) 2008 Mostafa Muhammad. All rights reserved.
* @license		GNU/GPL
*/
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JFormsDesignHelper{

	/**
	 * Outputs Javascript/HTML required for session status indicators
	 *
	 * @return void
	 */
	function doSessionStatus(){;}
	
	/**
	 * Outputs Javascript required to load external Stylesheet for the Design area
	 *
	 * @return void
	 */
	function loadCSS(){
	
		$path = JURI::base().'components/com_jforms/views/design/style.css';
		$output = '';
		
		$output .= _line('var oLink = document.createElement("link")',2);
		$output .= _line('oLink.href = "'.$path.'";',2);
		$output .= _line('oLink.rel = "stylesheet"',2);
		$output .= _line('oLink.type = "text/css"',2);
		$output .= _line('document.head.appendChild(oLink);',2);
		
		return $output;
	}
	function fillObligatoryList(){

		global $JFormGlobals;
		$loadedPlugins =& $JFormGlobals['JFormsPlugin']->element_plugins;
	
		$count  = 0;
		$output = '';

		foreach( $loadedPlugins as $p ){
			//Does it have a storage requirment?
			if( count($p->storage) ){
				//Add it to the list
				$output .= _line('obligatoryList['.$count.'] = "'.$p->name.'";',2);
				$count++;
			}
		}
		$countLimit = 'var countLimit = {';
		$lines = array();
		foreach( $loadedPlugins as $p ){
			$lines[] = "'". $p->name ."':" . $p->limit;
		}
		$countLimit .= implode(',',$lines);
		$countLimit .= "};";
		$output .= _line($countLimit,2);
		return $output;
	
	}
	
	/**
	 * Outputs HTML <script> tags that includes the javascript core files "core.js, CElement.js, CLabeledElement.js, event.js"
	 *
	 * @return void
	 */
	function loadCoreJSFiles($template)
	{	
		$jsDirURI = JURI::base().'components/com_jforms/JS/';
		$output = '';
		
		$src = $jsDirURI.'sha1.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$output .= _line('<script type="text/javascript">',1);
		$output .= get_include_contents(JFORMS_BACKEND_PATH.DS.'JS'.DS.'design.js.php',$template);
		$output .= _line('</script>',1);

		$src = $jsDirURI.'event.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$src = $jsDirURI.'CElement.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$src = $jsDirURI.'CLabeledElement.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$src = $jsDirURI.'utilities.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);

		$src = JURI::root() . 'plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js';
		$output .= _line('<script src="'.$src.'" type="text/javascript"></script>',2);
		$output .= _line('<script type="text/javascript">
		tinyMCE.init({
			theme : "advanced",
			language : "en",
			mode : "none",
			gecko_spellcheck : "true",
			editor_selector : "mce_editable",
			document_base_url : "'.JURI::root().'",
			entities : "60,lt,62,gt",
			relative_urls : 1,
			remove_script_host : false,
			invalid_elements : "applet",
			extended_valid_elements : "a[class|name|href|target|title|onclick|rel],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],,hr[id|title|alt|class|width|size|noshade]",
			theme_advanced_toolbar_location : "top",
			directionality: "ltr",
			force_br_newlines : "true",
			force_p_newlines : "false",
			content_css : "'.JURI::root().'templates/system/css/editor.css",
			debug : false,
			cleanup : true,
			cleanup_on_startup : false,
			safari_warning : false,
			plugins : "advlink, advimage, searchreplace,insertdatetime,media,advhr,table,fullscreen,directionality,style",
			theme_advanced_buttons1_add : "insertdate,inserttime,fontselect,media,ltr,rtl,absolute,forecolor",
			theme_advanced_buttons2_add : "",
			theme_advanced_buttons3_add : "advhr,tablecontrols,fullscreen,styleprops",
			theme_advanced_disable : "help",
			plugin_insertdate_dateFormat : "%Y-%m-%d",
			plugin_insertdate_timeFormat : "%H:%M:%S"
		});
		</script>',2);
		
			
		echo $output;
	}
	
	/**
	 * Outputs HTML code for property page of a given plugin
	 *
	 * @param object $plugin
	 * @return string HTML for the property page based on the passed plugin 
	 */
	function doPropertyPage( $plugin, $pluginsList )
	{
		$s  = $plugin->name;
		$output  = _line("<table id='ppage_$s' class='ppage'>", 2);
		//No parameters?
		if( count($plugin->parameters) == 0 ) {
			//Return an empty div
			$output .= '&nbsp;</div>';
			return $output;
		}
			
		//Loop through parameters of the passed plugin and generate HTML input fields
		foreach( $plugin->parameters as $param ){

			$id = "ppage_{$s}_{$param->name}";
			
			//What type of input field does this parameter requires
			switch( $param->control ){
				
				//A textbox
				case "textbox":
					$output .= _line("<tr>",3);
					$output .= _line("<td><label for='$id'>".JText::_($param->label)."</label></td>",3);
					$output .= _line("<td><input onchange='saveProperties()' name='$id' id='$id' type='text' value='' /></td>",3);
					$output .= _line("</tr>", 3);
					break;
				
				//A checkbox
				case "checkbox":
					$output .= _line("<tr>",3);
					$output .= _line("<td><label for='$id'>".JText::_($param->label)."</label></td>",3);
					$output .= _line("<td><input onclick='saveProperties()' name='$id' id='$id' type='checkbox' /></td>",3); 
					$output .= _line("</tr>", 3);
					break;
				//A List
				//The list is a bit complex, because to create a <select> list I need to be provided with <option>s
				//Check the XML file for "textbox" plugin to better understand this
				case "list":
					$output .= _line("<tr>",3);
					$output .= _line("<td><label for='$id'>".JText::_($param->label)."</label></td>",3);
					$output .= _line("<td><select onchange='saveProperties()' name='$id' id='$id'>",3);
					foreach($param->options as $key => $value){
						$key = JText::_($key);
						$output .= _line("<option value='$value'>$key</option>",4);
					}
					$output .= _line("</select></td>",3);
					$output .= _line("</tr>", 3);
					break;
			
				//A textarea
				case "textarea":
					$output .= _line("<tr>",3);
					$output .= _line("<td><label for='$id'>".JText::_($param->label)."</label></td>",3);
					$output .= _line("<td><textarea cols='25' rows='10' onchange='saveProperties()' name='$id' id='$id'></textarea></td>",3);
					$output .= _line("</tr>", 3);
					break;
					
				case 'editor':
					$output .= _line("<tr>",3);
					$output .= _line("<td><label for='$id'>".JText::_($param->label)."</label></td>",3);
					$output .= _line("<td><textarea cols='25' rows='25' onchange='saveProperties()' name='$id' id='$id'></textarea></td>",3);
					$editor =& JFactory::getEditor();
				//	$output .= _line($editor->display( $id,  '' , '100%', '550', '75', '20' ),3) ;
					$output .= _line("</tr>", 3);
					
			}
		}
		//The save button
		//Save now occurs onBlur and similar events, no need to manually click save
		//$output .= _line("<input name='' value='save' class='button' type='button' onclick='saveProperties();' />",3);
		
		
		//Conversion tools (Only for plugins that require DB storage)
		if( count($plugin->storage) ){
				
			$output .= _line('<tr>',3);
			$output .= _line('<td><hr /></td>',3);
			$output .= _line('<td><hr /></td>',3);
			$output .= _line('</tr>', 3);
			
			$output .= _line('<tr>',3);
			$output .= _line('<td><label for="'.$id.'">'.JText::_('Convert to').'</label></td>',3);
			$output .= _line('<td>',3);
			$output .= _line('<select style="float:left;" id="select_convert_'.$plugin->name.'">',4);
			foreach($pluginsList as $p){
				
				//Only add those with storage demands
				if( !count($p->storage) )continue;
				
				//Don't add the current plugin to the list
				if( $p->name == $plugin->name )continue;
				
				$label = JText::_($p->name);
				$output .= _line('<option value="'.$p->name.'">'.$label.'</option>',5);
			}
			$output .= _line('</select>',4);
			$output .= _line('<br clear="all" />',4);	
			$output .= 
			_line("<input onclick='if(confirm(\"".JText::_('Are you sure you want to convert this Element?')."\"))convert($(\"select_convert_{$plugin->name}\"))' type='button' value='".JText::_('Convert')."' />",4);
			$output .= _line('</td>',3);
			$output .= _line('</tr>', 3);
		}
		
		$output .= _line('</table>',2);
		
		
		$output .= "\n";
		return $output;
	}
	
	/**
	 * Outputs all the javascript code nessecary for property pages 
	 *
	 * @return string HTML/Javascript for all property pages 
	 */
	function doPropertyPages()
	{	
		global $JFormGlobals;
		$element_plugins = $JFormGlobals['JFormsPlugin']->element_plugins;
		
		$output = "";
		//Loop through all loaded plugins and generate HTML for their property pages
		foreach( $element_plugins as $p ){
			$output .= JFormsDesignHelper::doPropertyPage( $p, $element_plugins );	
		}
		//Include Javascript files for all plugins
		$output .= JFormsDesignHelper::doJSLoadElement($element_plugins);
		$output .= _line('<script type="text/javascript">',1);
		$output .= _line('//<![CDATA[',1);
		
	
		//The displayProperties javascript function
		$output .= JFormsDesignHelper::doJSDisplayProperties( $element_plugins );
		
		//The saveProperties javascript function
		$output .= JFormsDesignHelper::doJSSaveProperties( $element_plugins );
		
		//The addElement javascript function
		$output .= JFormsDesignHelper::doJSAddElement( $element_plugins );
		
		//Load CSS
		$output .= JFormsDesignHelper::loadCSS();
		
		
		$output .= _line('//]]>',1);
		$output .= _line('</script>',1);
	
		//Let it go :)
		echo $output;
	}

	/**
	* Returns javascript code for the "displayProperties" function 
	*
	* The displayProperties Javascript function is responsible for showing and updating the right property page for any selected element in the WYSIWYG form designer
	*
	* @param array $plugins a list of loaded element plugins
	* @return string Javascript function "displayProperties"
	*/
	function doJSDisplayProperties( $plugins )
	{
		$output  = _line('function displayProperties(){',1);
		$output .= _line('if(selectedElement == null)return;',2);
		$output .= _line('switch( selectedElement.type ){',2);
	
		foreach($plugins as $name => $data){
			$output .= _line("case '$name':",3);
			foreach( $data->parameters as $p ){
				
				$jsId = "ppage_{$name}_{$p->name}";
				if($p->control == "textbox" || $p->control == "textarea" || $p->control == "integer" ){
					$output .= _line('$("'.$jsId.'").value = selectedElement.'.$p->name.';',4);
				}
			
				if($p->control == "list"){
					$output .= _line('selectByValue($("'.$jsId.'"), selectedElement.'.$p->name.');',4);
				}
			
				if($p->control=="checkbox"){
					$output .= _line('$("'.$jsId.'").checked = selectedElement.'.$p->name.';',4);
				}
			
			}
			$output .= _line('break;',3);
		}
		$output .= _line('}',2);
		$output .= _line('}',1);
		return $output;
	}
	
	/**
	* Outputs HTML/Javascript for all draggable buttons in the WYSIWYG editor 
	*
	* @return void
	*/
	function doButtons()
	{
	
		/*
			This function has two output buffers
			$output and $windowLoadFunction
			$output will contain the HTML/Javascript code that will actually create the draggable buttons
			$windowLoadFunction will contain the javascript code that will be called with the "onLoad" event, This is required for proper alignment of the buttons
		*/
		
		$pane	=& JPane::getInstance('sliders',array('allowAllClose' => true));

		
	
	
	
		global  $JFormGlobals;
		$groupedElementPlugins = $JFormGlobals['JFormsPlugin']->getElementPluginsCategories();
		$output = "\n";
		
		//Very dirty hack to fix the annoying issue with sliders where a slider is open, but too short to show its contents, now they all show up closed
		$output .= _line('<div style="display:none">',1);
		$output .= $pane->startPane('xyz');	
		$output .= $pane->startPanel( 'xyz-p', 'xyz-p' );
		$output .= $pane->endPanel();
		$output .= $pane->endPane();
		$output .= _line('</div>',1);
		//End of dirty hack
		
		$windowLoadFunction = "\n";
		$windowLoadFunction .= _line('<script type="text/javascript">',2);
		$windowLoadFunction .= _line('//<![CDATA[',2);
		$windowLoadFunction .= _line('window.addEvent("load", startUp);',3);
		$windowLoadFunction .= _line('function startUp() {',3);
		$windowLoadFunction .= _line('$("properties").style.position = "relative";',4);
		
		$windowLoadFunction .= _line('$("workarea").addEvent("scroll", function(){',4);
		$windowLoadFunction .= _line('refreshSelectedElement();',5);
		$windowLoadFunction .= _line('});',4);
		
		$windowLoadFunction .= _line('window.addEvent("scroll", function(){',4);
		$windowLoadFunction .= _line('refreshSelectedElement();',5);
		$windowLoadFunction .= _line('var fx = new Fx.Morph($("properties"), {',5);
		$windowLoadFunction .= _line('duration:100, ',6);
		$windowLoadFunction .= _line('wait:true',6);
		$windowLoadFunction .= _line('});',5);
		$windowLoadFunction .= _line('fx.start({"top":  Window.getScrollTop()});',5);
		$windowLoadFunction .= _line('});',4);
		
		foreach($groupedElementPlugins as $group => $plugins){
			$title   = JText::_( $group );
			$output .= $pane->startPane($group);	
			$output .= $pane->startPanel( ucfirst($title), $group );
			$output .= _line('<ul>',2);
				
			foreach($plugins as $name => $data){
				
				$jsId = $name.'_control';
				$img = $data->button;
				
				$output .= _line('<li>',2);
				$output .= _line('<div id="'.$jsId.'" class="controls hasTip" title="'.JText::_($data->description).'" style="background-image:url('.$img.');"  name="'.$name.'"></div>',2);
				$output .= _line('<script type="text/javascript">',2);
				$output .= _line('//<![CDATA[',2);
				$output .= _line($jsId.'_drag = new Drag($("'.$jsId.'"),{',3);
				$output .= _line('onStart:function(e){',4);	
				//$output .= _line('JTooltips.detach($("'.$jsId.'"));',5);
				$output .= _line('$("'.$jsId.'").set("styles",{',5);
				$output .= _line('"position":  "absolute",',6);
				$output .= _line('"top":  $("'.$jsId.'").getParent().getPosition().y + correctionPixels + "px",',6);
				$output .= _line('"left": $("'.$jsId.'").getParent().getPosition().x + correctionPixels + "px"',6);
				$output .= _line('})',6);
				
				$output .= _line('},',4);
				$output .= _line('onComplete:function(e){',4);	
	
				$output .= _line('var top = $("'.$jsId.'").getParent().getPosition().y + correctionPixels',5);
				$output .= _line('var left = $("'.$jsId.'").getParent().getPosition().x + correctionPixels',5);
				$output .= _line('var fx = new Fx.Morph($("'.$jsId.'"));',5);
				$output .= _line('fx.onComplete = function(){',5);
				//$output .= _line('JTooltips.attach($("'.$jsId.'"));',6);
				$output .= _line('$("'.$jsId.'").style.position = "static";',6);
				$output .= _line('}',5);
				$output .= _line('fx.start({',5);
				$output .= _line('"top": top + "px",',6);
				$output .= _line('"left": left + "px"',6);
				$output .= _line('});',5);
				$output .= _line('addElement($("'.$jsId.'"));',5);
	
				$output .= _line('}',4);
				$output .= _line('});',3);
			
				$windowLoadFunction .= _line('$("'.$jsId.'").style.position = "static";',4);
				$windowLoadFunction .= _line('$("'.$jsId.'").style.left = ($("'.$jsId.'").getParent().getPosition().x + correctionPixels ) + "px";',4);
				$windowLoadFunction .= _line('$("'.$jsId.'").style.top  = ($("'.$jsId.'").getParent().getPosition().y + correctionPixels )+ "px";',4);	
		
		
				$output .= _line('//]]>',2);
				$output .= _line('</script>',2);
				$output .= _line('</li>',2);
				
			}
			$output .= _line('</ul>',2);
			$output .= $pane->endPanel();
			$output .= $pane->endPane();
		}	
		$output .= _line('<br clear="all" />',2);
	

		
		
		$windowLoadFunction .= _line('placeFormElements();',4);
		$windowLoadFunction .= _line('};',3);
		$windowLoadFunction .= _line('//]]>',2);
		$windowLoadFunction .= _line('</script>',2);
		
		echo $windowLoadFunction;
		echo $output;
		
			
	}
	/**
	* Returns javascript function "addElement"
	*
	* addElement function creates a new element "textbox,textarea,etc." in the WYSIWYG editor, the function is generated on the fly by PHP to match loaded plugins
	*
	* @param array $plugins , a list of all loaded element plugins
	* @return Javascript code for addElement function
	*/
	function doJSAddElement( $plugins ){
	
		$output  = _line('function addElement(e){',2);
		$output .= _line('e=$(e);',3);	
		
		$output .= _line('if(reachedLimit(e.get("name"))){',3);
		$output .= _line('alert("'.JText::_('You cannot place anymore instances of this element').'");',4);
		$output .= _line('return;',4);
		$output .= _line('}',3);
		
		$output .= _line('var areaCoords = $("workarea").getCoordinates();',3);		
		$output .= _line('var elementPosition = e.getPosition();',3);
		$output .= _line('var x = elementPosition.x ;',3);
		$output .= _line('var y = elementPosition.y ;',3);
		$output .= _line('if( x < areaCoords.left || x > areaCoords.right)return;',3);	
		$output .= _line('if( y < areaCoords.top || y > areaCoords.bottom)return;',3);
		
		$output .= _line('var insertBeforeObject = beforeWhich(elementPosition.x,elementPosition.y);',3);
		$output .= _line('switch(e.get("name")){',3);
		foreach($plugins as $name => $data){
			$output .= _line('case "'.$name.'":',4);
			$output .= _line('elementArray.push(new '.$name.'($("clist"),autoIncrement,insertBeforeObject,',5);
			if( count( $data->parameters ) ){
				$output .= _line('{',5);
				foreach( $data->parameters as $p ){
					if($p->valueType == 'integer' ){
						$propertyText = $p->name.':'.$p->default.',';
					} else {
						$propertyText = $p->name.':"'.$p->default.'",';
					}
					$output .= _line($propertyText,6);	
				}
				$output = substr($output,0,strlen($output)-2)."\n";
				$output .= _line('}))',5);
			}
			$output .= _line('autoIncrement++;',5);
			$output .= _line('break;',4);
		}
		$output .= _line('}',3);
		$output .= _line('if(selectedElement){',3);
		$output .= _line('//Some sort of "refresh"',4);
		$output .= _line('selectedElement.select();',4);
		$output .= _line('}',3);
		//$output .= _line('updateSortableList();',3);
		$output .= _line('return elementArray[elementArray.length-1];',3);
		$output .= _line('}',2);
		$output .=  JFormsDesignHelper::doJSAddElementEx( $plugins );		


		return $output;
	




	}
	
	function doJSAddElementEx( $plugins ){
	
		$output  = _line('function addElementEx(type,order){',2);
		
		$output .= _line('if(reachedLimit(type)){',3);
		$output .= _line('alert("'.JText::_('You cannot place anymore instances of this element').'");',4);
		$output .= _line('return;',4);
		$output .= _line('}',3);
		
		
		$output .= _line('var insertBeforeObject = getLiAt( order+1 );',3);
		
		
		$output .= _line('switch(type){',3);
		foreach($plugins as $name => $data){
			$output .= _line('case "'.$name.'":',4);
			$output .= _line('elementArray.push(new '.$name.'($("clist"),autoIncrement,insertBeforeObject,',5);
			if( count( $data->parameters ) ){
				$output .= _line('{',5);
				foreach( $data->parameters as $p ){
					if($p->valueType == 'integer' ){
							$propertyText = $p->name.':'.$p->default.',';
					} else {
							$propertyText = $p->name.':"'.$p->default.'",';
					}
					$output .= _line($propertyText,6);	
				}
				$output = substr($output,0,strlen($output)-2)."\n";
				$output .= _line('}))',5);
			}
			$output .= _line('autoIncrement++;',5);
			$output .= _line('break;',4);
		}
		$output .= _line('}',3);
		$output .= _line('if(selectedElement){',3);
		$output .= _line('//Some sort of "refreash"',4);
		$output .= _line('selectedElement.select();',4);
		$output .= _line('}',3);
		$output .= _line('updateSortableList();',3);
		$output .= _line('return elementArray[elementArray.length-1];',3);
		$output .= _line('}',2);
		return $output;
	}
	
	/**
	* Returns HTML <script> tags for all loaded plugins
	*
	* @param array $plugins a list of loaded element plugins
	* @return string HTML <script> tags for loaded plugins
	*/
	function doJSLoadElement( $plugins )
	{
		$output = "";
		foreach($plugins as $p){
			$output .= _line('<script src="'.$p->js.'" type="text/javascript"></script>',2);
		}
		return $output;
	}
	
	/**
	* Returns javascript code for the "saveProperties" function 
	*
	* The saveProperties Javascript function is responsible for updating the selected element with the data from the property page
	*
	* @param array $plugins a list of loaded element plugins
	* @return string Javascript function "saveProperties"
	*/
	function doJSSaveProperties( $plugins )
	{
		$output  = _line('function saveProperties(){',1);
		$output .= _line('if(selectedElement == null)return;',2);
		$output .= _line('switch( selectedElement.type ){',2);
		
		foreach($plugins as $pluginName => $data){
		
			$output .= _line('case "'.$pluginName.'":',3);
			foreach( $data->parameters as $p ){
				
				$jsId = "ppage_{$pluginName}_{$p->name}";
				if($p->control == "textbox" || $p->control == "textarea"){
					$output .= _line('selectedElement.'.$p->name.' = $("'.$jsId.'").value;',4);
				}
			
				if($p->control == 'list'){
					$output .= _line('var l = $("'.$jsId.'");',4);
					$output .= _line('selectedElement.'.$p->name.'= l[l.selectedIndex].value;',4);
				}
			
				if($p->control == 'checkbox'){
					$output .= _line('selectedElement.'.$p->name.' = $("'.$jsId.'").checked;',4);
				}
			}
			$output .= _line('break;',3);
		}
		$output .= _line("}",2);
		$output .= _line("//Trigger update Event",2);
		$output .= _line("selectedElement.onUpdate();",2);
		$output .= _line("}",1);
		return $output;
		
	}
	/**
	* Returns javascript function "placeFormElements"
	*
	* placeFormElements function places pre-saved form elements in their places in the WYSIWYG editor.
	*
	* @return Javascript code for addElement function
	*/
	function JSappendElement( $element ){
	
		global $JFormGlobals;
		$loadedPlugins =& $JFormGlobals['JFormsPlugin']->element_plugins;
			
		$output   = _line('elementArray.push(new '.$element->type.'($("clist"),autoIncrement,null,',3);
		$output  .= _line('{',3);
		
		$paramIdList = _line('paramIdList += "'.$element->parameters['hash'].';";',3);
		$idArray = array();
		
		$parameters = $loadedPlugins[$element->type]->parameters;
		
		foreach( $parameters as $param ){
			
			
			//Get parameter info
			$valueType    = $loadedPlugins[$element->type]->parameters[$param->name]->valueType;
			$defaultValue = $loadedPlugins[$element->type]->parameters[$param->name]->default;
			
			$parameterId    = 0;
			$parameterValue = $defaultValue;
			if( array_key_exists( $param->name, $element->parameters ) ){
				$parameterId    = $element->parametersId[$param->name];
				$parameterValue = $element->parameters[$param->name];
			}
			
			
			if($valueType == 'string' ){
				//Fix for forms generated using version prior to 0.5 RC2
				$parameterValue = str_replace("\r", '', $parameterValue);
				
				//Prepare for Javascript
				$parameterValue = addslashes( $parameterValue );
				$parameterValue = str_replace( "\n",'\n', $parameterValue);
					
				$output .= _line($param->name . ':"' . $parameterValue .'",',4);
			} else {
				$parameterValue = intval( $parameterValue );
				$output .= _line($param->name . ':' .$parameterValue .',' ,4);
			}
			if($parameterId)$idArray[] =  $param->name . '=>' . $parameterId;
		}
		$paramIdList .= _line('paramIdList += "'.implode(',',$idArray).'"',3);
		$paramIdList .= _line('paramIdList += "|";',3);
		$output   = substr($output,0,strlen($output)-2)."\n";
		$output  .= _line('}));',3);
		$output  .= _line('autoIncrement++;',3);
		$output  .= $paramIdList;
		
		
		return $output;
		
	}

	
	function doACLList( $selected ){
	

		$acl	=& JFactory::getACL();
		$gtree	= $acl->get_group_children_tree( null, 'USERS', false );
	
		$guest = new stdClass();
		$guest->text  = JText::_('Guest');
		$guest->value = '0';
		$gtree = array_merge( array( $guest ), $gtree );
		
	
		$output  = _line('<fieldset>',2);
		$output .= _line('<legend>'.JText::_('Allowed user types').'</legend>',2);
	
		for($i=0;$i<count($gtree);$i++){
			
			$g = $gtree[$i];
			
			//I don't like seeing public frontend and public backend, I understand this is so messy, but I just couldn't help it
			if( in_array( $g->value, array(29,30)))continue;
			
			$g->text = trim( str_replace( array('-','.','&nbsp;') , '', $g->text) );
			
			$s = '';
			// $selected == null means we're in "add new form" screen, we need to load defaults, i.e. allow all
			if( $selected == null || in_array( $g->value, $selected )  ){
				$s = 'checked="checked"';
			}
			$output .= _line('<input id="groups_'.$i.'" type="checkbox" value="'.$g->value.'" '.$s.' name="groups[]" />',3);
			$output .= _line('<label for="groups_'.$i.'">'.$g->text.'</label><br />',3);
		}
		$output .= _line('</fieldset>',2);
		return $output;
	}

	function doThemeList( $selected ){
	
		$themeFiles = JFolder::files(JFORMS_FRONTEND_PATH.DS.'views'.DS.'form'.DS.'tmpl','^(.+)_thank.php$');
		
		$themes = array();
		foreach($themeFiles as $f){
			$t = str_replace( '_thank.php', '', $f );
			$themes[] = array('key' => $t, 'value' => $t);
		}
		$output  = '<table class="admintable"><tr>';
		$output .= _line('<td class="paramlist_key"><label class="" for="paramstheme">'.JText::_('Theme').'</label></td>',2);
	 	$output .= _line('<td>'.JHTML::_('select.genericlist', $themes, 'params[theme]', null, 'key', 'value', $selected ).'</td>',2);
		$output .= '</tr></table>';
		return $output;
		
	}
	
	function doJEditorFunction(){
		/*
		$output = _line('function doJEditor( container, id, content, width, height, cols, rows){',0);
		$token= JUtility::getToken();
		$url  = "'" . JURI::base().'index.php';
		$url .= "?option=com_jforms&task=createJEditor&$token=1&areaname='+id+'&content='+content+'&width='+width+'&";
		$url .= "height='+height+'&cols='+cols+'&rows='+rows";
		$output .= _line( 'var request = '.$url.';', 1);
		$output .= _line( 'var req = new XHR({', 1);
		$output .= _line( 'method: "get",', 2);
		$output .= _line( 'async: false', 2);
		$output .= _line( '});', 1);
		$output .= _line( 'req.send(request)', 1);
		$output .= _line( '$(container).innerHTML = req.transport.responseText;', 1);
		$output .= _line( '}', 0);
		
		return $output;
		*/
	
	}
}