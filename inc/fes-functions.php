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

	return EDD_FES()->vendors->get_vendor_store_url( $author->ID );
}


/**
 * filter download comment author avatar size in FES dashboard
 */
function vendd_comment_author_image_size( $size ) {
	return 75;
}
add_filter( 'fes_get_avatar_size_comment_author_image', 'vendd_comment_author_image_size' );


/**
 * check for FES shortcodes and add post classes
 */
function vendd_fes_shortcodes_classes( $classes ) {
	global $post;

	if ( is_a( $post, 'WP_Post' ) &&
		! is_page_template( 'fes_templates/fes-dashboard.php' ) &&
		has_shortcode( $post->post_content, 'fes_vendor_dashboard' ) ||
		has_shortcode( $post->post_content, 'fes_login_registration_form' ) ||
		has_shortcode( $post->post_content, 'fes_submission_form' ) ||
		has_shortcode( $post->post_content, 'fes_profile_form' ) ||
		has_shortcode( $post->post_content, 'fes_login_form' ) ||
		has_shortcode( $post->post_content, 'fes_registration_form' ) ||
		has_shortcode( $post->post_content, 'fes_vendor_contact_form' )
	) {
		$classes[] = 'vendd-edd-fes-shortcode';
	}

	return $classes;
}
add_filter( 'post_class', 'vendd_fes_shortcodes_classes' );


/**
 * filter document title on FES vendor store pages
 */
function vendd_vendor_store_title( $title ) {
	$page_id = EDD_FES()->helper->get_option( 'fes-vendor-page', false );

	if ( is_page( $page_id ) ) {

		// translators: %1$s vendor store name, %2$s website name
		$title = sprintf( __( '%1$s on %2$s', 'vendd' ), $title, get_bloginfo( 'name' ) );
	}

	return $title;
}
add_filter( 'pre_get_document_title', 'vendd_vendor_store_title', 99999 );