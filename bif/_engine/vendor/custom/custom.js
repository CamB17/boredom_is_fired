// add padding to the top of body for the fixed header
jQuery(document).ready(function ($) {
    // Wrap iframes from youtube in div
    $('iframe[src*="youtube"]').wrap("<div class='iframe_wrapper'></div>");
    $(document).on("keypress", function (e) {
        // if you press control + w, this will take you to the login screen and will redirect you back to your current page
        if (e.ctrlKey && (e.which === 23)) {
            window.location.replace("/wp-login.php?redirect_to=" + window.location.pathname);
        }
        // if you press control + e, this will toggle error mode in php by redirecting you to ?e and back
        if (e.ctrlKey && (e.which === 5)) {
            if (window.location.href.indexOf("?e") >= 0) {
                window.location.replace(window.location.origin + window.location.pathname);
            }
            else {
                window.location.replace(window.location.origin + window.location.pathname + "?e");
            }
        }
    });
    $('.gform_wrapper select').select2({
        minimumResultsForSearch: Infinity
    });
    

        		
	$('.magnific_popup').magnificPopup({
      type:'inline',
      midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
    });
        
        	
});
