<?php

	//create and instance of the controller and include the result in the page
	global $objWPComcarCarComparatorController;
	if (class_exists("WPComcarCarComparatorController") && !$objWPComcarCarComparatorController) {
	    $objWPComcarCarComparatorController = new WPComcarCarComparatorController();	
	    $objWPComcarCarComparatorController->controller();
	}

	//include the page
	include_once($objWPComcarCarComparatorController->thePageToInclude);

	class WPComcarCarComparatorController{

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
			$theIdPageWhereShouldLoadThePlugin=$arrOptions["comparator_cars_page"];
			if (strcmp($theIdPageWhereShouldLoadThePlugin,$thePostId)==0){
				$this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Comparator/Car-select.php";
			}else if (in_array($thePostId,$arrOptions["cars_subpages"])){
				$theNameOfThePage=array_search($thePostId,$arrOptions["cars_subpages"]);
				$this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Comparator/Car-$theNameOfThePage.php";				
			}
		}	
	}
?>
