<?php
/**
 * Plugin Name:  Comcar Tools
 * Plugin URI: http://github.com/carmendata/comcar-wordpress-plugin/wiki
 * Description: Includes the Tax Calculator, Vehicle Comparator amd Emissions Footprint Calculator from comcar.co.uk.
 * Version: 1.4.0
 * Author: Carmen data
 * Author URI: http://carmendata.co.uk/
 * License: GPL2
 */



// Uncomment if you want to debug to receive warnings and errors
// ini_set( 'error_reporting', E_ALL );
// ini_set( 'display_errors', true );

define( "WPComcar_PLUGINVERSION","1.4.0" );

require_once( __DIR__."/wp-comcar-constants.php" );
require_once( __DIR__."/admin/wp-comcar-plugins-admin-html.php" );


add_action( "wp", "plugin_redirection" );    
add_action( "wp_head", "activate_page_plugins");   

wp_register_style( "wp_ibuttons" , plugins_url( "/css/i_buttons.css", __FILE__ ));
wp_register_script( "wp_ibuttons" , plugins_url( "/js/i_buttons.js", __FILE__ ));




// decode url from base64
function decodeURLParam( $str_to_decode ) {
	// decode string (can't use hex2bin prior to php5.4)
    $cnt_code = strlen( $str_to_decode ); 
    $unhexed_taxcalculatorcode = "";   
    $i = 0; 
    while($i < $cnt_code ) {       
        $a = substr( $str_to_decode, $i, 2 );           
        $c = pack( "H*", $a ); 
        if ( $i == 0 ) {
        	$unhexed_taxcalculatorcode = $c;
       	} else {
       		$unhexed_taxcalculatorcode .= $c;
       	} 
        $i += 2; 
    } 
    return base64_decode( $unhexed_taxcalculatorcode );
}


function do_redirection( $post_to_override, $str_code ) {
    if( !empty( $_POST ) OR isset( $_GET[$str_code] ) ) {
        if( isset( $_GET[$str_code] )) {
            $_POST =  (array) json_decode( base64_decode( $_GET[$str_code]) );  
        } else if ( $post_to_override ) {
            $WPComcar_hashedData = base64_encode( json_encode( $_POST ));                
            header( "Location: $post_to_override?$str_code=$WPComcar_hashedData");
            exit(1);
        }  
    }
}




// process any actions that need to be done before page rendering
function plugin_redirection() {
    global $pagename;
    global $post;
    $post_id = $post->ID;

    $WPTax_calc_arrOptions = get_option( "WP_plugin_options_tax_calculator" ); 
    $WPComparator_arrOptions = get_option( "WP_plugin_options_comparator" );
    $WPFuel_benefit_check_arrOptions = get_option( "WP_plugin_options_fuel_benefit_check" );
    $WPcar_details_arrOptions = get_option( "WP_plugin_options_car_details" );
    $WPprices_and_options_arrOptions = get_option( "WP_plugin_options_prices_and_options" );
    $WPchooser_arrOptions = get_option( "WP_plugin_options_chooser" );
  
    $WPComcar_arrOptions = array_merge ( $WPTax_calc_arrOptions, $WPComparator_arrOptions );

    switch( $post_id ) {
        case $WPComcar_arrOptions["tax_calculator_cars_subpage_calc"] : 
            // check for calculation redirect
            $WPComcar_tax_calc_override = $WPComcar_arrOptions["tax_calculator_cars_calc_override"];

            if( isset($_GET["taxcalculatorcode"] ) ) {

                // if there is encoded data put it back into the form
                $encoded_taxcalculatorcode = htmlspecialchars( $_GET[ "taxcalculatorcode" ] );
                $decoded_taxcalculatorcode =   decodeURLParam( $encoded_taxcalculatorcode );
                $arr_decoded = explode( "~", $decoded_taxcalculatorcode );
                $_POST["id"] = $arr_decoded[ 0 ];

                if( count( $arr_decoded > 1 ) ) {
                    $_POST["CapCon"] = $arr_decoded[ 1 ];
                    $_POST["AnnCon"] = $arr_decoded[ 2 ];
                    $_POST["frm_listID"] = $arr_decoded[ 3 ];
                    $_POST["optTotal"] = $arr_decoded[ 4 ];
                }

            } else if ( $WPComcar_tax_calc_override ) {
                // if an override exists, encode data and transmit
				$_GET["car"]		= isset( $_GET["car"]) ? $_GET["car"] : "";
              	$_POST["car"]		= isset( $_POST["car"]) ? $_POST["car"] : $_GET["car"];
              	$_GET["id"]			= isset( $_GET["id"]) ? $_GET["car"] : $_POST["car"];
              	$_POST["id"]		= isset( $_POST["id"]) ? $_POST["id"] : $_GET["id"];
              	$_POST["CapCon"]	= isset( $_POST["CapCon"]) ? $_POST["CapCon"] : "";
              	$_POST["AnnCon"]	= isset( $_POST["AnnCon"]) ? $_POST["AnnCon"] : "";
              	$_POST["frm_listID"]= isset( $_POST["frm_listID"]) ? $_POST["frm_listID"] : "";
              	$_POST["optTotal"]	= isset( $_POST["optTotal"]) ? $_POST["optTotal"] : "";
              	 
                // create formData string to encode as base64
                $WPComcar_formData = 	$_POST["id"]."~"
                						.$_POST["CapCon"]."~"
                						.$_POST["AnnCon"]."~"
                						.$_POST["frm_listID"]."~"
                						.$_POST["optTotal"];

                $WPComcar_hashedData = bin2hex( base64_encode( $WPComcar_formData ) );
                header( "Location: $WPComcar_tax_calc_override?taxcalculatorcode=$WPComcar_hashedData");
                exit(1);
            }

        break;

        case $WPComcar_arrOptions["comparator_cars_subpage_details"]:   
            $WPComcar_comparator_override= $WPComcar_arrOptions["comparator_cars_comp_override"];       
              // check for calculation redirect
            if( isset($_GET["comparatorcode"])) {
                $_POST =  (array) json_decode(base64_decode($_GET["comparatorcode"]));  
            } else if ( $WPComcar_comparator_override ) {
                if( !isset( $_POST ) ) {  
                    $_POST = $_GET;  
                }
                $WPComcar_hashedData = base64_encode( json_encode( $_POST ));                
                header( "Location: $WPComcar_comparator_override?comparatorcode=$WPComcar_hashedData");
                exit(1);
            }
        break;

        case $WPFuel_benefit_check_arrOptions['fuel_benefit_check_page']:        
            $fuel_benefit_override= $WPFuel_benefit_check_arrOptions["fuel_benefit_check_override"];       
            do_redirection( $fuel_benefit_override, "fuelBenefitCode" );               
        break;

        case $WPcar_details_arrOptions['car_details_page']: 
            $car_details_override= $WPcar_details_arrOptions["car_details_override"];       
            do_redirection( $car_details_override, "carDetailsCode" );               
        break;

        case $WPprices_and_options_arrOptions['prices_and_options_car_page']: 

            $_POST['get_content'] = json_encode($_GET); 
            $car_details_override= $WPprices_and_options_arrOptions["prices_and_options_car_override"];       
            if( !empty( $_POST ) OR isset( $_GET["carPricesAndOptionsCode"] ) ) {
                if( isset( $_GET["carPricesAndOptionsCode"] )) {
                    $_POST =  (array) json_decode( base64_decode( $_GET["carPricesAndOptionsCode"]) );  
                    $_GET = (array)json_decode($_POST['get_content']);   
                } else if ( $car_details_override ) {                            
                    if ( $_POST['submit'] == 'Calculate' ) {
                        $WPComcar_hashedData = base64_encode( json_encode( $_POST ));                
                        header( "Location: $car_details_override?carPricesAndOptionsCode=$WPComcar_hashedData");
                        exit(1);
                    }
                }  
            }
             
        break;

        case $WPprices_and_options_arrOptions['prices_and_options_van_page']: 
            $_POST['get_content'] = json_encode($_GET); 
            $van_details_override= $WPprices_and_options_arrOptions["prices_and_options_van_override"];       
                  
            if( !empty( $_POST ) OR isset( $_GET["vanPricesAndOptionsCode"] ) ) {
                if( isset( $_GET["vanPricesAndOptionsCode"] )) {
                    $_POST =  (array) json_decode( base64_decode( $_GET["vanPricesAndOptionsCode"]) );  
                    $_GET = (array)json_decode($_POST['get_content']);   
                } else if ( $van_details_override ) {
                    if ( $_POST['submit'] == 'Calculate' ) {
                        $WPComcar_hashedData = base64_encode( json_encode( $_POST ));                
                        header( "Location: $van_details_override?vanPricesAndOptionsCode=$WPComcar_hashedData");
                        exit(1);
                    }
                }  
            }  
        break;


         case $WPchooser_arrOptions['chooser_car_page']: 

            $_POST['get_content'] = json_encode($_GET); 
            $chooser_override= $WPchooser_arrOptions["chooser_car_override"];    
            if( !empty( $_POST ) OR isset( $_GET["carChooserCode"] ) ) {
                if( isset( $_GET["carChooserCode"] )) {
                    $_POST =  (array) json_decode( base64_decode( $_GET["carChooserCode"]) );  
                    $_GET = (array)json_decode($_POST['get_content']);   
                } else if ( $chooser_override ) {                            

                    if ( $_POST['submit'] == 'Calculate' ) {
                        $WPComcar_hashedData = base64_encode( json_encode( $_POST ));                
                        header( "Location: $chooser_override?carChooserCode=$WPComcar_hashedData");
                        exit(1);
                    }
                }  
            }
             
        break; 

         case $WPchooser_arrOptions['chooser_van_page']: 

            $_POST['get_content'] = json_encode($_GET); 
            $chooser_override = $WPchooser_arrOptions["chooser_van_override"];    
            if( !empty( $_POST ) OR isset( $_GET["vanChooserCode"] ) ) {
                if( isset( $_GET["vanChooserCode"] )) {
                    $_POST =  (array) json_decode( base64_decode( $_GET["vanChooserCode"]) );  
                    $_GET = (array)json_decode($_POST['get_content']);   
                } else if ( $chooser_override ) {                            

                    if ( $_POST['submit'] == 'Calculate' ) {
                        $WPComvan_hashedData = base64_encode( json_encode( $_POST ));                
                        header( "Location: $chooser_override?vanChooserCode=$WPComvan_hashedData");
                        exit(1);
                    }
                }  
            }
             
        break; 
    }
}






//this function is called once every post and will call the desired plugin function
function activate_page_plugins( ) {           

    $loadCssAndJavascript = false;
    $arrGeneralSettings = get_option("WP_plugin_options_general");
    require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-global-objects.php");
   
    global $plugin_nav;        
    global $thisPluginName;
    global $post;
    global $current_page;
  
    $thisPluginName = '';
    $idOfTheCurrentPage = get_post( $post )->ID;


    foreach (  $plugin_nav as $thisPluginName => $plugin_info ) { 

        //if it is not activated jump to next 
        if ( !isset( $arrGeneralSettings["pluginsOptions"][$thisPluginName] )) {
            continue;
        }

        //options of the current plugin
        $arrOptions = get_option("WP_plugin_options_".$thisPluginName);
  
        // if the arrOption is empty also jump to next one
        if ( !isset( $arrOptions ) ) {
            continue;
        }
        $arr_sub_pages = matchPattern( "#^".$thisPluginName."(.*)page(.*)$#i", $arrOptions );

        foreach( $arr_sub_pages as $key => $value ) {



          
            if ( $value == $idOfTheCurrentPage ) { 
                if ( isset( $arrOptions["pages"] ) &&
                    is_array( $arrOptions["pages"] ) ) {

                    foreach( $arrOptions["pages"] as $page_key => $page) {        
                        $arr_pages =  preg_match ( "#^(.*)".$page."(.*)$#i", $key );
                        if ( $arr_pages ) {
                            $current_page = $page;
                            break;
                        }
                    }
                } else {
                    $current_page = '';
                }

                $loadCssAndJavascript = true;         
                add_filter( "the_content",  "getToolContent" );
                break 2;
            }
        }
    }

    if ( $loadCssAndJavascript ) {
        // Trick to avoid errors with some versions of jquery
        echo "<script> $=jQuery; </script>";
        wp_enqueue_script("comcar-javascript");
        wp_enqueue_style("comcar-style");
    }
}


// include the webservices-calls
function getToolContent(  ) {
    global $thisPluginName;
    global $current_page;

    if( is_page() && is_main_query() ) { 
        switch ( $thisPluginName ) {
            case "tax_calculator":
                // Van or Car?
                if ( $current_page =='cars' ) {
                    $path_to_include = "Tax-Calculator/Car-tax-calculator.php";                  
                } else {
                    $path_to_include = "Tax-Calculator/Van-tax-calculator.php";
                }
            break;
            case "comparator":
                // Van or Car?
                if ( $current_page =='cars' ) {
                    $path_to_include = "Comparator/Car-comparator.php";
                } else {
                    $path_to_include = "Comparator/Van-comparator.php";                   
                }
            break;
            case "footprint":
                $path_to_include = "Footprint-Calculator/Footprint-Calculator.php";
            break;
            case "electric_comparator": 
                $path_to_include = "Electric-Comparator/Electric-Comparator.php";
            break;
            case "fuelprices": 
                $path_to_include = "FuelPrices/FuelPrices.php";
            break;
            case "fuel_benefit_check":
                // When the old tools has been changed we can put this code at the very top of the page
                wp_enqueue_style('wp_ibuttons');
                wp_enqueue_script('wp_ibuttons');  
                $path_to_include = "Fuel-Benefit-check/Fuel-benefit-check.php";
            break;
            case "car_details":
                wp_enqueue_style('wp_ibuttons');
                wp_enqueue_script('wp_ibuttons');  

                $path_to_include = "Car_Details/Car_details.php";
            break;

            case "prices_and_options":
                wp_enqueue_style('wp_ibuttons');
                wp_enqueue_script('wp_ibuttons');  

                $path_to_include = "prices-And-Options/prices_and_options.php";           
            break;

            case "chooser":
                wp_enqueue_style('wp_ibuttons');
                wp_enqueue_script('wp_ibuttons');  

              $path_to_include = "Chooser/chooser.php";     

            break;




            default:
                $path_to_include = "";
            break;
        }
                     
    	include_once( WPComcar_WEBSERVICESCALLSPATH.$path_to_include );                 

        $WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
		$content = isset( $content ) ? $content : "";
        $content = $content.$WPComcar_theResultOfTheWebservice;
        return $content;
    }   
}  

?>
