<?php

	

	// get data from GET
	if(count($_GET)>0){
		$WPComcar_jsnData = json_encode($_GET);
	}else{
		$WPComcar_jsnData = '{}';
		//redirect to the select of the comparator
		//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
		$WPComcar_arrOptions=get_option("WPComcar_plugin_options_comparator");
		$WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');	

		//callback page
		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["select"];
		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);
		
		//redirect to the callback page
		//echo "<script> window.top.location='$WPComcar_actionName';</script>";
		echo "You cannot load the callback page";
		return;
	}
	
	try {

		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['comparator'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsHTML = $WPComcar_ws->GetHTML($WPComcar_pubhash, $WPComcar_clk, 'callback', '', $WPComcar_jsnData);
	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the Callback stage<br />';
	}
	
	echo $WPComcar_resultsHTML;
?>
