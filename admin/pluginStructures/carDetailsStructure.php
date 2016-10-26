<?php

$car_details_structure = array(  
            array( 
                "label" => "Car Details page",
                "name" => "car_details_page",
                "options" => "Pages",
                "desc" => "Select which page Car details tool should be loaded into",
                "type" => "select"
                ) ,
            array( 
                "label" => "Fuel benefit override URL",
                "name" => "car_details_override",
                "desc" => "Override URL to visit prior to the calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation)",
                "type" => "text"
            )
        );

?>