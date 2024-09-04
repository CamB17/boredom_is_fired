<?

if ( is_multisite() ) {
	add_filter('acf/location/rule_types', 'acf_location_rule_type_multisite');
	add_filter('acf/location/rule_values/site',  'acf_location_rule_values_multisites');
	add_filter('acf/location/rule_match/site', 'acf_location_rules_match_site', 10, 3);
}

function acf_location_rule_type_multisite( $choices ) {

	$choices['Multisite']['site'] = 'Site';
	return $choices;

}

function acf_location_rule_values_multisites( $choices ) {

	$choices ['all'] = 'All';
	$sites = get_sites();

	foreach( $sites as $site ) {
		$choices[ get_object_vars($site)['blog_id'] ] = get_object_vars($site)['domain'];
	}

	return $choices;
}

function acf_location_rules_match_site( $match, $rule, $options ) {
	$current_site = get_current_blog_id();
	$selected_site = (int) $rule['value'];

	if($rule['operator'] == "==") {
		$match = ( $current_site == $selected_site );
	}
	elseif($rule['operator'] == "!=") {
		$match = ( $current_site != $selected_site );
	}

	return $match;
}

// save fields to json
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {

    // update path
    $path = get_template_directory() . '/_engine/acf';
    // return
    return $path;

}

//load fields from json
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {

    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = get_template_directory() . '/_engine/acf';
    // return

    return $paths;

}

// add parent page to post object results
add_filter('acf/fields/post_object/result', 'my_acf_fields_post_object_result', 10, 4);
function my_acf_fields_post_object_result( $text, $post, $field, $post_id ) {
    
    if ( $post->post_type == "icons" ) {
		$post_id = $post->ID;
		$image_code = get_field('svg_code', $post_id) ? get_field('svg_code', $post_id) : "<img src='" . get_field('svg_file', $post_id)['url'] . "'>";
		$text = "<div class='acf_icon_hold'><div class='hold_icon'>$image_code</div><div class='hold_text'>$text</div></div>";
	}
	
    if($post->post_parent && get_the_title($post->post_parent)) {
        $text .= ' (Parent: ' . get_the_title($post->post_parent) .  ')';
    }
    return $text;
}

// Add Options Pages
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'  => 'Theme Options',
		'menu_title'  => 'Theme Options',
		'menu_slug'   => 'options',
		'capability'  => 'manage_options',
		'redirect'    => false
	));

}

// make the flexible content titles more helpful
function bif_filter_flexible_titles( $title, $field, $layout, $i ) {

    // if this is an additional module
    if ( get_sub_field('module') ) {
        $title .= " (" . str_replace("_", " ", get_sub_field('module')) . ")" ;
    }
    
    // use custom row if filled in, otherwise default to another title field within the module
    if( get_sub_field('custom_row_name') ) : 
        $title .= ' - "' . get_sub_field('custom_row_name') . '"';
    elseif( get_sub_field('headline') ) : 
        $title .= ' - "' . get_sub_field('headline') . '"';
    elseif ( get_sub_field('title') ) : 
        $title .= ' - "' . get_sub_field('title') . '"';
    endif;
    
    // add inactive status to module
    if ( get_sub_field("hide_module") ) {
        $title = "<span class=\"template-inactive\">Hidden</span>&nbsp;&nbsp;" . $title;
    }
    
    return $title;
}
add_filter('acf/fields/flexible_content/layout_title', 'bif_filter_flexible_titles', 10, 4);

// if editing an ACF group, make the title more helpful
add_filter('admin_title', 'bif_filter_admin_title', 10, 2);
function bif_filter_admin_title($admin_title, $title)
{
    $page_title = get_the_title();
    $post_type = get_post_type();
    
    if ( $post_type == "acf-field-group" ) {
      return "ACF: " . $page_title;
    }

    return $admin_title;
}
