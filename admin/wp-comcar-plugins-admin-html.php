<?php





include( 'wp-comcar-plugins-global-objects.php') ;

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
/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/
function plugin_option_settings_page( ) {
    global $themename,$plugin_options;
    $i=0;
    $message=''; 

    if ( 'save' == $_REQUEST['action'] ) {
     
        foreach ($plugin_options['general'] as $value) {
            update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
     
        foreach ($plugin_options['general'] as $value) {
            if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
        $message='saved';
    }
    else if( 'reset' == $_REQUEST['action'] ) {
         
        foreach ($plugin_options['general'] as $value) {
            delete_option( $value['id'] ); }
        $message='reset';        
    }
 
    ?>









    <div class="wrap options_wrap">
        <div id="icon-options-general"></div>   

        <?php
        if ( $message=='saved' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
        <p>'.$themename.' settings saved.</strong></p></div>';
        if ( $message=='reset' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
        <p>'.$themename.' settings reset.</strong></p></div>';
       
     
 foreach ( $plugin_options as $key => $content) {


 ?>
        <div class="content_options">
            <form method="post">
 <table>
    <tbody>
            <?php 

            foreach ($plugin_options[$key] as $value) {
                $name = isset( $value["name"] ) ? $value["name"] : "";
                $desc = isset( $value["desc"] ) ? $value["desc"] : "";
                $std = isset( $value["std"] ) ? $value["std"] : "";
                $label = isset( $value["label"] ) ? $value["label"] : "";
                $options = isset( $value["options"] ) ? $value["options"]:"";


                switch ( $value['type'] ) {
                              
                    case "description":  
                        echo $value['description'];
                    break;

                    case "note":  
                         echo '<h5>' . $value['note'] . '</h5>';
                    break;
                    
                    case 'text': ?>
                     <tr>
                        <td>
                            <label>
                                <?php 
                                    echo $label;    
                                ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="<?php echo $name; ?>" value="<?php if ( get_settings( $name ) != "") { echo stripslashes(get_settings( $name)  ); } else { echo $std; } ?>" />
                            <small><?php echo $desc; ?></small>
                        </td>
                   </tr>
                    <?php break;
                    case 'option':
                    
                    echo "<tr>
                            <td>
                                $label
                            </td>
                            <td>
                                $desc add checkbox
                            <td>
                        
                        </tr>";


                    break;
                    case 'textarea': ?>
                        <div class="option_input option_textarea">
                        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <textarea name="<?php echo $value['id']; ?>" rows="" cols=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
                        <small><?php echo $value['desc']; ?></small>
                        <div class="clearfix"></div>
                        </div>
                    <?php break;
                 
                    case 'select': ?>

                    <?php 
                    echo '<tr><td>'.$label.'</td><td>';
                       


                        // $arrOptions = get_option('WPComcar_plugin_options_'.$section);
                        // $theSelectedOptions=$arrOptions[$name];

        echo "<select name='$name'>";
        //para cada opcion
        foreach($options as $option=>$value){
            // if (strcmp($theSelectedOptions,$option)==0){
            //     echo "<option value='$option' selected>$value</option>";
            // }else{
                echo "<option value='$option'>$value</option>";
            // }
        }
        echo "</select>";
        
        if (isset($desc)){
            echo "<p class='description'> $desc </p>";
        }






                        echo "</td></tr>";
                    break;
                 
                    case "checkbox":                     
                        echo '<tr><td>' . $label . '</td><td>';
                        //print in order
                        foreach($options as $option){
                            // if ($this->theOptionIsSelected($theSelectedOptions, $option)){
                            //     echo "<input type='checkbox' name='WPComcar_plugin_options_[$name][]' value='$option' checked> $option <br/>";
                            // }else{
                                echo "<input type='checkbox' name='$name' value='$option'> $option <br/>";
                            // }
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
          <input type="hidden" name="action" value="save" />

          </form>
          </div>
     <?php } ?>
    </div>
    <?php
}


 

 



function plugin_settings_page() {
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
        // call_user_func( 'WPComcar_plugin_options_' . $arrKey );              
    
    }




    echo '
        </h2>   
    </div>
    ';
plugin_option_settings_page();
    
    // submit_button("Save Changes"); 
}

 




?>


