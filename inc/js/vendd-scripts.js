/**
 * Handles the [downloads] shortcode purchase button display
 *
 * @package Vendd
 */
(function($){
	$(document).ready(function(){
		$('.vendd-show-button').on('click',function(e){
			e.preventDefault();
			$(this).toggleClass('vendd-price-button-displayed').siblings('.vendd-price-button-container').slideToggle();
			$(this).parents('.edd_download').siblings().find('.vendd-price-button-container').slideUp().prev('.vendd-show-button').toggleClass('vendd-price-button-displayed');
		});
		var body = $(document.body);
		var header_cart_total = $('.header-cart-total');
		body.on('edd_cart_item_added',function(event, response){
			header_cart_total.html(response.subtotal);
		});
		body.on('edd_cart_item_removed',function(event, response){
			header_cart_total.html (response.subtotal);
		});
	});
})(jQuery);