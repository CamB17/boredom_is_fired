<?php 

$type = gf('type');

$remove_date = gf('remove_date');

if ( $type !== "content" ) wp_redirect('/');

get_template_part( 'global/header/header' ); 

fm_subpage_header();

echo "<section class='row module bg_light bg_white content'>";
    echo "<div class='columns small-12'>";
        while (have_posts()) : the_post(); 
		    echo !$remove_date ? "<h2 class='h4 date'>" . get_the_date() . "</h2>" : null;
		    echo gf('content');
			
        endwhile;
    echo "</div>";
echo "</section>";

(new bif_module_wrapper(
	name: 'resource_feed',
	background_color: 'bg_light bg_purple',
	element: 'section',
	params: array(
	    'headline' => "Recently Added Resources",
	    'button' => false,
	    'mode' => 'most_recent',
	    'exclude_ids' => array(get_the_ID())
	)
))->wrap();


get_template_part( 'global/footer/footer' ); 
