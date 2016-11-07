<?php 
$plugin_options["prices_and_options"] = array(     
          
        array( 
            "label" => "Car prices and options page",
            "name" => "prices_and_options_car_page",
            "options" => "Pages",
            "desc" => "Select which page Prices and options should be loaded on.",
            "type" => "select"
        ),
        array( 
            "label" => "Car prices and options override URL",
            "name" => "prices_and_options_car_override",
            "desc" => "Override URL to visit prior to the calculation - leave blank if not needed",
            "type" => "text"
        ),
        array( 
            "label" => "Van prices and options page",
            "name" => "prices_and_options_van_page",
            "options" => "Pages",
            "desc" => "Select which page Prices and options should be loaded on.",
            "type" => "select"
        ),
        array( 
            "label" => "Van prices and options override URL",
            "name" => "prices_and_options_van_override",
            "desc" => "Override URL to visit prior to the calculation - leave blank if not needed",
            "type" => "text"
        )
    )
?>