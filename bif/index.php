<?php
if ( is_page() ) {

    get_template_part( 'pages/page-builder' );
}
elseif ( is_singular() ) {

    $post_type = get_post_type();

    $has_single = get_template_part( "cpt/$post_type/{$post_type}_single" );

}
elseif ( is_home() || is_category() ) {

    get_template_part( 'cpt/post/post_archive' );
}
elseif ( is_post_type_archive() ) {

    $post_type = $wp_query->query['post_type'];
    $has_archive = get_template_part( "cpt/$post_type/{$post_type}_archive" );
    echo "sdf";

    if ( !$has_archive ) {
        if ( is_user_logged_in() )
        {
            echo "No archive setup for this post type.";
        }
    }
}
elseif ( is_search() ) {

    get_template_part( 'global/search_results/search_results' );
}
elseif ( is_404() ) {
    
    // if the URL ends with /wpa, trigger a redirect to wp login and redirect back to the starting page
    $path = $_SERVER['REQUEST_URI'];
    if ( str_contains($path, "/wpa") )
    {
        $correct_path = str_replace("/wpa", "", $path);
        $login_url = wp_login_url($correct_path);
        wp_redirect($login_url);
    }
    
    get_template_part( 'global/404/404' );

}
elseif ( ( is_front_page() ) && ( !get_option( 'page_on_front' ) ) ) {

    echo "<a href='/wp-admin/options-reading.php'>Set a front page.</a>";
}
else {
    echo "Blank";
}


?>


