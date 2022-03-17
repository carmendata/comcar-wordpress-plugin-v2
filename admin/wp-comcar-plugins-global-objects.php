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
    // array(
    //     "title" => "Company Van Tax",
    //     "name" => "company_van_Tax",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "Comparator",
    //     "name" => "comparator",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "CO<sub>2</sub> footprint",
    //     "name" => "co2_footprint",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "Fuel Prices",
    //     "name" => "fuel_prices",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "Fuel Benefit Check",
    //     "name" => "fuel_benefit_check",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "Car Details",
    //     "name" => "car_details",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "Prices and Options",
    //     "name" => "prices_and_options",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    // array(
    //     "title" => "Chooser",
    //     "name" => "chooser",
    //     "description" => "",
    //     "type" => "pages"
    // ),
    array(
        "title" => "MPG Calculator",
        "name" => "mpg calculator",
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
            // array(
            //     "title" => "Van Channel ID",
            //     "name" => "van_channel_id",
            //     "description" => "Provided by Carmen Data Ltd",
            //     "type" => "integer"
            // ),
            // array(
            //     "title" => "Van Channel Pubhash",
            //     "name" => "van_channel_pubhash",
            //     "description" => "Provided by Carmen Data Ltd",
            //     "type" => "string"
            // )
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
            // array(
            //     "title" => "Calculation Override URL",
            //     "name" => "calculation_override_url",
            //     "description" => "Intemediary page to send users to before revealing the tax calculation",
            //     "type" => "string"
            // ),
            array(
                "title" => "Model Page column selector",
                "name" => "model_page_column_selector",
                "description" => "Select a column from the drop down to add to the column list for the model page",
                "type" => "array",
                "values" => array(
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
                )
            ),
            array(
                "title" => "Model Page column list",
                "name" => "model_page_column_list",
                "description" => "List of columns to show on the model page",
                "type" => "string"
            )
        )
    )
);

// Car Tax specific settings
// <br />model page settings column list
// <br />model page settings column headers
// <br />Capital Contributions field label (checkbox)
// <br />Annual contributions field label (checkbox)
// <br />Intro to the Vehicle Options section (checkbox)
// <br />Specify vehicle options button text (checkbox)
// <br />Specify vehicle options button hint (checkbox)
// <br />Quick calculation button text (checkbox)
// <br />Quick calculation button hint (checkbox)

// Van Tax specific settings
// <br />calculation override URL
// <br />model page settings column dropdown
// <br />model page settings column list
// <br />model page settings column headers
// </div>

?>
