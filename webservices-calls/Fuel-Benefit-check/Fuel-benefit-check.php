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
	

	if (  $idThePageWhereShouldLoadThePlugin == $thePostId  ) {
		$pageToInclude = WPComcar_WEBSERVICESCALLSPATH . "Fuel-Benefit-check/select.php";
 		include_once( $pageToInclude );
	} else {
		foreach ($arrOptions as $page_label => $page_id ) {
			if ( $page_id == $thePostId ) {
			
				$pageToLoad =str_replace('fuel_benefit_check_subpage_','', $page_label );
				
				$pageToInclude = WPComcar_WEBSERVICESCALLSPATH . "Fuel-Benefit-check/" . $pageToLoad . ".php";
 				include_once( $pageToInclude );
	
				break;
			}
	 	} 	
	}

?>
