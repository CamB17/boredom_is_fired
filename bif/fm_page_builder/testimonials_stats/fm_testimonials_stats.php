<? function fm_testimonials_stats(
    $color = null,
    $box = null
) { 
    $boxes = $box;
    if ( !ga($boxes) ) return;
    
    echo "<div class='row boxes'>";
        foreach ( $boxes as $box )
        {
            $type = $box['type'] ?? null;
            
            echo "<div class='column small-12 medium-6 box $type'>";
            
                if ( $type == "testimonial" )
                {
                    $t = $box['testimonial'] ?? null;
                    
                    
                    $testimonial = $t['testimonial'] ?? null;
                    $photo_url = $t['photo']['url'] ?? null;
                    $photo_alt = $t['photo']['alt'] ?? null;
                    $tagline = $t['tagline'] ?? null;
                    
                    echo "<div class='small-12 hold_testimonial bg_light bg_$color'>";
                        echo "<div class='row'>";
                            echo "<div class='column small-12 quote_icon'>";
                                echo "<img src='" . get_template_directory_uri() . "/_images/icon_quote.svg' alt='quote icon'>";
                            echo "</div>";
                            echo "<div class='column small-12 content'>";
                                echo "<div class='row'>";
                                    echo "<div class='column quote'>";
                                        echo $testimonial ? "<p class='small'>$testimonial</p>" : null;
                                        echo $tagline ? "<p class='h5'>— $tagline</p>" : null;
                                    echo "</div>";
                                    if ( $photo_url )
                                    {
                                        echo "<div class='column small-4 photo'>";
                                            echo $photo_url ? "<img src='$photo_url' alt='$photo_alt'>" : null;
                                        echo "</div>";
                                    }
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
                elseif ( $type == "stat" )
                {
                    $s = $box['stat'] ?? null;
                    $stat = $s['stat'] ?? null;
                    $headline = $s['headline'] ?? null;
                    $sub_headline = $s['sub_headline'] ?? null;
                    $icon_id = $s['icon'];
                    
                    echo "<div class='small-12 hold_stat $color'>";
                        echo "<div class='row large-unstack'>";
                            echo "<div class='stat column small-12'>";
                                echo $stat ? "<p>$stat</p>" : null;
                            echo "</div>";
                            echo "<div class='headline column small-12'>";
                                echo $headline ? "<h2>$headline</h2>" : null;
                                echo $sub_headline ? "<p>$sub_headline</p>" : null;
                            echo "</div>";
                            echo "<div class='icon column small-12 '>";
                                $icon_id ? fm_icon($icon_id) : null;
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
                
            echo "</div>";
        }
        
    echo "</div>";

    
    
    return array(
        // 'background_color' => "",
        'classes' => array(
            'textured wave_bottom wave_top'
        )
    );

} ?>