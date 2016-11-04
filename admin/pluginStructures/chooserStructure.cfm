<?php
    $chooser_structure = array(  
            array( 
                "label" => "Car chooser page",
                "name" => "chooser_car_page",
                "options" => "Pages",
                "desc" => "Select which page the tool should be loaded into",
                "type" => "select"
                ) ,
            array( 
                "label" => "Car chooser override URL",
                "name" => "chooser_car_override",
                "desc" => "Override URL to visit prior to the calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation)",
                "type" => "text"
            ),
             array( 
                "label" => "Van chooser page",
                "name" => "chooser_van_page",
                "options" => "Pages",
                "desc" => "Select which page the tool should be loaded into",
                "type" => "select"
                ) ,
            array( 
                "label" => "Van chooser override URL",
                "name" => "chooser_van_override",
                "desc" => "Override URL to visit prior to the calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation)",
                "type" => "text"
            )
        );

?>