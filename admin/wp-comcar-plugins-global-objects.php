<?php
/**
 *Declare options
    */

// id and label of each nav, they will be shown in same order as this array
// $plugin_nav = array(
//     "general"               => "Main",
//     "tax_calculator"        => "Tax calculator",
//     "comparator"            => "Comparator",
//     "electric_comparator"   => "Electric comparator",
//     "footprint"             => "Footprint calculator",
//     "fuelprices"            => "Fuel prices calculator",
//     "fuel_benefit_check"    => "Fuel benefit check",
//     "car_details"           => "Car Details",
//     "prices_and_options"    => "Prices and options",
//     "chooser"               => "Chooser",
//     "mpg_calculator"        => "MPG Calculator"
// );

// $arr_type_vehicles = array('cars','vans');

// // Include all files inside plugin structure
// $scan_result =  scandir(dirname(__FILE__).'/pluginStructures/');
// foreach ( $scan_result as $key => $value ) {
//     if ( !in_array( $value, array( '.', '..' ) ) ) {
//         require_once( 'pluginStructures/'.$value );
//     }
// }

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
        "settings" => array(
            array(
                "title" => "Company Car Tax",
                "name" => "company_car_tax",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Company Van Tax",
                "name" => "company_van_Tax",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Comparator",
                "name" => "comparator",
                "description" => "",
                "type" => "pages"
            ),
            // array(
            //     "title" => "electric comparator page (I think we dropped this?)",
            //     "name" => "electric comparator page (I think we dropped this?)",
            //     "description" => "",
            //     "type" => "pages",
            // ),
            array(
                "title" => "CO<sub>2</sub> footprint",
                "name" => "co2_footprint",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Fuel Prices",
                "name" => "fuel_prices",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Fuel Benefit Check",
                "name" => "fuel_benefit_check",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Car Details",
                "name" => "car_details",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Prices and Options",
                "name" => "prices_and_options",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "Chooser",
                "name" => "chooser",
                "description" => "",
                "type" => "pages"
            ),
            array(
                "title" => "MPG Calculator",
                "name" => "mpg calculator",
                "description" => "",
                "type" => "pages"
            )
        )
    ),
    array(
        "title" => "Company Car Tax",
        "name" => "company_car_tax",
        "settings" => array(
            array(
                "title" => "Calculation Override URL",
                "name" => "calculation_override_url",
                "description" => "Intemediary page to send users to before revealing the tax calculation",
                "type" => "string"
            ),
            array(
                "title" => "Model Page column selector",
                "name" => "model_page_column_selector",
                "description" => "Select a column from the drop down to add to the column list for the model page",
                "type" => "string",
                "values" => ["foo","bar"]
            ),
            array(
                "title" => "Model Page column list",
                "name" => "model_page_column_list",
                "description" => "List of columns to show on the model page",
                "type" => "string",
                "values" => ["foo","bar"]
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
