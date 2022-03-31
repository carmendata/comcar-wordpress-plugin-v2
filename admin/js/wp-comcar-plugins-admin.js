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
    $('.wp_comcar_plugins_setting-model_list .wp_comcar_plugins_setting-model_list_checkbox').on('change',function(){
        console.log('clicked',this.checked);
        // get current val, turn into array, filter to remove empty values, add new value to the end
        var current_val = $('#wp_comcar_plugins_company_car_tax_settings_model_page_column_list').val().split(',').filter(el => el);

        // make sure the item is not in the current list, if it is, remove it
        var this_val = this.value;
        var this_val_index = current_val.indexOf(this_val);
        if(this_val_index !== -1) {
            current_val.splice(this_val_index,1);
        }
        // if the checkbox is checked, add the value
        if(this.checked) {
            current_val.push(this.value);
        }
        $('#wp_comcar_plugins_company_car_tax_settings_model_page_column_list').val(current_val.join(','));
    });

    // custom javscript for model_page_column_list and model_page_column_heading settings
    console.log('admin.js');

});
