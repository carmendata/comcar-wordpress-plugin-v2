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
	// get the page JS
	$wp_comcar_plugins_results_js = $wp_comcar_plugins_ws->GetJS(
		$plugin_call_channel_pubhash,
		$plugin_call_channel_id,
		1
	);
	
	// get the page HTML
	$wp_comcar_plugins_results_html = $wp_comcar_plugins_ws->GetHTML(
		$plugin_call_channel_pubhash,
		$plugin_call_channel_id,
		$plugin_call_stage,
		"http://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"], '?')
	);
} catch ( Exception $wp_comcar_plugins_err ) {
	// Append to error handling msg if SOAP request fails 
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the selector<br />';
}
?>
