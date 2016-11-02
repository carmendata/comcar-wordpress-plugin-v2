<?php 


    global $post;
    $thePostId = $post->ID;
    $WPComcar_arrOptions = get_option( 'WP_plugin_options_prices_and_options' ); 
   
    $idThePageWhereShouldLoadThePlugin = $WPComcar_arrOptions["prices_and_options_page"];

    if (  $idThePageWhereShouldLoadThePlugin == $thePostId  ) {
        include_once ( WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Common-Files/requiredForCarTools.php' );





       
        try {
            // connect to the webservice
            $WPComcar_ws = new SoapClient( $WPComcar_services['pricesAndOptions'], array( 'cache_wsdl' => 0 ) );
            $stage = "select";
           
            if (array_key_exists( 'fuelType', $_GET )) {
                $stage = "model";
            }    
         
            if (array_key_exists( 'ID', $_GET )) {
                $stage = "options";            
            }   

            if (array_key_exists( 'AnnCon', $_POST )) {

                $stage = "calculation";            
            }   


            $_POST['stage'] = $stage;
            
             // Convert structure into JSON
            $WPComcar_jsonPost = json_encode(  $_POST );
            $WPComcar_jsonGet = json_encode(  $_GET );

            $WPComcar_resultsHTML = fixForSsl( $WPComcar_ws -> GetHTML( $WPComcar_pubhash, $WPComcar_clk, $stage, $WPComcar_jsonPost, $WPComcar_jsonGet  ));
            $WPComcar_resultsJS = fixForSsl( $WPComcar_ws -> GetJS( $WPComcar_pubhash, $WPComcar_clk,   $stage,  $WPComcar_jsonGet ) );
            $WPComcar_resultsCSS = fixForSsl( $WPComcar_ws -> GetCSS( $WPComcar_pubhash, $WPComcar_clk,   $stage ) );
                
        } catch ( Exception $WPComcar_e ) {
            // Error handling code if soap request fails 
            $WPComcar_msg = $WPComcar_msg.'The webservice failed to load the selector<br />';
        }
    
        include_once ( WPComcar_WEBSERVICESCALLSPATH . 'Carmen-Data-Web-Services-Template/template.php');
    } 

?>
