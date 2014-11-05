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
	public static $arrOfTextsToPrintGeneralTaxCalculator=array(
															0 => array("tabulated","true","Display results as a table.", array("true"=>"HTML Table", "false"=>"HTML Div")),
															1 => array("modelTitleElemType","h4","Header html type of the model."));
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
	public static $arrOfTextsToPrintGeneralComparator=array(
															0 => array("typicalMonthPriceInDetails","true","Typical month price", array("true"=>"Show", "false"=>"Don't show")),
															1 => array("cchAnchorAsSpan","true","Include link to comparecontracthire contract page",array("true"=>"Yes", "false"=>"No")),
															2 => array("defaultAnnualMileage","","Default annual mileage",array("10000"=>"10000", "20000"=>"20000")));

	function __construct(){
	}

	/*********************** FUNCTIONS THAT PRINT HTML INPUTS ******************/


	function plugin_create_checkboxes($args){
		$name=$args["name"]; //name of the checkbox
		$description=$args["description"]; //description of the checkbox
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL
		$options=$args["options"];

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

		$name=$args["name"]; //name of the checkbox
		$description=$args["description"]; //description of the checkbox
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL
		$options=$args["options"];

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
		$name=$args["name"]; //name of the selector
		$options=$args["options"]; //description of the checkbox
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL

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

	function plugin_create_selector_with_list_of_pages($args){

		$name=$args["name"]; //name of the textbox
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL
		$class=$args["class"];


		$arrPages= $this->thePagesOfWordPress;
		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		$theSelectedOptions=$arrOptions[$name];


		$theDropDownArguments=array();
		$theDropDownArguments["name"]="WPComcar_plugin_options_".$section."[$name]";
		$theDropDownArguments["selected"]=$theSelectedOptions;
		$theDropDownArguments['show_option_none']=' ';
		$theDropDownArguments["option_none_value"]="0"; 
		wp_dropdown_pages($theDropDownArguments); 


	    //if there is any explanation
	    if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";
		}
	}

	function plugin_create_textbox($args){
		$name=$args["name"]; //name of the textbox
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL
		
		$class=$args["class"];


		$arrOptions = get_option('WPComcar_plugin_options_'.$section);
		if (strlen($class)>0){
			echo "<input id='$name' name='WPComcar_plugin_options_".$section."[$name]' size='40' type='text' value='{$arrOptions[$name]}' class='$class' />";
		}else{
			echo "<input id='$name' name='WPComcar_plugin_options_".$section."[$name]' size='40' type='text' value='{$arrOptions[$name]}' />";
		}

		if (isset($explanation)){
			echo "<p class='description'> $explanation </p>";	
		}
	}

	function plugin_setting_string_plugins_to_use_general($args) {
		$name=$args["name"];
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
		echo "<p class='description'> Select as many plugins as you want to install in your wordpress site  </p>";
	}
	
	function plugin_tax_calculator_print_the_options($args,$vehicleType){
		$name=$args["name"]; //name of the textbox
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL
		$class=$args["class"];

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
	    
	    echo "<p class='description'> Select the options to request in each tax calculator webservice request </p><br/>";


	    $thisDefaultWebRequest=WPComcarPlugin_admin_configuration_html::$defaultTaxCalculatorWebRequest[$vehicleType];
	    $thisDefaultWebRequestHeaders=WPComcarPlugin_admin_configuration_html::$defaultTaxCalculatorWebRequestHeaders[$vehicleType];



	    $thisValue=isset($arrOptions[$name]["tax_calculator_".$vehicleType."_request"]) ? $arrOptions[$name]["tax_calculator_".$vehicleType."_request"] : ""; 
	    echo "<input id='jquery_request_".$vehicleType."' name='WPComcar_plugin_options_".$section."[$name][tax_calculator_".$vehicleType."_request]' size='40' type='text' value='$thisValue' placeholder='$thisDefaultWebRequest' title='$thisDefaultWebRequest' />";
	    echo "<p class='description'> Request to the webservice </p><br/>";

	    $thisValue=isset($arrOptions[$name]["tax_calculator_".$vehicleType."_headers"]) ? $arrOptions[$name]["tax_calculator_".$vehicleType."_headers"] : ""; 
	    echo "<input id='jquery_headers_".$vehicleType."' name='WPComcar_plugin_options_".$section."[$name][tax_calculator_".$vehicleType."_headers]' size='40' type='text' value='$thisValue' placeholder='$thisDefaultWebRequestHeaders' title='$thisDefaultWebRequestHeaders' />";
		echo "<p class='description'> Headers of the table in the results page </p><br/>";	
	}

	function plugin_tax_calculator_print_text_subsection($arrayOfOptions, $args){
		$name=$args["name"]; //name of the section
		$section=$args["section"]; //tax_calculator, comparator etc
		$explanation=$args["explanation"];//explanation of the field OPTIONAL
		$class=$args["class"];

		$arrPages= $this->thePagesOfWordPress;
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
									<input type="checkbox" checked id="" class="WPComcar_inline WPComcar_jquery_click_checkbox">
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
	/***************************************************************************/


	/********************** ARGUMENTS FOR THE WEBSERVICES BACKEND *****************************/	
	//COMPARATOR
	function plugin_comparator_print_texts($args){
		$this->plugin_tax_calculator_print_text_subsection(WPComcarPlugin_admin_configuration_html::$arrOfTextsToPrintGeneralComparator, $args);
	}

	//TAX CALCULATOR
	function plugin_tax_calculator_print_general_texts($args){
		$this->plugin_tax_calculator_print_text_subsection(WPComcarPlugin_admin_configuration_html::$arrOfTextsToPrintGeneralTaxCalculator, $args);
	}

	function plugin_tax_calculator_print_cars_texts($args){
		$this->plugin_tax_calculator_print_the_options($args,"cars");
		$this->plugin_tax_calculator_print_text_subsection(WPComcarPlugin_admin_configuration_html::$arrOfTextsToPrintCarTaxCalculator, $args);
	}


	function plugin_tax_calculator_print_vans_texts($args){
		$this->plugin_tax_calculator_print_the_options($args,"vans");
	}



	/*************************************************************************/


	/******************** INTERNAL FUNCTIONS ********************************/

    function theOptionIsSelected($arrOfValuesSelected,$value){
    	if (is_array($arrOfValuesSelected)){
    		foreach($arrOfValuesSelected as $key=>$thisCurrentValue){
	    		if(strcmp($thisCurrentValue,$value)==0)
	    			return true;
    		}	
    	}
    	return false;
    }
	/************************************************************************/


	/****************************** HEADERS OF THE SUBSECTIONS ***************************/
	//DESCRIPTIONS OF THE HEADERS
	function plugin_section_description_general() {
		echo '<p>Please introduce the channel id and public hash for both vans and cars. In case you want to get a licence refer to <a href="http://comparecontracthire.com">Compare contract hire</a></p>';
		echo '<p>Otherwise, the plugins may <b>not work</b></p>';
	}
	function plugin_section_description_footprint() {
		echo '<p>The footprint calculator pages shows information about CO2 emissions and... For more information, refer to <a href="http://comparecontracthire.com">Compare contract hire</a> </p>';
	}
	function plugin_section_description_comparator() {
		echo '<p>The comparator plugin is an useful tool for displaying...</p>';
	}
	function plugin_section_description_tax_calculator() {
		echo '<p>With the tax calculator plugin, you can compare among...</p>';
	}
	/*************************************************************************************/
}
?>
