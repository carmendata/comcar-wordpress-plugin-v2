<?php



	// Vehicle type ('Car' or 'Van'). The variable is defined in either 'Car-model.php' or 'Van-model.php'
	if(!isset($WPComcar_vehicleType)){    $WPComcar_vehicleType="Car";    }
	
	// defaults in case the page is visited without a $_POST submission from stage 1 
	if(!isset($_GET['MakeModel']))  {  $_GET['MakeModel']="";  }
	if(!isset($_GET['fjs_fuel']))   {  $_GET['fjs_fuel']="any";  }
	if(!isset($_POST['MakeModel'])) {  $_POST['MakeModel']=$_GET['MakeModel'];  }
	if(!isset($_POST['fjs_fuel']))  {  $_POST['fjs_fuel'] =$_GET['fjs_fuel'];  }

	// get data from POST or GET
	$WPComcar_MakeModel = $_POST['MakeModel'];
	$WPComcar_fuelType = $_POST['fjs_fuel'];

	if (strlen($WPComcar_MakeModel)==0){
		echo "Insufficient data was supplied to load the model page";
		return;
	}
	
	$WPComcar_arrOptions=get_option("WPComcar_plugin_options_tax_calculator");




	// Extra config info. All the parameters are optional: if not provided, the defaults will be used
	$WPComcar_objConfig = array();
		//Sorting parameters
		if(!isset($_GET['orderBy']))   {  $_GET['orderBy']="derivative";  }
		if(!isset($_GET['orderDir']))  {  $_GET['orderDir']="";  }
		$WPComcar_objConfig['orderBy']  = $_GET['orderBy'];
		$WPComcar_objConfig['orderDir'] = $_GET['orderDir'];

		//get the values from the options for the webservice
		$WPComcar_webServiceRequest=isset($WPComcar_arrOptions["tax_calculator_general_texts"]) ? $WPComcar_arrOptions["tax_calculator_general_texts"] : array() ;
		foreach($WPComcar_webServiceRequest as $key=>$value){
			if (strlen($value)>0){
				$WPComcar_objConfig[$key]=$value;
			}				
		}


		// Hard code some options to the new modern standards	
		$WPComcar_objConfig['modelTitleElemType'] = 'h1'; 
		$WPComcar_objConfig['tabulated'] = true;  	


		if( $WPComcar_vehicleType=='Car' ){
			// Parameters available in the company car tax calculator
		
			//Edit these values if you want to personalise the content on the page
			$WPComcar_objConfig['attributes'] = 'derivative,transmission,co2gpkm,fueltype,otrPrice';						// default="derivative,otrPrice" 
			$WPComcar_objConfig['attributesHeaders'] = 'Derivative,Transmission,CO<sub>2</sub> g/km,Fuel,List price';	// default="" (no headers displayed)


			//get the values from the options for the webservice
			$WPComcar_webServiceRequest=$WPComcar_arrOptions["tax_calculator_cars_texts"];
			foreach($WPComcar_webServiceRequest as $key=>$value){
				if (strlen($value)>0){
					if (strpos($key,"request")!==false){
						$WPComcar_objConfig['attributes']=$value;
					}else if (strpos($key,"headers")!==false){
						$WPComcar_objConfig['attributesHeaders']=$value;
					}else{
						$WPComcar_objConfig[$key]=$value;	
					}					
				}				
			}		

			
			//$WPComcar_jsnData = json_encode($_POST);


			//$WPComcar_objConfig['capCon'] = 'Capital contributions: ';
			//$WPComcar_objConfig['annCon'] = 'Annual contributions: ';

			//$WPComcar_objConfig['optionsIntro'] = "...";		// default="Drivers are taxed on the vehicle's full list price including options. " unless specified
			//$WPComcar_objConfig['optionsAdd'] = "..."; 		// default="Specify vehicle options" unless specified
			//$WPComcar_objConfig['optionsAddSubtext'] = "..."; 	// default="Configure the complete vehicle by selecting which options will be included" unless specified
			//$WPComcar_objConfig['inpGoToCalcValue'] = "..."; 	// default="Quick calculation" unless specified
			//$WPComcar_objConfig['goToCalcSubtext'] = "..."; 	// default="Continue straight to results without specifying vehicle options" unless specified

			//$WPComcar_objConfig['optionsAdd'] = '...'; 		// default="Add options" unless specified
			//$WPComcar_objConfig['optionsTotalText'] = '...'; 	// default="Or Insert total" unless specified

		}else{
			// Parameters available in the company van tax calculator
			//get the values from the options for the webservice

			//Edit these values if you want to personalise the content on the page
			$WPComcar_objConfig['attributes'] = 'derivative,transmission,gvwkg,fueltype,cvotr';			// default="derivative,otrPrice"
			$WPComcar_objConfig['attributesHeaders'] = 'Derivative,Transmission,GVW,Fuel,CV OTR Price';	// default="" (no headers displayed)

			$WPComcar_webServiceRequest=$WPComcar_arrOptions["tax_calculator_vans_texts"];
			foreach($WPComcar_webServiceRequest as $key=>$value){
				if (strlen($value)>0){
					if (strpos($key,"request")!==false){
						$WPComcar_objConfig['attributes']=$value;
					}else if (strpos($key,"headers")!==false){
						$WPComcar_objConfig['attributesHeaders']=$value;
					}else{
						$WPComcar_objConfig[$key]=$value;	
					}					
				}				
			}
		}
	$WPComcar_jsnConfig = json_encode($WPComcar_objConfig);


	try {
		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['taxcalc'], array('cache_wsdl' => 0));

		//CHANGE THE FORM SUBMISSION TO THE NEXT PAGE in Wordpress

		$WPComcar_vehicleTypeForIncluding=strtolower($WPComcar_vehicleType.'s');		
		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["options"];
		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);


		// call the required functions and store the returned data
		$WPComcar_resultsHTML = $WPComcar_ws->GetHTML( $WPComcar_pubhash, $WPComcar_clk, 2, $WPComcar_actionName, "$WPComcar_MakeModel~$WPComcar_fuelType~$WPComcar_jsnConfig" );
		//$WPComcar_resultsJS = $WPComcar_ws->GetJS( $WPComcar_pubhash, $WPComcar_clk, 2, $WPComcar_vehicleType."-calc.php~".$WPComcar_jsnConfig );

		$WPComcar_actionName= $WPComcar_arrOptions[$WPComcar_vehicleTypeForIncluding."_subpages"]["calc"];
		$WPComcar_actionName= WPComcar_getPageUrlById($WPComcar_actionName);

		$WPComcar_resultsJS = $WPComcar_ws->GetJS( $WPComcar_pubhash, $WPComcar_clk, 2, $WPComcar_actionName."~".$WPComcar_jsnConfig );
	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails 
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the Model list<br />';
	}
	
	
	$WPComcar_pageTitle = 'Models';

	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
