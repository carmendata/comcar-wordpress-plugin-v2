<?php

class WPComcarPlugin_admin_configuration_html
{

	public static $defaultTaxCalculatorWebRequest= 			array(	"cars"=>	"derivative,transmission,co2gpkm,fueltype,otrPrice",
																	"vans"=>	"derivative,transmission,gvwkg,fueltype,cvotr");

	public static $defaultTaxCalculatorWebRequestHeaders=	array(	"cars"=>	"Derivative,Transmission,CO2 g/km,Fuel,List price",
																	"vans"=>	"Derivative,Transmission,GVW,Fuel,CV OTR Price");

	//TAX CALCULATOR OPTIONS AND TEXTS
	public static $arrOptionsTaxCalculator= array( 	0 => array( "maxP11D", "P11D Value" ),
													1 => array( "cvotr", "Price" ),
													2 => array( "make", "Manufacturer" ),
													3 => array( "model", "Model" ),
													4 => array( "derivative", "Derivative" ),
													5 => array( "roof", "Roof height" ),
													6 => array( "wheelbase", "Wheelbase" ),
													7 => array( "loadlength", "Load length" ),
													8 => array( "payload", "Payload" ),
													9 => array( "loadvolume", "Load Volume" ),
													10 => array( "gvwkg", "Gross Weight" ),
													11 => array( "CO2gpkm", "CO2" ),
													12 => array( "fuelType", "Fuel Type" ),
													13 => array( "taxHigh", "Tax (high)" ),
													14 => array( "taxLow", "Tax (low)" ),
													15 => array( "bik", "BIK" ),
													16 => array( "bodyStyle", "Bodystyle" ),
													17 => array( "VED", "VED" ),
													18 => array( "fuelConsumptionDf", "MPG" ),
													19 => array( "CO2pctge", "CO2 Percentage" ),
													20 => array( "otrPrice", "List Price" ),
													21 => array( "seats", "Seats" ),
													22 => array( "transmission", "Transmission" ),
													23 => array( "doors", "Doors" ),
													24 => array( "insfifty", "Insurance Group" ),
													25 => array( "ps", "Power" ));

	//option, default value, description, array of options
	public static $arrOfTextsToPrintCarTaxCalculator=array( 
															0 => array("capCon","Capital Contributions","&quot;Capital Contributions&quot; field label"),
															1 => array("annCon","Annual contributions","&quot;Annual contributions&quot; field label"),
															2 => array("optionsIntro","Drivers are taxed on the vehicle&#39;s full list price including options.","Intro to the &quot;Vehicle Options&quot; section"),
															3 => array("optionsAdd","Specify vehicle options","&quot;Specify vehicle options&quot; button text"),
															4 => array("optionsAddSubtext","Configure the complete vehicle by selecting which options will be included","&quot;Specify vehicle options&quot; button hint"),
															5 => array("inpGoToCalcValue","Quick calculation","&quot;Quick calculation&quot; button text"),
															6 => array("goToCalcSubtext","Continue straight to results without specifying vehicle options","&quot;Quick calculation&quot; button hint"));

	//COMPARATOR OPTIONS AND TEXTS
	//option, default value, description, array of options
	public static $arrOfTextsToPrintGeneralComparator=array( 	array("typicalMonthPriceInDetails","true","Typical month price", array("true"=>"Show", "false"=>"Don't show")),
																array("defaultAnnualMileage","","Default annual mileage",array("10000"=>"10000", "20000"=>"20000"))
															);


	/*********************** FUNCTIONS THAT PRINT HTML INPUTS ******************/


	function plugin_create_checkboxes($args){
		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;
		$description=isset($args["description"]) ? $args["description"] : ""; //description of the checkbox
		$options=isset($args["options"]) ? $args["options"]:"";

		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];

		//print in order
		foreach($options as $option=>$description){
			if ($this->theOptionIsSelected($theSelectedOptions, $option)){
				echo "<input type='checkbox' name='WPComcar_plugin_options_".$section."[$name][]' value='$option' checked> $description <br/>";
			}else{
				echo "<input type='checkbox' name='WPComcar_plugin_options_".$section."[$name][]' value='$option'> $description <br/>";
			}
		}
		if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";
		}
	}

	function plugin_create_radio_buttons($args){

		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;
		$description=isset($args["description"]) ? $args["description"] : ""; //description of the checkbox
		$options=isset($args["options"]) ? $args["options"]:"";


		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];

		//print in order
		foreach($options as $option=>$description){
			if ($this->theOptionIsSelected($theSelectedOptions, $option)){
				echo "<input type='radio' name='WPComcar_plugin_options_".$section."[$name][]' value='$option' checked> $description <br/>";
			}else{
				echo "<input type='radio' name='WPComcar_plugin_options_".$section."[$name][]' value='$option'> $description <br/>";
			}
		}
		if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";
		}
	}

	function plugin_create_selector($args){

		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;


		$options=$args["options"]; //description of the checkbox


		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];

		echo "<select name='WPComcar_plugin_options_".$section."[$name]'>";
		//para cada opcion
		foreach($options as $option=>$description){
			if (strcmp($theSelectedOptions,$option)==0){
				echo "<option value='$option' selected>$description</option>";
			}else{
				echo "<option value='$option'>$description</option>";
			}
		}
		echo "</select>";
		
		if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";
		}
	}

	/**
	 Generates a HTML selector with a list of pages on the WordPress site 
	*/
	function plugin_create_selector_with_list_of_pages($args){

		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;


		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];


		$theDropDownArguments=array();
		$theDropDownArguments["name"]="WPComcar_plugin_options_".$section."[$name]";
		$theDropDownArguments["selected"]=$theSelectedOptions;
		$theDropDownArguments['show_option_none']=' ';
		$theDropDownArguments["option_none_value"]="0"; 
		$theDropDownArguments["sort_column"]="menu_order"; 
		wp_dropdown_pages($theDropDownArguments); 


	    //if there is any explanation
	    if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";
		}
	}


	function plugin_create_textbox($args){
		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;


		$arrOptions = get_option('WPComcar_plugin_options_'.$section);

		$thisValue="";
		if (isset($arrOptions[$name])){
			$thisValue=$arrOptions[$name];
		}

		if (strlen($class)>0){
			echo "<input id='$name' name='WPComcar_plugin_options_".$section."[$name]' size='40' type='text' value='$thisValue' class='$class' />";
		}else{
			echo "<input id='$name' name='WPComcar_plugin_options_".$section."[$name]' size='40' type='text' value='$thisValue' />";
		}

		if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";	
		}
	}


	function plugin_setting_string_plugins_to_use_general($args) {

		$name=isset($args["name"]) ? $args["name"] : "";

		$arrOptions = get_option('WPComcar_plugin_options_general');
		$theSelectedOptions=$arrOptions[$name];


		$theNumberOfPlugins=count(WPComcarPlugin_admin_configuration::$arrOrderOfPlugins);

		//print in order
		for($i=1;$i<$theNumberOfPlugins;$i++){
			$index=WPComcarPlugin_admin_configuration::$arrOrderOfPlugins[$i][0];
			$checkBoxDescription=WPComcarPlugin_admin_configuration::$arrOrderOfPlugins[$i][2];

			if (isset($theSelectedOptions[$index])){
				echo "<input type='checkbox' name='WPComcar_plugin_options_general[$name][]' value='$index' checked class='WPComcar_subTabs'> $checkBoxDescription <br/>";
			}else{
				echo "<input type='checkbox' name='WPComcar_plugin_options_general[$name][]' value='$index' class='WPComcar_subTabs'> $checkBoxDescription <br/>";
			}
		}
	}

	
	function plugin_tax_calculator_print_the_options($args,$vehicleType){
		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;
		$description=isset($args["description"]) ? $args["description"] : ""; //description of the checkbox
		$options=isset($args["options"]) ? $args["options"]:"";

	    //if there is any explanation
	    if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";	
		}


		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];

		$arrOfOptions= WPComcarPlugin_admin_configuration_html::$arrOptionsTaxCalculator;

		if (strlen($class)>0){
			echo "<select name='WPComcar_plugin_options_".$section."_".$vehicleType."[$name]' id='jquery_options_".$vehicleType."' class='$class'>";
		}else{
			echo "<select name='WPComcar_plugin_options_".$section."_".$vehicleType."[$name]' id='jquery_options_".$vehicleType."'>";
		}

		$numberOfOptions=count($arrOfOptions);
		echo "<option value='0' selected></option>";
		foreach($arrOfOptions as $key=>$value){
			$thisTitle=$arrOfOptions[$key][0];
			$thisTextToShow=$arrOfOptions[$key][1];
			echo "<option value='$thisTitle'> $thisTextToShow </option>";
		}

		echo "</select>";
	    
	    echo "<p class='description'>Select options from list to add them to the box below. Repeat several times to build a list.</p><br>";


	    $thisDefaultWebRequest=WPComcarPlugin_admin_configuration_html::$defaultTaxCalculatorWebRequest[$vehicleType];
	    $thisDefaultWebRequestHeaders=WPComcarPlugin_admin_configuration_html::$defaultTaxCalculatorWebRequestHeaders[$vehicleType];

	    $thisValue=isset($arrOptions[$name]["tax_calculator_".$vehicleType."_request"]) ? $arrOptions[$name]["tax_calculator_".$vehicleType."_request"] : ""; 
	    echo "<input id='jquery_request_".$vehicleType."' name='WPComcar_plugin_options_".$section."[$name][tax_calculator_".$vehicleType."_request]' size='40' type='text' value='$thisValue' placeholder='$thisDefaultWebRequest' title='$thisDefaultWebRequest' />";
	    echo "<p class='description'>List of fields to include in the table of results. Must match database names exactly.</p><br>";

	    $thisValue=isset($arrOptions[$name]["tax_calculator_".$vehicleType."_headers"]) ? $arrOptions[$name]["tax_calculator_".$vehicleType."_headers"] : ""; 
	    echo "<input id='jquery_headers_".$vehicleType."' name='WPComcar_plugin_options_".$section."[$name][tax_calculator_".$vehicleType."_headers]' size='40' type='text' value='$thisValue' placeholder='$thisDefaultWebRequestHeaders' title='$thisDefaultWebRequestHeaders' />";
		echo "<p class='description'>Table Headers. These correspond to the list above, use it to give the fields human-friendly aliases.</p><br>";	
	}


	//print the textareas for the 
	function plugin_comparator_print_textareas_subsection($args,$vehicleType){

		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";

		$arrOptions = get_option('WPComcar_plugin_options_'.$section);

		echo '<div class="WPComcar_formRow WPComcar_separateTextAreas">
							<div class="WPComcar_inline WPComcar_sizeOfOptionText WPComcar_float"> Block of text above the selector dropdowns. By default contains: <em>"For a comprehensive range of..."</em>. Edit as <b>HTML</b> </div>
							<div class="WPComcar_float WPComcar_inline WPComcar_sizeOfCheckBox WPComcar_checkBoxWrap">
								<input type="checkbox" checked class="WPComcar_inline WPComcar_jquery_click_checkbox">
								<label for="">Default</label>
							</div>';
		$thisSubName="preSelectorText";
		$thisValue=isset($arrOptions[$name][$thisSubName]) ? $arrOptions[$name][$thisSubName] : "";				
		echo "<textarea rows='4' cols='50' name='WPComcar_plugin_options_".$section."[$name][$thisSubName]' id='$name"."_"."$thisSubName' value='$thisValue' type='textarea' class='WPComcar_inline WPComcar_jquery_editOption WPComcar_float'>$thisValue</textarea>";
		echo "</div>";		


		echo '<div class="WPComcar_formRow">
							<div class="WPComcar_inline WPComcar_sizeOfOptionText WPComcar_float"> Block of text below the selector dropdowns. By default contains: <em>"Once you have selected a vehicle..." </em>. Edit as <b>HTML</b></div>
							<div class="WPComcar_float WPComcar_inline WPComcar_sizeOfCheckBox WPComcar_checkBoxWrap">
								<input type="checkbox" checked class="WPComcar_inline WPComcar_jquery_click_checkbox">
								<label for="">Default</label>
							</div>';
		$thisSubName="postSelectorText";
		$thisValue=isset($arrOptions[$name][$thisSubName]) ? $arrOptions[$name][$thisSubName] : "";				
		echo "<textarea rows='4' cols='50' name='WPComcar_plugin_options_".$section."[$name][$thisSubName]' id='$name"."_"."$thisSubName' value='$thisValue' type='textarea' class='WPComcar_inline WPComcar_jquery_editOption WPComcar_float'>$thisValue</textarea>";
		echo "</div>";
	}


	function plugin_tax_calculator_print_text_subsection($arrayOfOptions, $args){
		$name=isset($args["name"]) ? $args["name"] : "";
		$section=isset($args["section"]) ? $args["section"] : "";
		$explanation=isset($args["explanation"]) ? $args["explanation"] : "";	
		$class=isset($args["class"]) ? $args["class"] : "" ;
		$description=isset($args["description"]) ? $args["description"] : ""; //description of the checkbox
		$options=isset($args["options"]) ? $args["options"]:"";

		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];

		$thisArrOfOptions=$arrayOfOptions;
		$lenOfOptionsArr=count($thisArrOfOptions);

		//for all the options in the array
		for($i=0;$i<$lenOfOptionsArr;$i++){
			$thisIsASelect=false;
			$thisSubOptions="";
			$thisNumberOfSubOptions=0;

			//if number of options equals 4, then it is a select
			if (count($thisArrOfOptions[$i])==4){
				$thisIsASelect=true;
				$thisSubOptions=$thisArrOfOptions[$i][3];
				//exit(var_dump($thisArrOfOptions[$i][3]));
				$thisNumberOfSubOptions=count($thisSubOptions);
			}
			$thisSubName=$thisArrOfOptions[$i][0];
			$thisDefault=$thisArrOfOptions[$i][1];
			$thisDescription=$thisArrOfOptions[$i][2];

			echo '<div class="WPComcar_formRow">
								<div class="WPComcar_inline WPComcar_sizeOfOptionText WPComcar_float"> '.$thisDescription.'</div>
								<div class="WPComcar_float WPComcar_inline WPComcar_sizeOfCheckBox WPComcar_checkBoxWrap">
									<input type="checkbox" checked class="WPComcar_inline WPComcar_jquery_click_checkbox">
									<label for="">Default</label>
								</div>';
			if ($thisIsASelect){
				echo "<select name='WPComcar_plugin_options_".$section."[$name][$thisSubName]' class='WPComcar_inline WPComcar_jquery_editOption WPComcar_float'>";
				//the selected option
				$theSelectedOption=isset($arrOptions[$name][$thisSubName]) ? $arrOptions[$name][$thisSubName]: "" ;				
				foreach($thisSubOptions as $key=>$thisText){
			    	if (strcmp($theSelectedOption,$key)==0){
			    		echo "<option value='$key' selected>$thisText</option>";
			    	}else{
			    		echo "<option value='$key'>$thisText</option>";
			    	}
				}
				echo "</select>";			
			}else{
				$thisValue=isset($arrOptions[$name][$thisSubName]) ? $arrOptions[$name][$thisSubName] : "";				
				echo "<input title='$thisDefault' id='$name"."_"."$thisSubName' placeholder='$thisDefault' name='WPComcar_plugin_options_".$section."[$name][$thisSubName]' size='40' type='text' value='$thisValue' class='WPComcar_inline WPComcar_jquery_editOption WPComcar_float' />";	
			}
			echo "</div>";
			
		}
	}




	/* -------------------------- ARGUMENTS FOR THE WEBSERVICES BACKEND -------------------------- */	

	function plugin_comparator_print_texts($args){
		$this->plugin_tax_calculator_print_text_subsection(WPComcarPlugin_admin_configuration_html::$arrOfTextsToPrintGeneralComparator, $args);
	}

	function plugin_comparator_print_textareas($args){
		if (strpos($args["name"],"vans")>-1){
			$this->plugin_comparator_print_textareas_subsection($args, "vans");
		}else{
			$this->plugin_comparator_print_textareas_subsection($args, "cars");
		}		
	}


	function plugin_tax_calculator_print_cars_texts($args){
		$this->plugin_tax_calculator_print_the_options($args,"cars");
		$this->plugin_tax_calculator_print_text_subsection(WPComcarPlugin_admin_configuration_html::$arrOfTextsToPrintCarTaxCalculator, $args);
	}

	function plugin_tax_calculator_print_vans_texts($args){
		$this->plugin_tax_calculator_print_the_options($args,"vans");
	}




	/* ----------------------------------- INTERNAL FUNCTIONS ----------------------------------- */

    function theOptionIsSelected($arrOfValuesSelected,$value){
    	if (is_array($arrOfValuesSelected)){
    		foreach($arrOfValuesSelected as $key=>$thisCurrentValue){
	    		if(strcmp($thisCurrentValue,$value)==0)
	    			return true;
    		}	
    	}
    	return false;
    }




	/* --------------------------------- HEADERS OF THE SUBSECTIONS --------------------------------- */

	function plugin_section_description_general() {
		echo '<p>
				Please insert the <em>ID</em> and <em>public hash</em> for your own car and/or van channel. 
				Channels are available to customers of Carmen Data Ltd. To become a customer see  
				<a target="_blank" href="http://carmendata.co.uk/">carmendata.co.uk</a>
			</p> 
			<p>
				<small>
					Note: If the <em>ID</em> and <em>public hash</em> fields are left blank the plugin will default to use our demo channels.
					These demo channels will only provide data on a limited selection of vehicle manufacturers. Which manufacturers are included 
					will change randomly each month.
				</small>
			<p>';
	}

	function plugin_section_description_footprint() {
		echo '<p>The Footprint Calculator tool is a simple way to allow users to calculate their CO<sub>2</sub> tailpipe 
				emissions based on fuel used, cost of fuel or distance travelled.</p>';
	}

	function plugin_section_description_comparator() {
		echo '<p>The Comparator allows users to compare several different vehicle across several contract terms and mileages. 
				Calculations can be viewed from the point of view of the driver and the company.</p>';
	}

	function plugin_section_description_tax_calculator() {
		echo '<p>The Tax Calculator tool allows users to calculate how much company car tax they will incur.</p>';
	}

}
?>
