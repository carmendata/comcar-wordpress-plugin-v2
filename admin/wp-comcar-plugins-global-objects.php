<?php
/* ---------------------------------------------------------
Declare options
----------------------------------------------------------- */
$plugin_nav = array(     
                        'general'               => array( 'label' => 'Main', 'path' => ''),
                        'tax_calculator'        => array( 'label' => 'Tax calculator', 'path' => ''),
                        'comparator'            => array( 'label' => 'Comparator','path' => ''),
                        'electric_comparator'   => array( 'label' => 'Electric comparator','path' => ''),
                        'footprint'             => array( 'label' => 'Footprint calculator', 'path' => '')
                    );


$arr_page_setting = array(  "" => "",
                            "maxP11D" => "P11D Value", 
                            "cvotr" => "Price",
                            "make" => "Manufacturer",
                            "model" => "Model",
                            "derivative" => "Derivative",
                            "roof" => "Roof height",
                            "wheelbase" => "Wheelbase",
                            "loadlength" => "Load length",
                            "payload" => "Payload",
                            "loadvolume" => "Load Volume" ,
                            "gvwkg" => "Gross Weight",
                            "CO2gpkm" => "CO2",
                            "fuelType" => "Fuel Type",
                            "taxHigh" => "Tax (high)",
                            "taxLow" => "Tax (low)",
                            "bik" => "BIK",
                            "bodyStyle" => "Bodystyle",
                            "VED" => "VED",
                            "fuelConsumptionDf" => "MPG",
                            "CO2pctge" => "CO2 Percentage",
                            "otrPrice" => "List Price",
                            "seats" => "Seats",
                            "transmission" => "Transmission",
                            "doors" => "Doors",
                            "insfifty" => "Insurance Group",
                            "ps" => "Power" 
                        );



$plugin_options = array( 
    'general' => array(
        array( 
                "description" => "Please insert the ID and public hash for your own car and/or van channel. Channels are available to customers of Carmen Data Ltd. To become a customer see carmendata.co.uk",
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
                "options" => array( 'Tax calculator' => 'tax_calculator', 'Comparator' => 'comparator', 'Electric comparator' => 'electric_comparator', 'Footprint calculator' =>'footprint'),
                "type" => "checkbox"
        )      
    ),


    'tax_calculator' => array(  
            array( 
                "description" => "Please insert the ID and public hash for your own car and/or van channel. Channels are available to customers of Carmen Data Ltd. To become a customer see carmendata.co.uk",
                "type" => "description"
            ),

            array( 
                "label" => "Enable tax calculator",
                "name" => "pages",
                "options" => array( 'For car channel' => 'pages_cars', 'For van channel'=> 'pages_vans' ),
                "type" => "checkbox"
                ),

            array( 
                "label" => "Car tax calculator pages",
                "name" => "tax_calculator_cars_page",
                "options" => 'Pages',
                "desc" => "Select which page the car Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
                ) ,

            array( 
                "name" => "tax_calculator_cars_subpage_select",
                 "options" => 'Pages',
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
                ) ,
            array( 
                "name" => "tax_calculator_cars_subpage_model",
                "options" => 'Pages',
                "desc" => "The Model page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_cars_subpage_options",
                "options" => 'Pages',
                "desc" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_cars_subpage_calc",
                "options" => 'Pages',
                "description" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ) ,
            array( 
                "label" => "Calculation override URL",
                "name" => "tax_calculator_cars_calc_override",
                "desc" => "Override URL to visit prior to the tax calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation).",
                "type" => "text"
            ),


             array( 
                "label" => "Van tax calculator pages",
                "name" => "tax_calculator_vans_page",
                "options" => 'Pages',
                "desc" => "Select which page the Van Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
            ),

            array( 
                "name" => "tax_calculator_vans_subpage_select",
                 "options" => 'Pages',
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vans_subpage_model",
                "options" => 'Pages',
                 "desc" => "The Model page.",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vans_subpage_options",
                "options" => 'Pages',
                 "desc" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_vans_subpage_calc",
                "options" => 'Pages',
                 "desc" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ),
           

            array( 
                "name" => "tax_calculator_cars_texts",
                "type" => "openSection" 
                ),

                array( 
                    "label" => "Car Tax Calculator Model page settings",
                    "name" => "",
                    "class"=> "selectorToFillBox",
                    "options" =>  $arr_page_setting,
                    "desc" => "Select options from list to add them to the box below. Repeat several times to build a list.",
                    "type" => "select"
                ),
                array( 
                    "name" => "tax_calculator_cars_request",
                    "desc" => "List of fields to include in the table of results. Must match database names exactly.",
                    "std" => "derivative,transmission,co2gpkm,fueltype,otrPrice",
                    "type" => "text"
                ),
                array( 
                    "name" => "tax_calculator_cars_headers",
                    "desc" => "Table Headers. These correspond to the list above, use it to give the fields human-friendly aliases.",
                    "std" => "Derivative,Transmission,CO2 g/km,Fuel,List price",
                    "type" => "text"
                ),
                array( 
                    "name" => "capCon",
                    "desc" => '"Capital Contributions" field label',
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "annCon",
                    "desc" => '"Annual contributions" field label',
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "optionsIntro",
                    "desc" => 'Intro to the "Vehicle Options" section',
                    "type" => "option",
                    "default" => true
                ),
                array(
                    "name" => "optionsAdd", 
                    "desc" => '"Specify vehicle options" button text',
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "optionsAddSubtext",
                    "desc" => '"Specify vehicle options" button hint',
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "inpGoToCalcValue",
                    "desc" => '"Quick calculation" button text',
                    "type" => "option",
                    "default" => true
                ),
                array(
                    "name" => "goToCalcSubtext", 
                    "desc" => '"Quick calculation" button hint',
                    "type" => "option",
                    "default" => true
                ),

            array( "type" => "closeSection" ),
            array( 
                "name" => "tax_calculator_vans_texts",
                "type" => "openSection" 
                ),
            array( 
                "label" => "van Tax Calculator Model page settings",
                "name" => "",
                "class"=> "selectorToFillBox",
                "options" => $arr_page_setting,
                "desc" => "Select options from list to add them to the box below. Repeat several times to build a list.",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vans_request",
                "desc" => "List of fields to include in the table of results. Must match database names exactly.",
                 "std" => "derivative,transmission,co2gpkm,fueltype,otrPrice",
                
                "type" => "text"
            ),
            array( 
                "name" => "tax_calculator_vans_headers",
                "desc" => "Table Headers. These correspond to the list above, use it to give the fields human-friendly aliases.",
                "std" => "Derivative,Transmission,CO2 g/km,Fuel,List price",
                "type" => "text"
            ),
            array( "type" => "closeSection" )
        ),


    'comparator' => array(  
            array( 
                "description" => "The Comparator allows users to compare several different vehicle across several contract terms and mileages. Calculations can be viewed from the point of view of the driver and the company.",
                "type" => "description"
            ),
            array( 
                "label" => "Enable comparator",
                "name" => "pages",
                "options" => array( 'For car channel' => 'pages_cars', 'For van channel'=> 'pages_vans' ),
                "type" => "checkbox"
                ),
          
            array( 
                "label" => "Car channel comparator",
                "name" => "comparator_cars_page",
                "options" => 'Pages',
                "desc" => "Select which page the car Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
                ) ,

            
            array( 
                "name" => "comparator_cars_subpage_select",
                "options" => 'Pages',
                 "desc" => "The Select (the first page in the comparison process).",
                "type" => "select"
            ) ,
            array( 
                "name" => "comparator_cars_subpage_details",
                "options" => 'Pages',
                 "desc" => "The Details page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "comparator_cars_subpage_callback",
                "options" => 'Pages',
                 "description" => "The Callback page (This never gets seen by users but is crucial to user flow).",
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
                "options" => 'Pages',
                 "desc" => "Parent page where you want the vans comparator plugin to appear.",
                "type" => "select"
                ) ,

            array( 
                "name" => "comparator_vans_subpage_select",
                "options" => 'Pages',
                 "desc" => "Select which page the van Comparator Parent page will be loaded into.",
                "type" => "select"
                ) ,
  
            array( 
                "name" => "comparator_vans_subpage_details",
                "options" => 'Pages',
                 "desc" => "The Details page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "comparator_vans_subpage_callback",
                "options" => 'Pages',
                 "description" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            ),


            array( 
                "name" => "comparator_cars_texts",
                "type" => "openSection" 
                ),

            array(
                "name" => "preSelectorText",
                "label" =>  'Cars Selector Texts',
                "desc" => 'Block of text above the selector dropdowns. By default contains: "For a comprehensive range of...". Edit as HTML',
                "type" => "option",
                "default" => true
            ),
              array( 
                "name" => "postSelectorText",
                "desc" => 'Block of text below the selector dropdowns. By default contains: "Once you have selected a vehicle..." . Edit as HTML',
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
                "name" => "preSelectorText",
                "label" => 'Vans Selector Texts',
                "desc" => 'Block of text above the selector dropdowns. By default contains: "For a comprehensive range of...". Edit as HTML',
                "type" => "option",
                "default" => true
            ),
            array( 
                "name" => "postSelectorText",
                "desc" => 'Block of text above the selector dropdowns. By default contains: "For a comprehensive range of...". Edit as HTML Default Block of text below the selector dropdowns. By default contains: "Once you have selected a vehicle..." . Edit as HTML',
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
                "options" => array( true => 'Show', false => 'Don\'t Show' ),
                "description" => "Typical month price",
                "type" => "select"
            ),
                  array( 
                "name" => "defaultAnnualMileage",
                "options" => array( '10000'=>'10000', '20000'=>'20000' ),
                "description" => "Default annual mileage",
                "type" => "select"
            ),
            array( 
                "type" => "closeSection" 
            )
        ),
        'electric_comparator' => array( 
                 
             array( 
                "label" => "Enable electric comparator",
                "name" => "pages",
                "options" => array( 'For car channel' => 'pages_cars' ),
                "type" => "checkbox"
                ),
                array( 
                "label" => "Electric comparator page",
                "name" => "electric_comparator_cars_page",
                "options" => 'Pages',
                 "desc" => "Select which page the Electric comparator should be loaded on.",
                "type" => "select"
                ) ,

            array( 
                "name" => "electric_comparator_cars_subpage_details",
                "options" => 'Pages',
                 "desc" => "The Details page.",
                "type" => "select"
                ) ,
            array( 
                "name" => "electric_comparator_cars_subpage_callback",
                "options" => 'Pages',
                 "desc" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            )
        ),
        'footprint' => array(
            array( 
                "description" => "The Footprint Calculator tool is a simple way to allow users to calculate their CO<sub>2</sub> tailpipe emissions based on fuel used, cost of fuel or distance travelled.",
                "type" => "description"
            ),
            array( 
                "label" => "Footprint calculator page",
                "name" => "footprint_page",
                "options" => 'Pages',
                 "desc" => "Select which page the Footprint Calculator should be loaded on.",
                "type" => "select"
            )
        )
);
?>