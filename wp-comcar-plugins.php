<?php
/**
 * Plugin Name:  Comcar Tools
 * Plugin URI: http://github.com/carmendata/comcar-wordpress-plugin/wiki
 * Description: Includes the Copmany Var Tax Calculator and MPG Calculator
 * Version: 2.0.0
 * Author: Carmen data
 * Author URI: http://carmendata.co.uk/
 * License: GPL2
 */

// Uncomment if you want to debug to receive warnings and errors
// ini_set( 'error_reporting', E_ALL );
// ini_set( 'display_errors', true );

define("WP_COMCAR_PLUGINS_PLUGINVERSION","2.0.0");
define("WP_COMCAR_PLUGINS_WEBSERVICECONTENT",dirname(__FILE__)."/webservices-calls/");

# set default webservice URL if not defined in environment
define(
    "WP_COMCAR_PLUGIN_WS_URL",
    getenv('WP_COMCAR_PLUGIN_WS_URL') === false
        ? 'https://legacy.comcar.co.uk/webservices/'
        : getenv('WP_COMCAR_PLUGIN_WS_URL')
);

# default dev mode to false
define(
    "WP_COMCAR_PLUGIN_DEV_MODE",
    getenv('WP_COMCAR_PLUGIN_DEV_MODE') === false
        ? false
        : getenv('WP_COMCAR_PLUGIN_DEV_MODE')
);

require_once( __DIR__."/admin/wp-comcar-plugins-global-objects.php" );
require_once( __DIR__."/admin/wp-comcar-plugins-admin.php" );
require_once( __DIR__."/wp-comcar-plugins-content.php" );

add_filter( "the_content",  "getToolContent" );

// add_action( "wp", "plugin_redirection" );
// add_action( "wp_head", "activate_page_plugins");

// add_action( 'wp_head', 'wp_buttons' );
// add_action( 'wp_head', 'mpg_scripts' );
// add_action( 'wp_head', 'vue_test_scripts_and_css' );
?>
