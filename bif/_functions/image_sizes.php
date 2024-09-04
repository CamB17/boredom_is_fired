<?php
function bif_custom_images() {
  add_theme_support('post-thumbnails');
  // add_image_size('blog-post', 600, 370, true );
  // add_image_size('portrait-medium', 600, 800, true);
  // add_image_size('split-section', 1000, 550, true);
  // add_image_size('mainstage-image', 1600, 1000, true);
  // add_image_size('small-square', 500, 500, true);
}
add_action( 'after_setup_theme', 'bif_custom_images' );

/**
How to use Fly Dynamic Image Size function
Get the image ID either through an array or by returning the ID directly
$image_id = get_sub_field('image')["ID"];
Using the fly_get_attachment_image_src() function, pass the image ID, then an array of the dynamic dimensions (this example will create an image size of 1000x600 pixels),
then a hard crop boolean. This returns an array with 'src' being the first key/value pair
$image_source = fly_get_attachment_image_src( $image_id, array( 1000, 600 ), true )['src'];
**/