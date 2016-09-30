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

// 

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
}


/*---------------------------------------------------
add settings page to menu
----------------------------------------------------*/
function add_settings_page() {
    add_menu_page(  'Comcar tools' , 'Comcar tools settings' , 'manage_options', 'settings', 'plugin_settings_page');
}


/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/
/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/

function plugin_settings_page() {
    $structure = get_plugin_setting_structure();
    echo '
    <div class="wrap">
        <h2 class="nav-tab-wrapper">';
        
    foreach($structure as $arrKey => $arrTitle){  
        if (strcmp($arrKey,"general")==0){
            echo '<a class="nav-tab WPComcar_subTab nav-tab-active '.$arrKey.'" data-targettab="' . $arrValue[1] . '">'.$arrTitle.'</a>';
        }else{
            echo '<a class="nav-tab WPComcar_subTab '.$arrKey.'" data-targettab="' . $arrValue[1] . '">'.$arrTitle.'</a>';
        }               
    }

    echo '
        </h2>   
    </div>';

}




?>
