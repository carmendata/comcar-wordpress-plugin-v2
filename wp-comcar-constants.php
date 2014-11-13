<?php
	//global constants
	define("WPComcar_WEBSERVICESCALLSPATH",dirname(__FILE__)."/webservices-calls/");
	define("WPComcar_FUNCTIONSPREFIX", "WPComcar_");
	define("WPComcar_PLUGINNAME", "WPComcarPlugin");
	define("WPComcar_PLUGINADMINNAME", "WPComcarPlugin_admin_configuration");
	define("WPComcar_PLUGINADMINHTMLNAME", "WPComcarPlugin_admin_configuration_html");

	//default channels and pubhash if not specified by the user
	define("WPComcar_CLKDEFAULTCARS", "44");
	define("WPComcar_PUBHASHDEFAULTCARS", "465C8B81AF089A09A88F4882AA52853B099483B1A9210ACA8943C37974BB8C832F85E0");
	define("WPComcar_CLKDEFAULTVANS", "45");
	define("WPComcar_PUBHASHDEFAULTVANS", "6C789D3B29BE9A17E8279ECCBE20D15B99F48858BBDD0F022F34D1C584B09CB966566A");

	//URL of the webservices
	define("WPComcar_WEBSERVICEBASEURL",'http://comcar.co.uk/webservices/');
?>