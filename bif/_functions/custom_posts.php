<?php
/*
this is a function that serves as a very quick way to set up a new post type with some default settings. to use it, uncomment the action below. for more customization, create a new function based on the function below called bif_add_advanced_post_type

https://developer.wordpress.org/resource/dashicons/

*/

function bif_custom_post_init() {

    
    bif_add_simple_post_type("Post Type", "Post Types", "post-types", "post-types", false, false, true, "dashicons-admin-tools", false);
  
  
    $queryArray = array(
        'post_type' => 'post-types',
        'posts_per_page' => -1
    );

  
  
    $loop = new WP_Query( $queryArray ); 
  
    if ( $loop->have_posts() ) : 
      
        while ( $loop->have_posts() ) : $loop->the_post(); 
            
            if ( get_the_title() == "Post" ) {
                continue;
            }
            
        
            $singular_name = gf('singular_name');
            $plural_name = gf('plural_name');
            $post_type_key = gf('post_type_key');
            $url_slug = gf('url_slug');
            $public = gf('public');
            $use_wordpress_archive = gf('use_wordpress_archive');
            $archive_page = gf('archive_page');
            $default_image = gf('default_image');
            $dashboard_icon = gf('dashboard_icon');
            $taxonomy_array = gf('taxonomies');
            $taxonomies = array();
       
            if ( ga($taxonomy_array) ) {
                foreach ( $taxonomy_array as $key => $taxonomy ) {
                    $taxonomies[] = $taxonomy;
                }
               
            }
            
            
            
            // if this post type doesnt have a WP archive and does have an archive page assigned
            if ( !$use_wordpress_archive && $archive_page ) {
                $url_slug = get_page_uri($archive_page);
            }
            

            bif_add_simple_post_type($singular_name, $plural_name, $post_type_key, $url_slug, $use_wordpress_archive, $public, true, $dashboard_icon, $taxonomies);
        
  
        endwhile; 
     
    endif; 
  
    wp_reset_postdata(); 
    

  
    
    // bif_add_simple_post_type("Tutorial", "Tutorials", "tutorial", "tutorials", false, true, true, "dashicons-welcome-learn-more", true);
}
add_action('init', 'bif_custom_post_init');


function bif_add_simple_post_type($singular, $plural, $post_type_name, $slug, $archive, $public, $queryable, $dashicon = "dashicons-admin-post", $taxonomies) {

  if ( $slug == null ) {
    $slug = $post_type_name;
  }

  $labels = array(
    'name' => $singular,
    'singular_name' => $singular,
    'menu_name' => $plural,
    'add_new' => 'Add ' . $singular . '',
    'add_new_item' => 'Add New ' . $singular . '',
    'edit' => 'Edit',
    'edit_item' => 'Edit ' . $singular . '',
    'new_item' => 'New ' . $singular . '',
    'view' => 'View ' . $singular . '',
    'view_item' => 'View ' . $singular . '',
    'search_items' => 'Find ' . $plural . '',
    'not_found' => 'No ' . $plural . ' Found',
    'not_found_in_trash' => 'No ' . $plural . ' Found in Trash',
    'parent' => 'Parent ' . $singular . '',
  );

  $args = array( 
    'labels' => $labels,
    'public' => $public,
    'publicly_queryable' => $queryable,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array(
      'slug' => $slug,
      'with_front' => false
    ),
    'capability_type' => 'post',
    'hierarchical' => false,
    'has_archive' => $archive,
    'menu_position' => null,
    'menu_icon' => $dashicon,
    
    'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' )
  );
  
  if ( $taxonomies ) {
    $args['taxonomies'] = array('category','tutorial-type');
  }

  register_post_type( $post_type_name , $args );
  flush_rewrite_rules();
}


/*
use the following function to add a customized post type

function bif_add_advanced_post_type()) {

  $singuler = "Example";
  $plural = "Examples";
  $post_type_name = "example"

  $labels = array(
    'name' => $singular,
    'singular_name' => $singular,
    'menu_name' => $singular,
    'add_new' => 'Add ' . $singular . '',
    'add_new_item' => 'Add New ' . $singular . '',
    'edit' => 'Edit',
    'edit_item' => 'Edit ' . $singular . '',
    'new_item' => 'New ' . $singular . '',
    'view' => 'View ' . $singular . '',
    'view_item' => 'View ' . $singular . '',
    'search_items' => 'Add ' . $plural . '',
    'not_found' => 'No ' . $plural . ' Found',
    'not_found_in_trash' => 'No ' . $plural . ' Found in Trash',
    'parent' => 'Parent ' . $singular . '',
  );

  $args = array( 'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title' )
  );

  register_post_type( $post_type_name , $args );
  flush_rewrite_rules();

}
add_action('init', 'bif_add_advanced_post_type');
*/

function bif_get_post_type_id_by_key($key) {
    
    
    $queryArray = array(
        'post_type' => 'post-types',
        'posts_per_page' => -1
    );

  
  
    $loop = new WP_Query( $queryArray ); 
  
    if ( $loop->have_posts() ) : 
      
        while ( $loop->have_posts() ) : $loop->the_post(); 
        
            $post_type_key = get_field('post_type_key');
            
            if ( $key == $post_type_key ) {
                $id = get_the_ID();
                wp_reset_postdata(); 
                return $id;
            }
  
        endwhile; 
     
    endif; 
  
    wp_reset_postdata(); 
    
    return null;
    
}
function bif_get_post_type_key_by_id($id) {
    
    
    $queryArray = array(
        'post_type' => 'post-types',
        'posts_per_page' => -1
    );

  
  
    $loop = new WP_Query( $queryArray ); 
  
    if ( $loop->have_posts() ) : 
      
        while ( $loop->have_posts() ) : $loop->the_post(); 
        
    
            
            if ( $id == get_the_ID() ) {
                $key = get_field('post_type_key');
                wp_reset_postdata(); 
                
                
                return $key;
            }
  
        endwhile; 
     
    endif; 
  
    wp_reset_postdata(); 
    
    return null;
    
}

function bif_get_archive_page_by_post_type_key($key)
{
    $post_type_id = bif_get_post_type_id_by_key($key);
    
    if ( $post_type_id )
    {
        return $archive_page = gf('archive_page', $post_type_id);
    }
}

function bif_get_archive_url_by_post_type_key($key)
{
    
    if ( $key == "post" )
    {
        return get_the_permalink(get_option( 'page_for_posts' ));
    }
    
    $archive_page = bif_get_archive_page_by_post_type_key($key);
        
    if ( $archive_page )
    {
        $archive_page_id = $archive_page->ID;
        $archive_page_url = get_the_permalink($archive_page_id);
        return $archive_page_url;
    }

    return false;
}

function bif_get_option_by_key($option, $key)
{
    $id = bif_get_post_type_id_by_key($key);
    
    return gf($option, $id);
    
}
function bif_get_plural_name_by_key($key)
{
    if ( $key == "post" )
    {
        return "Posts";
    }
    elseif ( $key == "page" )
    {
        return "Pages";
    }
    else
    {
        return bif_get_option_by_key("plural_name", $key);
    }
}