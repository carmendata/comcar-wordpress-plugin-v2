<?php
/* ---------------------------------------------------------
Declare options
----------------------------------------------------------- */
require_once( "pluginStructures/taxCalculatorStructure.php");
require_once( "pluginStructures/generalStructure.php");
require_once( "pluginStructures/comparatorStructure.php");
require_once( "pluginStructures/electricComparatorStructure.php");
require_once( "pluginStructures/footprintStructure.php");


global $general_structure;
global $tax_calculator_structure;
global $comparator_structure;
global $electric_comparator_structure;
global $footprint_structure;

$plugin_nav = array(     
                        "general"               => array( "label" => "Main", "path" => ""),
                        "tax_calculator"        => array( "label" => "Tax calculator", "path" => ""),
                        "comparator"            => array( "label" => "Comparator","path" => ""),
                        "electric_comparator"   => array( "label" => "Electric comparator","path" => ""),
                        "footprint"             => array( "label" => "Footprint calculator", "path" => "")
                    );






$plugin_options = array( 
    "general" => $general_structure,
    "tax_calculator" => $tax_calculator_structure,
    "comparator" => $comparator_structure,
    "electric_comparator" => $electric_comparator_structure,
    "footprint" => $footprint_structure


);
?>