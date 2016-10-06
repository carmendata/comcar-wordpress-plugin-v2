<?php
/* ---------------------------------------------------------
Declare options
----------------------------------------------------------- */
 $plugin_nav = array(     
                            'general'               => 'Main',
                            'tax_calculator'        => 'Tax calculator',
                            'comparator'            => 'Comparator',
                            'electric_comparator'   => 'Electric comparator',
                            'footprint'             => 'Footprint calculator'
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
                "name" => "general_clkCars",
                "type" => "text"
        ),
        array( 
                "label" => "Car Channel Public hash",
                "desc" => "The public hash delivered with the car channel",
                "name" => "general_pushCars",
                "type" => "text"
        ),
        array( 
                "label" => "Van Channel ID",
                "name" => "general_clkVans",
                "type" => "text"
        ),
        array( 
                "label" => "Van Channel Public hash",
                "desc" => "The public hash delivered with the van channel",
                "name" => "general_pushVans",
                "type" => "text"
        ),
        array( 
                "label" => "Enable tools",
                "name" => "general_enableTools",
                "options" => array( 'Tax calculator','Comparator','Electric comparator', 'Footprint calculator'),
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
                "name" => "tax_calculator_enableTaxCalculator",
                "options" => array( 'For car channel', 'For van channel' ),
                "type" => "checkbox"
                ),

            array( 
                "label" => "Car tax calculator pages",
                "name" => "tax_calculator_carParentPage",
                "options" => 'Pages',
                "desc" => "Select which page the car Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
                ) ,

            array( 
                "name" => "tax_calculator_carSelectPage",
                 "options" => 'Pages',
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
                ) ,
            array( 
                "name" => "tax_calculator_carModelPage",
                "options" => 'Pages',
                "desc" => "The Model page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_carOptionPage",
                "options" => 'Pages',
                "desc" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_carCalculatePage",
                "options" => 'Pages',
                "description" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ) ,
            array( 
                "label" => "Calculation override URL",
                "name" => "tax_calculator_carOverrideURL",
                "desc" => "Override URL to visit prior to the tax calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation).",
                "type" => "text"
            ),


             array( 
                "label" => "Van tax calculator pages",
                "name" => "tax_calculator_vanParentPage",
                "options" => 'Pages',
                "desc" => "Select which page the Van Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
            ),

            array( 
                "name" => "tax_calculator_vanSelectPage",
                 "options" => 'Pages',
                 "desc" => "The Select page (the first page in the calculation process).",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vanTaxModelPage",
                "options" => 'Pages',
                 "desc" => "The Model page.",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vanOptionsPage",
                "options" => 'Pages',
                 "desc" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "tax_calculator_vanCalculatePage",
                "options" => 'Pages',
                 "desc" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ),
           
            array( 
                "label" => "Car Tax Calculator Model page settings",
                "name" => "tax_calculator_vanModelPage",
                "options" => 'Pages',
                 "desc" => "Select options from list to add them to the box below. Repeat several times to build a list.",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_carCalculatorListFields",
                "desc" => "List of fields to include in the table of results. Must match database names exactly.",
                "std" => "derivative,transmission,co2gpkm,fueltype,otrPrice",
                "type" => "text"
            ),
            array( 
                "name" => "tax_calculator_carCalculatorTableHeaders",
                "desc" => "Table Headers. These correspond to the list above, use it to give the fields human-friendly aliases.",
                "type" => "text"
            ),
            array( 
                "desc" => '"Capital Contributions" field label',
                "type" => "option"
            ),
            array( 
                "desc" => '"Annual contributions" field label',
                "type" => "option"
            ),
            array( 
                "desc" => 'Intro to the "Vehicle Options" section',
                "type" => "option"
            ),
            array( 
                "desc" => '"Specify vehicle options" button text',
                "type" => "option"
            ),
            array( 
                "desc" => '"Specify vehicle options" button hint',
                "type" => "option"
            ),
            array( 
                "desc" => '"Quick calculation" button text',
                "type" => "option"
            ),
            array( 
                "desc" => '"Quick calculation" button hint',
                "type" => "option"
            ),

            array( 
                "label" => "van Tax Calculator Model page settings",
                "name" => "tax_calculator_vanModelPage",
                "options" => array( 'test1', 'test2' ),
                "desc" => "Select options from list to add them to the box below. Repeat several times to build a list.",
                "type" => "select"
            ),
            array( 
                "name" => "tax_calculator_vanCalculatorListFields",
                "desc" => "List of fields to include in the table of results. Must match database names exactly.",
                "type" => "text"
            ),
            array( 
                "name" => "tax_calculator_vanTaxCalculatorTableHeaders",
                "desc" => "Table Headers. These correspond to the list above, use it to give the fields human-friendly aliases.",
                "type" => "text"
            )
        ),


    'comparator' => array(  
            array( 
                "description" => "The Comparator allows users to compare several different vehicle across several contract terms and mileages. Calculations can be viewed from the point of view of the driver and the company.",
                "type" => "description"
            ),

            array( 
                "label" => "Enable comparator",
                "name" => "enableComparator",
                "options" => array( 'For car channel', 'For van channel' ),
                "type" => "checkbox"
                ),

            array( 
                "label" => "Car channel comparator",
                "name" => "carComparatorParentPage",
                "options" => 'Pages',
                "desc" => "Select which page the car Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
                ) ,

            
            array( 
                "name" => "carComparatorSelectPage",
                "options" => 'Pages',
                 "desc" => "The Select (the first page in the comparison process).",
                "type" => "select"
            ) ,
            array( 
                "name" => "carComparatorDetailsPage",
                "options" => 'Pages',
                 "desc" => "The Details page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "carComparatorCallbackPage",
                "options" => 'Pages',
                 "description" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            ) ,
            array( 
                "label" => "Comparator override URL",
                "name" => "carTaxOverrideURL",
                "desc" => "Override URL to visit prior to the comparation - leave blank if not needed (refer to documentation for correct redirection to final comparation)",
                "type" => "text"
            ),



            array( 
                "label" => "van channel comparator",
                "name" => "vanComparatorParentPage",
                "options" => 'Pages',
                 "desc" => "Parent page where you want the vans comparator plugin to appear.",
                "type" => "select"
                ) ,

            array( 
                "name" => "vanComparatorSelectPage",
                "options" => 'Pages',
                 "desc" => "Select which page the van Comparator Parent page will be loaded into.",
                "type" => "select"
                ) ,
            array( 
                "name" => "vanComparatorSelectPage",
                "options" => 'Pages',
                 "desc" => "The Select (the first page in the comparison process).",
                "type" => "select"
            ) ,
            array( 
                "name" => "vanComparatorDetailsPage",
                "options" => 'Pages',
                 "desc" => "The Details page.",
                "type" => "select"
            ) ,
            array( 
                "name" => "vanComparatorCallbackPage",
                "options" => 'Pages',
                 "description" => "The Callback page (This never gets seen by users but is crucial to user flow).",
                "type" => "select"
            ),



            array(
                "label" =>  'Cars Selector Texts',
                "desc" => 'Block of text above the selector dropdowns. By default contains: "For a comprehensive range of...". Edit as HTML',
                "type" => "option"
            ),
              array( 
                "desc" => 'Block of text below the selector dropdowns. By default contains: "Once you have selected a vehicle..." . Edit as HTML',
                "type" => "option"
            ),
                array(
                "label" => 'Vans Selector Texts',
                "desc" => 'Block of text above the selector dropdowns. By default contains: "For a comprehensive range of...". Edit as HTML',
                "type" => "option"
            ),
            array( 
                "desc" => 'Block of text above the selector dropdowns. By default contains: "For a comprehensive range of...". Edit as HTML Default Block of text below the selector dropdowns. By default contains: "Once you have selected a vehicle..." . Edit as HTML',
                "type" => "option"
            ),
               array( 
                "label" => "General settings",
                "name" => "comparatorTypicalMonthPrice",
                "options" => array( 'show'=>true, 'Don\'t Show'=>false ),
                "description" => "Typical month price",
                "type" => "select"
            ),
                  array( 
                "name" => "comparatorDefaultMileage",
                "options" => array( '10000'=>'10000', '20000'=>'20000' ),
                "description" => "Default annual mileage",
                "type" => "select"
            )









        )

);
?>