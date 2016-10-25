<?php
	// Vehicle type ('Car' or 'Van'). The variable is defined in either 'Car-select.php' or 'Van-select.php'
	if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Car";    }


	$_POST['thisPage'] = 'select.php';

	try {

		//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
		$WPComcar_arrOptions=get_option("WP_plugin_options_comparator");	
		$WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');		

		//lets set the textareas 
		if (isset($WPComcar_arrOptions["comparator_".$WPComcar_vehicleTypeForIncluding."_texts"])){
			$arrOfTexts=$WPComcar_arrOptions["comparator_".$WPComcar_vehicleTypeForIncluding."_texts"];
			foreach( $arrOfTexts as $key => $value ) {
				//if it is not defined, then use the default ones
				if ( strlen( $value ) > 0 ) {
					$_POST[$key] = $value;
				}
			}
		}


		$WPComcar_jsnData = json_encode($_POST);

		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["details"];
		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);


		// connect to the webservice
		$WPComcar_ws = new SoapClient( $WPComcar_services['comparator'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsJS   = fixForSsl( $WPComcar_ws -> GetJS   ( $WPComcar_pubhash, $WPComcar_clk, 'select'));
		$WPComcar_resultsHTML = fixForSsl(  $WPComcar_ws -> GetHTML ( $WPComcar_pubhash, $WPComcar_clk, 'select', $WPComcar_actionName, $WPComcar_jsnData));

	} catch (Exception $WPComcar_e) {

		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the selector<br />';
	}

	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
