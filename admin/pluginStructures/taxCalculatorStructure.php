<?php


 $plugin_options[ "tax_calculator" ] = array(  "" => "",
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
    $tax_calculator_structure = array(  
            array( 
                "description" => "The Tax Calculator tool allows users to calculate how much company car tax they will incur.",
                "type" => "description"
            ),

            array( 
                "label" => "Enable tax calculator",
                "name" => "pages",
                "options" => array( "For car channel" => "cars", "For van channel"=> "vans" ),
                "type" => "checkbox"
                ),

            array( 
                "label" => "Car tax calculator pages",
                "name" => "tax_calculator_cars_page",
                "options" => "Pages",
                "desc" => "Select which page the car Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
                ) ,

            array( 
                "name" => "tax_calculator_cars_subpage_select",
                 "options" => "Pages",
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
                ) ,
            array( 
                "name" => "tax_calculator_cars_subpage_model",
                "options" => "Pages",
                "desc" => "The Model page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_cars_subpage_options",
                "options" => "Pages",
                "desc" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_cars_subpage_calc",
                "options" => "Pages",
                "desc" => "And finally the Calculate page (the last page).",
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
                "options" => "Pages",
                "desc" => "Select which page the Van Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
            ),

            array( 
                "name" => "tax_calculator_vans_subpage_select",
                 "options" => "Pages",
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vans_subpage_model",
                "options" => "Pages",
                 "desc" => "The Model page.",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vans_subpage_options",
                "options" => "Pages",
                 "desc" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_vans_subpage_calc",
                "options" => "Pages",
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
                    "desc" => "'Capital Contributions' field label",
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "annCon",
                    "desc" => "'Annual contributions' field label",
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "optionsIntro",
                    "desc" => "Intro to the 'Vehicle Options' section",
                    "type" => "option",
                    "default" => true
                ),
                array(
                    "name" => "optionsAdd", 
                    "desc" => "'Specify vehicle options' button text",
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "optionsAddSubtext",
                    "desc" => "'Specify vehicle options' button hint",
                    "type" => "option",
                    "default" => true
                ),
                array( 
                    "name" => "inpGoToCalcValue",
                    "desc" => "'Quick calculation' button text",
                    "type" => "option",
                    "default" => true
                ),
                array(
                    "name" => "goToCalcSubtext", 
                    "desc" => "'Quick calculation' button hint",
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
        )









?>