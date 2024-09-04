<?
// no rss feed for static sites
function bif_disable_feed() {
  wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

add_action('do_feed', 'bif_disable_feed', 1);
add_action('do_feed_rdf', 'bif_disable_feed', 1);
add_action('do_feed_rss', 'bif_disable_feed', 1);
add_action('do_feed_rss2', 'bif_disable_feed', 1);
add_action('do_feed_atom', 'bif_disable_feed', 1);

add_filter('transient_update_plugins', 'bif_update_active_plugins');
function bif_update_active_plugins($value = '') {
/*
The $value array passed in contains the list of plugins with time
marks when the last time the groups was checked for version match
The $value->reponse node contains an array of the items that are
out of date. This response node is use by the 'Plugins' menu
for example to indicate there are updates. Also on the actual
plugins listing to provide the yellow box below a given plugin
to indicate action is needed by the user.
*/
  if ((isset($value->response)) && (count($value->response))) {
    // Get the list cut current active plugins
    $active_plugins = get_option('active_plugins');
    if ($active_plugins) {
      //  Here we start to compare the $value->response
      //  items checking each against the active plugins list.
      foreach($value->response as $plugin_idx => $plugin_item) {
        // If the response item is not an active plugin then remove it.
        // This will prevent WordPress from indicating the plugin needs update actions.
        if (!in_array($plugin_idx, $active_plugins))
          unset($value->response[$plugin_idx]);
      }
    }
    else {
      // If no active plugins then ignore the inactive out of date ones.
      foreach($value->response as $plugin_idx => $plugin_item) {
        unset($value->response);
      }
    }
  }
  return $value;
}
// remove version info from head and feeds
add_filter('the_generator', 'bif_complete_version_removal');
function bif_complete_version_removal() {
  return '';
}



// remove wp version param from any enqueued scripts
function at_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'at_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'at_remove_wp_ver_css_js', 9999 );

//remove pings to self
add_action( 'pre_ping', 'bif_no_self_ping' );
function bif_no_self_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
      if  ( 0 === strpos( $link, $home ) )
          unset($links[$l]);
}

// no error message on login failure
// add_filter('login_errors',create_function('$a', "return null;"));

// login errors
function login_errors($errors) {
  global $user_login;

  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'lostpassword' || isset($_REQUEST['checkemail'])) {
    if(
    preg_match('/There is no user registered with that email address/', $errors) ||
    preg_match('/Invalid username or e-mail/', $errors) ||
    preg_match('/Check your e-mail for the confirmation link/', $errors)
    ) {
    $errors = 'If the account information you provided was valid, we have sent you an e-mail. Please check your e-mail for the confirmation link.';

    if(!isset($_REQUEST['checkemail'])) {
      $redirect_to = 'wp-login.php?checkemail=confirm';
      wp_safe_redirect( $redirect_to );
      exit();
    }
    }
  }
  else {
    if(preg_match('/password you entered for the username/', $errors) ||
     preg_match('/Invalid username/', $errors)) {

    $errors = 'Your login information was incorrect. <a href="/wp-login.php?action=lostpassword">Lost your password</a>?';
    $user_login = $_POST['log'];
    unset($_POST['log']);

    if(preg_match('/[@]/', $user_login)) {
      $errors .= "<br><br>Hint: your email address is not your username.";
    }
    }
  }

  return $errors;
}

// prevent multisite signup
function rbz_prevent_multisite_signup() {
  wp_redirect( site_url() );
  die();
}
add_action( 'signup_header', 'rbz_prevent_multisite_signup' );

// Disable ping back scanner and complete xmlrpc class.
add_filter( 'wp_xmlrpc_server_class', '__return_false' );
add_filter('xmlrpc_enabled', '__return_false');

//remove xpingback header
function remove_x_pingback($headers) {
  unset($headers['X-Pingback']);
  return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');

function bif_acf_confirm_row_delete() { ?>
    <script type="text/javascript">
    (function($) {

        acf.add_action('ready', function(){

            $('body').on('click', 'li.acf-fc-show-on-hover a.acf-icon.-minus.small', function( e ){

                return confirm("Do you really want to delete this row?");

            });

        });

    })(jQuery);
    </script>

    <?php
}
add_action('acf/input/admin_head', 'bif_acf_confirm_row_delete');

// gets ubermenu code from acf and parses it
function bif_display_ubermenu() {
    $menuCode = str_replace(array("<?php","?>"), "", get_field('main_navigation_code','options'));
    eval($menuCode);
}
/*
@description
Finds all of the values that are used for a certain checkbox field group and displays them as links in a row.

@param $categoryField
The name of the checkbox field ACF group

@param $postType
The post type we are working with
*/
function bif_display_isotope_categories( $categoryField, $postType ) {
    $categoryList = [];

    $loop = new WP_Query( array( 'post_type' => $postType, 'posts_per_page' => '-1' ) );
    if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post();

            $categories = get_field($categoryField);

            if ( is_array($categories) ) {
                foreach ( $categories as $category ) {

                    if ( !in_array($category, $categoryList) ) {

                        $categoryList[] = $category;

                    }

                }
            }

        endwhile;

    endif;
    wp_reset_postdata();
    ?>
    <li data-filter="*" class="active">All</li>
    <?

    foreach ( $categoryList as $category ) {

        ?>
        <li data-filter=".<?= onlyLetters($category); ?>"><?= $category; ?></li>
        <?
    }
}
function bif_archive_pagination() {
    global $wp_query;

    $big = 999999999; // This needs to be an unlikely integer

    $paginate_links = paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 5,
        'prev_next' => True,
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'type' => 'list'
    ) );

    // Display the pagination if more than one page is found
    if ( $paginate_links ) {
        echo $paginate_links;
    }
}
// redirect attachments to the homepage
function bif_attachment_redirect(){
    global $post;
    if ( is_attachment() ) :
        wp_redirect( '/', 301 );
        exit();
        wp_reset_postdata();
    endif;
}
add_action( 'template_redirect', 'bif_attachment_redirect' );


// The following snippet will update the database's sitename if it's on c9 and if it's incorrect
$url = $_SERVER['SERVER_NAME'] . dirname(__FILE__);
$domain = explode('/',$url);
$domain = $domain[0];
$domain = explode('.',$domain);
$siteName = $domain[0];
if ( $domain[1] == "c9users") :
    if ( get_option('siteurl') !== 'http://'. $siteName .'.c9users.io') :
        update_option( 'siteurl', 'http://'. $siteName .'.c9users.io' );
        update_option( 'home', 'http://'. $siteName .'.c9users.io' );
    endif;
endif;

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
function bif_excerpt_filter( $more ) {
    return '...';
}
add_filter('excerpt_more', 'bif_excerpt_filter');

/* Changed excerpt length to 150 words*/
function bif_excerpt_length($length) {
return 30;
}
add_filter('excerpt_length', 'bif_excerpt_length');
add_filter( 'mce_buttons', 'bif_mce_buttons_1' );
function bif_mce_buttons_1( $buttons ) {
  $buttons = array( 'styleselect', 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', 'removeformat', 'charmap', 'fullscreen' );
  return $buttons;
}

add_filter( 'mce_buttons_2', 'bif_mce_buttons_2' );
function bif_mce_buttons_2( $buttons ) {
  $buttons = array();
  return $buttons;
}
//h
add_filter( 'tiny_mce_before_init', 'bif_mce_init' );
function bif_mce_init( $args ) {
  $style_formats = array(
    array(
      'title' => 'Header 1',
      'format' => 'h1'
    ),
    array(
      'title' => 'Header 2',
      'format' => 'h2'
    ),
    array(
      'title' => 'Header 3',
      'format' => 'h3'
    ),
    array(
      'title' => 'Header 4',
      'format' => 'h4'
    ),
    array(
      'title' => 'Header 5',
      'format' => 'h5'
    ),
    array(
      'title' => 'Header 6',
      'format' => 'h6'
    ),
    array(
      'title' => 'Paragraph',
      'block' => 'p',
      'classes' => false
      ), 
      
      array(
      'title' => 'Large Paragraph',
      'block' => 'p',
      'classes' => 'large'
      ),    
      array(
      'title' => 'Small Paragraph',
      'block' => 'p',
      'classes' => 'small'
      ),
    array(
      'title' => 'Blockquote',
      'format' => 'blockquote',
      'icon' => 'blockquote'
    )
  );


  // Last minute filter for anything more complicated before json_encoded
  $style_formats = apply_filters( 'bif_mce_style_formats', $style_formats );

  $args['style_formats'] = json_encode( $style_formats );

  return $args;
}
/**
 * Example filter to add text style to TinyMCE filter with Mark's "MRW TinyMCE Mods" plugin
 *
 * Adds a "Text Styles" submenu to the "Formats" dropdown
 *
 * This would go in a functions.php file or mu-plugin so you don't have to modify the original plugin.
 *
 * $styles  array   Contains arrays of style_format arguments to define styles.
 *          Note: Should be an "array of arrays"
 *
 * see tinymce.com/wiki.php/Configuration:style_formats
 * see also tinymce.com/wiki.php/Configuration:formats
 * see also also wordpress.stackexchange.com/a/128950/9844
 */


add_editor_style('_engine/css/tiny_mce_editor.css');

if ( function_exists('get_field') ) :
  $typekit = get_field('typekit_id', 'options');

  if ( $typekit ) {
    function bif_typekit() {
      $typekit_code = get_field('typekit_id', 'options');
      wp_enqueue_script( 'bif_typekit', '//use.typekit.net/'.$typekit_code.'.js');
    }
    add_action( 'wp_enqueue_scripts', 'bif_typekit' );

    function bif_typekit_inline() {
      if ( wp_script_is( 'bif_typekit', 'done' ) ) { ?>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <?php }
    }
    add_action( 'wp_head', 'bif_typekit_inline' );
  }
endif;

// Disable Gutenberg
add_filter('use_block_editor_for_post', '__return_false', 10);

// Allows YOAST to manage title tags
add_theme_support( 'title-tag' );



// Saves conditional fields that are hidden through ACF
function my_acf_input_admin_footer() {
  ?>
  <script type="text/javascript">
    (function($) {
      acf.add_action('hide_field', function($field, context) {
        // bail early if not conditional logic (may be tab field)
        if (context !== 'conditional_logic') {
          return;
        }

        // remove disable attr so value gets saved even tho field was hidden
        $field.find(':disabled').removeAttr('disabled');
      });
    })(jQuery);
  </script>
  <?
}
add_action('acf/input/admin_footer', 'my_acf_input_admin_footer');


/***************
REGISTER MENUS
*/
function bif_register_menus() {
  register_nav_menus(
    array(
    'menu-header' => __('Main Menu'),
    'footer-menu-1' => __( 'Footer Menu 1')
    )
  );
}

add_action('init', 'bif_register_menus');

// remove caption width inline css
add_filter( 'img_caption_shortcode_width', '__return_false' );

//Remove Gutenberg Block Library CSS from loading on the frontend
function bif_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'bif_remove_wp_block_library_css', 100 );

//Header Code
function header_code() {
  if ( function_exists('get_field') )
  {
    echo get_field('header_code','options');
  }

}
add_action( 'wp_head', 'header_code', 1);

//Footer Code 
function footer_code() {
  if ( function_exists('get_field') )
  {
    echo get_field('footer_code','options'); 
  }

}
add_action('wp_footer', 'footer_code', 10000);

// Add Tag Manager Script to head.php 
function tag_manager_no_script() {
  if ( function_exists('get_field') )
  {
    echo get_field('tag_manager_script_code','options');
  }
}
add_action( 'wp_head', 'tag_manager_no_script', 1);
