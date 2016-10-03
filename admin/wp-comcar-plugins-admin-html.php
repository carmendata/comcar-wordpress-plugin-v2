<?php
function get_plugin_setting_structure() {
    
    $structure = array(     
                            'general'               => 'Main',
                            'tax_calculator'        => 'Tax calculator',
                            'comparator'            => 'Comparator',
                            'electric_comparator'   => 'Electric comparator',
                            'footprint'             => 'Footprint calculator'
                        );

    return $structure;
}
    



/*---------------------------------------------------
add actions
----------------------------------------------------*/
add_action( 'admin_init', 'plugin_settings_init' );
add_action( 'admin_menu', 'add_settings_page' );




function plugin_options_page() {
        include 'wp-comcar-plugins-admin-options.php';
}
/*---------------------------------------------------
register settings
----------------------------------------------------*/
function plugin_settings_init(){
    register_setting( 'plugin_settings', 'plugin_settings' );
    wp_register_script( 'panel_script' , plugins_url( '/js/wp-comcar-plugins-admin.js', __FILE__ ) );
    wp_register_style( 'panel_style' , plugins_url( '/css/wp-comcar-plugins-admin.css', __FILE__ ));
   
    wp_enqueue_script('panel_script');
    wp_enqueue_style('panel_style');      
  

// Nav options
    // add_options_page('Comcar Plugin Menu', 'Comcar Plugin Menu', 'manage_options', 'WPComcar_plugin', 'plugin_options_page');
}


/*---------------------------------------------------
add settings page to menu
----------------------------------------------------*/
function add_settings_page() {
    add_menu_page(  'Comcar tools' , 'Comcar tools settings' , 'manage_options', 'settings', 'plugin_settings_page');
}


/*---------------------------------------------------
Plugin setting output
----------------------------------------------------*/

function plugin_settings_page() {
    $structure = get_plugin_setting_structure();
    echo '
    <div class="wrap">
        <h2 class="nav-tab-wrapper">';

    $str_settings = '<div id="WPComcar_sections">';
    
    foreach($structure as $arrKey => $arrTitle) { 
        $str_function_name = 'WPComcar_plugin_options_'.$arrKey; 
        if (strcmp($arrKey,"general")==0){
            echo '<a class="nav-tab WPComcar_subTab nav-tab-active '.$arrKey.'" data-targettab="' .  $str_function_name . '">'.$arrTitle.'</a>';
        }else{
            echo '<a class="nav-tab WPComcar_subTab '.$arrKey.'" data-targettab="' .  $str_function_name . '">'.$arrTitle.'</a>';
        } 
        // $str_settings .= call_user_func( 'WPComcar_plugin_options_' . $arrKey );              
    }

    $str_settings = '</div>';


    echo '
        </h2>   
    </div>
    ';
    echo $str_settings;
    
    submit_button("Save Changes"); 
}



function WPComcar_plugin_options_general(){
 add_settings_field( 'myprefix_setting-id',
    'This is the setting title',
    'myprefix_setting_callback_function',
    'general',
    'myprefix_settings-section-name',
    array( 'label_for' => 'myprefix_setting-id' ) );

}




function WPComcar_plugin_options_tax_calculator(){
    echo 'tax calculator';
}





function WPComcar_plugin_options_comparator(){
    echo 'comparator';
}




function WPComcar_plugin_options_electric_comparator(){
    echo 'electric comparator';
}




function WPComcar_plugin_options_footprint(){
    echo 'footprint';
}









?>


