<?php 


    global $post;
    $thePostId = $post->ID;
    $WPComcar_arrOptions = get_option( 'WP_plugin_options_prices_and_options' ); 
   
    $idThePageWhereShouldLoadThePlugin = $WPComcar_arrOptions["prices_and_options_page"];

    if (  $idThePageWhereShouldLoadThePlugin == $thePostId  ) {
        include_once ( WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Common-Files/requiredForCarTools.php' );

        // Convert structure into JSON
        $WPComcar_jsnConfig = json_encode(  $_POST );

        try {
            // connect to the webservice
            $WPComcar_ws = new SoapClient( $WPComcar_services['carDetails'], array( 'cache_wsdl' => 0 ) );
            $stage = "select";
            



            if ( array_key_exists('fmake',$_POST) ) {
                $stage = "details";
            } 
            




            $WPComcar_resultsHTML = fixForSsl( $WPComcar_ws -> GetHTML( $WPComcar_pubhash, $WPComcar_clk,$WPComcar_jsnConfig ));
            $WPComcar_resultsJS = fixForSsl( $WPComcar_ws -> GetJS( $WPComcar_pubhash, $WPComcar_clk,   $stage ) );
            $WPComcar_resultsCSS = fixForSsl( $WPComcar_ws -> GetCSS( $WPComcar_pubhash, $WPComcar_clk,   $stage ) );
                
        } catch ( Exception $WPComcar_e ) {
            // Error handling code if soap request fails 
            $WPComcar_msg = $WPComcar_msg.'The webservice failed to load the selector<br />';
        }
    
        include_once ( WPComcar_WEBSERVICESCALLSPATH . 'Carmen-Data-Web-Services-Template/template.php');
    } 

?>
