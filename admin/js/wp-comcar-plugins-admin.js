// custom javscript for model_page_column_list and model_page_column_heading settings
jQuery(document).ready(function($){
    function saveValuesToForm() {
        console.log(arr_model_columns);
        $column_list.val(arr_model_columns.map((column) => column.name));
        $column_headings.val(arr_model_columns.map((column) => column.heading));
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

    // use the Company Car Tax "Model Page column selector" to populate the "Model page column list"
    $('.wp_comcar_plugins_setting-model_list .wp_comcar_plugins_setting-model_list_checkbox').on('change',function(){
        console.log('clicked',this.checked,this.value);
        
        // always remove from arr_model_columns
        var items_to_remove = arr_model_columns.filter((item) => item.name === this.value);
        if(items_to_remove.length > 0) {
            var idx_item_to_remove = arr_model_columns.indexOf(items_to_remove[0]);
            arr_model_columns.splice(idx_item_to_remove,1);
        }

        // if ticking box, add back in
        if(this.checked) {
            arr_model_columns.push({
                name: this.value,
                heading: $('.wp_comcar_plugins_setting-model_list_textinput--' + this.value).val()
            });
        }

        saveValuesToForm();
    });

	// grab the current column list and headings
    var $column_list = $('#wp_comcar_plugins_company_car_tax_settings_model_page_column_list');
	var $column_headings = $('#wp_comcar_plugins_company_car_tax_settings_model_page_column_headings');

    var current_column_list = $column_list.val();
	var current_column_headings = $column_headings.val();
	
	// split the 2 list into arrays
	var arr_column_list = current_column_list.split(',');
	var arr_column_headings = current_column_headings.split(',');
	
	// map the lists to an array of objects
	var arr_model_columns = arr_column_list
        .filter((column) => $('.wp_comcar_plugins_setting-model_list_checkbox--' + column).length )
        .map((column, index) => {
        // make sure any items are ticked and update the heading if it differs from the default
        $checkbox = $('.wp_comcar_plugins_setting-model_list_checkbox--' + column);

        // tick checkbox
        $checkbox.prop('checked', true);

        // get the heading if it is defined
        $heading = $('.wp_comcar_plugins_setting-model_list_textinput--' + column);
        var heading_from_input = arr_column_headings[index];
        var heading_default = $heading.data('default');
        var heading = (typeof heading_from_input !== 'undefined' && heading_from_input !== '' ? heading_from_input : heading_default);
        $heading.val(heading);

        // add the column
        return {
            name: column,
            heading
        };
    });

    // enable form inputs
    $('.wp_comcar_plugins_setting-model_list input').prop('disabled', false);
    saveValuesToForm();

});
