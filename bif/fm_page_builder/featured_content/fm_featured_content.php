<? 
function fm_featured_content(
    string $headline = null,
    string $description = null,
    $content_blocks = null
) 
{
    if ( !ga($content_blocks) ) return;
    
    $block_heading_level = "h2";
    
    if ( $headline || $description ) {
        
        echo "<div class='row intro'>";
            if ( $headline || $description ) {
                
                $block_heading_level = $headline ? "h3" : "h2";
                
                echo "<div class='column small-12 medium-9'>";
                    echo $headline ? "<h2>$headline</h2>" : null;
                    echo $description;
                echo "</div>";
            }
            
        echo "</div>";
    }
    
    $count = count($content_blocks);
    
    if ( $count == 2 )
    {
        $width_class = "medium-6";
    }
    else if ( $count == 3 || $count == 5 || $count == 6 )
    {
        $width_class = "medium-4";
    }
    else if ( $count == 4 || $count > 6 )
    {
        $width_class = "medium-3";
    }
    
    echo "<div class='row featured_blocks' data-count='$count'>";
        foreach ( $content_blocks as $block )
        {
            $image_url = $block['image']['url'] ?? null;
            $image_alt = $block['image']['alt'] ?? null;
            $content = $block['content'] ?? null;
            $headline = $block['headline'] ?? null;
            
            echo "<div class='column block small-8 $width_class' tabindex='0'>";
                echo $image_url ? "<img src='$image_url' alt='$image_alt'>" : null;
                echo $headline ? "<$block_heading_level class='h4'>$headline</$block_heading_level>" : null;
                echo $content;
            echo "</div>";
        }
    echo "</div>";
    
    
    return array(
        "background_color" => "bg_dark bg_black textured",
        // "id" => "",
        
        "classes" => array(
            "wave_bottom",
            "wave_top"
        )
    );
} ?>