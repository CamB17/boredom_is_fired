<? function fm_subpage_header() { 
	if ( !is_front_page() ) {
		$background_color = "bg_light bg_yellow";
		$image_url = null;
		$button = null;
		$button_two = null;
		if ( is_post_type_archive() ) {

			$post_type = $wp_query->query['post_type'];
			if ( $post_type == "news") {
				$title = "News";
			}
		} 
		elseif ( is_home() || is_category() ) {
			
			$title = "Blog";
			
		}
		elseif ( is_singular() ) {
			
			$post_type = get_post_type();
			$title = get_the_title();
			
			if ( $post_type == "resource" ) {
				
				
				$image_url = get_template_directory_uri() . "/_images/icon_resource.svg";
				$image_alt = "Article Icon";
			}
			elseif ( $post_type == "page" )
			{
				if ( gf('hide_subpage_header') ) return;
				$background_color = gf('background_color') ?? $background_color;
				$image = gf('image');
				$image_url = $image['url'] ?? null;
				$image_alt = $image['alt'] ?? null;
				
				$title = gf('override_page_title') ?: $title;
				
				$button = gf('button');
				$button_two = gf('button_two');
				
				$video_url = gf('video_url');
			}
		}	
		elseif ( is_404() ) {
			$title = "404 Error:<br>Page Not Found";
			$button['text'] = "Return to Home Page";
			$button['url'] = "/";
			
			$image_url = get_template_directory_uri() . "/_images/icon_alert.svg";
			$image_alt = "Alert Icon";
		}	
		elseif ( is_search() ) {
			$title = "Results for \"" . get_search_query() . "\"";
		}
		else {
			
			
			$title = get_the_title(); 
		}
		
		
		echo "<section class='fm_subpage_header $background_color textured wave_top wave_bottom'>";
			echo "<div class='row'>";
				echo "<div class='column small-12 medium-6 title'>";
					echo $title ? "<h1>$title</h1>" : null;
					if ( gb($button ) )
					{
						fm_button(...$button);
					}
					if ( gb($button_two ) )
					{
						fm_button(...$button_two);
					}
				echo "</div>";
				if ( $image_url )
				{
					echo "<div class='column small-12 medium-6 other_content'>";
						echo "<img src='$image_url' alt='$image_alt'>";
						if ( $video_url ) {
							$video_id = "video_" . rand(10000,10000000);
							echo "<a href='#$video_id' class='open-popup-link'>";
								echo '<svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM5 1a4 4 0 0 0-4 4v14a4 4 0 0 0 4 4h14a4 4 0 0 0 4-4V5a4 4 0 0 0-4-4H5Z" fill="#fcc44e" fill-rule="evenodd" class="fill-000000"></path><path d="m16 12-6 4.33V7.67L16 12Z" fill="#fcc44e" class="fill-000000"></path></svg>';
							echo "</a>";
							echo "<div id='$video_id' class='white-popup mfp-hide'>";
								echo $video_url;
							echo "</div>";
							
						}
					echo "</div>";
				}
			echo "</div>";
		echo "</section>";
		

	}
	
}