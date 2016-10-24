<?php
	// defaults in case the page is visited without a $_POST submission from stage 1
	if(!isset($_GET['car']))         {  $_GET['car']="";  }
	if(!isset($_POST['car']))        {  $_POST['car']=$_GET['car'];  }

	if(!isset($_GET['id']))          {  $_GET['id']=$_POST['car'];  }
	if(!isset($_POST['id']))         {  $_POST['id']=$_GET['id'];  }

	if(!isset($_POST['CapCon']))     {  $_POST['CapCon']="";  }
	if(!isset($_POST['AnnCon']))     {  $_POST['AnnCon']="";  }
	if(!isset($_POST['frm_listID'])) {  $_POST['frm_listID']="";  }
	if(!isset($_POST['optTotal']))   {  $_POST['optTotal']="";  }

	// get $_POST data
	$WPComcar_formData = "";
	$WPComcar_formData = $WPComcar_formData.$_POST['id']."~";
	$WPComcar_formData = $WPComcar_formData.$_POST['CapCon']."~";
	$WPComcar_formData = $WPComcar_formData.$_POST['AnnCon']."~";
	$WPComcar_formData = $WPComcar_formData.$_POST['frm_listID']."~";
	$WPComcar_formData = $WPComcar_formData.$_POST['optTotal'];

	try {
		// connect to the webservice
		$WPComcar_ws = new SoapClient($WPComcar_services['taxcalc'], array('cache_wsdl' => 0));
		// call the required functions and store the returned data
		$WPComcar_resultsJS = fixForSsl($WPComcar_ws->GetJS($WPComcar_pubhash, $WPComcar_clk, 4, ''));


		$WPComcar_resultsHTML = fixForSsl($WPComcar_ws->GetHTML($WPComcar_pubhash, $WPComcar_clk, 4, "", $WPComcar_formData));
	} catch (Exception $WPComcar_e) {
		// Error handling code if soap request fails
		$WPComcar_msg = $WPComcar_msg.'The webservice failed to load the Calculation<br />';
	}

	include_once (WPComcar_WEBSERVICESCALLSPATH.'Carmen-Data-Web-Services-Template/template.php');
?>
