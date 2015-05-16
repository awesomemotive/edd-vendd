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
})(jQuery);