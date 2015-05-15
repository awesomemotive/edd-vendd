<?php
/**
 * functions specific to Easy Digital Downloads
 */

/**
 * Allow comments on downloads
 */
function vendd_edd_add_comments_support( $supports ) {
	$supports[] = 'comments';
	return $supports;	
}
add_filter( 'edd_download_supports', 'vendd_edd_add_comments_support' );


/**
 * No purchase button below download content
 */
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

	
/*
 * If Subtitles plugin is activated, add support for Downloads
 */
function vendd_subtitles() {
	add_post_type_support( 'download', 'subtitles' );
}
add_action( 'init', 'vendd_subtitles' );

	
/*
 * Add HTML to the [downloads] shortcode for structure/styling
 */
function vendd_downloads_shortcode_wrap_open() {
	echo '<div class="vendd-download-information">';
}
add_action( 'edd_download_after_thumbnail', 'vendd_downloads_shortcode_wrap_open' );

function vendd_downloads_shortcode_wrap_close() {
	echo '</div>';
}
add_action( 'edd_download_after', 'vendd_downloads_shortcode_wrap_close' );


/**
 * Add downloads display to the empty cart
 */
function vendd_empty_cart_content( $message ) {
	$empty_cart_title         = get_theme_mod( 'vendd_empty_cart_title' );
	$empty_cart_text          = wpautop( get_theme_mod( 'vendd_empty_cart_text' ) );
	$empty_cart_downloads_qty = intval( get_theme_mod( 'vendd_empty_cart_downloads_count', 6 ) );

	ob_start();

	if ( '' != $empty_cart_title ) {
		echo '<h3 class="entry-title empty-cart-title">' . $empty_cart_title . '</h3>';
	} else {
		echo '<h3 class="entry-title empty-cart-title">' . __( 'Your cart is empty.', 'vendd' ) . '</h3>';
	}

	if ( '' != $empty_cart_text ) {
		echo $empty_cart_text;
	}

	if ( 0 != $empty_cart_downloads_qty ) {
		echo do_shortcode( '[downloads columns="2" number="' . $empty_cart_downloads_qty . '"]' );
	}

	$message = ob_get_clean();
	return $message;
}
add_filter( 'edd_empty_cart_message', 'vendd_empty_cart_content' );