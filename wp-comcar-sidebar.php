<?php
	$plugin_dir = dirname( plugin_dir_path( __FILE__ ) )
					. '/'
					. $instance[ 'plugin_target' ]
					. '/';

	include $plugin_dir . 'webservices-calls/Tax-Calculator/Car-select.php';

	echo $WPComcar_resultsHTML;
?>
