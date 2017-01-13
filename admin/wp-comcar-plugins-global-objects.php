<?php
    /* ---------------------------------------------------------
    Declare options
    ----------------------------------------------------------- */
    
    // id and label of each nav, they will be shown in same order as this array

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

    $arr_type_vehicles = array('cars','vans');
    
    // Include all files inside plugin structure
    $scan_result =  scandir(dirname(__FILE__).'/pluginStructures/');
    foreach ( $scan_result as $key => $value ) {  
        if ( !in_array( $value, array( '.', '..' ) ) ) {
            require_once( 'pluginStructures/'.$value );
        }
    }

?>
