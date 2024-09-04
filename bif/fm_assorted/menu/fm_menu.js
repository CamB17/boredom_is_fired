jQuery(document).ready(function($) {

    let $nav_container = $('.nav_and_search .nav');

    $('.primary_menu_item').each(function() {
        $(this).hover(
            function() {

                $nav_container.addClass('sub_item_hovered');
                $('.primary_menu_item').removeClass('hovered');
                $(this).addClass('hovered');
            },
            function() {
                $nav_container.removeClass('sub_item_hovered');
                $('.primary_menu_item').removeClass('hovered');

            }
        );
    })

});
