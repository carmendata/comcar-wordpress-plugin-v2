<?php
   $fuel_benefit_check_structure = array(  
            array( 
                "label" => "Fuel benefit page",
                "name" => "fuel_benefit_check_page",
                 "options" => "Pages",
                 "desc" => "Select which page Fuel benefit check tool should be loaded into",
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