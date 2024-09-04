<?
get_template_part( 'global/header/header' );

fm_subpage_header();

$query = get_search_query();

$post_types = array('post','news','page','team_member');

if ( !$query )
{
    echo "<section class='padding'>";
        echo "<div class='row'>";
            echo "<div class='column small-12'>";
                echo "<p>Please enter a search term.</p>";
            echo "</div>";
        echo "</div>";
    echo "</section>";
}
else {

    foreach ( $post_types as $post_type )
    {
        echo "<section class='module padding post_type_wrapper $post_type bg_light bg_white'>";
            
            $plural_name = bif_get_plural_name_by_key($post_type);
            $archive_url = bif_get_archive_url_by_post_type_key($post_type);
            
            if ( $plural_name )
            {
                echo "<div class='row intro'>";
                    echo "<div class='column small-12 medium-expand headline'>";
                        echo "<h3>$plural_name</h3>";
                    echo "</div>";
                    if ( $archive_url )
                    {
                        echo "<div class='column small-12 medium-expand shrink view_all'>";
                            fm_button(
                                text: "All $plural_name",
                                style: "primary",
                                url: $archive_url
                            );
                        echo "</div>";
                    }
                echo "</div>";
                
            }
            echo "<div class='row results'>";
                $query_array = array(
                    'post_type' => $post_type,
                    'posts_per_page' => -1,
                    's' => $query
                );
                
                $loop = new WP_Query( $query_array ); 
                
                if ( $loop->have_posts() ) {

                    while ( $loop->have_posts() ) { $loop->the_post();
                        
                        $title = get_the_title();
                        
                        echo "<div class='column small-12'>";
                            echo $title ? "<p>$title</p>" : null;    
                        echo "</div>";
                
                    }
                
                   
                }
                else
                {
                    echo "<div class='column small-12'>";
                        echo "<p>No results for $plural_name.</p>";
                    echo "</div>";
                }
            echo "</div>";
            
            wp_reset_postdata(); 
        echo "</section>";
    }
}


get_template_part( 'global/footer/footer' );
