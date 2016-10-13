<?php 


$electric_comparator_structure = array(             
             array( 
                "label" => "Enable electric comparator",
                "name" => "pages",
                "options" => array( "For car channel" => "cars" ),
                "type" => "checkbox"
                ),
                array( 
                "label" => "Electric comparator page",
                "name" => "electric_comparator_cars_page",
                "options" => "Pages",
                 "desc" => "Select which page the Electric comparator should be loaded on.",
                "type" => "select"
                ) ,

            array( 
                "name" => "electric_comparator_cars_subpage_details",
                "options" => "Pages",
                 "desc" => "The Details page.",
                "type" => "select"
                ) ,
            array( 
                "name" => "electric_comparator_cars_subpage_callback",
                "options" => "Pages",
                 "desc" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            )
        )


?>