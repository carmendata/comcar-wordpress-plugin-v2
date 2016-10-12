<?php
	/***************************************************************************
	* Authentication variables.                                                *
	* Replace with your numeric channel id for cars and your publisher hash,   *
	* which Comcar has supplied to you                                         *
	***************************************************************************/

	//here we need to access the cars information of the user
	//in case there is no one, use the demo one

	$WPComcar_options = get_option('WP_plugin_options_general');


	$WPComcar_clk = WPComcar_CLKDEFAULTCARS;
	$WPComcar_pubhash = WPComcar_PUBHASHDEFAULTCARS;

	if (isset($WPComcar_options["clkCars"]) && strlen($WPComcar_options["clkCars"])>0){
		$WPComcar_clk=$WPComcar_options["clkCars"];
	}
	if (isset($WPComcar_options["pushCars"]) && strlen($WPComcar_options["pushCars"])>0){
		$WPComcar_pubhash=$WPComcar_options["pushCars"];
	}

	include_once 'required.php';
?>
