<?php
$wp_comcar_plugins_results_css  = "";
$wp_comcar_plugins_results_js   = "";
$wp_comcar_plugins_results_html = "";
$wp_comcar_plugins_results_msg  = "";

try {	
	// get the page JS
	$wp_comcar_plugins_results_js = $wp_comcar_plugins_ws->GetJS(
		$plugin_call_van_channel_pubhash,
		$plugin_call_van_channel_id,
		1
	);
	
	// get the page HTML
	$wp_comcar_plugins_results_html = $wp_comcar_plugins_ws->GetHTML(
		$plugin_call_van_channel_pubhash,
		$plugin_call_van_channel_id,
		$plugin_call_stage,
		"https://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"], '?')
	);
} catch ( Exception $wp_comcar_plugins_err ) {
	// Append to error handling msg if SOAP request fails 
	var_dump($wp_comcar_plugins_err);
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the selector<br />';
}
?>
