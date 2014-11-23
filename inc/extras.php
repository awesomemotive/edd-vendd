<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Vendd
 */


/**
 * Add support for excerpts on pages
 */
function vendd_download_excerpts() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'vendd_download_excerpts' );


/**
 * Set excerpt length
 */
function custom_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


/**
 * Replace excerpt ellipses with new ellipses and link to full article
 */
function vendd_excerpt_more( $more ) {
	return '...</p><p class="continue-reading"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . get_theme_mod( 'vendd_read_more', __( 'Continue reading', 'vendd' ) ) . ' &rarr;</a></p>';
}
add_filter( 'excerpt_more', 'vendd_excerpt_more' );


/**
 * Only show regular posts in search results. Also account for the bbPress search form.
 */
function vendd_search_filter( $query ) {
	if ( $query->is_search && ! is_admin() && ( class_exists( 'bbPress' ) && ! is_bbpress() ) ) {
		$query->set( 'post_type', 'post' );
	}
	return $query;
}
add_filter( 'pre_get_posts','vendd_search_filter' );


/**
 * stupid skip link thing with the more tag -- remove it -- NOW
 */
function vendd_remove_more_tag_link_jump( $link ) {
	$offset = strpos( $link, '#more-' );	
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}	
	if ( $end ) {
		$link = substr_replace( $link, '', $offset, $end-$offset );
	}
	return $link;
} 
add_filter( 'the_content_more_link', 'vendd_remove_more_tag_link_jump' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function vendd_body_classes( $classes ) {
	global $post;

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	// Adds classes based on template
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'front-page';
	}
	
	// Adds classes based on EDD page template
	if ( is_page_template( 'edd_templates/edd-store-front.php' ) ) :		
		$classes[] = 'edd-store-front-template vendd-edd-template';
	elseif ( is_page_template( 'edd_templates/edd-checkout.php' ) ) :		
		$classes[] = 'edd-checkout-template vendd-edd-template';	
	elseif ( is_page_template( 'edd_templates/edd-confirmation.php' ) ) :		
		$classes[] = 'edd-confirmation-template vendd-edd-template';
	elseif ( is_page_template( 'edd_templates/edd-history.php' ) ) :		
		$classes[] = 'edd-history-template vendd-edd-template';
	elseif ( is_page_template( 'edd_templates/edd-members.php' ) ) :		
		$classes[] = 'edd-members-template vendd-edd-template';
	elseif ( is_page_template( 'edd_templates/edd-failed.php' ) ) :		
		$classes[] = 'edd-failed-template vendd-edd-template';
	endif;
	
	// Adds classes to blogs based on main sidebar use.
	if (	is_page_template( 'edd_templates/edd-checkout.php' ) ||
			is_page_template( 'edd_templates/edd-confirmation.php' ) ||
			is_page_template( 'edd_templates/edd-history.php' ) ||
			is_page_template( 'edd_templates/edd-members.php' ) ||
			is_page_template( 'edd_templates/edd-failed.php' ) ||
			is_post_type_archive( 'download' ) ) {
		$classes[] = 'vendd-no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'vendd_body_classes' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function vendd_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'vendd' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'vendd_wp_title', 10, 2 );


/**
 * Sets the authordata global when viewing an author archive.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function vendd_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'vendd_setup_author' );