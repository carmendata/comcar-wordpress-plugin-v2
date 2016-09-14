<?php

include_once(WPComcar_WEBSERVICESCALLSPATH."general-plugin-functions.php");

/****************************** BACKEND ADMIN PAGE **************************************/
class WPComcarPlugin_admin_configuration
{

	var $objHtmlAdmin;

	public static $arrGroupOfPluginOptions = 	array( 	"general" 			=> "WPComcar_plugin_options_general",
										  				"footprint" 		=> "WPComcar_plugin_options_footprint",
														"comparator" 		=> "WPComcar_plugin_options_comparator",
                                                        "electric_comparator" => "WPComcar_plugin_options_electric_comparator",
														"tax_calculator" 	=> "WPComcar_plugin_options_tax_calculator");

	//sets the order of the plugins. KEEP ALWAYS GENERAL AT THE TOP
	public static $arrOrderOfPlugins = array( 	array( "general", "Main settings", ""),
												array( "tax_calculator", "Tax calculator settings", "Tax calculator"),
												array( "comparator", "Comparator settings", "Comparator"),
												array( "electric_comparator", "Electric comparator settings", "Electric comparator"),
                                                array( "footprint", "Footprint calculator settings", "Footprint calculator")
											);

	public static $arrOfTaxCalculatorSubPages = array( 	"select" 	=> "The <b>Select</b> page (the first page in the calculation process).",
														"model" 	=> "The <b>Model</b> page.",
														"options"	=> "The <b>Options</b> page.",
														"calc" 		=> "And finally the <b>Calculate</b> page (the last page)."
														);

	public static $arrOfComparatorSubPages = 	array( 	"select" 	=> "The <b>Select</b> (the first page in the comparison process).",
														"details" 	=> "The <b>Details</b> page.",
														"callback"	=> "The <b>Callback</b> page (This never gets seen by users but is crucial to user flow)."
														);

	function __construct(){
		if (is_admin()) {
			if (!isset($this->objHtmlAdmin)){
				// Load example settings page
				if (!class_exists(WPComcar_PLUGINADMINHTMLNAME)){
					require_once(dirname(__FILE__)."/wp-comcar-plugins-admin-html.php");
				}						
				$this->objHtmlAdmin = new WPComcarPlugin_admin_configuration_html();					
			}		
		}

		//when we trigger the admin part of wordpress...
		add_action('admin_init', array($this,'plugin_upgrade'));
		add_action('admin_init', array($this,'plugin_admin_init'));

		add_action('admin_menu', array($this,'plugin_admin_add_page'));
		add_action("admin_enqueue_scripts", array($this,'admin_css_and_scripts'));
		//shortcut to the settings
		add_filter('plugin_action_links', array($this,'add_action_links'),10,2);
	}

	//whenever we want to upgrade the plugin, we will use this function
	function plugin_upgrade() 
	{
		$thisPluginVersionOptionName = 'WPComcar_plugin_version';
		$updateOption=null;
		$theCurrentVersion=get_option($thisPluginVersionOptionName);

		//the first time it loads, lets save the current version
		if ($theCurrentVersion==null){
			update_option($thisPluginVersionOptionName,WPComcar_PLUGINVERSION);			
			return true;
		}

		//we need to upgrade here
		if ($theCurrentVersion!=WPComcar_PLUGINVERSION){
			$nameOfTheFunctionThatUpgrades='plugin_upgrade_operations';
			$this->$nameOfTheFunctionThatUpgrades();
			update_option($thisPluginVersionOptionName,WPComcar_PLUGINVERSION);
			return true;
		}
		//in case there is an error
		return false;
	}

	//UPGRADE TO VERSION WHATEVER
	function plugin_upgrade_operations(){
		//check the actual version and do the different updated
	}

	function add_action_links($links, $file) {
		//if we find comcar in the file, this is our plugin
		if (strpos($file,"comcar")!==false){
			$settings_link='<a href="'. get_admin_url(null, 'options-general.php?page=WPComcar_plugin') .'">Settings</a>';
			array_unshift($links,$settings_link);
		}
		return $links;
	}

	/**************************** ADMIN INITIALIZATION ***********************************/
	function plugin_admin_add_page() {
		add_options_page('Comcar Plugin Menu', 'Comcar Plugin Menu', 'manage_options', 'WPComcar_plugin', array($this,'plugin_options_page'));
	}


	function plugin_options_page() {
		include 'wp-comcar-plugins-admin-options.php';
	}

	function plugin_admin_init(){

		//show the error messages
		add_action("admin_notices",array($this,"showErrorMessages"));
		$theNumberOfPlugins=count($this::$arrOrderOfPlugins);

		for($i=0;$i<$theNumberOfPlugins;$i++){
			//general, footprint, comparator, tax_calculator
			$thisNameOfTheSection=$this::$arrOrderOfPlugins[$i][0];
			$thisDescriptionOfTheSection=$this::$arrOrderOfPlugins[$i][1];
			// add_settings_section( $id, $title, $callback, $page )
			add_settings_section('plugin_'.$thisNameOfTheSection, $thisDescriptionOfTheSection, array($this->objHtmlAdmin,'plugin_section_description_'.$thisNameOfTheSection), 'WPComcar_plugin');
			// add_settings_field( $id, $title, $callback, $page, $section, $args )
			$nameOfTheFunctionToCall="plugin_".$thisNameOfTheSection."_admin_options";
			$this->$nameOfTheFunctionToCall();
			// register_setting( $option_group, $option_name, $sanitize_callback )
			register_setting( 'WPComcar_plugin_options', $this::$arrGroupOfPluginOptions[$thisNameOfTheSection], array($this,'plugin_options_'.$thisNameOfTheSection.'_validate'));
		}
	}

	/**************************************************************************************/


	/**************************** CREATE THE FIELDS OF THE PLUGINS ***********************/

	function plugin_comparator_admin_options(){

		add_settings_field('pages', 'Enable Comparator', array($this->objHtmlAdmin,'plugin_create_checkboxes'), 'WPComcar_plugin', 'plugin_comparator',
							 array( 	"name" 			=> "pages",
							 		 	"description" 	=> "",
							 		 	"section" 		=> "comparator",
							 		 	"options"		=>	array("cars" => "For car channel", "vans" => "For van channel")));
		//parent page
		add_settings_field('comparator_cars_page', 'Car channel comparator', array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_comparator',
							 array( 	"name" 			=> 	"comparator_cars_page",
							 			"section"		=> 	"comparator",
							 			"explanation"	=>	"Select which page the Car Comparator <b>Parent page</b> will be loaded into."));

		foreach($this::$arrOfComparatorSubPages as $index=>$description){
				add_settings_field("comparator_cars_subpage_$index", "", array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_comparator',
							 array( 	"name" 			=> 	"comparator_cars_subpage_$index",
							 			"section"		=> 	"comparator",
							 			"explanation"	=>	"$description"));
		}

		add_settings_field(
		    		"comparator_cars_comp_override", 
		    		"Comparation override URL", 
		    		array(
		    			$this->objHtmlAdmin,
		    			'plugin_create_textbox'
		    		), 
		    		'WPComcar_plugin', 
		    		'plugin_comparator',
					 array( 	
					 	"name" 			=> 	"comparator_cars_comp_override",
			 			"section"		=> 	"comparator",
			 			"explanation"	=>	"Override URL to visit prior to the comparation - leave blank if not needed (refer to documentation for correct redirection to final comparation)",
			 			"class" 		=>  "WPComcar_inline"
			 		)
				);
		    	
		//parent page
		add_settings_field('comparator_vans_page', 'Van channel comparator', array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_comparator',
							 array( 	"name" 			=> 	"comparator_vans_page",
							 			"section"		=> 	"comparator",
							 			"explanation"	=>	"<b>Parent page</b> where you want the vans comparator plugin to appear."));

		foreach($this::$arrOfComparatorSubPages as $index=>$description){
				add_settings_field("comparator_vans_subpage_$index", "", array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_comparator',
							 array( 	"name" 			=> 	"comparator_vans_subpage_$index",
							 			"section"		=> 	"comparator",
							 			"explanation"	=>	"$description"));
		}

		// ADRIAN

    	add_settings_field('comparator_cars_selector_texts', 'Cars Selector Texts', array($this->objHtmlAdmin,'plugin_comparator_print_textareas'), 'WPComcar_plugin', 'plugin_comparator',
					 array( 	"name" 			=> 	"comparator_cars_texts",
					 	    	"section"		=>	"comparator"));

   		add_settings_field('comparator_vans_selector_texts', 'Vans Selector Texts', array($this->objHtmlAdmin,'plugin_comparator_print_textareas'), 'WPComcar_plugin', 'plugin_comparator',
					 array( 	"name" 			=> 	"comparator_vans_texts",
					 	    	"section"		=>	"comparator"));

    	//Now, let us print the general settings, the vans and cars settings
    	add_settings_field('comparator_general_texts', '<b>General settings</b>', array($this->objHtmlAdmin,'plugin_comparator_print_texts'), 'WPComcar_plugin', 'plugin_comparator',
					 array( 	"name" 			=> 	"comparator_general_texts",
					 	    	"section"		=>	"comparator",
					 			"explanation"	=>	"<b>General settings </b> for the comparator plugin.",
					 			"class" 		=> "WPComcar_comparator_options"));
	}

	
    function plugin_tax_calculator_admin_options(){

    	add_settings_field('pages', 'Enable tax calculator', array($this->objHtmlAdmin,'plugin_create_checkboxes'), 'WPComcar_plugin', 'plugin_tax_calculator',
    						 array( 	"name" 			=> "pages",
    						 		 	"description" 	=> "",
    						 		 	"section" 		=> "tax_calculator",
    						 		 	"options"		=>	array("cars" => "For car channel", "vans" => "For van channel")));
    
    	add_settings_field('tax_calculator_cars_page', 'Car tax calculator pages', array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_tax_calculator',
    						 array( 	"name" 			=> 	"tax_calculator_cars_page",
    						 			"section"		=> 	"tax_calculator",
    						 			"explanation"	=>	"Select which page the car Tax Calculator <b>Parent Page</b> should be loaded into."));
    	
    	foreach($this::$arrOfTaxCalculatorSubPages as $index=>$description){
				add_settings_field("tax_calculator_cars_subpage_$index", "", array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_tax_calculator',
    						 array( 	"name" 			=> 	"tax_calculator_cars_subpage_$index",
    						 			"section"		=> 	"tax_calculator",
    						 			"explanation"	=>	"$description",
    						 			"class" 		=>  "WPComcar_inline"));
    	}

    	add_settings_field(
    		"tax_calculator_cars_calc_override", 
    		"Calculation override URL", 
    		array(
    			$this->objHtmlAdmin,
    			'plugin_create_textbox'
    		), 
    		'WPComcar_plugin', 
    		'plugin_tax_calculator',
			 array( 	
			 	"name" 			=> 	"tax_calculator_cars_calc_override",
	 			"section"		=> 	"tax_calculator",
	 			"explanation"	=>	"Override URL to visit prior to the tax calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation)",
	 			"class" 		=>  "WPComcar_inline"
	 		)
		);

    	add_settings_field('tax_calculator_vans_page', 'Van tax calculator pages', array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_tax_calculator',
    						 array( 	"name" 			=> 	"tax_calculator_vans_page",
    						 	    	"section"		=>	"tax_calculator",
    						 			"explanation"	=>	"Select which page the van tax calculator <b>Parent page</b> should be loaded into."));


    	foreach($this::$arrOfTaxCalculatorSubPages as $index=>$description){
				add_settings_field("tax_calculator_vans_subpage_$index", "", array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_tax_calculator',
    						 array( 	"name" 			=> 	"tax_calculator_vans_subpage_$index",
    						 			"section"		=> 	"tax_calculator",
    						 			"explanation"	=>	"$description"));
    	}

    	//Now, let us print the GENERAL, the VANS and the CARS SETTINGS
    	// add_settings_field('tax_calculator_general_texts', '<b>General settings</b> model page', array($this->objHtmlAdmin,'plugin_tax_calculator_print_general_texts'), 'WPComcar_plugin', 'plugin_tax_calculator',
					//  array( 	"name" 			=> 	"tax_calculator_general_texts",
					//  	    	"section"		=>	"tax_calculator",
					//  			"explanation"	=>	"<b>General settings </b> for the tax calculator plugin.",
					//  			"class" 		=> "WPComcar_tax_calculator_options"));

    	add_settings_field('tax_calculator_cars_texts', 'Car Tax Calculator <b>Model</b> page settings', array($this->objHtmlAdmin,'plugin_tax_calculator_print_cars_texts'), 'WPComcar_plugin', 'plugin_tax_calculator',
					 array( 	"name" 			=> 	"tax_calculator_cars_texts",
					 	    	"section"		=>	"tax_calculator",
					 			"explanation"	=>	""));

   		add_settings_field('tax_calculator_vans_texts', '<b>Vans settings</b> model page', array($this->objHtmlAdmin,'plugin_tax_calculator_print_vans_texts'), 'WPComcar_plugin', 'plugin_tax_calculator',
					 array( 	"name" 			=> 	"tax_calculator_vans_texts",
					 	    	"section"		=>	"tax_calculator",
					 			"explanation"	=>	""));
    }

	//FOOTPRINT
    function plugin_footprint_admin_options(){

    	add_settings_field('footprint_page', 'Footprint calculator page', array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_footprint',
    						 array( 	"name" 			=> 	"footprint_page",
    						 			"section"		=> 	"footprint",
    						 			"explanation"	=>	"Select which page the Footprint Calculator should be loaded on."));
    }



    function plugin_electric_comparator_admin_options(){

        add_settings_field('electric_comparator_page', 'electric_comparator calculator page', array($this->objHtmlAdmin,'plugin_create_selector_with_list_of_pages'), 'WPComcar_plugin', 'plugin_electric_comparator',
                             array(     "name"          =>  "electric_comparator_page",
                                        "section"       =>  "electric_comparator",
                                        "explanation"   =>  "Select which page the Electric comparator should be loaded on."));
    }


    //GENERAL OPTIONS
    function plugin_general_admin_options(){


    	add_settings_field('clkCars', 'Car Channel ID', array($this->objHtmlAdmin,'plugin_create_textbox'), 'WPComcar_plugin', 'plugin_general',
					 array( 	"name" 			=> 	"clkCars",
					 			"section"		=> 	"general",
					 			"explanation"	=>	""));
    	add_settings_field('pushCars', 'Car Channel Public hash', array($this->objHtmlAdmin,'plugin_create_textbox'), 'WPComcar_plugin', 'plugin_general',
					 array( 	"name" 			=> 	"pushCars",
					 			"section"		=> 	"general",
					 			"explanation"	=>	"The public hash delivered with the car channel"));

       	add_settings_field('clkVans', 'Van Channel ID', array($this->objHtmlAdmin,'plugin_create_textbox'), 'WPComcar_plugin', 'plugin_general',
					 array( 	"name" 			=> 	"clkVans",
					 			"section"		=> 	"general",
					 			"explanation"	=>	""));

        add_settings_field('pushVans', 'Van Channel Public hash', array($this->objHtmlAdmin,'plugin_create_textbox'), 'WPComcar_plugin', 'plugin_general',
					 array( 	"name" 			=> 	"pushVans",
					 			"section"		=> 	"general",
					 			"explanation"	=>	"The public hash delivered with the van channel"));

    	add_settings_field('pluginsToUse','Enable tools',  array($this->objHtmlAdmin,'plugin_setting_string_plugins_to_use_general'), 'WPComcar_plugin', 'plugin_general',  array( "name" => "pluginsOptions"));
    }


	/**************************** BACKEND VALIDATION FIELDS ******************************/
	//VALIDATION OF THE BACKEND FIELDS
	function plugin_options_general_validate($input){
		$arrOptions = get_option('WPComcar_plugin_options_general');			
		$arrOptions["errors"]=array();
		//empty the selected plugins
		$arrOptions["pluginsOptions"]=array();
		
		foreach($input as $key=>$value){
			//escape characters
			$arrOptions[$key] = $input[$key];
			//found clk
			if (strpos($key,"clk")!==false && (strlen($input[$key])>0)){
				$arrOptions[$key] = esc_attr(trim($input[$key]));
				if(!preg_match('/^[0-9]+$/', $arrOptions[$key])) {
					$arrOptions["errors"]["clk"]="Clk needs to be a number";
					$arrOptions[$key] = '';
				}
			}//found push
			else if(strpos($key,"push")!==false && (strlen($input[$key])>0)){
				$arrOptions[$key] = esc_attr(trim($input[$key]));
				if(!preg_match('/^[A-Z0-9]+$/', $arrOptions[$key])) {
					//error
					$arrOptions["errors"]["push"]="Public hashes must include numbers and uppercase letters only";
					$arrOptions[$key] = '';
				}
			}//found pluginsOptions
			else if (strpos($key,"pluginsOptions")!==false){
				foreach($value as $keyOption => $optionSelected ){
					$arrOptions[$key][$optionSelected]=$optionSelected;
				}
			}
		}

		return $arrOptions;
	}

	function plugin_options_footprint_validate($input){
		$arrOptions = get_option('WPComcar_plugin_options_footprint');
		if (isset($input["footprint_page"])){
			$arrOptions["footprint_page"]=esc_attr(trim($input["footprint_page"]));
		}else{
			$arrOptions["footprint_page"]="";
		}
		return $arrOptions;
	}


function plugin_options_electric_comparator_validate($input){
        $arrOptions = get_option('WPComcar_plugin_options_electric_comparator');
        if (isset($input["electric_comparator_page"])){
            $arrOptions["electric_comparator_page"]=esc_attr(trim($input["electric_comparator_page"]));
        }else{
            $arrOptions["electric_comparator_page"]="";
        }
        return $arrOptions;
    }


	function plugin_options_comparator_validate($input){
		
		$arrOptions = get_option('WPComcar_plugin_options_comparator');
		//subpages where the different pages of the tax calculator will load
		$arrVansSubPages=array();
		$arrCarsSubPages=array();
		$arrOptions["pages"]=array();
		

		//if the same page, then it is an error
		if (strlen($input["comparator_cars_page"])>0 && strlen($input["comparator_vans_page"])>0){
			if (strcmp($input["comparator_cars_page"],$input["comparator_vans_page"] )==0){			
				//no error if the tax calculator cars page is not defined
				if (!strcmp($input["comparator_cars_page"],"0")==0){
					$this->pushError("The cars and the vans comparator parent pages need to be different");
					$input["comparator_cars_page"]="0";
					$input["comparator_vans_page"]="0";
				}
			}
		}

		foreach($input as $key=>$value){
			//escape characters
			$arrOptions[$key] = $input[$key];
			//found clk
			if(strpos($key,"_page")!==false){
				$arrOptions[$key] = esc_attr(trim($input[$key]));
				if(!preg_match('/^[0-9]+$/', $arrOptions[$key])) {
					//error
					$arrOptions["errors"]["page"]="Unknown page id";
					$arrOptions[$key] = '';
				}
			}
			//subpages where loading the cars and vans
			if (strpos($key,"vans_subpage")!==false && strlen($input[$key])>0){
				$thePosition=strpos($key,"vans_subpage");
				//return select, model, options or calc
				$theKeyInTheArr=substr($key,$thePosition+1+strlen("vans_subpage"), strlen($key));
				$arrVansSubPages[$theKeyInTheArr]=esc_attr(trim($input[$key]));

			}else if (strpos($key,"cars_subpage")!==false && strlen($input[$key])>0){
				$thePosition=strpos($key,"cars_subpage");
				//return select, model, options or calc
				$theKeyInTheArr=substr($key,$thePosition+1+strlen("cars_subpage"), strlen($key));
				$arrCarsSubPages[$theKeyInTheArr]=esc_attr(trim($input[$key]));
			}
		}
		
		$arrOptions["cars_subpages"]=$arrCarsSubPages;
		$arrOptions["vans_subpages"]=$arrVansSubPages;

		//as this is the last plugin loaded, check that all the pages are different. Otherwise prompt a warning!
		$this->checkAllPagesAreDifferentBeforeSaving();

		return $arrOptions;
	}

	function plugin_options_tax_calculator_validate($input){

		$arrOptions = get_option('WPComcar_plugin_options_tax_calculator');
		//subpages where the different pages of the tax calculator will load
		$arrVansSubPages=array();
		$arrCarsSubPages=array();
		$arrOptions["pages"]=array();
		

		//if the same page, then it is an error
		if (strlen($input["tax_calculator_cars_page"])>0 && strlen($input["tax_calculator_vans_page"])>0){
			if (strcmp($input["tax_calculator_cars_page"],$input["tax_calculator_vans_page"] )==0){			
				//no error if the tax calculator cars page is not defined
				if (!strcmp($input["tax_calculator_cars_page"],"0")==0){
					$this->pushError("The cars and the vans tax calculator parent pages need to be different");
					$input["tax_calculator_cars_page"]="0";
					$input["tax_calculator_vans_page"]="0";
				}
			}
		}

		foreach($input as $key=>$value){
			//escape characters
			$arrOptions[$key] = $input[$key];
			//found clk
			if(strpos($key,"_page")!==false){
				$arrOptions[$key] = esc_attr(trim($input[$key]));
				if(!preg_match('/^[0-9]+$/', $arrOptions[$key])) {
					//error
					$arrOptions["errors"]["page"]="Unknown page id";
					$arrOptions[$key] = '';
				}
			}
			//subpages where loading the cars and vans
			if (strpos($key,"vans_subpage")!==false && strlen($input[$key])>0){
				$thePosition=strpos($key,"vans_subpage");
				//return select, model, options or calc
				$theKeyInTheArr=substr($key,$thePosition+1+strlen("vans_subpage"), strlen($key));
				$arrVansSubPages[$theKeyInTheArr]=esc_attr(trim($input[$key]));

			}else if (strpos($key,"cars_subpage")!==false && strlen($input[$key])>0){
				$thePosition=strpos($key,"cars_subpage");
				//return select, model, options or calc
				$theKeyInTheArr=substr($key,$thePosition+1+strlen("cars_subpage"), strlen($key));
				$arrCarsSubPages[$theKeyInTheArr]=esc_attr(trim($input[$key]));
			}
		}

		$arrOptions["cars_subpages"]=$arrCarsSubPages;
		$arrOptions["vans_subpages"]=$arrVansSubPages;

		return $arrOptions;
	}
	/*************************************************************************************/



	/*************************** BACKEND SCRIPTS AND CSS *********************************/
	//register scripts and css for the back-end
	function admin_css_and_scripts(){
    	wp_register_script('comcar-admin-javascript', plugins_url( '/js/wp-comcar-plugins-admin.js', __FILE__ ), array( 'jquery' ) );   	
    	wp_register_style('comcar-admin-style', plugins_url( '/css/wp-comcar-plugins-admin.css', __FILE__ ));
    	$this->include_admin_js_and_css();
	}

	function include_admin_js_and_css(){

	 	wp_enqueue_script('comcar-admin-javascript');
	 	//pass some data to the javascript
		$dataToBePassed= $this::$arrOrderOfPlugins;
		wp_localize_script( 'comcar-admin-javascript', 'arrOrderOfPlugins', $dataToBePassed ); 	
	 	wp_enqueue_style('comcar-admin-style');
	}
	/*************************************************************************************/



	/****************** INTERNAL FUNCTIONS  *********************************************/
	function showErrorMessages(){
		//get the errors
		$arrOptions=get_option('WPComcar_plugin_options_general');
		$arrErrors=$arrOptions["errors"];

		if (count($arrErrors)>0){
			foreach($arrErrors as $key=>$error){
				echo "	<div id='message' class='error WPComcar_error' >
							$error
						</div>";
			}
		}

		//empty the array of errors
		$arrOptions["errors"]=array();
		update_option('WPComcar_plugin_options_general',$arrOptions);
	}

	function checkAllPagesAreDifferentBeforeSaving(){

		$typesOfVehicles=array("cars","vans");
		$numberOfDifferentVehicles=count($typesOfVehicles);
		$arrOfPageNumbers=array();

		//get the different ids
		foreach($this::$arrGroupOfPluginOptions as $thisKey=>$thisValue){
			$arrOptions=get_option("WPComcar_plugin_options_$thisKey");
			

			if (isset($arrOptions["$thisKey"."_page"])){

				//$arrPages[$key]=$arrOptions["$key"."_page"];
				array_push($arrOfPageNumbers,$arrOptions["$thisKey"."_page"]);
			}
			for($i=0;$i<$numberOfDifferentVehicles;$i++){
				if (isset($arrOptions["$thisKey"."_".$typesOfVehicles[$i]."_page"])){
					//$arrPages[$key][$i]=$arrOptions["$key"."_".$typesOfVehicles[$i]."_page"];
					array_push($arrOfPageNumbers,$arrOptions["$thisKey"."_".$typesOfVehicles[$i]."_page"]);
				}
			}
		}

		$numberOfPagesDefined=count($arrOfPageNumbers);
		//get rid of those where it is not defined (where the value equals 0)		
		for($i=0;$i<$numberOfPagesDefined;$i++){
			if($arrOfPageNumbers[$i]==0)
				unset($arrOfPageNumbers[$i]);
		}
		$arrNumberOfTimesRepeatedAValue=array_count_values($arrOfPageNumbers);


		foreach($arrNumberOfTimesRepeatedAValue as $key=>$times){
			if ($times>1){
				$this->pushError("The page <strong>". get_page($key)->post_title. "</strong> is used in more than one plugin. This may cause an unexpected behaviour");
			}
		}
	}

	//pushes errors into the main array of errors
	function pushError($error){		
		$arrOptions=get_option('WPComcar_plugin_options_general');
		array_push($arrOptions["errors"],$error);
		update_option('WPComcar_plugin_options_general',$arrOptions);
	}
	/************************************************************************************/
}

?>