<?php
/**
 * Plugin Name:  Comcar Tools
 * Plugin URI: http://github.com/carmendata/comcar-wordpress-plugin/wiki
 * Description: Includes the Tax Calculator, Vehicle Comparator amd Emissions Footprint Calculator from comcar.co.uk.
 * Version: 1.0.0
 * Author: Carmen data
 * Author URI: http://carmendata.co.uk/
 * License: GPL2
 */

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

define( "WPComcar_PLUGINVERSION","1.0.0" );

require_once( __DIR__."/wp-comcar-constants.php" );
require_once( __DIR__."/admin/wp-comcar-plugins-admin-html.php" );


add_action( "wp", "plugin_redirection" );    
add_action( "wp_head", "activate_page_plugins");   



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

// process any actions that need to be done before page rendering
function plugin_redirection() {
    global $pagename;
    global $post;
    $post_id = $post->ID;

    $WPTax_calc_arrOptions = get_option( "WP_plugin_options_tax_calculator" ); 
    $WPComparator_arrOptions = get_option( "WP_plugin_options_comparator" );
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
    }
}



//this function is called once every post and will call the desired plugin function
function activate_page_plugins(){           

    $loadCssAndJavascript = false;
    $arrGeneralSettings = get_option("WP_plugin_options_general");
    require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-global-objects.php");
   
    global $plugin_nav;        
    global $current_tool_name;
    global $post;

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
         
        // Has the plugin pages? as for example tax calculator 
        if ( isset( $arrOptions["pages"] ) && 
            is_array( $arrOptions["pages"] ) ) {     
            // Loop over all the pages search if we are in one of them
            foreach( $arrOptions["pages"] as $key => $page){
               
                $arr_sub_pages = matchPattern( "#^".$thisPluginName."_".$page."_subpage_(.*)$#i", $arrOptions );
               
                if ( isset( $arr_sub_pages )) {
                    // Include also parent page in to do the checkings 
                    //because we could be in the parent one
                    array_push( $arr_sub_pages, $arrOptions[ $thisPluginName."_".$page ."_page" ] );

                    foreach( $arr_sub_pages as $label=>$value ) {
                        if ( $value == $idOfTheCurrentPage ) {  
                            $current_tool_name = $thisPluginName.'_'.$page;
                            break 2;
                        }
                    }
                }
            }
        } else {
            // If the plugin doesn't has pages we have to check just the current one
            $value = $arrOptions[ $thisPluginName."_page" ];
            $current_tool_name = $thisPluginName;
        }

        // if we has found the page to load we have to get the content of it 
        if ( $value == $idOfTheCurrentPage ) {       
            $loadCssAndJavascript = true;         
            add_filter( "the_content",  "getToolContent" );
            break;
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
    global $current_tool_name;
    if( is_page() && is_main_query() ) { 
        switch ( $current_tool_name ) {
            case "tax_calculator_cars":
                $path_to_include = "Tax-Calculator/Car-tax-calculator.php";                  
            break;
            case "tax_calculator_vans":
                $path_to_include = "Tax-Calculator/Van-tax-calculator.php";
            break;
            case "comparator_cars":
                $path_to_include = "Comparator/Car-comparator.php";
            break;
            case "comparator_vans":
                $path_to_include = "Comparator/Van-comparator.php";
            break;
            case "footprint":
                $path_to_include = "Footprint-Calculator/Footprint-Calculator.php";
            break;
            case "electric_comparator_cars": 
                $path_to_include = "Electric-Comparator/Electric-Comparator.php";
            break;
            default:
                $path_to_include = "";
            break;
        }
                     
    	include_once(WPComcar_WEBSERVICESCALLSPATH.$path_to_include);                 

        $WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
			$content = isset( $content ) ? $content : "";
        $content = $content.$WPComcar_theResultOfTheWebservice;
        return $content;
    }   
}        
?>
