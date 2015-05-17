/**
 * Handles the [downloads] shortcode purchase button display
 *
 * @package Vendd
 */
( function( $ ) {
	$( ".vendd-show-button" ).on( "click", function(e){
		var purchaseButton = $( this ).siblings( ".vendd-price-button-container" );
		if ( purchaseButton.css( "display" ) == "none" ) {
			purchaseButton.slideDown();
			$( this ).addClass( "vendd-price-button-displayed" );
		} else if (purchaseButton.css( "display" ) == "block" ) {
			purchaseButton.slideUp();
			$( this ).removeClass( "vendd-price-button-displayed" );
		}
		return false;
	});

	var header_cart_total = $('.header-cart-total');

	$('body').on('edd_cart_item_added', function (event, response) {
		header_cart_total.html( response.subtotal );
	});

	$('body').on('edd_cart_item_removed', function (event, response) {
		header_cart_total.html (response.subtotal);
	});

})(jQuery);