<?php

	//create and instance of the controller and include the result in the page
	global $objWPComcarVanComparatorController;
	if (class_exists("WPComcarVanComparatorController") && !$objWPComcarVanComparatorController) {
	    $objWPComcarVanComparatorController = new WPComcarVanComparatorController();	
	    $objWPComcarVanComparatorController->controller();
	}

	//include the page
	include_once($objWPComcarVanComparatorController->thePageToInclude);

	class WPComcarVanComparatorController{

		public $thePageToInclude;

		function __construct(){
		}

		function controller(){

			

			global $post;
			$thePostId=$post->ID;

			//decide what page to load
			//parent or subpage?
			$arrOptions = get_option('WP_plugin_options_comparator');

			//check if the parent title is the one expected
			$theIdPageWhereShouldLoadThePlugin=$arrOptions["comparator_vans_page"];
			if (strcmp($theIdPageWhereShouldLoadThePlugin,$thePostId)==0){
				$this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Comparator/Van-select.php";
			}else if (in_array($thePostId,$arrOptions["vans_subpages"])){
				$theNameOfThePage=array_search($thePostId,$arrOptions["vans_subpages"]);
				$this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Comparator/Van-$theNameOfThePage.php";
			}
		}
	
	}
?>
