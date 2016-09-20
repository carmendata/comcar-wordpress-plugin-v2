<?php
/**
 * Plugin Name:  Comcar Tools
 * Plugin URI: http://github.com/carmendata/comcar-wordpress-plugin/wiki
 * Description: Includes the Tax Calculator, Vehicle Comparator amd Emissions Footprint Calculator from comcar.co.uk.
 * Version: 0.19
 * Author: Carmen data
 * Author URI: http://carmendata.co.uk/
 * License: GPL2
 */

	//global constants
	define("WPComcar_PLUGINVERSION","0.19");
	include_once(__DIR__."/wp-comcar-constants.php");







	// don't load directly
	if (!function_exists('is_admin')) {
	    header('Status: 403 Forbidden');
	    header('HTTP/1.1 403 Forbidden');
	    exit();
	}

	defined( 'ABSPATH' ) OR exit;


	//using the is_main_call in the plugin
	$WPComcar_exitMsg="Comcar plugins requires Wordpress 3.3 or newer.";
	global $wp_version;

	if (version_compare($wp_version, "3.3","<")){
		exit($WPComcar_exitMsg);
	}

	if (!class_exists("WPComcarPlugin")) :

		class WPComcarPlugin
		{

			//in the settings we will include the admin part of the comcar plugin
			var $settings;

			function __construct() {
				if (is_admin()) {
					if (!isset($this->settings)){
						// Load example settings page
						if (!class_exists(WPComcar_PLUGINADMINNAME)){
							require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-admin.php");
						}						
						$this->settings = new WPComcarPlugin_admin_configuration();					
					}		
				}

			    //hooks for the activation, deactivation and uninstalling
			    register_activation_hook 	(__FILE__, array('WPComcarPlugin','activate'));
				register_deactivation_hook	(__FILE__, array('WPComcarPlugin','deactivate'));
				register_uninstall_hook		(__FILE__, array('WPComcarPlugin','uninstall'));





				add_action("wp", array($this,'plugin_redirection'));	

				//in every head loading we call this function that will be in charge of loading only those tools that are necessary.
				//be aware! call the head instead of the_post, because other plugins may have conflicts when creating a new WP_Query
				add_action("wp_head", array($this,'activate_page_plugins'));	

				//flush the content in case we call the callback page
				add_action("get_header", array($this,"flush_if_callback"));

				//enqueue scripts and css for the front end
				add_action("wp_enqueue_scripts", array($this,'css_and_scripts'));
				add_action("wp_head", array($this,"include_jquery_trick"));

			}

			/************************** JAVASCRIPT AND CSS ******************************************/
			//FRONTEND
			//register scripts and css for the front-end
			function css_and_scripts(){
				wp_register_script('comcar-javascript', plugins_url( '/js/wp-comcar-plugins.js', __FILE__ ), array( 'jquery' ) );
		    	wp_register_style('comcar-style', plugins_url( '/css/wp-comcar-plugins.css', __FILE__ ));
			}

			function include_js_and_css(){
				wp_enqueue_script('comcar-javascript');
				wp_enqueue_style('comcar-style');
			}

			//be aware that we need to flush the content of the page in case it is a callback request
			function flush_if_callback(){
				//if it is not defined, we need to access the variables in the admin part 
				if (!class_exists(WPComcar_PLUGINADMINNAME)){
					require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-admin.php");
				}

				$arrGeneralSettings=get_option("WPComcar_plugin_options_general");
				//for all the plugins in comcar but for the general

				$numberOfPlugins=count(WPComcarPlugin_admin_configuration::$arrOrderOfPlugins);
				for($i=1;$i<$numberOfPlugins;$i++){
					//name of the plugin (footprint, comparator, tax_calculator)
					$thisPluginName=WPComcarPlugin_admin_configuration::$arrOrderOfPlugins[$i][0];					
					//not activated
					if (!isset($arrGeneralSettings["pluginsOptions"][$thisPluginName])){
						continue;
					}

					//options of the current plugin
					$arrOptions = get_option('WPComcar_plugin_options_'.$thisPluginName);
					if (!isset($arrOptions)){
						continue;
					}

					//page where we should load the plugin
					//BEWARE! If we are in the tax_calculator, maybe we should look into $thisPluginName_cars/vans_page
					global $post;
					$idOfTheCurrentPage = get_post( $post )->ID;

					/********************* TAX CALCULATOR AND COMPARATOR *************************/
					if (isset($arrOptions["pages"]) && is_array($arrOptions["pages"])){
						//foreach vans and cars...
						foreach($arrOptions["pages"] as $key=>$page){
							$thisCallbackPage=isset($arrOptions[$thisPluginName.'_'.$page.'_subpage_callback']) ? $arrOptions[$thisPluginName.'_'.$page.'_subpage_callback'] : 0 ;
							//if this is the callbackpage, start loggin the output and flush it in the callback page
							if ($thisCallbackPage==$idOfTheCurrentPage){
								ob_start();
								return;
							}
						}
					}
				}				
			}

			//we include the jquery trick to make it work
			function include_jquery_trick(){
				//needed by the carmendata plugins jquery. If it is still not loaded, load it cause otherwise the webservices jQuery wont work
				echo "<script>!window.jQuery && document.write('<script type=\"text/javascript\" language=\"javascript\" src=\"http://comcar.co.uk/page/external/jquery/1.8.2/jquery-1.8.2.min.js\"><\/script>');</script>";
				echo "<script> $=jQuery; </script>";
			}
			


			function decodeURLParam( $str_to_decode ) {
				// decode string (can't use hex2bin prior to php5.4)
		        $cnt_code = strlen( $str_to_decode ); 
		        $unhexed_taxcalculatorcode = "";   
		        $i = 0; 
		        while($i < $cnt_code ) {       
		            $a = substr( $str_to_decode, $i, 2 );           
		            $c = pack("H*",$a ); 
		            if ( $i==0 ){
		            	$unhexed_taxcalculatorcode = $c;
		           	} else {
		           		$unhexed_taxcalculatorcode .= $c;
		           	} 
		            $i+=2; 
		        } 
		        return base64_decode( $unhexed_taxcalculatorcode );
			}





			/****************************************************************************************/

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


			/******************************** MAIN ACTION **************************************/
			//this function is called once every post and will call the desired plugin function
			function activate_page_plugins(){			

				$loadCssAndJavascript=false;
				//if it is a page the one that is being loaded (not a POST)
				$arrGeneralSettings=get_option("WPComcar_plugin_options_general");
				//for all the plugins in comcar but for the general

				//if it is not defined, we need to access the variables in the admin part 
				if (!class_exists(WPComcar_PLUGINADMINNAME)){
					require_once(dirname(__FILE__)."/admin/wp-comcar-plugins-admin.php");
				}

				$numberOfPlugins=count(WPComcarPlugin_admin_configuration::$arrOrderOfPlugins);

				global $post;
				$idOfTheCurrentPage = get_post( $post )->ID;
				$idOfTheCurrentPageParent=$this->getParentId();

				for($i=1;$i<$numberOfPlugins;$i++){
					//name of the plugin (footprint, comparator, tax_calculator)
					$thisPluginName=WPComcarPlugin_admin_configuration::$arrOrderOfPlugins[$i][0];	

					//not activated
					if (!isset($arrGeneralSettings["pluginsOptions"][$thisPluginName])){
						continue;
					}
					//options of the current plugin
					$arrOptions = get_option('WPComcar_plugin_options_'.$thisPluginName);
					if (!isset($arrOptions)){
						continue;
					}
					



					//page where we should load the plugin
					$idPageWhereShouldBeLoadedThePlugin=isset($arrOptions[$thisPluginName.'_page']) ? $arrOptions[$thisPluginName.'_page']: "";

			

					//LOAD THE PLUGIN IF WE ARE IN THE FIRST PAGE OR IN A SUBPAGE
					/********************* TAX CALCULATOR AND COMPARATOR *************************/
					if (isset($arrOptions["pages"]) && is_array($arrOptions["pages"]) && count($arrOptions["pages"]) > 0 ){		
						
						//foreach vans and cars...
						foreach($arrOptions["pages"] as $key=>$page){
							$idPageWhereShouldBeLoadedThePlugin=$arrOptions[$thisPluginName.'_'.$page.'_page'];
							if (isset($arrOptions[$page."_subpages"]) && is_array($arrOptions[$page."_subpages"])){
								if (in_array($idOfTheCurrentPage, $arrOptions[$page."_subpages"])){									
									//if the parent id is thePageWhereShouldBeLoadedThePlugin, then load
									if (strcmp($idOfTheCurrentPageParent, $idPageWhereShouldBeLoadedThePlugin)==0){
										$loadCssAndJavascript=true;
										$theFunctionName=$thisPluginName.'_'.$page."_execute";
										$this->$theFunctionName();
										break;
									}
								}
							}
							//if it is the same page, load the plugin, or if it is a subpage
							if (strcmp($idPageWhereShouldBeLoadedThePlugin,$idOfTheCurrentPage)==0){							
								$loadCssAndJavascript=true;
								$theFunctionName=$thisPluginName.'_'.$page."_execute";
								$this->$theFunctionName();
								break;
							}
						}
					}else{
						/******************* FOOTPRINT CALCULATOR **********************/
						if (strcmp($idPageWhereShouldBeLoadedThePlugin,$idOfTheCurrentPage)==0){
							$loadCssAndJavascript=true;
							$theFunctionName=$thisPluginName."_execute";
							$this->$theFunctionName();
						}
					}					
				}
				if ($loadCssAndJavascript){
					$this->include_js_and_css();
				}
			}
			/*******************************************************************************/

			/*************** FUNCTIONS THAT CALL THE PHP WEBSERVICES *************************/
			//load footprint calculator
			function comparator_cars_execute(){
				//attach to the content the result of the webservice
				add_filter('the_content', array($this,'addTheContentOfTheCarsComparatorWebservice'));					
			}

			function comparator_vans_execute(){
				//attach to the content the result of the webservice
				add_filter('the_content', array($this,'addTheContentOfTheVansComparatorWebservice'));					
			}


			//load footprint calculator
			function tax_calculator_cars_execute(){
				//attach to the content the result of the webservice
				add_filter('the_content', array($this,'addTheContentOfTheCarsTaxCalculatorWebservice'));			
			}

			//load footprint calculator
			function tax_calculator_vans_execute(){
				//attach to the content the result of the webservice
				add_filter('the_content', array($this,'addTheContentOfTheVansTaxCalculatorWebservice'));			
			}
			

			function electric_comparator_execute() {

				add_filter('the_content', array($this,'addTheContentOfTheElectricComparatorWebservice'));
			}

			function addTheContentOfTheElectricComparatorWebservice($content){
				
				// We want to attach the content only whenever the main query is called and not in secondary ocassions. Check if it is a page. 
				// http://codex.wordpress.org/Function_Reference/is_main_query
				if( is_page() && is_main_query() ) {	
					// lets include the code
					include_once(WPComcar_WEBSERVICESCALLSPATH."Electric-Comparator/Electric-Comparator.php");
					//attach the content of the webservice to the post
					$WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
					$content=$content.$WPComcar_theResultOfTheWebservice;
					return $content;
				}				
			}



			//load footprint calculator
			function footprint_execute(){
				//attach to the content the result of the webservice
				add_filter('the_content', array($this,'addTheContentOfTheFootprintWebservice'));
			}

			function addTheContentOfTheFootprintWebservice($content){
				// We want to attach the content only whenever the main query is called and not in secondary ocassions. Check if it is a page. 
				// http://codex.wordpress.org/Function_Reference/is_main_query
				if( is_page() && is_main_query() ) {	
					// lets include the code
					include_once(WPComcar_WEBSERVICESCALLSPATH."Footprint-Calculator/Footprint-Calculator.php");
					//attach the content of the webservice to the post
					$WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
					$content=$content.$WPComcar_theResultOfTheWebservice;
					return $content;
				}				
			}

			//create tax calculator with input hidden and load one or another depending on the user action
			//set form here, and process the info inside car-select always. Call one or another
			function addTheContentOfTheCarsTaxCalculatorWebservice($content){	
				// We want to attach the content only whenever the main query is called and not in secondary ocassions. Check if it is a page. 
				// http://codex.wordpress.org/Function_Reference/is_main_query
				if( is_page() && is_main_query() ) {	
					// lets include the code
					include_once(WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Car-tax-calculator.php");
					//attach the content of the webersive to the post
					$WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
					$content=$content.$WPComcar_theResultOfTheWebservice;
					return $content;
				}				
			}

			function addTheContentOfTheVansTaxCalculatorWebservice($content){	
				// We want to attach the content only whenever the main query is called and not in secondary ocassions. Check if it is a page. 
				// http://codex.wordpress.org/Function_Reference/is_main_query
				if( is_page() && is_main_query() ) {	
					// lets include the code
					include_once(WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Van-tax-calculator.php");
					//attach the content of the webersive to the post
					$WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
					$content=$content.$WPComcar_theResultOfTheWebservice;
					return $content;
				}


			}


			function addTheContentOfTheCarsComparatorWebservice($content){
				// We want to attach the content only whenever the main query is called and not in secondary ocassions. Check if it is a page. 
				// http://codex.wordpress.org/Function_Reference/is_main_query
				if( is_page() && is_main_query() ) {	
					// lets include the code
					include_once(WPComcar_WEBSERVICESCALLSPATH."Comparator/Car-comparator.php");
					//attach the content of the webersive to the post
					$WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
					$content=$content.$WPComcar_theResultOfTheWebservice;
					return $content;
				}	

			}

			function addTheContentOfTheVansComparatorWebservice($content){		
				// We want to attach the content only whenever the main query is called and not in secondary ocassions. Check if it is a page. 
				// http://codex.wordpress.org/Function_Reference/is_main_query
				if( is_page() && is_main_query() ) {	
					// lets include the code
					include_once(WPComcar_WEBSERVICESCALLSPATH."Comparator/Van-comparator.php");
					//attach the content of the webersive to the post
					$WPComcar_theResultOfTheWebservice=isset($WPComcar_theResultOfTheWebservice) ? $WPComcar_theResultOfTheWebservice : "";
					$content=$content.$WPComcar_theResultOfTheWebservice;
					return $content;
				}
				
			}

			function getParentId(){
				global $post;
				$thePageParents = get_post_ancestors( $post->ID );
		        /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
				$parentId = ($thePageParents) ? $thePageParents[count($thePageParents)-1]: $post->ID;
				$theParent=get_page($parentId);
				return $theParent->ID;
			}

			/**********************************************************************************/



			/********************* UNINSTALL, DEACTIVATE AND ACTIVATE PLUGIN *****************/
			static function uninstall(){
			    if ( ! current_user_can( 'activate_plugins' ) )
			        return;			   
				//get rid of the database tables
			}


			static function deactivate(){
			    if ( ! current_user_can( 'activate_plugins' ) )
			        return;
			}

			static function activate(){

				if ( ! current_user_can( 'activate_plugins' ) )
			        return;

			    //go into the database and create the tables etc.
			}


		/**********************************************************************************/
		}
	endif;

	// Initialize the plugin object.
	global $objWPComcarPlugin;
	if (class_exists(WPComcar_PLUGINNAME) && !$objWPComcarPlugin) {
	    $objWPComcarPlugin = new WPComcarPlugin();	
	}

?>
