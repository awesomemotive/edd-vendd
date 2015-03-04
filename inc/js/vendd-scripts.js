( function( $ ) {
	$( ".vendd-show-button" ).on( "click", function(e){
		var postList = $( this ).siblings( ".vendd-price-button-container" );
		if ( postList.css( "display" ) == "none" ) {
			postList.slideDown();
			$( ".vendd-show-button" ).addClass( "vendd-price-button-displayed" );
		} else if (postList.css( "display" ) == "block" ) {
			postList.slideUp();
			$( ".vendd-show-button" ).removeClass( "vendd-price-button-displayed" );
		}
		return false;
	});
})(jQuery);