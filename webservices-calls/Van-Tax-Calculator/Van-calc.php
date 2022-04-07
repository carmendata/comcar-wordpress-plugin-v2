<?php
	try {
		$wp_comcar_plugins_results_html	= $wp_comcar_plugins_ws->GetHTML(
			$plugin_call_car_channel_pubhash,
			$plugin_call_car_channel_id,
			$plugin_call_stage,
			"",
			$_GET['vehicle_id']
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
