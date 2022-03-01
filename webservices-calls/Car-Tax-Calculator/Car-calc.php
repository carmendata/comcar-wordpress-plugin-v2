<?php
	// defaults in case the page is visited without a $_POST submission from stage 1
	if(!isset($_GET['car']))         {  $_GET['car']="";  }
	if(!isset($_POST['car']))        {  $_POST['car']=$_GET['car'];  }

	if(!isset($_GET['id']))          {  $_GET['id']=$_POST['car'];  }
	if(!isset($_POST['id']))         {  $_POST['id']=$_GET['id'];  }

	if(!isset($_POST['CapCon']))     {  $_POST['CapCon']="";  }
	if(!isset($_POST['AnnCon']))     {  $_POST['AnnCon']="";  }
	if(!isset($_POST['frm_listID'])) {  $_POST['frm_listID']="";  }
	if(!isset($_POST['optTotal']))   {  $_POST['optTotal']="";  }

	// get $_POST data
	$wp_comcar_plugins_options_form_data = "";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['id']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['CapCon']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['AnnCon']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['frm_listID']."~";
	$wp_comcar_plugins_options_form_data = $wp_comcar_plugins_options_form_data.$_POST['optTotal'];

	try {
		$wp_comcar_plugins_results_js = $wp_comcar_plugins_ws->GetJS(
			$plugin_call_channel_pubhash,
			$plugin_call_channel_id,
			$plugin_call_stage,
			''
		);

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
