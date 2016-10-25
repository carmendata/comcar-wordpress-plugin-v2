<?php



// include authentication and other required variables
    include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Common-Files/requiredForCarTools.php');
       // include code with the actual call to the web service

    $WPComcar_objConfig = array();
    $WPComcar_objConfig['formMethod'] = 'get'; // Must be "get" or "post", anything else will be rejected
    $WPComcar_objConfig['thisPage'] = 'detail.php';
    // Convert structure into JSON
    $WPComcar_jsnConfig = json_encode( $WPComcar_objConfig );

    try {
        // connect to the webservice
        $WPComcar_ws = new SoapClient( $WPComcar_services['fuelBenefit'], array( 'cache_wsdl' => 0 ) );

        // call the required functions and store the returned data
    
        $WPComcar_resultsJS = fixForSsl( $WPComcar_ws -> GetJS( $WPComcar_pubhash, $WPComcar_clk, 1 ) );
     
        $WPComcar_arrOptions = get_option("WP_plugin_options_fuel_benefit_check");
        $WPComcar_actionName =  get_permalink($WPComcar_arrOptions['fuel_benefit_check_subpage_model']); 

        //CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress
        $WPComcar_arrOptions = get_option( "WP_plugin_options_fuel_benefit_check" );
    
        $WPComcar_resultsHTML = fixForSsl( $WPComcar_ws -> GetHTML( $WPComcar_pubhash, $WPComcar_clk,2,$WPComcar_actionName,$WPComcar_jsnConfig ));

    } catch (Exception $WPComcar_e) {
        // Error handling code if soap request fails 
        $WPComcar_msg = $WPComcar_msg.'The webservice failed to load the selector<br />';
    }
    
    include_once ( WPComcar_WEBSERVICESCALLSPATH . 'Carmen-Data-Web-Services-Template/template.php');
?>