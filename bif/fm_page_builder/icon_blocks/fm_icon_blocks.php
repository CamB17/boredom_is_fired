<? function fm_icon_blocks(
    $headline = null,
    $description = null,
    $icons = null
    
) { 
    
    if ( !ga($icons) ) return;
    
    if ( $headline || $description ) {
        echo "<div class='row title'>";
            echo "<div class='column'>";
                echo $headline ? "<h2>$headline</h2>" : null;
                echo $description;
            echo "</div>";
        echo "</div>";
    }
    if ( !empty($icons) ) {
        echo "<div class='row icons'>";
            foreach ( $icons as $icon ) {
                
                $icon_id = $icon['icon']->ID ?? null;
                $icon_title = $icon['title'] ?? null;
                $icon_description = $icon['description'] ?? null;
                
                
                echo "<div class='column small-12 medium-6 content_icon'>";
                    echo "<div class='row'>";
                        echo "<div class='column shrink icon'>";
                            $icon_id ? fm_icon(icon_id: $icon_id) : null;
                        echo "</div>";
                        echo "<div class='column content'>";
                            echo $icon_title ? "<h3>$icon_title</h3>" : null;
                            echo $icon_description;
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                    
            }
        echo "</div>";
    }
    
    
    return array(
        "background_color" => "bg_dark bg_black textured",
        
        "classes" => array(
            "wave_bottom",
            "wave_top"
        )

    );
}
    
    