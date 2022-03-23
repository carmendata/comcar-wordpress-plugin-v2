<?php
$wp_comcar_plugins_results_css  = "";
$wp_comcar_plugins_results_js   = "";
$wp_comcar_plugins_results_html = "";
$wp_comcar_plugins_results_msg  = "";

try {
	// call the required functions and store the returned data
	$wp_comcar_plugins_results_js = $wp_comcar_plugins_ws->GetJS(
		$plugin_call_channel_pubhash,
		$plugin_call_channel_id,
		1
	);
	
	// check the make and model are present
	$required_data_present = true;
	if(!array_key_exists('MakeModel',$_GET)) {
		$wp_comcar_plugins_results_msg .= "A make and model needs to be selected, please go back to the select stage";
		$required_data_present = false;
	}
	
	// default fueltype to "ANY" if we don't have one
	$fueltype = array_key_exists('fjs_fueltype',$_GET) ? $_GET['fjs_fueltype'] : 'ANY';
	$fueltype = $fueltype === "" ? "ANY" : $fueltype;

	// build config object
	$company_car_tax_settings = get_option('wp_comcar_plugins_company_car_tax_settings');
	$company_car_tax_model_page_column_list = $company_car_tax_settings['wp_comcar_plugins_company_car_tax_settings_model_page_column_list'];
	$obj_config = array(
		'attributes' => $company_car_tax_model_page_column_list
	);

	// check for "order by" and direction
	if(array_key_exists('orderBy',$_GET)) {
		$obj_config['orderBY'] = $_GET['orderBy'];
	};
	if(array_key_exists('orderDir',$_GET)) {
		$obj_config['orderDir'] = $_GET['orderDir'];
	};

	$json_config = json_encode($obj_config);

	// if we don't have enough data we can't load the model page
	if($required_data_present) {
		$wp_comcar_plugins_results_html = $wp_comcar_plugins_ws->GetHTML(
			$plugin_call_channel_pubhash,
			$plugin_call_channel_id,
			$plugin_call_stage,
			"http://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"], '?'),
			$_GET['MakeModel'].'~'.$fueltype.'~'.$json_config
		);

		$wp_comcar_plugins_results_js = $wp_comcar_plugins_ws->GetJS(
			$plugin_call_channel_pubhash,
			$plugin_call_channel_id,
			$plugin_call_stage,
		);
	}
} catch ( Exception $wp_comcar_plugins_err ) {
	// Append to error handling msg if SOAP request fails 
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the model list<br />';
}
?>
