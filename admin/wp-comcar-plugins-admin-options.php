
<div class="wrap">
	
	<h2 class="nav-tab-wrapper">
		<?php
			$WPComcar_thePluginsSubTabs=WPComcarPlugin_admin_configuration::$arrOrderOfPlugins;
			foreach($WPComcar_thePluginsSubTabs as $arrKey=>$arrValue){
				if (strcmp($arrValue[0],"general")==0){
					echo '<a class="nav-tab WPComcar_subTab nav-tab-active '.$arrValue[0].'" data-targettab="' . $arrValue[0] . '">'.$arrValue[1].'</a>';
				}else{
					echo '<a class="nav-tab WPComcar_subTab '.$arrValue[0].'" data-targettab="' . $arrValue[0] . '">'.$arrValue[1].'</a>';
				}				
			}
		?>
	</h2>

	<form method="post" action="options.php">
		<?php settings_fields("WPComcar_plugin_options"); ?>
		<div id="WPComcar_sections">
			<?php do_settings_sections("WPComcar_plugin"); ?>
		</div>
		<?php submit_button("Save"); ?>	
	</form>	

</div>
