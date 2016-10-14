<?php


$comparator_structure = array(  
            array( 
                "description" => "The Comparator allows users to compare several different vehicle across several contract terms and mileages. Calculations can be viewed from the point of view of the driver and the company.",
                "type" => "description"
            ),
            array( 
                "label" => "Enable comparator",
                "name" => "pages",
                "options" => array( "For car channel" => "cars", "For van channel"=> "vans" ),
                "type" => "checkbox"
                ),
          
            array( 
                "label" => "Car channel comparator",
                "name" => "comparator_cars_page",
                "options" => "Pages",
                "desc" => "Select which page the Car Comparator Parent page will be loaded into.",
                "type" => "select"
                ) ,
            
            array( 
                "name" => "comparator_cars_subpage_select",
                "options" => "Pages",
                 "desc" => "The Select (the first page in the comparison process).",
                "type" => "select"
            ) ,
            array( 
                "name" => "comparator_cars_subpage_details",
                "options" => "Pages",
                 "desc" => "The Details page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "comparator_cars_subpage_callback",
                "options" => "Pages",
                 "desc" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            ) ,
            array( 
                "label" => "Comparator override URL",
                "name" => "comparator_cars_comp_override",
                "desc" => "Override URL to visit prior to the comparation - leave blank if not needed (refer to documentation for correct redirection to final comparation)",
                "type" => "text"
            ),

            array( 
                "label" => "van channel comparator",
                "name" => "comparator_vans_page",
                "options" => "Pages",
                 "desc" => "Parent page where you want the vans comparator plugin to appear.",
                "type" => "select"
                ) ,

            array( 
                "name" => "comparator_vans_subpage_select",
                "options" => "Pages",
                 "desc" => "The Select (the first page in the comparison process).",
                "type" => "select"
                ) ,
  
            array( 
                "name" => "comparator_vans_subpage_details",
                "options" => "Pages",
                 "desc" => "The Details page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "comparator_vans_subpage_callback",
                "options" => "Pages",
                 "description" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            ),

            array( 
                "name" => "comparator_cars_texts",
                "type" => "openSection" 
                ),

            array(
                "name" => "preSelectorText",
                "label" =>  "Cars Selector Texts",
                "desc" => "Block of text above the selector dropdowns. By default contains: 'For a comprehensive range of...'. Edit as HTML",
                "type" => "option",
                "default" => true
            ),
            array( 
                "name" => "postSelectorText",
                "desc" => "Block of text below the selector dropdowns. By default contains: 'Once you have selected a vehicle...' . Edit as HTML",
                "type" => "option",
                "default" => true
            ),
            array( 
                "type" => "closeSection" 
                ),
            array( 
                "name" => "comparator_vans_texts",
                "type" => "openSection" 
                ),

            array(
                "name" => "vanPreSelectorText",
                "label" => "Vans Selector Texts",
                "desc" => "Block of text above the selector dropdowns. By default contains: 'For a comprehensive range of...'. Edit as HTML",
                "type" => "option",
                "default" => true
            ),
            array( 
                "name" => "vanPostSelectorText",
                "desc" => "Block of text above the selector dropdowns. By default contains: 'For a comprehensive range of...'. Edit as HTML Default Block of text below the selector dropdowns. By default contains: 'Once you have selected a vehicle...' . Edit as HTML",
                "type" => "option",
                "default" => true
            ),
            array( 
                "type" => "closeSection" 
            ),
            array( 
                "name" => "comparator_general_texts",
                "type" => "openSection" 
            ),

               array( 
                "label" => "General settings",
                "name" => "typicalMonthPriceInDetails",
                "options" => array( true => "Show", false => "Don't Show" ),
                "description" => "Typical month price",
                "type" => "select"
            ),
                  array( 
                "name" => "defaultAnnualMileage",
                "options" => array( "10000"=>"10000", "20000"=>"20000" ),
                "description" => "Default annual mileage",
                "type" => "select"
            ),
            array( 
                "type" => "closeSection" 
            )
        );

?>