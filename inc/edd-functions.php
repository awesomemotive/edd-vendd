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