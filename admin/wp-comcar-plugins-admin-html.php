<?php
require_once( "wp-comcar-plugins-global-objects.php") ;

/*---------------------------------------------------
add actions
----------------------------------------------------*/
add_action( "admin_init", "plugin_settings_init" );
add_action( "admin_menu", "add_settings_page" );



/*---------------------------------------------------
register settings
----------------------------------------------------*/
function plugin_settings_init(){
    register_setting( "plugin_settings", "plugin_settings" );
    wp_register_script( "panel_script" , plugins_url( "/js/wp-comcar-plugins-admin.js", __FILE__ ) );
    wp_register_style( "panel_style" , plugins_url( "/css/wp-comcar-plugins-admin.css", __FILE__ ));
   
    wp_enqueue_script("panel_script");
    wp_enqueue_style("panel_style");      
}


/*---------------------------------------------------
add settings page to menu
----------------------------------------------------*/
function add_settings_page() {
    add_menu_page(  "Comcar tools" , "Comcar tools settings" , "manage_options", "settings", "plugin_settings_page");
}


function saveToolsOptions( ) {
    global $plugin_options;
    $parent_name =  "";
    delete_option("WP_plugin_options_".$_REQUEST["nav"]);

    foreach ( $plugin_options[$_REQUEST["nav"]] as $value ) { 
   
        $obj_opt = get_option("WP_plugin_options_".$_REQUEST["nav"]);
        $desc = isset( $value["desc"] ) ? $value["desc"] : "";
        
        if ( $value["type"] == "openSection" ) {
            $parent_name =  $value["name"];
     
            $obj_opt[$parent_name] = array();

            update_option( "WP_plugin_options_".$_REQUEST["nav"] ,  $obj_opt ); 

        } else if(  $value["type"] == "closeSection" ) {
            $parent_name = "";
            continue;
        }  

        if ( $parent_name != "" && $value["type"] != "openSection" ) {    
  
            if ( $value["name"] != ""){
            $value_to_update = isset($_REQUEST[ $value["name"]]) ?$_REQUEST[ $value["name"]]:"";        
            $obj_opt[$parent_name][$value["name"]] = $value_to_update;
        
            update_option( "WP_plugin_options_".$_REQUEST["nav"] ,  $obj_opt ); 
            }
         
        }


        if ( isset( $value["name"] ) && $value["type"] != "checkbox" && $value["type"] != "openSection" ) {      
            $value_to_update = isset($_REQUEST[ $value["name"]]) ?$_REQUEST[ $value["name"]]:"";        
            $obj_opt[$value["name"]] = $value_to_update;

            update_option( "WP_plugin_options_".$_REQUEST["nav"] ,  $obj_opt ); 

            update_option( $value["name"], $value_to_update ); 

        } else if ( $value["type"] == "checkbox" ) {       
 
            $obj_opt[$value["name"]]= array();
            foreach ( $value["options"] as $label => $option ) {

                // $obj_to_insert[$value["name"]] = array();

                if ( isset( $_REQUEST[ $option ] )) {

                    update_option( $option, $_REQUEST[ $option ] );               
                    
                    array_push(   $obj_opt[$value["name"]], $option );
                    $obj_opt[$value["name"]][$option]  = $_REQUEST[ $option ];
                  
                } else {
                    unset( $obj_opt[$option] );
                    delete_option($option);
                }
            }

    

             

               

                update_option( "WP_plugin_options_".$_REQUEST["nav"] , $obj_opt  ); 
            
        } 

    }


    $arrOptions = get_option("WP_plugin_options_".$_REQUEST["nav"]);
    if ( isset( $arrOptions["pages"] )) {
        foreach($arrOptions["pages"] as $key=>$page){       
            $arr_subpages = matchPattern("#^".$_REQUEST["nav"]."_".$page."_subpage_(.*)$#i",$arrOptions);
            $arrOptions[$page."_subpages"] =  array();
            foreach( $arr_subpages as $label=>$value ) {
                
                $subpage = str_replace( $_REQUEST["nav"]."_".$page."_subpage_","",$label );
                $arrOptions[$page."_subpages"][$subpage] = $value;

            }

            update_option( "WP_plugin_options_".$_REQUEST["nav"] , $arrOptions  ); 
        }
                               
    }                    




}



function matchPattern($pattern, $input) {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input))));
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
    $message = ""; 

    if ( "save" == $_REQUEST["action"] ) {
        saveToolsOptions();
        $message = "saved";
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
                    echo $value['description'];
                break;

                case "note":  
                    echo '<h5>'.$value["note"]."</h5>";
                break;  

                case "text": 
                    echo $std."<tr><th><label>$label</label></th><td>
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
                            <textarea rows='4' cols='50' name='$name' >"
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
                        
                        if ( get_option( $option ) != "" ) {
                            echo "<input class='$name' type='checkbox' name='$option' value='$option' checked> $label <br/>";
                        }else{
                            echo "<input class='$name' type='checkbox' name='$option' value='$option'> $label <br/>";
                        }
                    }
                    echo "</td></tr>";
                break; 

                default:
                break;                   
            }
        }
        echo "</tbody></table>
            <span class='submit'><input name='save$i' type='submit' class='button-primary' value='Save changes' /></span>
            <input type='hidden' name='nav' value='$key' />    
            <input type='hidden' name='action' value='save' />
            </form></div>";            
    } 
    echo "</div>";
}

 

 function createNavsAdminPanel() {
    global $plugin_nav;
    
    echo "<div class='wrap'><h2 class='nav-tab-wrapper'>";

    foreach($plugin_nav as $arrKey => $arrInfo) {
        $arrTitle = $arrInfo["label"]; 
        $str_function_name = "WP_plugin_options_".$arrKey; 
        $class_activation = "";
        if ( strcmp( $arrKey, "general" ) == 0 ) {
            $class_activation =  "nav-tab-active";
            
        } 
        echo "<a name = $arrKey class='nav-tab WPComcar_subTab $class_activation $arrKey ' data-targettab= $str_function_name > $arrTitle </a>";      
    }

    echo "</h2></div>";
 }



function plugin_settings_page() {
    createNavsAdminPanel();
    createOptionsForEachNav();   
}

 




?>


