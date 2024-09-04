<?
echo "<!DOCTYPE html>";
echo "<html class='no-js override' " . get_language_attributes() . ">";

echo "<head>";
    echo "<meta charset='utf-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />";
    wp_head();
echo "</head>";


echo "<body class='" . implode(" ", get_body_class()) . "'>";
    echo function_exists('get_field') ? get_field('tag_manager_noscript_code','options') : null;
    fm_alert_bar(); 
    
    echo "<header class=''>";
        echo "<div class='hold_header bg_dark wave_top'>";
            echo "<div class='row'>";
                echo "<div class='shrink columns logo'>";
                
                    $home_url = home_url();
              
                    // large logo
                    $logo_homepage_footer = gf('logo_homepage_footer', 'options');
                    echo "<a href='$home_url' class='logo_homepage_footer'>";
                        $logo_url = $logo_homepage_footer['url'] ?? null;
                        $logo_alt = get_bloginfo('name') . " logo";
                        echo $logo_homepage_footer ? "<img src='$logo_url' alt='$logo_alt' class='skip-lazy'>" : null; 
                    echo "</a>";

                    // horizontal logo 
                    $logo = gf('logo', 'options');
                    echo "<a href='$home_url' class='logo_normal'>";
                        $logo = gf('logo', 'options');
                        $logo_url = $logo['url'] ?? null;
                        $logo_alt = get_bloginfo('name') . " logo";
                        echo $logo ? "<img src='$logo_url' alt='$logo_alt' class='skip-lazy'>" : null; 
                    echo "</a>";
                echo "</div>";
                echo "<div class='columns navigation align-center align-middle'>";
                    
                    echo "<div class='menu_mobile_trigger_holder'>";
                        echo "<div id='menu_mobile_trigger'>";
                            echo "<span></span>";
                            echo "<span></span>";
                            echo "<span></span>";
                            echo "<span></span>";
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='menu_wrap'>";
                        // bif_menu('menu-header', 'menu_header', '', '3'); 
                        // fm_search_form(); 
                        fm_menu(
                            menu_id: 2,
                            html_id: "desktop_menu",
                            levels: 3,
                            mode: "dropdown" 
                        );
                    echo "</div>";
                echo "</div>";
                
                $header_cta_button = gf('header_cta_button','options');
                
                if ( gb($header_cta_button) )
                {
                    $header_cta_button['style'] = "primary";
                    echo "<div class='column cta shrink'>";
                        fm_button(...$header_cta_button);
                    echo "</div>";
                }
                
                
            echo "</div>";
        echo "</div>";
        fm_mobile_menu_container();
    echo "</header>";
