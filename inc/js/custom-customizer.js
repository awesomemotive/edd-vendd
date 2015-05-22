/**
 * Theme Customizer scripts.
 *
 * @package Vendd
 */
(function($){
	$(document).ready(function() {
		$('.vendd-toggle-description').on('click',function(e){
			e.preventDefault();
			$(this).toggleClass('vendd-description-opened').parents('.customize-control-title').siblings('.vendd-control-description').slideToggle();
		});
	});
})(jQuery);