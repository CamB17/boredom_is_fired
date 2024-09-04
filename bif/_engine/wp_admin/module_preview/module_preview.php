<?

if ( is_user_logged_in() )
{
    
    
    // change the post preview URL if there's a module_id
    add_filter( "preview_post_link", "modify_preview_post_link_defaults", 10, 2 );
    function modify_preview_post_link_defaults($preview_link, $post) { 
        
        $module_id = $_POST['module_id'] ?? null;
        
        if ( $module_id )
        {
            $preview_link .= "&module_id=$module_id";
        }
        return $preview_link; 
    }
    
    // if module preview, add class
    add_filter( 'body_class', 'add_module_preview_body_class' );
    function add_module_preview_body_class( $classes ) {
        
      if ( isset($_GET['module_id']) )
      {
          $classes[] = "is_module_preview";
      }
      return $classes;
    }
}