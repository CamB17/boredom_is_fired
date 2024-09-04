<?
/*
$levels: 1, 2 or 3
$mode: visible, dropdown, mobile
*/
function fm_menu($menu_id, $html_id, $levels = 1, $mode = "visible")
{
    $menu_tree = fm_menu_get_menu_tree( $menu_id );
    
    // get the page ID that we're currently on
    $current_page_id = get_the_ID();
    echo "<nav id='$html_id' class='fm_menu $mode'>";
        echo "<ul class='level_1'>";
        
            foreach ( $menu_tree as $item ) 
            {
                
                $item = fm_menu_get_menu_item_info($item, $current_page_id);
                
                $class_string = $item['class_string'] ?? null;
                $title = $item['title'] ?? null;
                $url = $item['url'] ?? null;
                $children = $item['children'] ?? null;
                $children = $levels > 1 ? $children : null;
                $class_string = $item['hide_from_header_menu'] ? $class_string . " hide_from_header_menu" : $class_string;
                
                $svg_code = $children ? '<svg width="15" height="24" viewBox="0 0 15 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 21.17L9.17 12L0 2.83L2.83 0L14.83 12L2.83 24L0 21.17Z" fill="currentColor"/></svg>' : null;
                
                echo "<li class='$class_string'>";
                    echo "<div class='hold_link'>";
                        echo "<a href='$url'>$title$svg_code</a>";
                        
                        echo $mode == "mobile" && ga($children) && $levels > 1 ? "<button class='to_next_level' aria-label='go to $title sub menu'>Go to $title sub menu</button>" : null;
                        
                    echo "</div>";
                    
                    
                
                    if ( ga($children) && $levels > 1 ) {
                        
                        
                        echo "<ul class='level_2 bg_dark bg_black'>";
                        
                            if ( $mode == "mobile" )
                            {
                                echo "<li class='back'>";
                                    echo "<div class='hold_link'>";
                                        echo "<span>$title</span>";
                                        echo "<button class='to_prev_level' aria-label='go back to the level before $title'>go back to the level before $title</button>";
                                    echo "</div>";
                                echo "</li>";
                            }
                        
                            foreach ( $children as $item )
                            {
                                $item = fm_menu_get_menu_item_info($item, $current_page_id);
                
                                $class_string = $item['class_string'] ?? null;
                                $title = $item['title'] ?? null;
                                $url = $item['url'] ?? null;
                                $children = $item['children'] ?? null;
                                
                                echo "<li class='$class_string'>";
                                    echo "<div class='hold_link'>";
                                        echo "<a href='$url'>$title</a>";
                                        echo $mode == "mobile" && ga($children) && $levels > 2 ? "<button class='to_next_level' aria-label='go to $title sub menu'>Go to $title sub menu</button>" : null;
                                    echo "</div>";

          
                                    if ( ga($children) && $levels > 2 )
                                    {
                                        echo "<ul class='level_3'>";
                                        
                                            if ( $mode == "mobile" )
                                            {
                                                echo "<li class='back'>";
                                                    echo "<div class='hold_link'>";
                                                        echo "<span>$title</span>";
                                                        echo "<button class='to_prev_level' aria-label='go back to the level before $title'>go back to the level before $title</button>";
                                                    echo "</div>";
                                                echo "</li>";
                                            }
                                            
                                            foreach ( $children as $item )
                                            {
                                                $item = fm_menu_get_menu_item_info($item, $current_page_id);
                
                                                $class_string = $item['class_string'] ?? null;
                                                $title = $item['title'] ?? null;
                                                $url = $item['url'] ?? null;
                                                
                                                echo "<li class='$class_string'>";
                                                    echo "<div class='hold_link'>";
                                                        echo "<a href='$url'>$title</a>";
                                                    echo "</div>";
                                                echo "</li>";
                                                    
                                            }
                                        echo "</ul>";
                                    }
                                echo "</li>";
                                
                            }
                            
                        echo "</ul>";
                    }
                echo "</li>";
                
            }
            // add empty menu item to get 5 in the first column
            if ( $html_id === "footer_menu" )
            {
                echo "<li>&nbsp;</li>";
            }
        echo "</ul>";
    echo "</nav>";
}

function fm_menu_get_menu_item_info($item, $current_page_id)
{
    // clear the $class variable
    $classes = [];
    
    
    // get the ID of the page this menu item is pointing to
    $page_id = $item->object_id;
    
    $classes[] = "post_id_$page_id";
  
    // if the menu item page ID is the same as the current page ID, add is_active class
    if ( $page_id == $current_page_id )
    {
        $classes[] = "is_active";
    }
    
    if ( get_post_type($current_page_id) == "resource" )
    {
        if ( bif_get_archive_page_by_post_type_key("resource")->ID == $page_id )
        {
            $classes[] = "is_active";
        }
    }

    $menu_id = $item->ID;
    $children = $item->fm_menu_children;
    
    $hide_from_header_menu = gf('hide_from_header_menu', $item);
    
    $has_children = is_array($children) && !empty($children);
    
    // the following code figures out if we're currently on a child page of this top level menu item so we
    // can add an is_active class
    
    // if this menu item has children
    if ( $has_children )
    {
        // loop through each of these children
        foreach ( $children as $child )
        {
            // if this menu item's associated page ID is the same as the page ID we're currently on...
            if ( $child->object_id == $current_page_id )
            {
                // add is_active to the class list
                $classes[] = "is_active";
            }
        }
    }
    
    if ( $has_children )
    {
        $classes[] = "has_children";
    }
    
    $title = $item->title;
    $url = $item->url;
    $class_string = ga($classes) ? implode(" ", $classes) : null;
    
    return array(
        'class_string' => $class_string,
        'title' => $title,
        'url' => $url,
        'children' => $children,
        'hide_from_header_menu' => $hide_from_header_menu
    );
}


function fm_menu_get_page_ancestors( $page_id, $breadcrumbs = [] ) {

	$ancestors = array_reverse(get_ancestors($page_id, 'page'));
	foreach ( $ancestors as $ancestor_ID ) {
		$breadcrumbs[] = array(
			'title'	=> get_the_title($ancestor_ID),
			'url' => get_the_permalink($ancestor_ID)
		);
	}
	return $breadcrumbs;
}

function fm_menu_build_menu_tree( array &$elements, $parentId = 0 )
{
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parentId )
        {
            $children = fm_menu_build_menu_tree( $elements, $element->ID );
            if ( $children )
                $element->fm_menu_children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}
function fm_menu_get_menu_tree( $menu_id )
{
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? fm_menu_build_menu_tree( $items, 0 ) : null;
}