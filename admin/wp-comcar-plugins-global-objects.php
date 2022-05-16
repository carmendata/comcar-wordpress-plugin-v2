<?php
/**
 * Array of options (with types, values description) used to build plugin admin interface
 */
$wp_comcar_plugins_pages = array(
    array(
        "title" => "Company Car Tax",
        "name" => "company_car_tax",
        "description" => "",
        "type" => "pages"
    ),
    array(
        "title" => "Company Van Tax",
        "name" => "company_van_tax",
        "description" => "",
        "type" => "pages"
    ),
    array(
        "title" => "CO<sub>2</sub> footprint",
        "name" => "co2_footprint",
        "description" => "",
        "type" => "pages"
    ),
    array(
        "title" => "MPG Calculator",
        "name" => "mpg_calculator",
        "description" => "",
        "type" => "pages"
    )
);

$wp_comcar_plugins_settings_array = array(
    array(
        "title" => "Main Settings",
        "name" => "main",
        "settings" => array(
            array(
                "title" => "Car Channel ID",
                "name" => "car_channel_id",
                "description" => "Provided by Carmen Data Ltd",
                "type" => "integer"
            ),
            array(
                "title" => "Car Channel Pubhash",
                "name" => "car_channel_pubhash",
                "description" => "Provided by Carmen Data Ltd",
                "type" => "string"
            ),
            array(
                "title" => "Van Channel ID",
                "name" => "van_channel_id",
                "description" => "Provided by Carmen Data Ltd",
                "type" => "integer"
            ),
            array(
                "title" => "Van Channel Pubhash",
                "name" => "van_channel_pubhash",
                "description" => "Provided by Carmen Data Ltd",
                "type" => "string"
            )
        )
    ),
    array(
        "title" => "Pages",
        "name" => "pages",
        "settings" => $wp_comcar_plugins_pages
    ),
    array(
        "title" => "Company Car Tax",
        "name" => "company_car_tax",
        "settings" => array(
            array(
                "title" => "Model Page column selector",
                "name" => "model_page_column_selector",
                "description" => "Select a column from to add to the column list for the model page",
                "dont_save" => true,
                "type" => "array",
                "custom_logic" => "model_page_column_selector",
                "values" => array(
                    "bik" => "BIK",
                    "bodyStyle" => "Bodystyle",
                    "CO2gpkm" => "CO2",
                    "CO2pctge" => "CO2 Percentage",
                    "derivative" => "Derivative",
                    "doors" => "Doors",
                    "fuelType" => "Fuel Type",
                    "insfifty" => "Insurance Group",
                    "make" => "Manufacturer",
                    "model" => "Model",
                    "fuelConsumptionDf" => "MPG",
                    "p11d" => "P11D Value", 
                    "ps" => "Power",
                    "otrPrice" => "List Price",
                    "seats" => "Seats",
                    "taxHigh" => "Tax (high)",
                    "taxLow" => "Tax (low)",
                    "transmission" => "Transmission",
                    "VED" => "VED"
                )
            ),
            array(
                "title" => "Model Page column list",
                "name" => "model_page_column_list",
                "description" => "List of columns to show on the model page",
                "type" => "string",
                "readonly" => true
            ),
            array(
                "title" => "Model Page column headings",
                "name" => "model_page_column_headings",
                "description" => "Titles for columns to show on the model page",
                "type" => "string",
                "readonly" => true
            )
        )
    ),
    array(
        "title" => "Company Van Tax",
        "name" => "company_van_tax",
        "settings" => array(
            array(
                "title" => "Model Page column selector",
                "name" => "model_page_column_selector",
                "description" => "Select a column from to add to the column list for the model page",
                "dont_save" => true,
                "type" => "array",
                "custom_logic" => "model_page_column_selector",
                "values" => array(
                    "bodyStyle" => "Bodystyle",
                    "CO2gpkm" => "CO2",
                    "cvotr" => "CV Price",
                    "derivative" => "Derivative",
                    "doors" => "Doors",
                    "fuelType" => "Fuel Type",
                    "gvwkg" => "Gross Weight",
                    "insfifty" => "Insurance Group",
                    "loadlength" => "Load length",
                    "loadvolume" => "Load Volume" ,
                    "make" => "Manufacturer",
                    "model" => "Model",
                    "fuelConsumptionDf" => "MPG",
                    "payload" => "Payload",
                    "ps" => "Power",
                    "roof" => "Roof height",
                    "seats" => "Seats",
                    "taxHigh" => "Tax (high)",
                    "taxLow" => "Tax (low)",
                    "transmission" => "Transmission",
                    "VED" => "VED",
                    "wheelbase" => "Wheelbase"
                )
            ),
            array(
                "title" => "Model Page column list",
                "name" => "model_page_column_list",
                "description" => "List of columns to show on the model page",
                "type" => "string",
                "readonly" => true
            ),
            array(
                "title" => "Model Page column headings",
                "name" => "model_page_column_headings",
                "description" => "Titles for columns to show on the model page",
                "type" => "string",
                "readonly" => true
            )
        )
    )
);

?>
