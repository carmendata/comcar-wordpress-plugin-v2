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

            //decide what page to load
            //parent or subpage?
            $arrOptions = get_option('WPComcar_plugin_options_electric_comparator');

            //check if the parent title is the one expected
            $theIdPageWhereShouldLoadThePlugin=$arrOptions["electric_comparator_page"];


            if (strcmp($theIdPageWhereShouldLoadThePlugin,$thePostId)==0){
                $this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Electric-Comparator/comparation.php";
            }else if (in_array($thePostId,$arrOptions["electric_comparator_subpages"])){
                if (strcmp($theIdPageWhereShouldLoadThePlugin, $this->getParentId())==0){
                    $theNameOfThePage=array_search($thePostId,$arrOptions["electric_comparator_subpages"]);
                   
                    $this->thePageToInclude=WPComcar_WEBSERVICESCALLSPATH."Electric-Comparator/electric-comparator-$theNameOfThePage.php";
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



















    // // include authentication and other required variables
    // include(WPComcar_WEBSERVICESCALLSPATH."/Carmen-Data-Web-Services-Common-Files/requiredForCarTools.php");

    // // Extra config info. All the parameters are optional: if not provided, the defaults will be used
    // $WPComcar_objConfig = array();
    // // Whether or not the HTML returned should be wrapped in a FORM tag
    // // Set this to false if your application has an external FORM tag wrapping the part of the code where the HTML of the web service will go
    // // In particular, .NET developers would probably want to set this parameter to false
    // // $objConfig['isFormWrapped'] = true;  // default="true"

    // // Merge POST data and config variables into single object
    // $WPComcar_objDataAndConfig = array();
    // $WPComcar_objDataAndConfig['data'] = $_POST;    // get data from POST
    // $WPComcar_objDataAndConfig['config'] = $WPComcar_objConfig;

    // // Serialize object to JSON
    // $WPComcar_jsnDataAndConfig = json_encode($WPComcar_objDataAndConfig);

    // try {
       
    //     // connect to the webservice
    //     $WPComcar_ws = new SoapClient($WPComcar_services['electric_comparator'], array('cache_wsdl' => 0, "Access-Control-Allow-Origin"=> '*'));
    //     // call the required functions and store the returned data
    //     $WPComcar_resultsJS = $WPComcar_ws->GetJS($WPComcar_pubhash, $WPComcar_clk);
    //     $WPComcar_resultsHTML = $WPComcar_ws->GetHTML($WPComcar_pubhash, $WPComcar_clk, 'callback', $WPComcar_jsnDataAndConfig);
         
        
    // } catch (Exception $e) {
  
    //     // Error handling code if soap request fails 
    //     $WPComcar_msg = $WPComcar_msg.'The webservice has failed loading<br />';
    // }
    
    // include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
