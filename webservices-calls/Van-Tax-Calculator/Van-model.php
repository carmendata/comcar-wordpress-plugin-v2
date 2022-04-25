<?php
$wp_comcar_plugins_results_css  = "";
$wp_comcar_plugins_results_js   = "";
$wp_comcar_plugins_results_html = "";
$wp_comcar_plugins_results_msg  = "";

try {
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
	$company_van_tax_settings = get_option('wp_comcar_plugins_company_van_tax_settings');
	$company_van_tax_model_page_column_list = $company_van_tax_settings['wp_comcar_plugins_company_van_tax_settings_model_page_column_list'];
	$company_van_tax_model_page_column_headings = $company_van_tax_settings['wp_comcar_plugins_company_van_tax_settings_model_page_column_headings'];
	$obj_config = array(
		'model_column_list' => $company_van_tax_model_page_column_list,
		'model_column_headers' => $company_van_tax_model_page_column_headings
	);

	// check for "order by" and direction
	if(array_key_exists('orderBy',$_GET)) {
		$obj_config['orderBy'] = $_GET['orderBy'];
	};
	if(array_key_exists('orderDir',$_GET)) {
		$obj_config['orderDir'] = $_GET['orderDir'];
	};

	$json_config = urlencode(json_encode($obj_config));

	// if we don't have enough data we can't load the model page
	if($required_data_present) {
		$wp_comcar_plugins_results_html = $wp_comcar_plugins_ws->GetHTML(
			$plugin_call_van_channel_pubhash,
			$plugin_call_van_channel_id,
			$plugin_call_stage,
			"https://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"], '?'),
			$_GET['MakeModel'].'~'.$fueltype.'~'.$json_config
		);
	}
} catch ( Exception $wp_comcar_plugins_err ) {
	// Append to error handling msg if SOAP request fails 
	$wp_comcar_plugins_results_msg .= 'The webservice failed to load the model list<br />';
	// var_dump($wp_comcar_plugins_err);
}
?>
