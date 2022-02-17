<?php
// include authentication and other required variables
// include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Common-Files/requiredForCarTools.php');

// Vehicle type ('Car' or 'Van'). The variable is defined in either 'Car-select.php' or 'Van-select.php'
// if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Car";    }

// $WPComcar_objConfig = array();
// $WPComcar_objConfig['formMethod'] = 'get'; // Must be "get" or "post", anything else will be rejected

// Convert structure into JSON
// $WPComcar_jsnConfig = json_encode($WPComcar_objConfig);

$wp_comcar_plugins_results_css  = "";
$wp_comcar_plugins_results_js   = "";
$wp_comcar_plugins_results_html = "";
$wp_comcar_plugins_results_msg  = "";

try {
	// connect to the webservice
	$wp_comcar_plugins_ws = new SoapClient(WP_COMCAR_PLUGIN_URL . 'TaxCalc.cfc?wsdl', array('cache_wsdl' => 0));
	
	// call the required functions and store the returned data
	$wp_comcar_plugins_results_js = $wp_comcar_plugins_ws->GetJS(
		$plugin_call_channel_pubhash,
		$plugin_call_channel_id,
		1
	);
	
	//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
	// $WPComcar_arrOptions=get_option("WP_plugin_options_tax_calculator");
	// $WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');		
	// $WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["model"];

	// $WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);

	// $wp_comcar_plugins_results_html = fixForSsl( $wp_comcar_plugins_ws->GetHTML( $WPComcar_pubhash, $WPComcar_clk, 1, $WPComcar_actionName, $WPComcar_jsnConfig ));
	$wp_comcar_plugins_results_html = $wp_comcar_plugins_ws->GetHTML(
		$plugin_call_channel_pubhash,
		$plugin_call_channel_id,
		$plugin_call_stage,
		"http://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"], '?')."?stage=2",
		json_encode(array(
			"formMethod"=>"GET"
		))
	);
} catch ( Exception $wp_comcar_plugins_err ) {
	// Append to error handling msg if SOAP request fails 
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the selector<br />';
	// var_dump($wp_comcar_plugins_err);
}
?>
