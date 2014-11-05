<?php
	// Vehicle type ('Car' or 'Van'). The variable is defined in either 'Car-select.php' or 'Van-select.php'
	if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Car";    }
	
	$WPComcar_objConfig = array();
	$WPComcar_objConfig['formMethod'] = 'get'; // Must be "get" or "post", anything else will be rejected

	// Convert structure into JSON
	$WPComcar_jsnConfig = json_encode($WPComcar_objConfig);

	try {
		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['taxcalc'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsJS = $WPComcar_ws->GetJS( $WPComcar_pubhash, $WPComcar_clk, 1, '' );
		
		//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
		$WPComcar_arrOptions=get_option("WPComcar_plugin_options_tax_calculator");
		$WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');		
		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["model"];

		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);


		$WPComcar_resultsHTML = $WPComcar_ws->GetHTML( $WPComcar_pubhash, $WPComcar_clk, 1, $WPComcar_actionName, $WPComcar_jsnConfig );

	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the selector<br />';
	}
	
	$WPComcar_pageTitle = 'Selector';
	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
