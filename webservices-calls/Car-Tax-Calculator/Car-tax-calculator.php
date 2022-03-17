<?php 
// update the URL
$wp_comcar_plugin_ws_options['uri'] =WP_COMCAR_PLUGIN_WS_URL . 'TaxCalc.cfc?wsdl';
$wp_comcar_plugin_ws_options['location'] =WP_COMCAR_PLUGIN_WS_URL . 'TaxCalc.cfc?wsdl';

// connect to the webservice
$wp_comcar_plugins_ws = new SoapClient(
	NULL,
	$wp_comcar_plugin_ws_options
);

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
		include_once('Car-calc.php');
		break;
	default:
		$wp_comcar_plugins_results_html = 'Invalid stage loaded';
}
			
//include the page
// include_once($objWPComcarCarTaxCalculatorController->thePageToInclude);
?>
