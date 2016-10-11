<?php 
	
	//create and instance of the controller and include the result in the page
	global $objWPComcarVanTaxCalculatorController;
	if (class_exists("WPComcarVanTaxCalculatorController") && !$objWPComcarVanTaxCalculatorController) {
	    $objWPComcarVanTaxCalculatorController = new WPComcarVanTaxCalculatorController();	
	    $objWPComcarVanTaxCalculatorController->controller();
	}

	//include the page
	include_once($objWPComcarVanTaxCalculatorController->thePageToInclude);

	class WPComcarVanTaxCalculatorController{

		public $thePageToInclude;

		function __construct(){

		}

		function controller(){

			global $post;
			$thePostId=$post->ID;

			//decide what page to load
			//parent or subpage?
			$arrOptions = get_option('WP_plugin_options_tax_calculator');

			$idThePageWhereShouldLoadThePlugin=$arrOptions["tax_calculator_vans_page"];
			
			if(strcmp($idThePageWhereShouldLoadThePlugin,$thePostId)==0){
				$this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Van-select.php";
			}else if (in_array($thePostId,$arrOptions["vans_subpages"])){
				//check if the parent is the one expected
				if (strcmp($idThePageWhereShouldLoadThePlugin, $this->getParentId())==0){
					$theNameOfThePage=array_search($thePostId,$arrOptions["vans_subpages"]);
					$this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Van-$theNameOfThePage.php";
				}				
			}
		}

		function getParentId(){
			global $post;
			$thePageParents = get_post_ancestors( $post->ID );
	        /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
			$parentId = ($thePageParents) ? $thePageParents[count($thePageParents)-1]: $post->ID;
			return $parentId;
		}
	}
?>
