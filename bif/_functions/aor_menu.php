<?




// // Retrieve all items of a specific menu
// function get_menu_items($menu_slug) {
//     // Get all menu locations
//     $menu_locations = get_nav_menu_locations(); 
//     // Get our nav menu object
//     $menu_object = (isset($menu_locations[$menu_slug]) ? wp_get_nav_menu_object($menu_locations[$menu_slug]) : null); 
//     // If it exists, get the items (posts) in that menu
//     return (isset($menu_object->term_id) ? wp_get_nav_menu_items($menu_object->term_id) : null); 
// }

// // Function to get all the ancestor IDs of the current page
// function get_page_ancestors() {
//     $ancestors = [];
//     $current_page = get_post();

//     while ($current_page) {
//         $ancestors[] = $current_page->ID;
//         $current_page = $current_page->post_parent ? get_post($current_page->post_parent) : false;
//     }

//     return $ancestors;
// }

// // This function checks if a menu item or any of its descendants is the active page
// function is_active_page_recursive($menu_item, $menu_items, $ancestors) {
//     // Check if the current item is active or if it corresponds to an ancestor of the current page
//     if (get_the_ID() === (int)$menu_item->object_id || in_array((int)$menu_item->object_id, $ancestors)) {
//         return true;
//     }

//     // Iterate through the menu items to find any active descendants
//     foreach ($menu_items as $child_item) {
//         if ((int)$child_item->menu_item_parent === (int)$menu_item->ID && is_active_page_recursive($child_item, $menu_items, $ancestors)) {
//             return true;
//         }
//     }

//     return false;
// }

// // Recursive function to generate menu and submenu HTML structure
// function generate_menu_html($menu_items, $levels = PHP_INT_MAX, $class = "", $parent_id = 0, $current_level = 0) {
//     $html = '';
//     $ancestors = get_page_ancestors();

//     // If the current level exceeds the specified levels, return without further processing.
//     if ($current_level >= $levels) {
//         return $html;
//     }

//     foreach ($menu_items as $item) {
//         if ((int)$item->menu_item_parent === $parent_id) {
//             $active_class = is_active_page_recursive($item, $menu_items, $ancestors) ? 'menu_header_item_active' : '';

//             // Handle ACF custom fields on the menu items
//             // Check if the "bold_label" field is set for the menu item and assign class accordingly.
//             $bold_label_class = gf('bold_label', $item) ? 'bold_label' : '';
//             $no_link_class = gf('no_link', $item) ? 'no_link' : '';
//             $href_attribute = $no_link_class ? '' : "href='{$item->url}'";
            
//             // Recursive call to get sub-menu items first. Incrementing current level.
//             $submenu_html = generate_menu_html($menu_items, $levels, '', $item->ID, $current_level + 1);

//             $parent_class = $submenu_html ? 'menu_header_item_parent' : '';


//             $html .= "<li class='menu_header_item menu_id_{$item->ID} {$active_class} {$parent_class}' data-id='{$item->ID}' data-post-id='{$item->object_id}'>";
//             $html .= "<a class='menu_header_link {$no_link_class} {$bold_label_class}' {$href_attribute}>{$item->title}</a>";
//             $html .= $submenu_html;
//             $html .= "</li>";
//         }
//     }
    
//     $top_level_menu_class = $class ? "$class" : "menu menu_header";
//     $menu_class = $parent_id == 0 ? "$top_level_menu_class" : 'menu_header_sub_menu';
//     $menu_style = $parent_id != 0 ? "display:none;" : '';
//     if($html) {
//         return "<ul class='$menu_class' style='$menu_style'>$html</ul>";
//     }
// }

// // Function to render the menu
// function bif_menu($menu_slug, $levels = PHP_INT_MAX, $class = '') {
//     $menu_items = get_menu_items($menu_slug);
//     echo generate_menu_html($menu_items, $levels, $class);
// }
/*

class bif_menu_walker extends Walker_Nav_Menu {

    function __construct($css_class_prefix) {

        $this->css_class_prefix = $css_class_prefix;

        // Define menu item names appropriately

        $this->item_css_class_suffixes = array(
            'item'                      => '_item',
            'parent_item'               => '_item_parent',
            'active_item'               => '_item_active',
            'parent_of_active_item'     => '_item_parent_active',
            'ancestor_of_active_item'   => '_item_ancestor_active',
            'sub_menu'                  => '_sub_menu',
            'sub_menu_item'             => '_sub_menu_item',
            'link'                      => '_link',
        );

    }

    // Check for children

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = !empty( $children_elements[$element->$id_field] );
        }

        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

    }

    function start_lvl(&$output, $depth = 1, $args=array()) {

        $real_depth = $depth + 1;

        $indent = str_repeat("\t", $real_depth);

        $prefix = $this->css_class_prefix;
        $suffix = $this->item_css_class_suffixes;

        $classes = array(
            $prefix . $suffix['sub_menu'],
            $prefix . $suffix['sub_menu']. '_' . $real_depth
        );

        $class_names = implode( ' ', $classes );

        // Add a ul wrapper to sub nav

        $output .= "\n" . $indent . '<ul style="display:none;" class="'. $class_names .'">' ."\n";
    }

    // Add main/sub classes to li's and links

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        global $wp_query;
        
        
        
        

        $indent = ( $depth > 0 ? str_repeat( "    ", $depth ) : '' ); // code indent

        $prefix = $this->css_class_prefix;
        $suffix = $this->item_css_class_suffixes;

        // Item classes
        $item_classes =  array(
            'item_class'            => $depth == 0 ? $prefix . $suffix['item'] : '',
            'parent_class'          => $args->has_children ? $parent_class = $prefix . $suffix['parent_item'] : '',
            'active_page_class'     => in_array("current-menu-item",$item->classes) ? $prefix . $suffix['active_item'] : '',
            'active_parent_class'   => in_array("current-menu-parent",$item->classes) ? $prefix . $suffix['parent_of_active_item'] : '',
            'active_ancestor_class' => in_array("current-menu-ancestor",$item->classes) ? $prefix . $suffix['ancestor_of_active_item'] : '',
            'depth_class'           => $depth >=1 ? $prefix . $suffix['sub_menu_item'] . ' ' . $prefix . $suffix['sub_menu'] . '-' . $depth . '_item' : '',
            'user_class'            => $item->classes[0] !== '' ? $prefix . '_item-'. $item->classes[0] : '',
            'menu-id'               => 'menu_id_' . $item->object_id
       
        );

        // convert array to string excluding any empty values
        $class_string = implode("  ", array_filter($item_classes));

        // Add the classes to the wrapping <li>
        $output .= $indent . '<li class="' . $class_string . '">';

        // Link classes
        $link_classes = array(
            'item_link'             => $depth == 0 ? $prefix . $suffix['link'] : '',
            'depth_class'           => $depth >=1 ? $prefix . $suffix['sub_menu'] . $suffix['link'] . '  ' . $prefix . $suffix['sub_menu'] . '__' . $depth . $suffix['link'] : '',
        );

        $link_class_string = implode("  ", array_filter($link_classes));
        $link_class_output = 'class="' . $link_class_string . '"';

        // link attributes
        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';

        // Creatre link markup
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' ' . $link_class_output . '><span>';
        $item_output .=     $args->link_before;
        $item_output .=     apply_filters('the_title', $item->title, $item->ID);
        $item_output .=     $args->link_after;
        $item_output .=     $args->after;
        $item_output .= '</span></a>';

        // Filter <li>

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

}

/**
 * bif_nav_walker returns an instance of the walker_texas_ranger class with the following arguments
 * @param  string $location This must be the same as what is set in wp-admin/settings/menus for menu location.
 * @param  string $css_class_prefix This string will prefix all of the menu's classes, BEM syntax friendly
 * @param  arr/string $css_class_modifiers Provide either a string or array of values to apply extra classes to the <ul> but not the <li's>
 * @param  bool $remove_plugin This boolean will remove the data attributes and extra classes for plugin targeting. 'False' will output a basic UL structure.
 * @return [type]
 */
 /*
function bif_menu($location = "menu__main", $css_class_prefix = 'main-menu', $css_class_modifiers = null, $the_depth, $remove_plugin = false){

    // Check to see if any css modifiers were supplied
    if($css_class_modifiers){

        if(is_array($css_class_modifiers)){
            $modifiers = implode(" ", $css_class_modifiers);
        } elseif (is_string($css_class_modifiers)) {
            $modifiers = $css_class_modifiers;
        }

    } else {
        $modifiers = '';
    }
    
    if($remove_plugin) {
        $ul_structure = '<ul class="' . $css_class_prefix . ' ' . $modifiers . '">%3$s</ul>';
    } else {
        $ul_structure = '<ul class="menu ' . $css_class_prefix . ' ' . $modifiers . '">%3$s</ul>';
    }

    $args = array(
        'theme_location'    => $location,
        'container'         => false,
        'items_wrap'        => $ul_structure,
        'walker'            => new bif_menu_walker($css_class_prefix, true),
        'depth'             => $the_depth
    );

    if (has_nav_menu($location)){
        return wp_nav_menu($args);
    }else{
        $url = site_url();
        echo "<p>You need to first define a menu in <a href='" . $url . "/wp-admin/nav-menus.php?action=edit&menu=0'>WP-Admin</a><p>";
    }
}
*/