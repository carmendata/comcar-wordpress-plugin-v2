// custom javscript for model_page_column_list and model_page_column_heading settings
jQuery(document).ready(function($){
    function saveValuesToForm() {
        // column list
        $column_list['car'].val(arr_model_columns['car'].map((column) => column.name));
        $column_list['van'].val(arr_model_columns['van'].map((column) => column.name));
        // column headings
        $column_headings['car'].val(arr_model_columns['car'].map((column) => column.heading));
        $column_headings['van'].val(arr_model_columns['van'].map((column) => column.heading));
    }

    function getSettingListType(setting_name) {
        console.log('setting name', setting_name);
        switch(setting_name) {
            case 'wp_comcar_plugins_company_car_tax_settings_model_page_column_selector' : 
                return 'car';
            case 'wp_comcar_plugins_company_van_tax_settings_model_page_column_selector' : 
                return 'van';
            default :
                // invalid, return nothing;
                return '';
        }
    }

    // handle nav tab click
    $('.wp-comcar-plugins .nav-tab').on('click',function() {
        // get the data from the tab
        var target = $(this).data('target');
        // hide all content, then reveal the one we want
        $('.wp-comcar-plugins .tab-content').removeClass('tab-content-active');
        $('.wp-comcar-plugins .tab-content-'+target).addClass('tab-content-active');
        // deactivate all tab buttons, then activate the current one being clicked
        $('.wp-comcar-plugins .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
    });

    // use the Company Car/Van Tax "Model Page column selector" to populate the "Model page column list"
    $('.wp_comcar_plugins_setting-model_list .wp_comcar_plugins_setting-model_list_checkbox').on('change',function(){
        console.log('clicked',this.checked,this.value);
        var setting_name = $(this).closest('.wp_comcar_plugins_setting-model_list').data('setting');
        var car_or_van = getSettingListType(setting_name);
        console.log('car or van', car_or_van);
        
        // always remove from arr_model_columns
        var items_to_remove = arr_model_columns[car_or_van].filter((item) => item.name === this.value);
        if(items_to_remove.length > 0) {
            var idx_item_to_remove = arr_model_columns[car_or_van].indexOf(items_to_remove[0]);
            arr_model_columns[car_or_van].splice(idx_item_to_remove,1);
        }

        // if ticking box, add back in
        if(this.checked) {
            arr_model_columns[car_or_van].push({
                name: this.value,
                heading: $('.wp_comcar_plugins_setting-model_list_textinput--' + this.value).val()
            });
        }

        saveValuesToForm();
    });

	// grab the current column list and headings
    var $column_list = {};
	var $column_headings = {};
    var current_column_list = {};
    var current_column_headings = {};
	var arr_column_list = {};
    var arr_column_headings = {};
    var arr_model_columns = [];
	
	// map the lists to an array of objects, for cars and vans
    var arr_types = ['car','van'];
    for(var i in arr_types) {
        var type = arr_types[i];
        console.log('type',type);

        $column_list[type] = $('#wp_comcar_plugins_company_'+type+'_tax_settings_model_page_column_list')[0];
        $column_headings[type] = $('#wp_comcar_plugins_company_'+type+'_tax_settings_model_page_column_headings')[0];

        current_column_list[type] = $column_list[type].value;
        current_column_headings[type] = $column_headings[type].value;
        
        // split the 2 list into arrays
        arr_column_list[type] = current_column_list[type].split(',');
        arr_column_headings[type] = current_column_headings[type].split(',');
        
        // get the checkbox setting container
        $checkbox_container = $($column_list[type]).closest('form').find('.wp_comcar_plugins_setting-model_list');

        console.log($checkbox_container);

        arr_model_columns[type] = arr_column_list[type]
            .filter((column) => $checkbox_container.find('.wp_comcar_plugins_setting-model_list_checkbox--' + column).length )
            .map((column, index) => {
            // make sure any items are ticked and update the heading if it differs from the default
            $checkbox = $('.wp_comcar_plugins_setting-model_list_checkbox--' + column);
    
            // tick checkbox
            $checkbox.prop('checked', true);
    
            // get the heading if it is defined
            $heading = $('.wp_comcar_plugins_setting-model_list_textinput--' + column);
            var heading_from_input = arr_column_headings[type][index];
            var heading_default = $heading.data('default');
            var heading = (typeof heading_from_input !== 'undefined' && heading_from_input !== '' ? heading_from_input : heading_default);
            $heading.val(heading);
    
            // add the column
            return {
                name: column,
                heading
            };
        });
    }

    // enable form inputs
    $('.wp_comcar_plugins_setting-model_list input').prop('disabled', false);
    saveValuesToForm();

});
