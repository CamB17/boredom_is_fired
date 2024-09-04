jQuery(document).ready(function ($) {
    // clone the header and set up the cloned header to show on scroll
    var $header = $('header');
    // var $header_cloned = $header.clone().addClass('cloned');
    var $body = $('body');
    
    // $header.after($header_cloned);
    // $header_cloned.find('#alert_bar').remove();
    $(window).scroll(function () {
        var distance_from_top = $(window).scrollTop();
        var header_height = $header.outerHeight();
        if (distance_from_top > 150) {
            if ( !$body.hasClass('scrolled') ) {
                $body.addClass('scrolled');
                // $body.css('padding-top', header_height + 'px');
            }
        }
        else {
            if ( $body.hasClass('scrolled') )
            {
                $body.removeClass('scrolled');
                // $body.css('padding-top', '0px');
            }
        }
    });
    
    
    var menu_hover_timeout;
    $("header li.menu_header_item_parent").hover(
        function() {
            
            let $menu_pane = $(this).find('> ul');
            
            if (!menu_hover_timeout) {
                menu_hover_timeout = window.setTimeout(function() {
                    menu_hover_timeout = null;
                    $menu_pane.slideDown(100);
               }, 100);
            }
        },
        function () {
            
            let $menu_pane = $(this).find('> ul');
            
            if (menu_hover_timeout) {
                window.clearTimeout(menu_hover_timeout);
                menu_hover_timeout = null;
            }
            else {
               $menu_pane.slideUp(100);
            }
        }
    );


});
