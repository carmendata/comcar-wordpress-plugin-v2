<?php 

	global $post;
	$thePostId=$post->ID;


// worth do thisPlugin variable global to reuse the code inside this file?
// Decide which page should we include??????




	$arrOptions = get_option('WP_plugin_options_fuel_benefit_check'); 
	$thePageParents = get_post_ancestors( $post->ID );
	/* Get the top Level page->ID count base 1, array base 0 so -1 */ 
	$parentId = ( $thePageParents ) ? $thePageParents[ count( $thePageParents ) - 1 ]: $post->ID;

	$idThePageWhereShouldLoadThePlugin = $arrOptions["fuel_benefit_check_page"];
echo $thePostId;

	if (strcmp($idThePageWhereShouldLoadThePlugin,$thePostId) == 0){
		$pageToInclude = WPComcar_WEBSERVICESCALLSPATH . "Fuel-Benefit-check/select.php";

	
 	include_once( $pageToInclude );
	} 


?>
