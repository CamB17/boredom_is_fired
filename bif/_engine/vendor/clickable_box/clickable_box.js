/*
Using this code will make a full box clickable
1. put the class "clickable_box" on the element holding the box
2. if there's an A tag inside of clickable box, that href will be used

for an example, see the fm_article_box
*/
jQuery(document).ready(function ($) {
    $('body').on('click', '.clickable_box', function (e) {
        const box = $(this);
        const a_tag = box.find("a:first");
        const no_text_selected = !window.getSelection().toString();
        let href = null;
        
        if (a_tag) {
            href = a_tag.attr('href');
            if (no_text_selected && href) {
                a_tag[0].click();
            }
        }
    });
    
    // check each clickable box for a link. if none, change the cursor
    $('.clickable_box').each(function() {
        let href = $(this).find("a:first");
        if ( !href.length )
        {
            $(this).css('cursor','initial');
        }
    });
});
