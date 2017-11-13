/***
 *  create component variables
 *  used for calculations and showing / hiding elements
***/
var miles_km_ratio         = 1.609344,
    gallons_litres_ration  = 4.54609,
    distance_in_miles      = 0,
    distance_in_kilometers = 0,
    fuel_in_gallons        = 0
    fuel_in_litres         = 0,
    mpg                    = 0,
    lpkm                   = 0,
    show_fuel_values       = false,
    show_errors            = false;



/***
 *  ("calculateMPG").onclick()
 *  When the calculateMPG button is clicked
 *  Reset the MPG Calculator, then
 *  Perform checks and calculations
***/
document.getElementById("calculateMPG").onclick = function() {
    // console.log('("calculateMPG").onclick()'); // debugging

    resetMPGCalculator()
        .then( performChecksAndCalculations );

}; // END : ("calculateMPG").onclick()



/***
 *  resetMPGCalculator()
 *  Resets values for showing errors and mileage calculations
 *  Hides errors and MPG values on screen
 *  Returns a promise, can be chained with other methods
***/
function resetMPGCalculator() {
    // created new Deferred object
    var deferred = $.Deferred();
    // console.log('resetMPGCalculator()'); // debugging

    // reset checks for showing fuel values and errors
    show_fuel_values = false;
    show_errors = false;

    // remove visiblity classes from values and errors
    document.getElementById("mpg-calculator-errors").classList.remove('is_visible');
    document.getElementById("mpg-calculator-fuel-values").classList.remove('is_visible');

    // resolve the deferred object
    deferred.resolve();
    // return the deferred promise
    return deferred.promise();
} // END : resetMPGCalculator()



/***
 *  performChecksAndCalculations()
 *  Gets values from form inputs
 *  Checks if input values are valid and can be used for calculations
 *  Shows errors on screen, or
 *  Performs calculations and show mileage values on screen
 *  Returns a promise, can be chained with other methods
***/
function performChecksAndCalculations() {
    // created new Deferred object
    var deferred = $.Deferred();
    // console.log('performChecksAndCalculations()'); // debugging

    // get values for doing calculations and checks
    // get the distance travelled
    var distance = document.getElementById('distance').value;
    // console.log("distance:", distance); // debugging
    // get distance units
    var distance_units = document.getElementById('distanceunit').value;
    // console.log("distance_units:", distance_units); // debugging
    // get the amount of fuel used
    var fuel = document.getElementById('fuelused').value;
    // console.log("fuel:", fuel); // debugging
    // get the fuel units
    var fuel_units = document.getElementById('fuelunit').value;
    // console.log("fuel_units:", fuel_units); // debugging


    // check if the distance and fuel values are valid
    // if either value is less than zero we have a problem
    // set show_errors = true
    if (distance <= 0 || fuel <= 0) {
        show_errors = true;
    }
    // if show_errors is false all is good
    // set show values = true
    if ( !show_errors ) {
        show_fuel_values = true;
    }


    // if show_errors is true
    // show error on screen
    if ( show_errors ) {
        document.getElementById("mpg-calculator-errors").classList.add('is_visible');
    }


    // if show_fuel_values is true
    // perform calculations and show values on page
    if ( show_fuel_values ) {
        // calculate distance travelled in miles and kilometers
        if (distance_units === "m") {
            distance_in_miles = distance;
            distance_in_kilometers = (distance * miles_km_ratio).toFixed(2);
        }
        if (distance_units === "k") {
            distance_in_kilometers = distance;
            distance_in_miles = (distance / miles_km_ratio).toFixed(2);
        }
        // console.log("distance_in_miles:", distance_in_miles); // debugging
        // console.log("distance_in_kilometers:", distance_in_kilometers); // debugging


        // calculate fuel used in litres and gallons
        if (fuel_units === "l") {
            fuel_in_litres = fuel;
            fuel_in_gallons = (fuel / gallons_litres_ration).toFixed(2);
        }
        if (fuel_units === "g") {
            fuel_in_gallons = fuel;
            fuel_in_litres = (fuel * gallons_litres_ration).toFixed(2);
        }
        // console.log("fuel_in_litres:", fuel_in_litres); // debugging
        // console.log("fuel_in_gallons:", fuel_in_gallons); // debugging


        // calculate MPG
        mpg = (distance_in_miles / fuel_in_gallons).toFixed(2);
        // calculate litres per 100 kms
        lpkm = ((fuel_in_litres / distance_in_kilometers) * 100).toFixed(2);


        // set values
        var mpgElement = document.getElementById("mpgValue");
        mpgElement.innerHTML = mpg;
        var lpkmElement = document.getElementById("lpkmValue");
        lpkmElement.innerHTML = lpkm;


        // show fuel values on screen
        document.getElementById("mpg-calculator-fuel-values").classList.add('is_visible');
    }

    // resolve the deferred object
    deferred.resolve();
    // return the deferred promise
    return deferred.promise();
} // END : performChecksAndCalculations()
