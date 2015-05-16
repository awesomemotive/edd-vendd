<?php
/**
 * functions specific to Frontend Submissions for Easy Digital Downloads
 *
 * @package Vendd
 */
 
 
/**
 * get the FES vendor URL
 */
function vendd_edd_fes_author_url( $author = null ) {
 
	if ( ! $author ) {
		$author = wp_get_current_user();
	} else {
		$author = new WP_User( $author );
	}

	if ( ! class_exists( 'EDD_Front_End_Submissions' ) ) {
		return get_author_posts_url( $author->ID, $author->user_nicename );
	}

	return FES_Vendors::get_vendor_store_url( $author->ID );
}

/**
 * filter download comment author avatar size in FES dashboard
 */
function vendd_comment_author_image_size( $size ) {
	return 75;
}
add_filter( 'fes_get_avatar_size_comment_author_image', 'vendd_comment_author_image_size' );