<?
function fm_mainstage_area(
    // see mainstage area acf group
    $slides = null
)
{

    
    if ( !ga($slides) ) return;

    echo "<div class='slides'>";
        foreach ( $slides as $slide )
        {
            $background_image = $slide['background_image'] ?? null;
    	    $image_url = $background_image['url'] ?? null;
    	    $image_alt = $background_image['alt'] ?? null;
    	    
    	    $background_video = $slide['background_video'] ?? null;
    	    $sub_headline = $slide['sub_headline'] ?? null;
    	    $headline = $slide['headline'] ?? null;
    	    $description = $slide['description'] ?? null;
    	    $buttons = $slide['buttons'] ?? null;
    	    $tiles = $slide['tiles'] ?? null;
    	    
    	    
    	    
    	    echo "<div class='slide bg_dark bg_black wave_bottom'>";
	        
	            echo $image_url ? "<img src='$image_url' alt='$image_alt' class='bg'>" : null;
	         
    	        if ( $background_video ) 
    	        {
    	            echo "<video class='show-for-medium' preload='auto' loop='' autoplay='' muted='' webkit-plasinline='' poster='$image_url' aria-label='decorative video'>";
    	                echo "<source type='video/mp4' src='$background_video'>";
                    echo "</video>";
    	        }
    	    
    	        
    	        echo "<div class='content_wrapper'>";
    	            echo "<div class='row'>";
    	                echo "<div class='column small-12 medium-9 large-7'>";
            	            echo $sub_headline ? "<p class='h6'>$sub_headline</p>" : "";
            	            echo $headline ? "<h1>$headline</h1>" : "";
            	            echo $description;
            	            if ( is_array($buttons) ) {
            	                echo "<div class='buttons_hold'>";
                	                foreach ( $buttons as $button ) 
                	                {
                	                    fm_button(...$button['button']);
                	                }
                                echo "</div>";
            	            }
            	        echo "</div>";
    	            echo "</div>";
    	        echo "</div>";
    	    echo "</div>";
    	    if ( ga($tiles) )
	        {
    	        echo "<div class='bg_light bg_yellow textured hold_tiles'>";   
    	            echo "<div class='row tiles'>";
    	                $count = 0;
    	                foreach ( $tiles as $tile )
    	                {
    	                    $image = $tile['image'] ?? null;
                            $image_url = $image['url'] ?? null;
                            $image_alt = $image['alt'] ?? null;
                            $title = $tile['headline'] ?? null;
                            $link_url = $tile['link_url'] ?? null;
                            
                            
                            echo "<div class='tile column small-8 medium-6'>";
                                echo "<div class='hold_me clickable_box bg_light bg_white'>";
                                    echo "<div class='image'>";
                                         echo $image_url ? "<img src='$image_url' alt='$image_alt'>" : null;
                                    echo "</div>";
                                    echo "<div class='content'>";
                                        echo "<div class='top'>";
                                            echo $title ? "<h2 class='h3'>$title</h2>" : null;

                                        echo "</div>";
                                        echo "<div class='bottom'>";
                                            if ( $link_url ) {
                                                $count++;
                                                $x = $count % 2;
                                                $image_url = get_template_directory_uri() . "/_images/alt-spot-$x.svg";
                                                echo  "<a href='$link_url'><img src='$image_url' alt='learn about $title' /></a>";
                                                
                                            }
                                            
                                        echo "</div>";
                                        
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
    	                    
    	    
    	                }
    	            echo "</div>";
    	        echo "</div>";
	        }
    	            
        }
    echo "</div>";
    

    return array(
        "background_color" => "bg_dark bg_dark_gray",
        "id" => "",
        "classes" => array(
            "wave_bottom",
            ""
        )
    );
}
