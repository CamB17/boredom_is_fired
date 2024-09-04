jQuery(document).ready(function($) {
	var body = $('body');
	var menu_mobile = $('#mobile_menu_wrapper');
	var menu_mobile_container = $('.fm_mobile_menu_container');
	var menu_mobile_trigger_holder = $('.menu_mobile_trigger_holder');
	$(document).click(function(e) {
		// if the mobile menu is active and theres a click outside of it, close it
		if (!menu_mobile.is(e.target) && menu_mobile.has(e.target).length === 0 && body.hasClass('mobile_menu_active')) {
			e.preventDefault();
			body.removeClass('mobile_menu_active');
		}
		// if the mobile menu trigger holder (or something inside of it) is clicked
		else if (menu_mobile_trigger_holder.is(e.target) || menu_mobile_trigger_holder.has(e.target).length > 0) {
			body.toggleClass('mobile_menu_active');
		}
	});
	
	$('button.to_next_level').click(function(e) {
		e.preventDefault();
		let $li_parent = $(this).closest('li');
		$li_parent.find('> ul').addClass('active');
	});
	
	// if a sub level button is clicked, close the sub menu
	$('button.to_prev_level').click(function(e) {
		e.preventDefault();
		let $li_parent = $(this).closest('ul').removeClass('active');
	});
});


