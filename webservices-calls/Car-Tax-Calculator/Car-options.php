<?php
// defaults in case the page is visited without URL parameters
if(!isset($_GET['vehicle_id']))     {  $_GET['vehicle_id'] = '';  }
if(!isset($_GET['capcon']))  		{  $_GET['capcon'] = '';  }
if(!isset($_GET['anncon']))  		{  $_GET['anncon'] = '';  }

// get vehicle id
$wp_comcar_plugins_vehicle_id = $_GET['vehicle_id'];
$wp_comcar_plugins_capcon = $_GET['capcon'];
$wp_comcar_plugins_anncon = $_GET['anncon'];

$wp_comcar_plugins_results_css  = "";
$wp_comcar_plugins_results_js   = "";
$wp_comcar_plugins_results_html = "";
$wp_comcar_plugins_results_msg  = "";

try {
	// call the required functions and store the returned data
	$wp_comcar_plugins_results_css = $wp_comcar_plugins_ws->GetCSS(
		$plugin_call_car_channel_pubhash,
		$plugin_call_car_channel_id,
		$plugin_call_stage
	);

	$wp_comcar_plugins_results_html	= $wp_comcar_plugins_ws->GetHTML(
		$plugin_call_car_channel_pubhash,
		$plugin_call_car_channel_id,
		$plugin_call_stage,
		"http://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"], '?'),
		"$wp_comcar_plugins_vehicle_id~$wp_comcar_plugins_capcon~$wp_comcar_plugins_anncon"
	);

} catch (Exception $wp_comcar_plugins_e) {
	// Error handling code if soap request fails 
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the Options configurator<br />';
	// var_dump($wp_comcar_plugins_e);
}

?>
