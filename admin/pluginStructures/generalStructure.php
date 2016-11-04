
<?php

    // build options to enable or disable navs


    foreach ( $plugin_nav as $key => $value ) {
        if ( $key != 'general' ) {
            $nav_options[$value] = $key; 
        }
    }
    
   $plugin_options["general"] = array(
        array( 
                "description" => "Please insert the ID and public hash for your own car and/or van channel. Channels are available to customers of Carmen Data Ltd. To become a customer see <a target='_blank' href='http://carmendata.co.uk/'>carmendata.co.uk</a>",
                "type" => "description"
        ),
        array( 
                "note" => "Note: If the ID and public hash fields are left blank the plugin will default to use our demo channels. These demo channels will only provide data on a limited selection of vehicle manufacturers. Which manufacturers are included will change randomly each month.",
                "type" => "note"
        ),
        array( 
                "label" => "Car channel ID",
                "name" => "clkCars",
                "type" => "text"
        ),
        array( 
                "label" => "Car Channel Public hash",
                "desc" => "The public hash delivered with the car channel",
                "name" => "pushCars",
                "type" => "text"
        ),
        array( 
                "label" => "Van Channel ID",
                "name" => "clkVans",
                "type" => "text"
        ),
        array( 
                "label" => "Van Channel Public hash",
                "desc" => "The public hash delivered with the van channel",
                "name" => "pushVans",
                "type" => "text"
        ),
        array( 
                "label" => "Enable tools",
                "name" => "pluginsOptions",
                "options" =>  $nav_options,
                "type" => "checkbox"
        )
    );
?>