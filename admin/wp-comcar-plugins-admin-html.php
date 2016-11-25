<?php
require_once( "wp-comcar-plugins-global-objects.php") ;

/*---------------------------------------------------
add actions
----------------------------------------------------*/
add_action( "admin_init", "pluginSettingsInit" );
add_action( "admin_menu", "addSettingsPage" );



/*---------------------------------------------------
register settings
----------------------------------------------------*/
function pluginSettingsInit(){
     // register_setting( "plugin_settings", "plugin_settings" );
    wp_register_script( "panel_script" , plugins_url( "/js/wp-comcar-plugins-admin.js", __FILE__ ) );
    wp_register_style( "panel_style" , plugins_url( "/css/wp-comcar-plugins-admin.css", __FILE__ ));
   
    wp_enqueue_script("panel_script");
    wp_enqueue_style("panel_style");      
}


/*---------------------------------------------------
add settings page to menu
----------------------------------------------------*/
function addSettingsPage() {
    add_menu_page(  "Comcar tools" , "Comcar tools settings" , "manage_options", "settings", "pluginSettingsPage", plugins_url("/img/comcar_logo.png",__FILE__));
}


function pluginSettingsPage() {
    createNavsAdminPanel();
    createOptionsForEachNav();   
}



function saveToolsOptions( ) {
  
    global $plugin_options;
    $parent_name =  "";
    $current_tool_name = "WP_plugin_options_".$_REQUEST["nav"];


    // Delete all options to avoid problems if we change some id o name 
    // and the old one still there
    delete_option( $current_tool_name );

    // Loop over all options inside the tool that we are saving
    foreach ( $plugin_options[ $_REQUEST["nav"] ] as $value ) { 
   
        $obj_opt = get_option( $current_tool_name );
        $desc = isset( $value["desc"] ) ? $value["desc"] : "";
        
        // This is used if you want that the object generated have a 
        // parent call $value['name'] and any kind of info ( checkbox, text,
        // selector..) will be included as a children of this openSection name
        if ( $value["type"] == "openSection" ) {
            $parent_name =  $value["name"];    
            $obj_opt[$parent_name] = array();
            update_option( $current_tool_name ,  $obj_opt ); 
        } else if(  $value["type"] == "closeSection" ) {
            // set parent name as "" to indicate that the next 
            // option don't have parent
            $parent_name = "";
            continue;
        }  

        // Are we inside of a section, if it is like this store
        // the current option as children 
        if ( $parent_name != "" && $value["type"] != "openSection" ) {   
            if ( $value["name"] != "" ) {
                $value_to_update = isset($_REQUEST[ $value["name"]]) ?$_REQUEST[ $value["name"]]:"";        
                $obj_opt[$parent_name][$value["name"]] = $value_to_update;
                update_option( $current_tool_name ,  $obj_opt ); 
            }   
        }


        if (    isset( $value["name"] ) 
                && $value["type"] != "checkbox" 
                && $value["type"] != "openSection" ) {  

            $value_to_update = isset($_REQUEST[ $value["name"]]) ?$_REQUEST[ $value["name"]]:"";        
            $obj_opt[$value["name"]] = $value_to_update;
            
            // We update options twice because we have two objects of options
            // the first one $current_tool_name will be read from wp-comcar-plugins.php
            // and have to has same structrue as old code to match it

            // the other update_option is used to store and show the inputs values
            // inside admin panel.
            update_option( $current_tool_name ,  $obj_opt ); 
            update_option( $value["name"], $value_to_update ); 
       
        } else if ( $value["type"] == "checkbox" ) {       
            $obj_opt[$value["name"]]= array();
            // the checkboxes has to be treated diferent as the rest of the inputs

            foreach ( $value["options"] as $label => $option ) {
                if ( isset( $_REQUEST[ $_REQUEST["nav"]."_".$option ] )) {
                    update_option( $_REQUEST["nav"]."_".$option, $_REQUEST[ $_REQUEST["nav"]."_".$option ] );               
                    array_push(   $obj_opt[$value["name"]], $option );
                    $obj_opt[$value["name"]][$option]  = $_REQUEST[ $_REQUEST["nav"]."_".$option ];
         
                } else {

                    unset( $obj_opt[$option] );
                    delete_option(  $_REQUEST["nav"]."_".$option );
                }
            }
            update_option( $current_tool_name , $obj_opt  ); 
        } 
    }

    // This is a little hack necessary to match te new code with the old one
    // it is redundant info, but in the future will be deleted
    $arrOptions = get_option($current_tool_name);
    if ( isset( $arrOptions["pages"] )) {
        foreach($arrOptions["pages"] as $key=>$page){       
            $arr_subpages = matchPattern("#^".$_REQUEST["nav"]."_".$page."_subpage_(.*)$#i",$arrOptions);
            $arrOptions[$page."_subpages"] =  array();
            foreach( $arr_subpages as $label=>$value ) {
                $subpage = str_replace( $_REQUEST["nav"]."_".$page."_subpage_","",$label );
                $arrOptions[$page."_subpages"][$subpage] = $value;
            }
            update_option( $current_tool_name , $arrOptions  ); 
        }                         
    }  

                 
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

 

 function createNavsAdminPanel() {
    global $plugin_nav;
    echo "<div class='wrap'><h2 class='nav-tab-wrapper'>";

    foreach( $plugin_nav as $arrKey => $arr_title ) {

        $str_function_name = "WP_plugin_options_".$arrKey; 
        $class_activation = "";
        if ( strcmp( $arrKey, "general" ) == 0 ) {
            $class_activation =  "nav-tab-active";       
        } 
        echo "<a name = $arrKey class='nav-tab WPComcar_subTab $class_activation $arrKey ' data-targettab= $str_function_name > $arr_title </a>";      
    }
    echo "</h2></div>";
 }
?>


