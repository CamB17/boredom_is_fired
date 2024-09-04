<? function fm_icon(
    $icon_id,
) { 
    
    $slug = get_post_field('post_name', $icon_id);
    $svg_code = get_field('svg_code', $icon_id);
    
    if ( $svg_code )
    {
        echo "<div class='fm_icon $slug'>";
            echo $svg_code;
        echo "</div>";
    }
   
}
    
    