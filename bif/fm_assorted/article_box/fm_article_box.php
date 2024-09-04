<? function fm_article_box(
    $post_id,
    $mobile_width = "small-12",
    $width = "medium-6 large-3"
) { 
	
    $type = gf('type', $post_id);
    $title = get_the_title($post_id);
    $permalink = get_the_permalink($post_id);
    $short_description = gf('short_description', $post_id);
    
    $target = null;
    
    if ( $type == "offsite_link" || $type == "onsite_link" )
    {
        $button_text = "Access";
        $aria_label = "Read offsite article titled $title";
        $button_link = gf('offsite_link_url');
        $button_new_tab = true;
        if ( $type == "onsite_link" )
        {
            $button_new_tab = false;
        }
    }
    elseif ( $type == "download" )
    {
        $button_text = "Download";
        $aria_label = "Download the resource associated with $title";
        $button_link = gf('download');
        $button_new_tab = true;
    }
    if ( $type == "content" )
    {
        $button_text = "Read More";
        $aria_label = "Read article titled $title";
        $button_link = $permalink;
        $button_new_tab = false;
    }
    $button_text = gf('cta_override') ?? $button_text;
    
    echo "<div class='fm_article_box column $mobile_width $width'>";
        echo "<div class='hold_me clickable_box bg_light bg_white'>";
            echo "<div class='content'>";
                echo "<div class='top'>";
                    echo "<img src='" . get_template_directory_uri() . "/_images/icon_resource_$type.svg' alt='$type icon' class='icon'>";
                    echo $title ? "<h3>$title</h3>" : null;
                    echo $short_description ? "<p>$short_description</p>" : null;
                echo "</div>";
                echo "<div class='bottom'>";
                    fm_button(
                        text: $button_text,
                        style: "primary",
                        url: $button_link,
                        aria_label: $aria_label,
                        new_tab: $button_new_tab,
                    );
                echo "</div>";
                
            echo "</div>";
        echo "</div>";
    echo "</div>";
    
} 