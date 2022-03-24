<?php
    // custom logic to populate model_page_column_list and model_page_column_headings
    echo '<div class="wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list">';
    foreach($setting_values as $option_key => $option_title) {
        $selected = $value == $option_key ? 'selected' : '';
        echo '<div class="wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list_item">';
            echo '<label>';
                echo '<span>' . $option_title . '</span>';
                echo '<input class="wp_comcar_plugins_setting wp_comcar_plugins_setting-model_list_checkbox" type="checkbox" value="'.$option_key.'" />';
            echo '</label>';
            echo '<input type="text" value="'.$option_title.'" />';
        echo '</div>';
    }
    echo '</div>';
?>