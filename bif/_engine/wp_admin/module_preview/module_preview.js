jQuery(document).ready(function ($) {
    $('body').on('click', '.trigger_module_preview', function (t) {
        var e = $(this),
            i = $("form#post"),
            a = $("input#wp-preview"),
            n = e.attr("target") || "wp-preview",
            s = navigator.userAgent.toLowerCase();
            
            let module_id = $(this).data('id');
            
            if ( $('#module_id').length )
            {
                $('#module_id').val(module_id);
                
            }
            else
            {
                i.prepend("<input type='hidden' id='module_id' name='module_id' value='" + module_id + "'>");
                console.log(module_id);
            }
            
        t.preventDefault(),
            e.hasClass("disabled") || (wp.autosave && wp.autosave.server.tempBlockSave(), a.val("dopreview"), i.attr("target", n).trigger("submit").attr("target", ""), -1 !== s.indexOf("safari") && -1 === s.indexOf("chrome") && i.attr("action", function (t, e) {

                return e + "?t=" + (new Date).getTime();
            }), a.val(""))
    });
    
    
    let $pb_fields = $('.acf-field[data-name="page_builder"]');
    let $layouts = $pb_fields.find('> .acf-input > .acf-flexible-content > .values > .layout');
    
    $layouts.each(function() {
        let module_id = $(this).data('id');
        
        console.log(module_id);
        
        // add preview icon to the layout row
        let $gear_icon = $(this).find('.acf-icon.dashicons-admin-generic').first();
        let $controls_container = $(this).find('> .acf-fc-layout-controls').first();
        let $cloned_icon = $gear_icon.clone().removeClass('dashicons-admin-generic').addClass('dashicons-visibility trigger_module_preview').attr('title', 'Preview Module').data('id', module_id).removeAttr('data-acfe-flexible-settings').removeData('acfe-flexible-settings').css('visibility','visible');
        $cloned_icon.insertBefore($gear_icon);
        
        let $modal_wrapper = $(this).find('.acfe-modal-wrapper');
        let $preview_button = $('<div class="button button-primary trigger_module_preview">Preview Module</div>').data('id', module_id);
        $preview_button.appendTo($modal_wrapper);
        
    });
});