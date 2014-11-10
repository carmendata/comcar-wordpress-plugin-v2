<?php
	if(!isset($WPComcar_resultsCSS))	{	$WPComcar_resultsCSS="";	}
	if(!isset($WPComcar_resultsJS))		{	$WPComcar_resultsJS="";		}
	if(!isset($WPComcar_resultsHTML))	{	$WPComcar_resultsHTML="";	}
	if(!isset($WPComcar_pageTitle))		{	$WPComcar_pageTitle="";		}
	if(!isset($WPComcar_msg))			{	$WPComcar_msg="";			}
?>
<?php
	$WPComcar_theMessageOfTheWebservice= strlen($WPComcar_msg) ?'<p>'.$WPComcar_msg.'</p>' : '';
	$WPComcar_theResultOfTheWebservice=$WPComcar_resultsCSS.$WPComcar_resultsJS."<div id='WPComcar_container'>".$WPComcar_theMessageOfTheWebservice.$WPComcar_resultsHTML."</div>";
?>
<!-- Comcar Tools plugin for WordPress version <?php print WPComcar_PLUGINVERSION ?> -->
