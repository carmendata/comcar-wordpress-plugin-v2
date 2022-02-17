<?php 
switch($plugin_call_stage) {
	case 1:
		include_once('Car-select.php');
		break;
	case 2:
		include_once('Car-model.php');
		break;
	case 3:
		include_once('Car-options.php');
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
