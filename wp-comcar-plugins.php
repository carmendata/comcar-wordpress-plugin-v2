<?php
/**
 * Plugin Name:  Comcar Tools
 * Plugin URI: http://github.com/carmendata/comcar-wordpress-plugin/wiki
 * Description: Includes the Tax Calculator, Vehicle Comparator amd Emissions Footprint Calculator from comcar.co.uk.
 * Version: 0.20.1
 * Author: Carmen data
 * Author URI: http://carmendata.co.uk/
 * License: GPL2
 */

// ini_set( 'error_reporting', E_ALL );
// ini_set( 'display_errors', true );
include_once(__DIR__."/wp-comcar-constants.php");

// shall I ask if it is admin to include it?
require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-admin-html.php");


add_action("wp", 'plugin_redirection');    
add_action("wp_head",'activate_page_plugins');   





    /********************** ACTIONS TO TAKE BEFORE RENDERING PLUGIN**************************/
            function plugin_redirection() {
                // process any actions that need to be done before page rendering
                global $pagename;
                global $post;
                $post_id = $post->ID;
            
        
                $WPTax_calc_arrOptions = get_option("WPComcar_plugin_options_tax_calculator"); 
                $WPComparator_arrOptions = get_option("WPComcar_plugin_options_comparator");
                $WPComcar_arrOptions=array_merge ( $WPTax_calc_arrOptions, $WPComparator_arrOptions );
            

                switch( $post_id ) {
                    case $WPComcar_arrOptions["tax_calculator_cars_subpage_calc"] : 
                        // check for calculation redirect
                        $WPComcar_tax_calc_override= $WPComcar_arrOptions["tax_calculator_cars_calc_override"];

                        if( isset($_GET['taxcalculatorcode'] ) ) {
                            // if there is encoded data put it back into the form
                            $encoded_taxcalculatorcode = htmlspecialchars( $_GET[ 'taxcalculatorcode' ] );

                            $decoded_taxcalculatorcode =   $this->decodeURLParam( $encoded_taxcalculatorcode );

                            $arr_decoded = explode( '~', $decoded_taxcalculatorcode );

                            $_POST['id'] = $arr_decoded[ 0 ];

                            if( count( $arr_decoded > 1 ) ) {
                                $_POST['CapCon'] = $arr_decoded[ 1 ];
                                $_POST['AnnCon'] = $arr_decoded[ 2 ];
                                $_POST['frm_listID'] = $arr_decoded[ 3 ];
                                $_POST['optTotal'] = $arr_decoded[ 4 ];
                            }

                        } else if ( $WPComcar_tax_calc_override ) {
                            // if an override exists, encode data and transmit

                            // defaults in case the page is visited without a $_POST submission
                            if(!isset($_GET['car']))         {  $_GET['car']="";  }
                            if(!isset($_POST['car']))        {  $_POST['car']=$_GET['car'];  }

                            if(!isset($_GET['id']))          {  $_GET['id']=$_POST['car'];  }
                            if(!isset($_POST['id']))         {  $_POST['id']=$_GET['id'];  }

                            if(!isset($_POST['CapCon']))     {  $_POST['CapCon']="";  }
                            if(!isset($_POST['AnnCon']))     {  $_POST['AnnCon']="";  }
                            if(!isset($_POST['frm_listID'])) {  $_POST['frm_listID']="";  }
                            if(!isset($_POST['optTotal']))   {  $_POST['optTotal']="";  }

                            // create formData string to encode as base64
                            $WPComcar_formData = "";
                            $WPComcar_formData = $WPComcar_formData.$_POST['id']."~";
                            $WPComcar_formData = $WPComcar_formData.$_POST['CapCon']."~";
                            $WPComcar_formData = $WPComcar_formData.$_POST['AnnCon']."~";
                            $WPComcar_formData = $WPComcar_formData.$_POST['frm_listID']."~";
                            $WPComcar_formData = $WPComcar_formData.$_POST['optTotal'];

                            $WPComcar_hashedData = bin2hex( base64_encode( $WPComcar_formData ) );
                            header( "Location: $WPComcar_tax_calc_override?taxcalculatorcode=$WPComcar_hashedData");
                            exit(1);
                        }

                        break;

                    case $WPComcar_arrOptions["comparator_cars_subpage_details"]:   
                        $WPComcar_comparator_override= $WPComcar_arrOptions["comparator_cars_comp_override"];       
                    
                        if( isset($_GET['comparatorcode'])) {
                            $_POST =  (array) json_decode(base64_decode($_GET['comparatorcode']));  
                        } else if ( $WPComcar_comparator_override ) {
                            if( !isset( $_POST ) ) {  
                                $_POST=$_GET;  
                            }
    
                            $WPComcar_hashedData = base64_encode(json_encode($_POST));
                            
                            header( "Location: $WPComcar_comparator_override?comparatorcode=$WPComcar_hashedData");
                            exit(1);
                        }
                    
                    break;
                }

            }




function preg_grep_keys($pattern, $input) {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input))));
}





    //this function is called once every post and will call the desired plugin function
            function activate_page_plugins(){           

                $loadCssAndJavascript=false;
                //if it is a page the one that is being loaded (not a POST)
                $arrGeneralSettings=get_option("WPComcar_plugin_options_general");
                //for all the plugins in comcar but for the general
                require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-global-objects.php");
                global $plugin_nav;        
  

                global $post;
                $idOfTheCurrentPage = get_post( $post )->ID;





            foreach ( array_slice( $plugin_nav , 1 ) as $thisPluginName => $plugin_info ) {
               
                    //name of the plugin (footprint, comparator, tax_calculator)
                 
                //not activated
                if (!isset($arrGeneralSettings["pluginsOptions"][$thisPluginName])){
                     continue;
                }
   
                    //options of the current plugin
                    $arrOptions = get_option('WP_plugin_options_'.$thisPluginName);

                    if (!isset($arrOptions)){
                        continue;
                    }
                    


                    //page where we should load the plugin
                    $idPageWhereShouldBeLoadedThePlugin = isset($arrOptions[$thisPluginName]) ? $arrOptions[$thisPluginName]: "";
                

                    //LOAD THE PLUGIN IF WE ARE IN THE FIRST PAGE OR IN A SUBPAGE
                    /********************* TAX CALCULATOR AND COMPARATOR *************************/
                      
                    if (isset($arrOptions["pages"]) && is_array($arrOptions["pages"]) ) {     
                        //foreach vans and cars...
                
                        foreach($arrOptions["pages"] as $key=>$page){
                            $idPageWhereShouldBeLoadedThePlugin = $arrOptions[$thisPluginName.'_'.$page.'_page'];

                            $arr_subpages = preg_grep_keys('#^'.$thisPluginName.'_'.$page.'_subpage_(.*)$#i',$arrOptions);

                            // if (isset($arrOptions[$page."_subpages"]) && is_array($arrOptions[$page."_subpages"])){
                           



                            foreach( $arr_subpages as $label=>$value ) {
                               
                         


                                if ( $value == $idOfTheCurrentPage ) {
                              
                              
                                        $loadCssAndJavascript=true;
                                        $current_tool_name=$thisPluginName.'_'.$page;
                                                                    
                                         add_filter('the_content',  function( $current_tool_name ) { return getToolContent( $current_tool_name ); });
  // add_filter('the_content', 'getToolContent');
                                        break;
                                }
    
                            }
                              
                           
                            //if it is the same page, load the plugin, or if it is a subpage
                            // if (strcmp($idPageWhereShouldBeLoadedThePlugin,$idOfTheCurrentPage)==0){                            
                            //     $loadCssAndJavascript=true;
                            //     $theFunctionName=$thisPluginName.'_'.$page."_execute";
                            //     $this->$theFunctionName();
                            //     break;
                            // }
                        }
                    }else{

    
 
                    
                        /******************* FOOTPRINT CALCULATOR **********************/
                        // if (strcmp($idPageWhereShouldBeLoadedThePlugin,$idOfTheCurrentPage)==0){
                        //     $loadCssAndJavascript=true;
                        //     $theFunctionName=$thisPluginName."_execute";
                        //     $this->$theFunctionName();
                        // } else {
                        //     if (strcmp($idPageWhereShouldBeLoadedThePlugin,$this->getParentId())==0){
                        //         $loadCssAndJavascript=true;
                        //         $parent_name = WPComcarPlugin_admin_configuration::$arrOrderOfPlugins[$i][0];
                             
                        //         $theFunctionName=$parent_name."_execute";
                        //         $this->$theFunctionName();
                        //     }
                            
                        // }
                    }                   
                }

                if ($loadCssAndJavascript){
                    wp_enqueue_script('comcar-javascript');
                    wp_enqueue_style('comcar-style');
                }
            }

function getToolContent( $current_tool_name ) {

        if( is_page() && is_main_query() ) { 
        //             // lets include the code
            $tool_to_include = '';
        

 include_once(WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Car-tax-calculator.php");
          
               

            
            $WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
            $content = $content.$WPComcar_theResultOfTheWebservice;
            return $content;
        }   
}


            
?>
