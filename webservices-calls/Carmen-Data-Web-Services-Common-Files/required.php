<?php


	$WPComcar_webServiceBaseURL = WPComcar_WEBSERVICEBASEURL;
	

	$WPComcar_services = array();
	$WPComcar_services['taxcalc'] 		= $WPComcar_webServiceBaseURL . 'TaxCalc.cfc?wsdl';
	$WPComcar_services['selectbyco2']	= $WPComcar_webServiceBaseURL . 'SelectByCO2.cfc?wsdl';
	$WPComcar_services['advsel']		= $WPComcar_webServiceBaseURL . 'AdvSel.cfc?wsdl';
	$WPComcar_services['footprint']		= $WPComcar_webServiceBaseURL . 'Footprint.cfc?wsdl';
	$WPComcar_services['electric_comparator']		= $WPComcar_webServiceBaseURL . 'ElectricComparator.cfc?wsdl';
	$WPComcar_services['fuelBenefit']	= $WPComcar_webServiceBaseURL . 'FuelBenefit.cfc?wsdl';
	$WPComcar_services['comparator']	= $WPComcar_webServiceBaseURL . 'Comparator.cfc?wsdl';
	$WPComcar_services['fuelprices']	= $WPComcar_webServiceBaseURL . 'fuelPrices.cfc?wsdl';
	$WPComcar_services['carDetails']	= $WPComcar_webServiceBaseURL . 'carDetails.cfc?wsdl';
	$WPComcar_services['pricesAndOptions']	= $WPComcar_webServiceBaseURL . 'pricesAndOptions.cfc?wsdl';
				


	// Only for debugging purposes
	$WPComcar_msg = '';

	include_once(WPComcar_WEBSERVICESCALLSPATH."general-plugin-functions.php");
?>