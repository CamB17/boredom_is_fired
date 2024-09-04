jQuery(document).ready(function ($) {
    $('#alert_bar_close').on('click', function () {
        $alert_bar = $('#alert_bar');
        $alert_bar.slideUp(200);
        let cookie_id = $alert_bar.data('cookie_id');
        console.log(cookie_id);
        Cookies.set(cookie_id, 'closed');
    })
})
