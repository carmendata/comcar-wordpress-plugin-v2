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



/*---------------------------------------------------
register settings
----------------------------------------------------*/
function plugin_settings_init(){
    register_setting( 'plugin_settings', 'plugin_settings' );
    wp_register_script( 'panel_script' , plugins_url( '/js/wp-comcar-plugins-admin.js', __FILE__ ) );
    wp_register_style( 'panel_style' , plugins_url( '/css/wp-comcar-plugins-admin.css', __FILE__ ));
    
    wp_enqueue_script('panel_script');
    wp_enqueue_style('panel_style');      
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

    foreach($structure as $arrKey => $arrTitle){ 
        $str_function_name = 'WPComcar_plugin_options_'.$arrKey; 
        if (strcmp($arrKey,"general")==0){
            echo '<a class="nav-tab WPComcar_subTab nav-tab-active '.$arrKey.'" data-targettab="' .  $str_function_name . '">'.$arrTitle.'</a>';
        }else{
            echo '<a class="nav-tab WPComcar_subTab '.$arrKey.'" data-targettab="' .  $str_function_name . '">'.$arrTitle.'</a>';
        }               
    }

    echo '
        </h2>   
    </div>
    ';
    submit_button("Save Changes"); 
}


function WPComcar_plugin_options_general(){
    echo 'main';
}





?>


