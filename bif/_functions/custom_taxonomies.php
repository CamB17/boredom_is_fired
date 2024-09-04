<?php
/*
this is a function that serves as a very quick way to set up a new taxonomy with some default settings. to use it, uncomment the action below.
*/

function bif_custom_taxonomy_init() {
    bif_custom_taxonomy('Career Path', 'Career Paths', array('resource'), 'career-path' );
    bif_custom_taxonomy('Resource Type', 'Resource Types', array('resource'), 'resource-type' );

}
add_action('init', 'bif_custom_taxonomy_init');

function bif_custom_taxonomy($singular, $plural, $custom_posts_array, $slug) {
    $labels = array(
        'name'                       => $plural,
        'singular_name'              => $singular,
        'menu_name'                  => $plural,
        'all_items'                  => 'All ' . $plural,
        'parent_item'                => 'Parent ' . $singular,
        'parent_item_colon'          => 'Parent ' . $singular . ':',
        'new_item_name'              => 'New Item ' . $singular,
        'add_new_item'               => 'Add New ' . $singular,
        'edit_item'                  => 'Edit ' . $singular,
        'update_item'                => 'Update ' . $singular,
        'view_item'                  => 'View ' . $singular,
        'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $plural,
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular ' . $plural,
        'search_items'               => 'Search ' . $plural,
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No ' . $plural,
        'items_list'                 => 'Items list',
        'items_list_navigation'      => 'Items list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
  
  
  
    // loop thru post types and see if any are assigned this taxonomy
    $queryArray = array(
        'post_type' => 'post-types',
        'posts_per_page' => -1
    );
    $loop = new WP_Query( $queryArray ); 
    if ( $loop->have_posts() ) : 
    
        while ( $loop->have_posts() ) : $loop->the_post(); 
      
            $taxonomy_array = gf('taxonomies');
            
        
            
            if ( is_array($taxonomy_array) ) {
                if ( in_array($slug, $taxonomy_array) ) {
                    $post_type_key = gf('post_type_key');
                    $custom_posts_array[] = $post_type_key;
                }
            }
            
        endwhile; 
   
    endif; 

    wp_reset_postdata(); 
  

    register_taxonomy( $slug, $custom_posts_array, $args );
}