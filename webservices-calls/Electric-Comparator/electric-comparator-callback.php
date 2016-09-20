<?php


	// get data from GET
	if(count($_GET)>0){
		$WPComcar_jsnData = json_encode($_GET);
	}else{
		echo "You cannot load the callback page";
		return;
	}
	
	try {
		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['electric-comparator'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsHTML = fixForSsl($WPComcar_ws->GetHTML($WPComcar_pubhash, $WPComcar_clk, 'callback', '', $WPComcar_jsnData));
		

		echo $WPComcar_resultsHTML;
	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the Callback stage<br />';
	}
	
	//flush the content of the 
	ob_get_clean();
	header('Content-type: application/json');
	echo $WPComcar_resultsHTML;
	exit();
?>
