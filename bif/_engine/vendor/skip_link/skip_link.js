jQuery(document).ready(function($) {
    let $body = $('body');
    let $element_after_header = $('header').next('section');

    $element_after_header.attr('id', 'main_content');
    $body.prepend("<span class='bg_light'><a id='skip_to_content' class='show-on-focus fm_button primary' href='#main_content'>Skip to content</a></span>");

});
