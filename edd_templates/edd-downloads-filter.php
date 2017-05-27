<?php
/*
 * Template name: FacetWP
 */
get_header();

if ( function_exists( 'FWP' ) ) {
	echo facetwp_display( 'facet', 'categories' );
	echo facetwp_display( 'template', 'downloads' );
	echo facetwp_display( 'pager' );
}

get_footer();