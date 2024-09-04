jQuery(document).ready(function ($) {
    $('.fm_content_section .slideshow').each(function () {
        let number_of_slides = $(this).find('.slide').length;
        if (number_of_slides > 1) {
            let slick = $(this).slick({
                arrows: true,
                autoplay: false,
                dots: true,
                rows: 0
            });
        }
    })
});
