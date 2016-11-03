<?php
    /* ---------------------------------------------------------
    Declare options
    ----------------------------------------------------------- */
    // include all structures
    $scan_result =  scandir(dirname(__FILE__).'/pluginStructures/');

    foreach ( $scan_result as $key => $value ) {  
        if ( !in_array( $value, array( '.', '..' ) ) ) {
            require_once( 'pluginStructures/'.$value );
        }
    }


    // global $general_structure;
    // global $tax_calculator_structure;
    // global $comparator_structure;
    // global $electric_comparator_structure;
    // global $footprint_structure;
    // global $fuelPrices_structure;
    // global $fuel_benefit_check_structure;
    // global $car_details_structure;
    // global $prices_and_options_structure;

    $plugin_nav = array(     
                            "general"               => array( "label" => "Main", "path" => "" ),
                            "tax_calculator"        => array( "label" => "Tax calculator", "path" => "" ),
                            "comparator"            => array( "label" => "Comparator","path" => "" ),
                            "electric_comparator"   => array( "label" => "Electric comparator","path" => "" ),
                            "footprint"             => array( "label" => "Footprint calculator", "path" => "" ),
                            "fuelprices"            => array( "label" => "Fuel prices calculator", "path" => "" ),
                            "fuel_benefit_check"    => array( "label" => "Fuel benefit check", "path" => ""  ),
                            "car_details"           => array( "label" => "Car Details", "path" => ""  ),
                            "prices_and_options"    => array( "label" => "Prices and options", "path" => ""  ),
                            "chooser"               => array( "label" => "Chooser", "path" => ""  )
                        );

    
    $plugin_options = array( 
        "general"               => $general_structure,
        "tax_calculator"        => $tax_calculator_structure,
        "comparator"            => $comparator_structure,
        "electric_comparator"   => $electric_comparator_structure,
        "footprint"             => $footprint_structure,
        "fuelprices"            => $fuelPrices_structure,
        "fuel_benefit_check"    => $fuel_benefit_check_structure,
        "car_details"           => $car_details_structure,
        "prices_and_options"    => $prices_and_options_structure,
        "chooser"               => $chooser_structure
    );
?>
