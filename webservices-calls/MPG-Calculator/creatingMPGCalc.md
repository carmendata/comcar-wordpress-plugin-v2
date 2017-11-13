#How I added the MPG Calculator to the Comcar WP Plugin

## What did I do?

The steps I followed

### 1) Add to plugin array

In the following file : \wp-content\plugins\comcar-wordpress-plugin\admin\wp-comcar-plugins-global-objects.php
Find the $plugin_nav array.
Add new item to the array, in this case "mpg_calculator" => "MPG Calculator".
This will add a tab to the plugin page and a checkbox to activate or deactivate the plugin.

### 2) Create plugin admin structure file

Copy one of the structure files in \wp-content\plugins\comcar-wordpress-plugin\admin\pluginStructures\
and give it an appropriate name, in this case mpgCalculatorStructure.php.
Update the options array with appropriate values

### 3) Add a case for the plugin

In \wp-content\plugins\comcar-wordpress-plugin\wp-comcar-plugins.php
Find the getToolContent() function, and add a case in the switch statement
for the new component.

### 4) Create folder and file

In \wp-content\plugins\comcar-wordpress-plugin\webservices-calls
Make a new folder for the plugin and add a php file for the component.
