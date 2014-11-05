<?php
	// include authentication and other required variables
	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Common-Files/requiredForVanTools.php');

	if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Van";    }
	// include code with the actual call to the web service
	include_once 'common-callback.php';
?>
