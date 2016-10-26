<?php
   $fuel_benefit_check_structure = array(  
            array( 
                "name" => "fuel_benefit_check_page",
                 "options" => "Pages",
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
                ) ,
            array( 
                "label" => "Fuel benefit override URL",
                "name" => "fuel_benefit_check_override",
                "desc" => "Override URL to visit prior to the calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation)",
                "type" => "text"
            )
        )
?>