<?php

// enqueue javascript
function bif_enqueue_scripts() {
    
    if( is_admin()) {
        
        // add the admin js
        // wp_register_script('bif_admin_scripts', get_template_directory_uri() . '/_engine/vendor/wp_admin/wp_admin.js');
        // wp_enqueue_script('bif_admin_scripts');
        
        foreach (glob(get_template_directory() . "/_engine/wp_admin/**/*.js", GLOB_NOSORT) as $filename) {
              
            $basename = basename($filename, ".js");
            
            $relative_filename = get_template_directory_uri() . str_replace(get_template_directory(), '', $filename);
            
            // get the time it was last updated to cache busting
            $js_updated_time = filemtime($filename);
            wp_register_script($basename, $relative_filename. "?v=" . $js_updated_time, array(), false, false);
            wp_enqueue_script($basename);
        }
        
        
        // add select2
        // wp_register_script('select2', get_template_directory_uri() . '/_engine/vendor/wp_admin/select2/select2.min.js');
        // wp_enqueue_script('select2');
        
    } else {
        // remove default wp jquery so we can manage it ourselves
        wp_deregister_script('jquery');
    
        // loop thru each js file in the vendors folder and enqueue it
        // if its the jquery script, add it to the header
        foreach (glob(get_template_directory() . "/_engine/vendor/**/*.js", GLOB_NOSORT) as $filename) {
              
            $basename = basename($filename, ".js");
            $in_footer = true;
            // if it's the jquery file add it to the header
            if ( $basename == "jquery" ) {
                $in_footer = false;
            }
            $relative_filename = get_template_directory_uri() . str_replace(get_template_directory(), '', $filename);
            
            // get the time it was last updated to cache busting
            $js_updated_time = filemtime($filename);
            wp_register_script($basename, $relative_filename. "?v=" . $js_updated_time, array(), false, $in_footer);
            wp_enqueue_script($basename);
        }
        
        function bif_enqueue_from_glob($filename)
        {
            $basename = basename($filename, ".js");

            $relative_filename = get_template_directory_uri() . str_replace(get_template_directory(), '', $filename);
            
            // get the time it was last updated to cache busting
            $js_updated_time = filemtime($filename);
            wp_register_script($basename, $relative_filename. "?v=" . $js_updated_time, array(), false, true);
            wp_enqueue_script($basename);
        }
        
        foreach (glob(get_template_directory() . "/fm_assorted/**/*.js", GLOB_NOSORT) as $filename) {
              
            bif_enqueue_from_glob($filename);
        }
        foreach (glob(get_template_directory() . "/fm_page_builder/**/*.js", GLOB_NOSORT) as $filename) {
              
            bif_enqueue_from_glob($filename);
        }
        foreach (glob(get_template_directory() . "/global/**/*.js", GLOB_NOSORT) as $filename) {
              
            bif_enqueue_from_glob($filename);
        }
        foreach (glob(get_template_directory() . "/cpt/**/*.js", GLOB_NOSORT) as $filename) {
              
            bif_enqueue_from_glob($filename);
        }
    }
}
add_action('wp_enqueue_scripts', 'bif_enqueue_scripts');
add_action('admin_enqueue_scripts', 'bif_enqueue_scripts');


// enqueue css
function bif_enqueue_styles() {

  
    if ( is_admin() ) {
     
        // get all compiled css files into an array
        $exported_css_array = glob(get_template_directory() . "/_exports/_css-source{,/*,/*/*,/*/*/*,/*/*/*/*,/*/*/*/*/*}/*.css", GLOB_BRACE);
     
        // remove non admin css files
        foreach ( $exported_css_array as $key => $css_file ) {
            // if not in the wp_admin folder
            if ( !strpos($css_file, "/wp_admin/" ) ) {
                unset($exported_css_array[$key]);
            }
        }
        
        // enqueue each exported css file 
        foreach ($exported_css_array as $filename) {
              
            $basename = basename($filename, ".css");
            $relative_filename = get_template_directory_uri() . str_replace(get_template_directory(), '', $filename);
            $css_updated_time = filemtime($filename);
            wp_enqueue_style( $basename, $relative_filename . "?v=" . $css_updated_time);
            
        }
        
    } else {
        
        // loop thru the google fonts and add them to the site
        if ( function_exists('get_field') )
        {
            if (get_field('google_fonts','options')):
        	    while(has_sub_field('google_fonts','options')):
               
                    wp_enqueue_style( get_sub_field('font_name'), get_sub_field('font_url'), [], null );
        
        	    endwhile;
        
            endif;
        }
        
        
        // get all compiled css files into an array
        $exported_css_array = glob(get_template_directory() . "/_exports/_css-source{,/*,/*/*,/*/*/*,/*/*/*/*,/*/*/*/*/*}/*.css", GLOB_BRACE);
        
        // move global css files up to the top
        foreach ( $exported_css_array as $key => $css_file ) {
            if ( strpos($css_file, "/global/" ) ) {
                $exported_css_array = array($key => $css_file) + $exported_css_array;
            }
        }
        // move styles css files up to the top
        foreach ( $exported_css_array as $key => $css_file ) {
            if ( strpos($css_file, "/styles/" ) ) {
                $exported_css_array = array($key => $css_file) + $exported_css_array;
            }
        }
        // move vendor css files up to the top
        foreach ( $exported_css_array as $key => $css_file ) {
            if ( strpos($css_file, "/vendor/" ) ) {
                $exported_css_array = array($key => $css_file) + $exported_css_array;
            }
        }
        // remove admin css files
        foreach ( $exported_css_array as $key => $css_file ) {
            if ( strpos($css_file, "/wp_admin/" ) ) {
                unset($exported_css_array[$key]);
            }
        }
        
        // enqueue each exported css file 
        foreach ($exported_css_array as $filename) {
              
            $basename = basename($filename, ".css");
            $relative_filename = get_template_directory_uri() . str_replace(get_template_directory(), '', $filename);
            $css_updated_time = filemtime($filename);
            wp_enqueue_style( $basename, $relative_filename . "?v=" . $css_updated_time);
            
        }
        
        //enqueue the main stylesheet with a timestamp version for cache busting
        // $css_updated_time = filemtime(get_stylesheet_directory() . '/_exports/css/style.css');
        // wp_enqueue_style( 'main_stylesheet', get_template_directory_uri() . '/_exports/css/style.css?v=' . $css_updated_time );

    }
    
}
add_action('wp_enqueue_scripts', 'bif_enqueue_styles', 200);
add_action('admin_enqueue_scripts', 'bif_enqueue_styles', 200);

// register favicon
function bif_theme_favicons() {
    if ( function_exists('get_field') )
    {
        if ( get_field('favicon', 'options' ) ) :
            echo '<link rel="shortcut icon" type="image/x-icon" href="'. get_field('favicon','options')['url'] . '"/>';
        endif;
    }

}
add_action('wp_head', 'bif_theme_favicons');