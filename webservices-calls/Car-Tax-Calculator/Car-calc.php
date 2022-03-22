<?php
	// vehicle ID, anncon and capcon will be sent in URL $_GET
	// but coming from the options page will submit a form that will contain option data
	// vehicle_ID at the very least must be supplied
	if(!isset($_GET['anncon'])) {  $_GET['anncon']="";  }
	if(!isset($_GET['capcon']))   {  $_GET['capcon']="";  }
	if(!isset($_POST['frm_listID'])) {  $_POST['frm_listID']="";  }
	if(!isset($_POST['optTotal']))   {  $_POST['optTotal']="";  }

	// remove trailing slash from option list
	$_POST['frm_listID'] = preg_replace('/,$/','',$_POST['frm_listID']);

	// get $_POST data
	$wp_comcar_plugins_options_form_data = "";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_GET['vehicle_id']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_GET['capcon']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_GET['anncon']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['frm_listID']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['optTotal'];

	try {
		$wp_comcar_plugins_results_html	= $wp_comcar_plugins_ws->GetHTML(
			$plugin_call_channel_pubhash,
			$plugin_call_channel_id,
			$plugin_call_stage,
			"",
			$wp_comcar_plugins_options_form_data
		);
	} catch (Exception $wp_comcar_plugins_e) {
		// Error handling code if soap request fails
		$wp_comcar_plugins_results_msg .= 'The webservice failed to load the Calculation<br />';
		var_dump($wp_comcar_plugins_e);
	}
?>
