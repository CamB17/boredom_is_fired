<? function fm_alert_bar()
{

	$args = array(
	    'post_type'      => "alert-bar",
	    'posts_per_page' => 1,
	    'order'          => 'ASC',
	 );
	
	$alert_query = new WP_Query( $args );
	
	if ( $alert_query->have_posts() ) { $alert_query->the_post();
	    
	    $cookie_id = "alert_bar_" . get_the_ID();
	    
	    
	    if(isset($_COOKIE[$cookie_id]) && $_COOKIE[$cookie_id] == "closed") {
	    	wp_reset_postdata();
	    	return;
	    }
	    	
    	$alert_bar_content = gf('alert_bar_content');
    
	    echo "<div id='alert_bar' class='fm_alert_bar bg_light bg_yellow textured' data-cookie_id='$cookie_id'>";
            echo "<div class='row'>";
               echo "<div class='column'>";
                  echo $alert_bar_content;
               echo "</div>";
            echo "</div>";
            echo "<button id='alert_bar_close' aria-label='close alert bar'>";
                icon_x();
                echo "Close Alert Bar";
            echo "</button>";
        echo "</div>";

	}
	wp_reset_postdata();
    
}