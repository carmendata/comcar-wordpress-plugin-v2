<?php
/**
 * Plugin Name:  Comcar Tools
 * Plugin URI: http://URI_Carmen DataOf_Page_Describing_Plugin_and_Updates
 * Description: Includes the Tax Calculator, Vehicle Comparator amd Emissions Footprint Calculator from comcar.co.uk.
 * Version: 0.6
 * Author: Carmen data
 * Author URI: http://carmendata.co.uk/
 * License: GPL2
 */
	
	// don't load directly
	if (!function_exists('is_admin')) {
	    header('Status: 403 Forbidden');
	    header('HTTP/1.1 403 Forbidden');
	    exit();
	}

	defined( 'ABSPATH' ) OR exit;

	//global constants
	define("WPComcar_WEBSERVICESCALLSPATH",dirname(__FILE__)."/webservices-calls/");
	define("WPComcar_FUNCTIONSPREFIX", "WPComcar_");
	define("WPComcar_PLUGINNAME", "WPComcarPlugin");
	define("WPComcar_PLUGINADMINNAME", "WPComcarPlugin_admin_configuration");
	define("WPComcar_PLUGINADMINHTMLNAME", "WPComcarPlugin_admin_configuration_html");
	define("WPComcar_PLUGINVERSION","1");
	//default channels and pubhash if not specified by the user
	define("WPComcar_CLKDEFAULTCARS", "44");
	define("WPComcar_PUBHASHDEFAULTCARS", "465C8B81AF089A09A88F4882AA52853B099483B1A9210ACA8943C37974BB8C832F85E0");
	define("WPComcar_CLKDEFAULTVANS", "45");
	define("WPComcar_PUBHASHDEFAULTVANS", "6C789D3B29BE9A17E8279ECCBE20D15B99F48858BBDD0F022F34D1C584B09CB966566A");
	//URL of the webservices
	define("WPComcar_WEBSERVICEBASEURL",'http://comcar.co.uk/webservices/');

	$WPComcar_exitMsg="Comcar plugins requires Wordpress 2.6 or newer.";
	global $wp_version;

	if (version_compare($wp_version, "2.6","<")){
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
			    register_activation_hook 	(__FILE__, array($this,'activate'));
				register_deactivation_hook	(__FILE__, array($this,'deactivate'));
				register_uninstall_hook		(__FILE__, array($this,'uninstall'));

				//in every post we call this function that will be encharged of loading only those pluggings that are neccesary
				add_action("the_post", array($this,'activate_page_plugins'));
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

			//we include the jquery trick to make it work
			function include_jquery_trick(){
				echo "<script> $=jQuery; </script>";
			}
			/****************************************************************************************/


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
				for($i=1;$i<$numberOfPlugins;$i++){
					//name of the plugin (footprint, comparator, tax_calculator)
					$thisPluginName=WPComcarPlugin_admin_configuration::$arrOrderOfPlugins[$i][0];					


					//not activated
					if (!isset($arrGeneralSettings["pluginsOptions"][$thisPluginName])){
						continue;
					}
					//options of the current plugin
					$arrOptions = get_option('WPComcar_plugin_options_'.$thisPluginName);


					//page where we should load the plugin
					//BEWARE! If we are in the tax_calculator, maybe we should look into $thisPluginName_cars/vans_page
					$idOfTheCurrentPage = get_post( $post )->ID;
					$idPageWhereShouldBeLoadedThePlugin=$arrOptions[$thisPluginName.'_page'];

					//LOAD THE PLUGIN IF WE ARE IN THE FIRST PAGE OR IN A SUBPAGE
					/********************* TAX CALCULATOR AND COMPARATOR *************************/
					if (isset($arrOptions["pages"]) && is_array($arrOptions["pages"])){		
						//foreach vans and cars...
						foreach($arrOptions["pages"] as $key=>$page){
							$idPageWhereShouldBeLoadedThePlugin=$arrOptions[$thisPluginName.'_'.$page.'_page'];
							if (isset($arrOptions[$page."_subpages"]) && is_array($arrOptions[$page."_subpages"])){
								if (in_array($idOfTheCurrentPage, $arrOptions[$page."_subpages"])){									
									//if the parent id is thePageWhereShouldBeLoadedThePlugin, then load
									if (strcmp($this->getParentId(), $idPageWhereShouldBeLoadedThePlugin)==0){
										$loadCssAndJavascript=true;
										$theFunctionName=$thisPluginName.'_'.$page."_execute";
										$this->$theFunctionName();
									}
								}
							}
							//if it is the same page, load the plugin, or if it is a subpage
							if (strcmp($idPageWhereShouldBeLoadedThePlugin,$idOfTheCurrentPage)==0){							
								$loadCssAndJavascript=true;
								$theFunctionName=$thisPluginName.'_'.$page."_execute";
								$this->$theFunctionName();
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
			
			//load footprint calculator
			function footprint_execute(){
				//attach to the content the result of the webservice
				add_filter('the_content', array($this,'addTheContentOfTheFootprintWebservice'));
			}

			function addTheContentOfTheFootprintWebservice($content){		
				// lets include the code
				include_once(WPComcar_WEBSERVICESCALLSPATH."Footprint-Calculator/Footprint-Calculator.php");
				//attach the content of the webservice to the post
				$content=$content.$WPComcar_theResultOfTheWebservice;
				return $content;
			}

			//create tax calculator with input hidden and load one or another depending on the user action
			//set form here, and process the info inside car-select always. Call one or another
			function addTheContentOfTheCarsTaxCalculatorWebservice($content){		
				// lets include the code
				include_once(WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Car-tax-calculator.php");
				//attach the content of the webersive to the post
				$content=$content.$WPComcar_theResultOfTheWebservice;
				return $content;
			}

			function addTheContentOfTheVansTaxCalculatorWebservice($content){		
				// lets include the code
				include_once(WPComcar_WEBSERVICESCALLSPATH."Tax-Calculator/Van-tax-calculator.php");
				//attach the content of the webersive to the post
				$content=$content.$WPComcar_theResultOfTheWebservice;
				return $content;
			}


			function addTheContentOfTheCarsComparatorWebservice($content){		
				// lets include the code
				include_once(WPComcar_WEBSERVICESCALLSPATH."Comparator/Car-comparator.php");
				//attach the content of the webersive to the post
				$content=$content.$WPComcar_theResultOfTheWebservice;
				return $content;
			}

			function addTheContentOfTheVansComparatorWebservice($content){		
				// lets include the code
				include_once(WPComcar_WEBSERVICESCALLSPATH."Comparator/Van-comparator.php");
				//attach the content of the webersive to the post
				$content=$content.$WPComcar_theResultOfTheWebservice;
				return $content;
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
			function uninstall(){
			    if ( ! current_user_can( 'activate_plugins' ) )
			        return;			   
				//get rid of the database tables
			}


			function deactivate(){
			    if ( ! current_user_can( 'activate_plugins' ) )
			        return;
			}

			function activate(){

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
