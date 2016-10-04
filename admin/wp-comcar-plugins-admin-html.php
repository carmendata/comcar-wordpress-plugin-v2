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
    
/* ---------------------------------------------------------
Declare options
----------------------------------------------------------- */

$theme_options = array(

    array( "name" => $themename." Options",
    "type" => "title"),

    /* ---------------------------------------------------------
    General section
    ----------------------------------------------------------- */
    array( "name" => "General",
    "type" => "section"),
    array( "type" => "open"),

    array( "name" => "Logo URL",
    "desc" => "Enter the link to your logo image",
    "id" => $shortname."_logo",
    "type" => "text",
    "std" => ""),

    array( "name" => "Custom Favicon",
    "desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
    "id" => $shortname."_favicon",
    "type" => "text",
    "std" => get_bloginfo('url') ."/images/favicon.ico"),

    array( "type" => "close"),

    /* ---------------------------------------------------------
    Home section
    ----------------------------------------------------------- */
    array( "name" => "Homepage",
    "type" => "section"),
    array( "type" => "open"),

    array( "name" => "Homepage Featured",
    "desc" => "Choose a category from which featured posts are.",
    "id" => $shortname."_feat_cat",
    "type" => "select",
    "options" => $all_cats,
    "std" => "Select a category"),

    array( "type" => "close"),

    /* ---------------------------------------------------------
    Footer section
    ----------------------------------------------------------- */
    array( "name" => "Footer",
    "type" => "section"),
    array( "type" => "open"),

    array( "name" => "Footer Credit",
    "desc" => "You can customize footer credit on footer area here.",
    "id" => $shortname."_footer_text",
    "type" => "text",
    "std" => ""),

    array( "type" => "close")

);


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
/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/
function plugin_settings_page() {
    global $themename,$theme_options;
    $i=0;
    $message=''; 
    if ( 'save' == $_REQUEST['action'] ) {
     
        foreach ($theme_options as $value) {
            update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
     
        foreach ($theme_options as $value) {
            if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
        $message='saved';
    }
    else if( 'reset' == $_REQUEST['action'] ) {
         
        foreach ($theme_options as $value) {
            delete_option( $value['id'] ); }
        $message='reset';        
    }
 
    ?>
    <div class="wrap options_wrap">
        <div id="icon-options-general"></div>
        <h2><?php _e( ' Theme Options' ) //your admin panel title ?></h2>
        <?php
        if ( $message=='saved' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
        <p>'.$themename.' settings saved.</strong></p></div>';
        if ( $message=='reset' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
        <p>'.$themename.' settings reset.</strong></p></div>';
        ?>
        <ul>
            <li>View Documentation |</li>
            <li>Visit Support |</li>
            <li>Theme version 1.0 </li>
        </ul>
        <div class="content_options">
            <form method="post">
 
            <?php foreach ($theme_options as $value) {
         
                switch ( $value['type'] ) {
             
                    case "open": ?>
                    <?php break;
                 
                    case "close": ?>
                    </div>
                    </div><br />
                    <?php break;
                 
                    case "title": ?>
                    <div class="message">
                        <p>To easily use the <?php echo $themename;?> theme options, you can use the options below.</p>
                    </div>
                    <?php break;
                 
                    case 'text': ?>
                    <div class="option_input option_text">
                    <label for="<?php echo $value['id']; ?>">
                    <?php echo $value['name']; ?></label>
                    <input id="" type="<?php echo $value['type']; ?>" name="<?php echo $value['id']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                    </div>
                    <?php break;
                 
                    case 'textarea': ?>
                    <div class="option_input option_textarea">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                    <textarea name="<?php echo $value['id']; ?>" rows="" cols=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                    </div>
                    <?php break;
                 
                    case 'select': ?>
                    <div class="option_input option_select">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                    <?php foreach ($value['options'] as $option) { ?>
                            <option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
                    <?php } ?>
                    </select>
                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                    </div>
                    <?php break;
                 
                    case "checkbox": ?>
                    <div class="option_input option_checkbox">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                    <?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
                    <input id="<?php echo $value['id']; ?>" type="checkbox" name="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /> 
                    <small><?php echo $value['desc']; ?></small>
                    <div class="clearfix"></div>
                    </div>
                    <?php break;
                 
                    case "section": 
                    $i++; ?>
                    <div class="input_section">
                    <div class="input_title">
                        
                        <h3><img src="<?php echo get_template_directory_uri();?>/images/options.png" alt="">&nbsp;<?php echo $value['name']; ?></h3>
                        <span class="submit"><input name="save<?php echo $i; ?>" type="submit" class="button-primary" value="Save changes" /></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="all_options">
                    <?php break;
                    
                }
            }?>
          <input type="hidden" name="action" value="save" />
          </form>
          <form method="post">
              <p class="submit">
              <input name="reset" type="submit" value="Reset" />
              <input type="hidden" name="action" value="reset" />
              </p>
          </form>
        </div>
        <div class="footer-credit">
            <p>This theme was made by <a title="anang pratika" href="http://anangpratika.wordpress.com" target="_blank" >Anang Pratika</a>.</p>
        </div>
    </div>
    <?php
}





function plugin_settings_page1() {
    $structure = get_plugin_setting_structure();
    echo '
    <div class="wrap">
        <h2 class="nav-tab-wrapper">';

    
    foreach($structure as $arrKey => $arrTitle) { 
        $str_function_name = 'WPComcar_plugin_options_'.$arrKey; 
        if (strcmp($arrKey,"general")==0){
            echo '<a class="nav-tab WPComcar_subTab nav-tab-active '.$arrKey.'" data-targettab="' .  $str_function_name . '">'.$arrTitle.'</a>';
       
        }else{
            echo '<a class="nav-tab WPComcar_subTab '.$arrKey.'" data-targettab="' .  $str_function_name . '">'.$arrTitle.'</a>';
        } 
        call_user_func( 'WPComcar_plugin_options_' . $arrKey );              
    
    }




    echo '
        </h2>   
    </div>
    ';

    
    submit_button("Save Changes"); 
}



function WPComcar_plugin_options_general(){





}




function WPComcar_plugin_options_tax_calculator(){
    // echo 'tax calculator';
}





function WPComcar_plugin_options_comparator(){
    // echo 'comparator';
}




function WPComcar_plugin_options_electric_comparator(){
    // echo 'electric comparator';
}




function WPComcar_plugin_options_footprint(){
  add_settings_field('footprint_page', 'Footprint calculator page', 'plugin_create_selector_with_list_of_pages', 'WPComcar_plugin', 'plugin_footprint',
                             array(     "name"          =>  "footprint_page",
                                        "section"       =>  "footprint",
                                        "explanation"   =>  "Select which page the Footprint Calculator should be loaded on."));
}


 




?>


