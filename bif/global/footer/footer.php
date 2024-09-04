<?
echo "<footer class='bg_dark bg_black textured wave_top'>";
    echo "<div class='top_footer '>";
        echo "<div class='row'>";
            
            echo "<div class='columns small-12 large-6 logo-menu'>";
                // large logo
                $logo_homepage_footer = gf('logo_homepage_footer', 'options');
                echo "<a href='/'>";
                    $logo_url = $logo_homepage_footer['url'] ?? null;
                    $logo_alt = get_bloginfo('name') . " logo";
                    echo $logo_homepage_footer ? "<img src='$logo_url' alt='$logo_alt' class='logo'>" : null; 
                echo "</a>";
                fm_menu(
                    menu_id: 2,
                    html_id: "footer_menu",
                    levels: 1,
                    mode: "visible"
                );
                
                $social_icons = gf('social_icons','options');
                
                if ( ga($social_icons) ) {
                    echo "<div class='social_icons'>";
                        foreach ( $social_icons as $social_icon ) {
                            $icon = isset($social_icon['icon']['url']) ? $social_icon['icon']['url'] : null;
                            $name = $social_icon['name'] ?? null;
                            $url = $social_icon['url'] ?? null;
                            
                            if ( $url && $icon ) {
                                echo "<a href='$url' target='_blank'>";
                                    echo "<img src='$icon' alt='$name'>";
                                echo "</a>";    
                            }
                        }
                    echo "</div>";
                }
                
                
            echo "</div>";
            echo "<div class='columns large-6 newsletter'>";
                $newsletter = gf('newsletter','options');
                echo $newsletter;
            echo "</div>";
        echo "</div>";
    echo "</div>";
    echo "<div class='bottom_footer'>";
        echo "<div class='row large-unstack'>";
            echo "<div class='columns copyright medium-12'>";
            
                $copyright_notice = gf('copyright_notice', 'options');
                $copyright_notice = str_replace('[year]', date('Y'), $copyright_notice);
                echo $copyright_notice ? "<p class='small'>$copyright_notice</p>" : null;
            echo "</div>";
            echo "<div class='columns links medium-12'>";
                $sub_footer_links = gf('sub_footer_links', 'options');
                if ( ga($sub_footer_links) )
                {
                    echo "<p class='small'>";
                        foreach ( $sub_footer_links as $sub_footer_link ) 
                        {
                            
                            $link_url = $sub_footer_link['link_url'] ?? null;
                            $link_text = $sub_footer_link['link_text'] ?? null;
                            
                            echo $link_url && $link_text ? "<a href='$link_url'>$link_text</a>" : null;
                        }
                        $powered_by_url = get_template_directory_uri() . "/_images/powered_by_aor.png";
                        echo "<p class='cam'><a href='https://cameronbarclay.com' rel='nofollow'><img src='$powered_by_url' alt='Powered by cameronbarclay.com'></a></p>";
                    echo "</p>";
                }
                
            
            echo "</div>";
        echo "</div>";
   echo "</div>";
echo "</footer>";



wp_footer(); 

echo "</body>";
echo "</html>";

