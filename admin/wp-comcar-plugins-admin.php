<?php
// require_once( "wp-comcar-plugins-global-objects.php") ;

/*---------------------------------------------------
add actions
----------------------------------------------------*/
add_action( "admin_init", "wp_comcar_plugins_settings_init" );
add_action( "admin_menu", "wp_comcar_plugins_setting_html" );

/**
 * load JS/CSS and prepare any admin settings
 * then build settings sections and fields and register as wordpress options
 */
function wp_comcar_plugins_settings_init(){
    global $wp_comcar_plugins_settings_array;

    // include JS and CSS scripts
    wp_register_script( "panel_script" , plugins_url( "/js/wp-comcar-plugins-admin.js", __FILE__ ), array('jquery'));
    wp_register_style( "panel_style" , plugins_url( "/css/wp-comcar-plugins-admin.css", __FILE__ ));

    // render them to the header
    wp_enqueue_script("panel_script");
    wp_enqueue_style("panel_style");

    // loop settings array in wp-comcar-plugins-global-objects and setup sections and register settings
    foreach($wp_comcar_plugins_settings_array as $group) {
        // work out the settings secton name, e.g. foo_settings
        $settings_section_name = 'wp_comcar_plugins_'.$group['name'].'_settings';
        // create the settings_section
        add_settings_section(
            $settings_section_name,
            $group['title'],
            'wp_comcar_plugin_section_title',
            $settings_section_name
        );
        // for each section, setup each field, this will be used to build the markup in the settings admin page
        foreach($group['settings'] as $setting) {
            $setting_full_name = $settings_section_name.'_'.$setting['name'];
            add_settings_field(
                $setting_full_name,
                $setting['title'],
                'wp_comcar_plugin_setting_markup',
                $settings_section_name,
                $settings_section_name,
                array(
                    $settings_section_name,
                    $setting_full_name,
                    $setting['type'],
                    array_key_exists('values', $setting) ? $setting['values'] : array()
                )
            );
        }
        // "register" the settings_section, this allows it to be saved on the form submission
        register_setting(
            $settings_section_name,
            $settings_section_name,
            'wp_comcar_plugins_settings_validate'
        );
    }
}

/**
 * add settings page to wordpress menu
 */
function wp_comcar_plugins_setting_html() {
    add_menu_page( 
        "Comcar tools",
        "Comcar tools settings",
        "manage_options",
        "wp_comcar_plugins_settings",
        "wp_comcar_plugins_print_page",
        plugins_url("/img/comcar_logo.png",__FILE__)
    );
}

function wp_comcar_plugins_settings_validate( $input ) {
    // array for storing validated options
    $output = array();
 
    foreach( $input as $key => $value ) {
       // process value if it's set
       if( isset( $input[$key] ) ) {
         // Strip all HTML and PHP tags and properly handle quoted strings
         $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
       }
    }

   return $output;
 }

// print a section title
function wp_comcar_plugin_section_title($args) {
    // args are id, title, callback
    switch($args['id']) {
        case 'company_car_tax_settings':
            echo '<p>These settings are used only for the '.$args["title"].' section';
            break;
        default:
            echo '<p>Set '.$args["title"].' settings</p>';
    }
}

// print markup for a single setting
function wp_comcar_plugin_setting_markup($args) {
    // args should contain seciton name, setting name, setting type, (optional) setting values for dropdown
    $settings_section_name = $args[0];
    $setting_full_name = $args[1];
    $setting_type = $args[2];
    $setting_values = $args[3];

    $options = get_option($settings_section_name);

    $value = array_key_exists( $setting_full_name, $options ) ? $options[$setting_full_name] : '';
    switch($setting_type) {
        case 'integer':
            echo '<input id="'.$setting_full_name.'" name="'.$settings_section_name.'['.$setting_full_name.']" pattern="[0-9]*" type="numeric" title="Only use numbers 0-9" type="numeric" value="'.esc_attr( $value ).'" />';
            break;
        case 'pages':
            echo '
                <select name="'.$settings_section_name.'['.$setting_full_name.']">
                    <option value="">Select page...</option>
            ';
            
            foreach(get_pages() as $page) {
                $selected = $value == $page->ID ? 'selected' : '';
                echo '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
            }

            echo '</select>';
            break;
        case 'array':
                echo '
                    <select name="'.$settings_section_name.'['.$setting_full_name.']">
                        <option value="">Select option...</option>
                ';
                
                foreach($setting_values as $option_key => $option_title) {
                    $selected = $value == $option_key ? 'selected' : '';
                    echo '<option value="'.$option_key.'" '.$selected.'>'.$option_title.'</option>';
                }
    
                echo '</select>';
                break;
        default:
            // assume text input
            echo '<input id="'.$setting_full_name.'" name="'.$settings_section_name.'['.$setting_full_name.']" value="'.esc_attr( $value ).'" />';
    }
}

// print the entire admin page markup (including settings and sections)
function wp_comcar_plugins_print_page() {
    global $wp_comcar_plugins_settings_array;

    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // start tab nav
    echo '
        <div class="wrap wp-comcar-plugins">
            <nav class="nav-tab-wrapper">
    ';

    // add nav buttons
    foreach($wp_comcar_plugins_settings_array as $index => $group) {
        $tab_active_class = $index ? '' : ' nav-tab-active';
        echo '<a href="#" data-target="'.$group['name'].'" class="nav-tab'.$tab_active_class.'">'.$group['title'].'</a>';
    }

    // close nav and start tab wrapper
    echo '
            </nav>
            <div class="tab-content-wrapper">
    ';

    // print each setting section and fields
    foreach($wp_comcar_plugins_settings_array as $index => $group) {
        // build the setting group name
        $settings_section_name = 'wp_comcar_plugins_'.$group['name'].'_settings';
        // set the active class for the first item in the array, page load will show the tab at index[0]
        $settings_active_class = $index ? '' : ' tab-content-active';
        // print the tab and settings content
        echo '
            <div class="tab-content tab-content-'.$group['name'].$settings_active_class.'">
                <form action="options.php" method="post">
        ';
                // output section and fields
                settings_fields($settings_section_name);
                echo do_settings_sections($settings_section_name);
                // print submit button
                echo submit_button( 'Save Settings' );
        echo '
                </form>
            </div>
        ';
    }
    
    // close main plugin div
    echo '</div>';
 }









/*---------------------------------------------------
Plugin setting output
----------------------------------------------------*/

function createOptionsForEachNav( ) {
    global $plugin_options;
    $message = "";
    if ( isset( $_REQUEST["action"] )) {
        if ( "save" == $_REQUEST["action"] ) {
            saveToolsOptions();
            $message = "saved";
        }
    }
    echo "<div class='wrap options_wrap'> <div id='icon-options-general'></div>";

    if ( $message == "saved" ) {
        echo "<div class='updated settings-error' id='setting-error-settings_updated'>
        <p> settings saved.</strong></p></div>";
    }

    foreach ( $plugin_options as $key => $content) {
        echo  "<div class='content_options' name='content_$key'><form method='post'  >
                <table class='options_table'><tbody>";

        foreach ( $plugin_options[$key] as $value ) {
            $name = isset( $value["name"] ) ? $value["name"] : "";
            $desc = isset( $value["desc"] ) ? $value["desc"] : "";
            $std  = isset( $value["std"] ) ? $value["std"] : "";
            $label = isset( $value["label"] ) ? $value["label"] : "";
            $options = isset( $value["options"] ) ? $value["options"]:"";
            $classes = isset( $value["class"] ) ? $value["class"]:"";

            switch ( $value['type'] ) {

                case "description":
                    echo "<tr><td colspan='2'>".$value['description']."</td></tr>";
                break;

                case "note":
                echo "<tr><td colspan='2'><h5>".$value["note"]."</h5></td></tr>";

                break;

                case "text":
                    echo "<tr><th><label>$label</label></th><td>
                        <input type='text' placeholder='$std' name='$name' value='";
                    if ( get_option( $name ) != "") {
                        echo stripslashes(get_option( $name)  ) ;
                    }
                    echo "'/><p>  $desc</p></td></tr>";
                break;

                case "option":
                    echo "<tr><th>$label</th><td>$desc </td><td>";
                    $checkbox_name = $name."_checkbox";

                    if ( get_option( $name ) ) {
                        echo "<input class='activation_textarea' type='checkbox' name='$checkbox_name' value='$name' >";
                    } else {
                        echo "<input class='activation_textarea' type='checkbox' name='$checkbox_name' value='$name' checked>  ";
                    }

                    echo "<label> Default </label></td></tr><tr><td></td><td>
                            <textarea rows='4' cols='50' name='$name' maxlength = '200'>"
                            .trim( get_option( $name ) )."</textarea></td></tr>";
                break;

                case "select":
                    echo "<tr><th>".$label."</th><td>";
                    if ( $options == "Pages" ) {
                        $theDropDownArguments = array();
                        $theDropDownArguments["name"] = $name;
                        $theDropDownArguments["selected"] = get_option( $name );
                        $theDropDownArguments["show_option_none"] = " ";
                        $theDropDownArguments["class"] = $classes;
                        $theDropDownArguments["option_none_value"] = "0";
                        $theDropDownArguments["sort_column"] = "menu_order";

                        wp_dropdown_pages( $theDropDownArguments );

                    } else {
                        echo "<select name='$name' class='$classes'> ";
                        //para cada opcion
                        foreach( $options as $value => $option ) {
                            if ( get_option( $name ) == $value ) {
                                echo "<option value='$value' selected>$option</option>";
                            } else {
                                echo "<option value='$value'>$option</option>";
                            }
                        }
                        echo "</select>";
                    }

                    if ( isset( $desc ) ) {
                        echo "<p class='description'> $desc </p>";
                    }
                    echo "</td></tr>";
                break;

                case "checkbox":
                    echo "<tr><th>" . $label . "</th><td>";
                    foreach($options as $label => $option){
                        $fullname =  $key."_".$option;

                        if ( get_option( $fullname ) != "" ) {
                            echo "<input class='$name' type='checkbox' name='$fullname' value='$option' checked> $label <br/>";
                        }else{
                            echo "<input class='$name' type='checkbox' name='$fullname' value='$option'> $label <br/>";
                        }
                    }
                    echo "</td></tr>";
                break;

                default:
                break;
            }
        }
        echo "</tbody></table>
            <span class='submit'><input name='save' type='submit' class='button-primary' value='Save changes' /></span>
            <input type='hidden' name='nav' value='$key' />
            <input type='hidden' name='action' value='save' />
            </form></div>";
    }
    echo "</div>";
}

?>
