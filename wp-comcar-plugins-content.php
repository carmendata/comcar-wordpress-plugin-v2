<?php
/**
 * load the webservice content
 * @content the original content of the post or page
 */
function getToolContent( $content ) {
//     global $thisPluginName;
//     global $current_page;
    // load the post data into the function
    global $post;
    global $wp_comcar_plugins_pages;

    // we only want to process pages, not posts
    if( !is_page() || !is_main_query() ) {
        return $content;
    }
    
    /*
     * we don't want to process pages outside of those specified in the comcar plugin pages array
     * so we check if the current post ID matches any of the IDs set in our plugin settings
     */

    // get all the IDs of pages we've set in the plugin admin "Pages" section
    $page_settings = get_option('wp_comcar_plugins_pages_settings');
    $comcar_page_ids = array_map(function($plugin_page) use ($page_settings) {
            $plugin_page_name = 'wp_comcar_plugins_pages_settings_'.$plugin_page['name'];
            return $page_settings[$plugin_page_name];
        }, $wp_comcar_plugins_pages);
    // try to get the index of the current page ID from the comcar_page_ids array
    $comcar_page_id = array_search($post->ID, $comcar_page_ids);

    // if we couldn't find an ID, then this page is not assigned to a plugin, return the original content
    if($comcar_page_id === false) {
        return $content;
    }

    // get the comcar plugin page setting information
    $comcar_plugin_page = $wp_comcar_plugins_pages[$comcar_page_id];

    // if no URL stage is set, default to 1
    $plugin_call_stage = array_key_exists('stage', $_GET) ? $_GET['stage'] : 1;

    // get main settings
    $main_settings = get_option('wp_comcar_plugins_main_settings');

    $plugin_call_channel_id         = $main_settings['wp_comcar_plugins_main_settings_car_channel_id'];
    $plugin_call_channel_pubhash    = $main_settings['wp_comcar_plugins_main_settings_car_channel_pubhash'];

    switch($comcar_plugin_page['name']) {
        case "company_car_tax":
            $path_to_include = "Car-Tax-Calculator/Car-tax-calculator.php";
            break;
        case "company_van_tax":
            $path_to_include = "Van-Tax-Calculator/Van-tax-calculator.php";
            break;
        case "mpg_calculator":
            $path_to_include = "MPG-Calculator/MPG-Calculator.php";
            break;
    //             case "comparator":
    //                  $path_to_include = "Comparator/Comparator.php";
    //             break;
    //             case "footprint":
    //                 $path_to_include = "Footprint-Calculator/Footprint-Calculator.php";
    //             break;
        default:
            $path_to_include = "";
        break;
    }

    // default empty results
    $wp_comcar_plugins_results_css  = "";
    $wp_comcar_plugins_results_js   = "";
    $wp_comcar_plugins_results_html = "";
    $wp_comcar_plugins_results_msg  = "";

    // prepare content to return
    $plugin_content = '';

    // setup webservice call options
    $wp_comcar_plugin_ws_options = array(
        'cache_wsdl' => 0
    );

    // for dev mode, allow unsigned CERTS for local development
    if(WP_COMCAR_PLUGIN_DEV_MODE) {
        $wp_comcar_plugin_context = stream_context_create(array(
            'ssl' => array(
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        ));
        $wp_comcar_plugin_ws_options['stream_context'] = $wp_comcar_plugin_context;
    }

    // make calls to web service
    $plugin_content .= '<!-- Calling the Comcar Tools Wordpress plugin v'.WP_COMCAR_PLUGINS_PLUGINVERSION.' -->';
    if($path_to_include != "") {
        include_once( WP_COMCAR_PLUGINS_WEBSERVICECONTENT.$path_to_include );
    } else {
        echo 'Plugin content has not been configured yet';
    }

    $plugin_content .= '<!-- Start of the output for the Comcar Tools Wordpress plugin v'.WP_COMCAR_PLUGINS_PLUGINVERSION.' -->';
    
    // print out any error or status messages, followed by original content
    if( strlen($wp_comcar_plugins_results_msg) ){
        $plugin_content .= '<p>'.$wp_comcar_plugins_results_msg.'</p>';
    }else{
        // if there were no messages, print the original page content then tool content
        $plugin_content .= $wp_comcar_plugins_results_css
            .'<div id="wp-comcar-plugins-container">'
            .urldecode($wp_comcar_plugins_results_html)
            .'</div>'
            .$wp_comcar_plugins_results_js;
    }
    $plugin_content .= '<!-- End of the output for the Comcar Tools Wordpress plugin v'.WP_COMCAR_PLUGINS_PLUGINVERSION.', original page content follows -->';

    return $content.$plugin_content;
}

?>
