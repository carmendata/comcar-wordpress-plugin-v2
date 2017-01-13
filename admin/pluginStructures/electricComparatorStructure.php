<?php 

 $plugin_options["electric_comparator"] = array(             
          
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