<?php
    $wp_comcar_plugins_results_js = '<script src="https://s3.eu-west-1.amazonaws.com/assets.comcar.co.uk/wordpress/mpg-calculator/vue-build-bundle.min.js"></script>';
	
	// get the page HTML
	$wp_comcar_plugins_results_html = '
        <!--
            MPG Calculator Markup
            Contains the form, mileage values, and error messages
        -->
        <div id="vue-gulp-app" class="component" v-cloak>
            <root-component></root-component>
            <noscript>You need javascript to use this app</noscript>
        </div>
    ';
