<?
function fm_resource_feed(
    $headline = null,
    $description = null,
    $button = null,
    $mode = null,
    $manual_resources = null,
    $by_resource_type = null,
    $exclude_ids = array()

) { 
    if ( $headline || $button )
    {
        echo "<div class='row headline'>";
            echo "<div class='small-8 medium-9 column text'>";
                echo $headline ? "<h2>$headline</h2>" : null; 
            echo "</div>";
            echo "<div class='small-4 medium-3 column link'>";
                 if ( $button ) {
                    $button['style'] = 'text';
                    fm_button(...$button);
                } 
            echo "</div>";
        echo "</div>";
    }
    if ( $description )
    {
        echo "<div class='row description'>";
            echo "<div class='small-12 column desc'>";
                echo $description;
            echo "</div>";
            
        echo "</div>";
    }
    echo "<div class='row resources'>";
        
        $query_array = array(
            'post_type' => 'resource',
            'posts_per_page' => 4,
            'post__not_in' => $exclude_ids
        );
        
        if ( $mode == "manual" )
        {

            if ( !ga($manual_resources) )
            {
                return;
            }
            $query_array['post__in'] = $manual_resources;
            $query_array['orderby'] = "post__in";
        }
        
        if ( $mode == "by_resource_type" )
        {
            
            $query_array['tax_query'] = array(
                array(
                    'taxonomy'         => 'resource-type',
                    'terms'            => array( $by_resource_type ),
                    'field'            => 'term_id',
                    'operator'         => 'IN',
                    'include_children' => true,
                ),
            );
        }
        
        
        $loop = new WP_Query( $query_array ); 
        
        $count = $loop->found_posts;
        $width = "large-3";
        if ( $count == 3 )
        {
            $width = "large-4";
        }
        
        if ( $loop->have_posts() ) : 
            
            while ( $loop->have_posts() ) : $loop->the_post(); 
                
                fm_article_box(
                    post_id: get_the_ID(),
                    mobile_width: "small-8 medium-5",
                    width: $width
                );
            
            endwhile; 
           
        endif; 
        
        wp_reset_postdata(); 
    echo "</div>";
    
    
    return array(
        // "background_color" => "",
        // "id" => "",
        
        "classes" => array(
            "textured",
            "wave_bottom",
            "wave_top"
        )
    );
 } 