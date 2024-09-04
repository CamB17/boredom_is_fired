<?
function fm_resource_archive(
    $headline = null,
    $hide_filters = false

) { 
    if ( $headline )
    {
        echo "<div class='row headline'>";
            echo "<div class='column small-12 medium-6'>";
                echo "<h1>$headline</h1>";
            echo "</div>";
        echo "</div>";
    }
    
    $filters_style = $hide_filters ? "style='display:none;'" : null;
    echo "<div class='row filters' $filters_style>";
        echo "<div class='column small-12'>";
            echo do_shortcode('[ajax_load_more_filters id="resource_archive" target="resource_archive_posts"]');
        echo "</div>";
    echo "</div>";
    
    echo "<div class='row resources'>";
        echo "<div class='column small-12'>";
            echo do_shortcode('[ajax_load_more id="resource_archive_posts" target="resource_archive" filters="true" seo="true" theme_repeater="alm_article.php" post_type="resource" posts_per_page="12" scroll="false" orderby="menu_order" order="ASC"]');
        echo "</div>";
    echo "</div>";
    
    return array(
        "background_color" => "bg_light bg_yellow",
        // "id" => "",
        
        "classes" => array(
            "textured",
            "wave_bottom",
            "wave_top"
        )
    );
 } 