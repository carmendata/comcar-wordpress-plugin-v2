<?php
    /* ---------------------------------------------------------
    Declare options
    ----------------------------------------------------------- */
    // include all structures
    $plugin_nav = array(     
                            "general"               => "Main",
                            "tax_calculator"        => "Tax calculator",
                            "comparator"            => "Comparator",
                            "electric_comparator"   => "Electric comparator",
                            "footprint"             => "Footprint calculator",
                            "fuelprices"            => "Fuel prices calculator",
                            "fuel_benefit_check"    => "Fuel benefit check",
                            "car_details"           => "Car Details",
                            "prices_and_options"    => "Prices and options",
                            "chooser"               => "Chooser"
                        );

    
    $scan_result =  scandir(dirname(__FILE__).'/pluginStructures/');

    foreach ( $scan_result as $key => $value ) {  
        if ( !in_array( $value, array( '.', '..' ) ) ) {
            require_once( 'pluginStructures/'.$value );
        }
    }


    
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
