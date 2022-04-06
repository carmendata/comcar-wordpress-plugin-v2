<?php 
// update the URL
$wp_comcar_plugin_ws_options['uri'] =WP_COMCAR_PLUGIN_WS_URL . 'VanCalc.cfc?wsdl';
$wp_comcar_plugin_ws_options['location'] =WP_COMCAR_PLUGIN_WS_URL . 'VanCalc.cfc?wsdl';

// connect to the webservice
$wp_comcar_plugins_ws = new SoapClient(
	NULL,
	$wp_comcar_plugin_ws_options
);

switch($plugin_call_stage) {
	case 1:
		include_once('Van-select.php');
		break;
	case 2:
		include_once('Van-model.php');
		break;
	case 3:
		include_once('Van-calc.php');
		break;
	default:
		$wp_comcar_plugins_results_html = 'Invalid stage loaded';
}
			
?>
