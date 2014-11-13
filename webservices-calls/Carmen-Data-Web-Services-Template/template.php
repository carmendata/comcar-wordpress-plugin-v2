<!-- Calling the Comcar Tools plugin for WordPress version <?php print WPComcar_PLUGINVERSION ?> -->
<?php
	if(!isset($WPComcar_resultsCSS))	{	$WPComcar_resultsCSS="";	}
	if(!isset($WPComcar_resultsJS))		{	$WPComcar_resultsJS="";		}
	if(!isset($WPComcar_resultsHTML))	{	$WPComcar_resultsHTML="";	}
	if(!isset($WPComcar_msg))			{	$WPComcar_msg="";			}
?>
<?php
	$WPComcar_theResultOfTheWebservice = '';
	$WPComcar_theResultOfTheWebservice .= '<!-- Start of the output for the Comcar Tools plugin for WordPress version ' . WPComcar_PLUGINVERSION . ' -->';
	if( strlen($WPComcar_msg) ){
		$WPComcar_theResultOfTheWebservice .= '<p>' . $WPComcar_msg . '</p>';
	}else{
		$WPComcar_theResultOfTheWebservice .= $WPComcar_resultsCSS . $WPComcar_resultsJS . '<div id="WPComcar_container">' . $WPComcar_resultsHTML . '</div>';
	}
	$WPComcar_theResultOfTheWebservice .= '<!-- End of the output for the Comcar Tools plugin for WordPress version ' . WPComcar_PLUGINVERSION . ' -->';
?>
