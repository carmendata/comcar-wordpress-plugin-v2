<?php 
	switch($plugin_call_stage) {
		case 1:
			$wp_comcar_plugins_results_html = 'Load the select stage';
			break;
		case 2:
			$wp_comcar_plugins_results_html = 'Load the derivative list stage';
			break;
		case 3:
			$wp_comcar_plugins_results_html = 'Load the options stage';
			break;
		case 4:
			$wp_comcar_plugins_results_html = 'Load the calculation stage';
			break;
		default:
			$wp_comcar_plugins_results_html = 'Invalid stage loaded';
	}
                
	//include the page
	// include_once($objWPComcarCarTaxCalculatorController->thePageToInclude);
?>
