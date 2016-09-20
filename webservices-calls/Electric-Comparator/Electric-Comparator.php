<?php

    //create and instance of the controller and include the result in the page
    global $objWPElectricComparatorController;
    if (class_exists("WPElectricComparatorController") && !$objWPElectricComparatorController) {
        $objWPElectricComparatorController = new WPElectricComparatorController();    
        $objWPElectricComparatorController->controller();
    }

    //include the page
    include_once($objWPElectricComparatorController->thePageToInclude);

    class WPElectricComparatorController{

        public $thePageToInclude;

        function __construct(){
        }

        function controller(){
            global $post;
            $thePostId=$post->ID;
            $this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Electric-Comparator/comparation.php";
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
