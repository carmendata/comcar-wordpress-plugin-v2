<?php
	/***************************************************************************
	* You can delete this file if you don't have Van tools                     *
	*                                                                          *
	* Authentication variables.                                                *
	* Replace with your numeric channel id for cars and your publisher hash,   *
	* which Comcar has supplied to you                                         *
	***************************************************************************/

	//here we need to access the cars information of the user
	//in case there is no one, use the demo one
	
	$WPComcar_options = get_option('WP_plugin_options_general');	

	$WPComcar_clk = WPComcar_CLKDEFAULTVANS;
	$WPComcar_pubhash = WPComcar_PUBHASHDEFAULTVANS;
	$type_vehicle = "Van";
	if (isset($WPComcar_options["clkVans"]) && strlen($WPComcar_options["clkVans"])>0){
		$WPComcar_clk=$WPComcar_options["clkVans"];
	}
	if (isset($WPComcar_options["pushVans"]) && strlen($WPComcar_options["pushVans"])>0){
		$WPComcar_pubhash=$WPComcar_options["pushVans"];
	}


	include_once 'required.php';
?>