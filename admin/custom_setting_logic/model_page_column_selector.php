<?php
    /**
     * custom logic to populate model_page_column_list and model_page_column_headings
	 * start all fields disabled, enable once JS logic finishes
	 */
	echo '<div class="wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list">';
    foreach($setting_values as $option_key => $option_title) {
        $selected = $value == $option_key ? 'selected' : '';
        echo '<div class="wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list_item">';
            echo '<label>';
                echo '<span>' . $option_title . '</span>';
                echo '<input class="wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list_checkbox wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list_checkbox--'.$option_key.'" data-name="'.$option_key.'" type="checkbox" disabled value="'.$option_key.'" />';
            echo '</label>';
            echo '<input class="wp_comcar_plugins_setting-model_list_textinput wp_comcar_plugins_setting-model_list_textinput--'.$option_key.'" data-default="'.$option_title.'" type="text" disabled value="'.$option_title.'" />';
        echo '</div>';
    }
    echo '</div>';
?>