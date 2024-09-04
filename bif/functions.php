<?php
// classes
foreach (glob(get_template_directory() . "/_classes/*.php") as $filename)
{
    require_once($filename);
}

// functions
foreach (glob(get_template_directory() . "/_functions/*.php") as $filename)
{
    require_once($filename);
}

// funcmods
foreach (glob(get_template_directory() . "/fm_assorted/*/*.php") as $filename)
{
    require_once($filename);
}
// funcmods
foreach (glob(get_template_directory() . "/fm_page_builder/*/*.php") as $filename)
{
    require_once($filename);
}

// include wp_admin
foreach (glob(get_template_directory() . "/_engine/wp_admin/*/*.php") as $filename)
{
    require_once($filename);
}

// require any function files that end in .func.php
foreach (glob(get_template_directory() . "{,/*,/*/*,/*/*/*,/*/*/*/*,/*/*/*/*/*}/*.func.php", GLOB_BRACE ) as $filename)
{
    require_once($filename);
}

if($_SERVER['SERVER_NAME'] === 'vidv.1.aordev.com') 
{
    add_filter('wp_get_attachment_url', function ($url) 
    {
      $parsed_url = parse_url( $url );
			$file = ABSPATH . ltrim( $parsed_url['path'], '/');
			if (file_exists( $file)) return $url;
			return str_replace('https://vidv.1.aordev.com', 'https://boredomisfired.com', $url);
        
    });
}

