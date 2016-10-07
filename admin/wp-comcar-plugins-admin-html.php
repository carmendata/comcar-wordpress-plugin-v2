<?php
include( 'wp-comcar-plugins-global-objects.php') ;

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
function createOptionsForEachNav( ) {
    global $plugin_options;
    $i = 0;
    $message = ''; 

    if ( 'save' == $_REQUEST['action'] ) {
        print_r($_REQUEST);
        foreach ( $plugin_options[$_REQUEST['nav']] as $value ) {         

            $desc = isset( $value["desc"] ) ? $value["desc"] : "";
                                   
            if ( isset( $value['name'] ) && $value['type'] != 'checkbox') {      
                $value_to_update = isset($_REQUEST[ $value['name']]) ?$_REQUEST[ $value['name']]:"";  
                
                update_option( $value['name'], $value_to_update ); 
            } else if ( $value['type'] == 'checkbox' ) {
                foreach ( $value['options'] as $option ) {
                    $full_name = $value['name']  . '_' . $option;
                    $full_name = str_replace( ' ', '_', $full_name );
                    if ( isset( $_REQUEST[ $full_name ] )) {
                        update_option( $full_name, $_REQUEST[ $full_name ] );               
                    } else {
                        delete_option($full_name);
                    }
                }
            } 

        }
    
        $message = 'saved';
    } 
    ?>

    <div class="wrap options_wrap">
        <div id="icon-options-general"></div>   
            
            <?php
            if ( $message == 'saved' ) {
                echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
                <p> settings saved.</strong></p></div>';
            }
         
            foreach ( $plugin_options as $key => $content) {   
               echo  "<div class='content_options' name='content_$key'>
                    <form method='post'  >
                        <table>
                            <tbody>";
                            
                                foreach ($plugin_options[$key] as $value) {
                                    $name = isset( $value["name"] ) ? $value["name"] : "";
                                    $desc = isset( $value["desc"] ) ? $value["desc"] : "";
                                    $std    = isset( $value["std"] ) ? $value["std"] : "";
                                    $label = isset( $value["label"] ) ? $value["label"] : "";
                                    $options = isset( $value["options"] ) ? $value["options"]:"";
                
                                    switch ( $value['type'] ) {
                                        case "description":  
                                            echo $value['description'];
                                        break;
                                        case "note":  
                                            echo '<h5>' . $value['note'] . '</h5>';
                                        break;  
                                        case 'text': 
                                        echo $std;
                                        echo "<tr><td><label>$label</label></td><td>
                                                <input type='text' placeholder='$std' name='$name' value='";
                                        if ( get_option( $name ) != "") { 
                                            echo stripslashes(get_option( $name)  ) ;
                                        }
                                        echo "'/><small>  $desc</small></td></tr>";
                    break;
                    case 'option':
                   
                        echo "<tr>
                            <td>$label</td>
                            <td>$desc ";
                        $checkbox_name = $name.'_checkbox';
                        if ( get_option( $name ) ) {
                            echo "<input class='activation_textarea' type='checkbox' name='$checkbox_name' value='$name' >";
                        } else {
                            echo "<input class='activation_textarea' type='checkbox' name='$checkbox_name' value='$name' checked>  ";
                        }



                        echo "<label> Default </label></td></tr>

                        <tr><td></td><td>

                        <textarea rows='4' cols='50' name='$name' >"
                            .trim( get_option( $name ) ). 
                        "</textarea>
                        </td></tr>";

                    break; 
                    case 'select': ?>

                        <?php 
                        echo '<tr><td>'.$label.'</td><td>';
                        if ( $options == 'Pages' ) {
                            $theDropDownArguments=array();
                            $theDropDownArguments["name"]=$name;
                            $theDropDownArguments["selected"]=get_option( $name );
                            $theDropDownArguments['show_option_none']=' ';
                            $theDropDownArguments["option_none_value"]="0"; 
                            $theDropDownArguments["sort_column"]="menu_order"; 
                            wp_dropdown_pages($theDropDownArguments); 

                        } else {
                            echo "<select name='$name'>";
                            //para cada opcion
                            foreach( $options as $value => $option ) {

                                 if ( get_option( $name ) == $value) {
                                     echo "<option value='$value' selected>$option</option>";
                                 }else{
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
                        echo '<tr><td>' . $label . '</td><td>';
                        //print in order
                        foreach($options as $option){
                            $full_name = $name . '_' . $option;
                            $full_name = str_replace( ' ', '_', $full_name );

                            if ( get_option( $full_name ) != '' ) {
                                echo "<input class='$name' type='checkbox' name='$full_name' value='$option' checked> $option <br/>";
                            }else{
                                echo "<input class='$name' type='checkbox' name='$full_name' value='disabled'> $option <br/>";
                            }
                        }
      
                        echo "</td></tr>";
                    break; 
                    default:
                    break;                   
                }
            }
            ?>
          </tbody>
      </table>
            
             <span class="submit"><input name="save<?php echo $i; ?>" type="submit" class="button-primary" value="Save changes" /></span>
             <input type="hidden" name="nav" value="<?php echo $key; ?>" />

             <input type="hidden" name="action" value="save" />

          </form>
          </div>
            <?php
            
      } ?>
    </div>
    <?php


}


 

 function createNavsAdminPanel() {
    global $plugin_nav;
    
    echo '<div class="wrap"><h2 class="nav-tab-wrapper">';

    foreach($plugin_nav as $arrKey => $arrTitle) { 
        $str_function_name = 'WPComcar_plugin_options_'.$arrKey; 
        $class_activation = '';
        if ( strcmp( $arrKey, "general" ) == 0 ) {
            $class_activation =  'nav-tab-active';
            
        } 
        echo "<a name = $arrKey class='nav-tab WPComcar_subTab $class_activation $arrKey ' data-targettab= $str_function_name > $arrTitle </a>";      
    }

    echo '</h2></div>';
 }



function plugin_settings_page() {
    createNavsAdminPanel();
    createOptionsForEachNav();   
}

 




?>


