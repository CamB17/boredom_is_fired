<?
if ( is_user_logged_in() && is_plugin_active('acf-image-aspect-ratio-crop/acf-image-aspect-ratio-crop.php') )
{
    add_action('init', 'bif_fix_acf_crop_plugin_alts');
}

if ( !function_exists('bif_fix_acf_crop_plugin_alts') )
{
    
    function bif_fix_acf_crop_plugin_alts()
    {
        $query_array = array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_status' => 'inherit',
            'post_parent' => null,
            'post_mime_type' => 'image',
            's' => 'scaled'
        );
        
        $meta_query = array(
            'relation' => 'OR',
            array(
                'key'     => '_wp_attachment_image_alt',
                'value'   => '',
                'compare' => '=',
            ),
            'relation' => 'OR',
            array(
                'key'     => '_wp_attachment_image_alt',
                'compare' => 'NOT EXISTS',
            ),
        );
    
        $query_array['meta_query'] = $meta_query;
        
        $loop = new WP_Query( $query_array ); 
        
        if ( $loop->have_posts() ) {
            
            while ( $loop->have_posts() ) { $loop->the_post();
                $title = get_the_title();
                $id = get_the_ID();
                
                $parts = explode("-scaled", $title);
                $title_source = $parts[0] ?? null;
                
                
                
                if ( $title_source )
                {
                    $alt = bif_get_attachment_alt_by_title($title_source);
                    
                    if ( !$alt )
                    {
                        $parts = explode("-1-scaled", $title);
                        $title_source = $parts[0] ?? null;
                        $alt = bif_get_attachment_alt_by_title($title_source);
                    }
                    
                    if ( $alt )
                    {
                        $meta_id = update_post_meta($id, '_wp_attachment_image_alt', $alt);
                    }
                    
                }
            }
        }
        
        wp_reset_postdata(); 
    
    }
    
    function bif_get_attachment_alt_by_title( $title ) {
        global $wpdb;
    
        $attachments = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_title = '$title' AND post_type = 'attachment' ", OBJECT );
    
        
        if ( is_array($attachments) && !empty($attachments) ){
            
            foreach ( $attachments as $attachment )
            {
                
                $attachment_id = $attachment->ID ?? null;
                
                if ( $attachment_id )
                {
                    
                    
                    $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                    
                    if ( $alt ) return $alt;
                    
                }
            }
            
            
    
        }
        
        return false;
    }
}