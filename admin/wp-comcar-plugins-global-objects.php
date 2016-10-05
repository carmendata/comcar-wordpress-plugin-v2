<?php
/* ---------------------------------------------------------
Declare options
----------------------------------------------------------- */

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
                "name" => "carChannelID",
                "type" => "text"
        ),
        array( 
                "label" => "Car Channel Public hash",
                "desc" => "The public hash delivered with the car channel",
                "name" => "carChannelHash",
                "type" => "text"
        ),
        array( 
                "label" => "Van Channel ID",
                "name" => "vanChannelID",
                "type" => "text"
        ),
        array( 
                "label" => "Van Channel Public hash",
                "desc" => "The public hash delivered with the van channel",
                "name" => "vanChannelHash",
                "type" => "text"
        ),
        array( 
                "name" => "Enable tools",
                "id" => "clkCars",
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
                "name" => "Enable tax calculator",
                "id" => "clkCars",
                "options" => array( 'For car channel', 'For van channel' ),
                "type" => "checkbox"
                ),

            array( 
                "name" => "Car tax calculator pages",
                "id" => "clkCars",
                "options" => array( 'test1', 'test2' ),
                "description" => "Select which page the car Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
                ) ,

            array( 
                "name" => " ",
                "id" => "clkCars",
                "options" => array( 'test1', 'test2' ),
                "description" => "The Select page (the first page in the calculation process).",
                "type" => "select"
                ) ,
            array( 
                "name" => " ",
                "id" => "clkCars",
                "options" => array( 'test1', 'test2' ),
                "description" => "The Model page.",
                "type" => "select"
            ) ,
            array( 
                "name" => " ",
                "id" => "clkCars",
                "options" => array( 'test1', 'test2' ),
                "description" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => " ",
                "id" => "clkCars",
                "options" => array( 'test1', 'test2' ),
                "description" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ) ,
            array( 
                "name" => "Calculation override URL",
                "id" => "clkCars",
                "desc" => "Override URL to visit prior to the tax calculation - leave blank if not needed (refer to documentation for correct redirection to final calculation).",
                "type" => "text",
                "std" => ""
            ) ,





             array( 
                "name" => "Van tax calculator pages",
                "id" => "clkVans",
                "options" => array( 'test1', 'test2' ),
                "description" => "Select which page the Van Tax Calculator Parent Page should be loaded into.",
                "type" => "select"
            ) ,

            array( 
                "name" => " ",
                "id" => "clkVans",
                "options" => array( 'test1', 'test2' ),
                "description" => "The Select page (the first page in the calculation process).",
                "type" => "select"
            ) ,
            array( 
                "name" => " ",
                "id" => "clkVans",
                "options" => array( 'test1', 'test2' ),
                "description" => "The Model page.",
                "type" => "select"
            ) ,
            array( 
                "name" => " ",
                "id" => "clkVans",
                "options" => array( 'test1', 'test2' ),
                "description" => "The Options page.",
                "type" => "select"
            ) ,
            array( 
                "name" => " ",
                "id" => "clkVans",
                "options" => array( 'test1', 'test2' ),
                "description" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ),

           
            array( 
                "name" => "Car Tax Calculator Model page settings",
                "id" => "clkVans",
                "options" => array( 'test1', 'test2' ),
                "description" => "And finally the Calculate page (the last page).",
                "type" => "select"
            ),
            array( 
                "name" => " ",
                "id" => "clkCars",
                "desc" => "List of fields to include in the table of results. Must match database names exactly.",
                "type" => "text",
                "std" => ""
            ) ,
            array( 
                "name" => " ",
                "id" => "clkCars",
                "desc" => "Table Headers. These correspond to the list above, use it to give the fields human-friendly aliases.",
                "type" => "text",
                "std" => ""
            )



        )

);
?>