<? 
function fm_page_builder() 
{ 
	if ( !function_exists('get_field') ) return;
	
	// presence of module_id in the URL indicates the module preview functionality is being used
	$module_id = isset($_GET['module_id']) ? str_replace("row-", "", $_GET['module_id']) : null;

	while (have_posts()) 
	{ the_post();
	
		$page_builder_modules = gf('page_builder');
		
		
		if ( have_rows('page_builder') ) 
		{
			$x = 0;
			
			while ( have_rows('page_builder') ) 
			{ the_row();
				
				// if module preview isnt being used (or if this is the module being previewed...)
				if ( !$module_id || (int) $module_id === $x )
				{
			
		        
		        	$this_module = $page_builder_modules[$x];
		        	$this_module_settings = $this_module['layout_settings'];
		        	
		        	if ( $this_module_settings['hide_module'] === true ) 
		        	{
		        		$x++;
		        		continue;
		        	}
		        	
					/*
					experimental. getting the list of parameters of the func mod and
					automatically grabbing them from the page builder row, passing them 
					*/
	            	$parameters = new ReflectionFunction("fm_" . get_row_layout());
	            	
	            	// if 
	            	$this_module_settings['custom_css_classes'] .= (int) $module_id === $x ? " module_preview" : null;
	            	
	            	$params = array();
	            	foreach ( $parameters->getParameters() as $param)
	            	{
	            		$params[$param->name] = $page_builder_modules[$x][$param->name] ?? null;
	            	}
		
					// every module must have the correct background color classes. this fall back is the default, change per site
					$bg_color = gsf('background_color') ?: "bg_light bg_white";
					
					// apr($page_builder_modules[$x]);
					
					$classes = explode(" ", $this_module_settings['custom_css_classes']);
			
	            	(new bif_module_wrapper(
	            		name: get_row_layout(),
	            		background_color: $bg_color,
	            		classes: $classes,
	            		padding_top: null,
	            		padding_bottom: null,
	            		margin_top: null,
	            		margin_bottom: null,
	            		inline_css: explode(";", $this_module_settings['custom_inline_css']),
	            		id: $this_module_settings['custom_id'],
	            		element: 'section',
	            		remove_bottom_wave: $this_module_settings['remove_bottom_wave'],
	            		remove_top_wave: $this_module_settings['remove_top_wave'],
	            		params: $params
	            	))->wrap();
	            
				}
        		
	        	$x++;
			}
		}
	}
}
