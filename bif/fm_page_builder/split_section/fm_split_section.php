<? function fm_split_section(
    $title = null,
    // wysiwyg
    $content = null,
    $buttons = null,
    // wp image array
    $image = null,
    // "image_left_content_right" or "image_right_content_left"
    $layout = "image_left_content_right",
    
    ) {
    
    
    $row_class = $video_trigger_class = $popup_href = null;
    
    
    $image_alt = $image["alt"] ?? null;
    $image_url = $image['url'] ?? null;
    
    
    if ( $layout == "image_right_content_left" ) {
        $row_class .= " content_first";
    }
    
    

    
    echo "<div class='row $row_class'>";
    
    
        echo "<div class='columns small-12 medium-6 hold_image'>";
            echo $image_url ? "<img src='$image_url' alt='$image_alt'>" : null;
        echo "</div>";
        echo "<div class='columns small-12 medium-6 hold_content'>";
            echo "<div class='content'>";
            
                echo $title ? "<h2>$title</h2>" : null;
                echo $content; 
                
                if ( is_array($buttons) ) {
                    echo "<div class='button_hold'>";
                        foreach ( $buttons as $button ) {
                            fm_button(...$button['button']);
                        }
                    echo "</div>";
                }
            echo "</div>";
        echo "</div>";
    echo "</div>";
    
    return array(
        // "background_color" => "",
        // "id" => "",
        
        "classes" => array(
            "wave_bottom",
            "wave_top"
        )
    );
}