<?php
	// Vehicle type ('Car' or 'Van'). The variable is defined in either 'Car-select.php' or 'Van-select.php'
	if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Car";    }

	// get data from POST
	$_POST['thisPage'] = 'select.php';
	$WPComcar_jsnData = json_encode($_POST);
	

	try {

		//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
		$WPComcar_arrOptions=get_option("WPComcar_plugin_options_comparator");
		$WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');		
		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["details"];

		//exit(var_dump($WPComcar_vehicleTypeForIncluding));

		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);


		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['comparator'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsJS   = $WPComcar_ws -> GetJS   ( $WPComcar_pubhash, $WPComcar_clk, 'select');
		$WPComcar_resultsHTML = $WPComcar_ws -> GetHTML ( $WPComcar_pubhash, $WPComcar_clk, 'select', $WPComcar_actionName, $WPComcar_jsnData);
	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the selector<br />';
	}

	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
