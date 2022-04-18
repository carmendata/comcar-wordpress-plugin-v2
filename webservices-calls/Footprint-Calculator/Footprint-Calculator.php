<?php 
// update the URL
$wp_comcar_plugin_ws_options['uri'] =WP_COMCAR_PLUGIN_WS_URL . 'Footprint.cfc?wsdl';
$wp_comcar_plugin_ws_options['location'] =WP_COMCAR_PLUGIN_WS_URL . 'Footprint.cfc?wsdl';

// connect to the webservice
$wp_comcar_plugins_ws = new SoapClient(
	NULL,
	$wp_comcar_plugin_ws_options
);

try {
	$wp_comcar_plugins_results_html	= $wp_comcar_plugins_ws->GetHTML(
		$plugin_call_car_channel_pubhash,
		$plugin_call_car_channel_id,
		$plugin_call_stage,
		""
	);
	$wp_comcar_plugins_results_js	= $wp_comcar_plugins_ws->GetJS(
		$plugin_call_car_channel_pubhash,
		$plugin_call_car_channel_id,
		$plugin_call_stage
	);
} catch (Exception $wp_comcar_plugins_e) {
	// Error handling code if soap request fails
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the Calculation<br />';
}
			
?>
