<?php
	// Vehicle type ('Car' or 'Van'). The variable is defined in either 'Car-options.php' or 'Van-options.php'
	if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Car";    }

	// defaults in case the page is visited without URL parameters
	if(!isset($_GET['car']))     {  $_GET['car'] = '';  }
	if(!isset($_GET['capcon']))  {  $_GET['capcon'] = '';  }
	if(!isset($_GET['anncon']))  {  $_GET['anncon'] = '';  }

	// defaults in case the page is visited without a form submission from stage 2 
	if(!isset($_POST['car']))    {  $_POST['car'] = isset($_GET['id']) ? $_GET['id'] : "" ;  }
	if(!isset($_POST['capcon'])) {  $_POST['capcon'] = $_GET['capcon'];  }
	if(!isset($_POST['anncon'])) {  $_POST['anncon'] = $_GET['anncon'];  }

	// get vehicle id
	$WPComcar_car 	= $_POST['car'];
	$WPComcar_capcon = $_POST['capcon'];
	$WPComcar_anncon = $_POST['anncon'];

	try {
		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['taxcalc'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsCSS 	= $WPComcar_ws->GetCSS($WPComcar_pubhash, $WPComcar_clk, 3);
		$WPComcar_resultsJS 	= $WPComcar_ws->GetJS($WPComcar_pubhash, $WPComcar_clk, 3, '');

		//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
		$WPComcar_arrOptions=get_option("WPComcar_plugin_options_tax_calculator");
		$WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');		
		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["calc"];
		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);
		
		$WPComcar_resultsHTML	= $WPComcar_ws->GetHTML($WPComcar_pubhash, $WPComcar_clk, 3,  $WPComcar_actionName, "$WPComcar_car~$WPComcar_capcon~$WPComcar_anncon");

	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the Options configurator<br />';
	}

	$WPComcar_pageTitle = "Options";
	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
