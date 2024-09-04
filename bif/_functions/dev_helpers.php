<?

/*
All of these are defined in the Development plugin, which fires in after_theme_setup (right after functions.php). If you want to run this in functions.php, you'll need to define them here.
*/

function bif_print_r($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}
function apr($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}
function bif_var_dump($val){
        echo '<pre>';
        var_dump($val);
        echo  '</pre>';
}
function avd($val){
        echo '<pre>';
        var_dump($val);
        echo  '</pre>';
}


// this function will output an image field as a bg image at a given size
function bif_get_bg_image($field, $size = "medium", $sub = 0, $options = 0) {
    
    if ( function_exists('get_field') ) {
            
        if ( $sub && $options ) :
            
        elseif ( $sub ) :
            return "style='background-image:url(" . get_sub_field($field)['sizes'][$size] . ");'";
        elseif ( $options ) :
            return "style='background-image:url(" . get_field($field, 'options')['sizes'][$size] . ");'";
        else :
            return "style='background-image:url(" . get_field($field)['sizes'][$size] . ");'";
        endif;
    }
}
// this function is a shortcut for the get_field function


function gf($field_name, $source = null) {
    if ( function_exists('get_field') ) {
        if ( $source ) {
            return get_field($field_name, $source);
        } else {
            return get_field($field_name); 
        }
    }
}
// this function is a shortcut for the get_sub_field function
function gsf($field_name) {
    if ( function_exists('get_field') ) {
        return get_sub_field($field_name);
    }
}
// this function is a shortcut for the get_field function
function tf($field_name, $source = null) {
    if ( function_exists('get_field') ) {
        if ( $source ) {
            echo get_field($field_name, $source);
        } else {
            echo get_field($field_name); 
        }
    }
}
// this function is a shortcut for the get_sub_field function
function tsf($field_name) {
    if ( function_exists('get_field') ) {
        echo get_sub_field($field_name);
    }
}
function ga($a)
{
    if ( is_array($a) && !empty($a) )
    {
        return true;
    }
    return false;
}
function gb($b)
{
    if ( ga($b) && $b['text'] !== "" ) 
    {
        return true;
    }
    return false;
}