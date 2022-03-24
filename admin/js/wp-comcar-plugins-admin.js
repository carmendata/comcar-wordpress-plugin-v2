jQuery(document).ready(function($){
    // handle nav tab click
    $('.wp-comcar-plugins .nav-tab').on('click',function() {
        // get the date from the tab
        var target = $(this).data('target');
        // hide all content, then reveal the one we want
        $('.wp-comcar-plugins .tab-content').removeClass('tab-content-active');
        $('.wp-comcar-plugins .tab-content-'+target).addClass('tab-content-active');
        // deactivate all tab buttons, then activate the current one being clicked
        $('.wp-comcar-plugins .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
    });

    // use the Company Car Tax "Model Page column selector" to populate the "Model page column list"
    $('[data-name="wp_comcar_plugins_company_car_tax_settings[wp_comcar_plugins_company_car_tax_settings_model_page_column_selector]"]').on('change',function(){
        // get current val, turn into array, filter to remove empty values, add new value to the end
        var current_val = $('#wp_comcar_plugins_company_car_tax_settings_model_page_column_list').val().split(',').filter(el => el);
        current_val.push(this.value);
        $('#wp_comcar_plugins_company_car_tax_settings_model_page_column_list').val(current_val.join(','));
    });

    // custom javscript for model_page_column_list and model_page_column_heading settings
    console.log('admin.js');

});
