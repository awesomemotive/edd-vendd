<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Vendd
 */


/**
 * Add support for excerpts on pages.
 */
function vendd_download_excerpts() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'vendd_download_excerpts' );


/**
 * Set excerpt length
 */
function custom_excerpt_length( $length ) {
	return 35;
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
 * Removes Page Templates from Add/Edit Page screen based on plugin activation
 *
 * @return array
 */
function vendd_page_template_conditions( $page_templates ) {
	if ( ! vendd_fes_is_activated() ) {
		unset( $page_templates['fes_templates/fes-dashboard.php'] );
		unset( $page_templates['fes_templates/fes-vendor.php'] );
	}
	if ( ! vendd_edd_is_activated() ) {
		unset( $page_templates['edd_templates/edd-checkout.php'] );
		unset( $page_templates['edd_templates/edd-confirmation.php'] );
		unset( $page_templates['edd_templates/edd-failed.php'] );
		unset( $page_templates['edd_templates/edd-history.php'] );
		unset( $page_templates['edd_templates/edd-members.php'] );
		unset( $page_templates['edd_templates/edd-downloads-shortcode.php'] );
	}
	return $page_templates;
}
add_filter( 'theme_page_templates', 'vendd_page_template_conditions' );


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

	// Adds class based on HTML structure
	if ( 1 == get_theme_mod( 'vendd_full_width_html', 0 ) ) {
		$classes[] = 'vendd-full-width-html-structure';
	}

	// Adds classes based on template
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'front-page';
	}

	if ( is_search() && 1 == get_theme_mod( 'vendd_advanced_search_results', 0 ) ) {
		// Adds class based on empty EDD cart
		$classes[] = 'vendd-advanced-search-results';
	}

	if ( vendd_edd_is_activated() ) {
		// Adds classes based on EDD page template
		if ( is_page_template( 'edd_templates/edd-downloads-shortcode.php' ) ) {
			$classes[] = 'vendd-downloads-template vendd-edd-template';
		} elseif ( is_page_template( 'edd_templates/edd-checkout.php' ) ) {
			$classes[] = 'vendd-checkout-template vendd-edd-template';
		} elseif ( is_page_template( 'edd_templates/edd-confirmation.php' ) ) {
			$classes[] = 'vendd-confirmation-template vendd-edd-template';
		} elseif ( is_page_template( 'edd_templates/edd-history.php' ) ) {
			$classes[] = 'vendd-history-template vendd-edd-template';
		} elseif ( is_page_template( 'edd_templates/edd-members.php' ) ) {
			$classes[] = 'vendd-members-template vendd-edd-template';
		} elseif ( is_page_template( 'edd_templates/edd-failed.php' ) ) {
			$classes[] = 'vendd-failed-template vendd-edd-template';
		}

		if ( defined( 'EDD_VERSION' ) && version_compare( EDD_VERSION, '3.0-beta1', '<' ) ) {
			$classes[] = 'vendd-pre-edd3';
		}
	}

	if ( is_page_template( 'page_templates/landing.php' ) ) {
		$classes[] = 'vendd-landing-page-template';
	} elseif ( is_page_template( 'page_templates/full-width.php' ) ) {
		$classes[] = 'vendd-full-width-page-template';
	} elseif ( is_page_template( 'page_templates/focus.php' ) ) {
		$classes[] = 'vendd-focus-page-template';
	}

	if ( vendd_edd_is_activated() && false === edd_get_cart_contents() ) {
		// Adds class based on empty EDD cart
		$classes[] = 'vendd-empty-cart';
	}

	if ( vendd_fes_is_activated() ) {
		// Adds classes based on FES page template
		if ( is_page_template( 'fes_templates/fes-dashboard.php' ) ) {
			$classes[] = 'vendd-fes-dashboard-template vendd-edd-template vendd-fes-template';
		} elseif ( is_page_template( 'fes_templates/fes-vendor.php' ) ) {
			$classes[] = 'vendd-fes-vendor-template vendd-edd-template';
		}
	}

	// Adds class based on whether or not is has a sidebar
	if (	is_page_template( 'edd_templates/edd-checkout.php' ) ||
			is_page_template( 'edd_templates/edd-confirmation.php' ) ||
			is_page_template( 'edd_templates/edd-history.php' ) ||
			is_page_template( 'edd_templates/edd-members.php' ) ||
			is_page_template( 'edd_templates/edd-failed.php' ) ||
			is_page_template( 'fes_templates/fes-vendor.php' ) ||
			is_post_type_archive( 'download' ) ||
			is_404() ) {
		$classes[] = 'vendd-no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'vendd_body_classes' );


/**
 * Add Social Network URL Fields to User Profile
 */
function vendd_add_social_profiles( $contactmethods ) {

	$contactmethods['twitter_profile']	= __( 'Twitter Profile URL', 'vendd' );
	$contactmethods['facebook_profile']	= __( 'Facebook Profile URL', 'vendd' );
	$contactmethods['gplus_profile']	= __( 'Google Plus Profile URL', 'vendd' );
	$contactmethods['youtube_profile']	= __( 'YouTube Profile URL', 'vendd' );

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'vendd_add_social_profiles', 10, 1 );


/**
 * Filters posts_orderby to display advanced search results
 */
function vendd_advanced_search_results( $orderby, $query ) {
	global $wpdb;

	if ( $query->is_search && ( class_exists( 'bbPress' ) && ! is_bbpress() ) ) {
		return $wpdb->posts . '.post_type ASC';
	}
	return $orderby;
}
add_filter( 'posts_orderby', 'vendd_advanced_search_results', 10, 2 );


/**
 * Number of search results to show
 */
function vendd_search_filter( $query ) {
	if ( $query->is_search && ! is_admin() && ( class_exists( 'bbPress' ) && ! is_bbpress() ) ) {
		$query->set( 'posts_per_page', 99999 );
	}
	return $query;
}
add_filter( 'pre_get_posts', 'vendd_search_filter' );


/**
 * social profiles
 *
 * @since 1.1.5
 */
function vendd_social_profiles() {
	if ( get_theme_mod( 'vendd_twitter' ) ||
		 get_theme_mod( 'vendd_facebook' ) ||
		 get_theme_mod( 'vendd_googleplus' ) ||
		 get_theme_mod( 'vendd_github' ) ||
		 get_theme_mod( 'vendd_instagram' ) ||
		 get_theme_mod( 'vendd_tumblr' ) ||
		 get_theme_mod( 'vendd_linkedin' ) ||
		 get_theme_mod( 'vendd_youtube' ) ||
		 get_theme_mod( 'vendd_pinterest' ) ||
		 get_theme_mod( 'vendd_dribbble' ) ||
		 get_theme_mod( 'vendd_wordpress' ) ||
		 get_theme_mod( 'vendd_etsy' ) ) :
	?>
		<span class="social-links">
			<?php
				$social_profiles = array(
					'twitter'    => array(
						'class'  => 'vendd-twitter',
						'icon'   => '<i class="fa fa-twitter-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_twitter' ) )
					),
					'facebook'   => array(
						'class'  => 'vendd-facebook',
						'icon'   => '<i class="fa fa-facebook-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_facebook' ) )
					),
					'googleplus' => array(
						'class'  => 'vendd-googleplus',
						'icon'   => '<i class="fa fa-google-plus-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_googleplus' ) )
					),
					'github'     => array(
						'class'  => 'vendd-github',
						'icon'   => '<i class="fa fa-github-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_github' ) )
					),
					'instagram'  => array(
						'class'  => 'vendd-instagram',
						'icon'   => '<i class="fa fa-instagram"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_instagram' ) )
					),
					'tumblr'     => array(
						'class'  => 'vendd-tumblr',
						'icon'   => '<i class="fa fa-tumblr-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_tumblr' ) )
					),
					'linkedin'   => array(
						'class'  => 'vendd-linkedin',
						'icon'   => '<i class="fa fa-linkedin-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_linkedin' ) )
					),
					'youtube'    => array(
						'class'  => 'vendd-youtube',
						'icon'   => '<i class="fa fa-youtube"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_youtube' ) )
					),
					'slack'      => array(
						'class'  => 'vendd-slack',
						'icon'   => '<i class="fa fa-slack" aria-hidden="true"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_slack' ) )
					),
					'pinterest'  => array(
						'class'  => 'vendd-pinterest',
						'icon'   => '<i class="fa fa-pinterest-square"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_pinterest' ) )
					),
					'dribbble'   => array(
						'class'  => 'vendd-dribbble',
						'icon'   => '<i class="fa fa-dribbble"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_dribbble' ) )
					),
					'wordpress'  => array(
						'class'  => 'vendd-wordpress',
						'icon'   => '<i class="fa fa-wordpress"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_wordpress' ) )
					),
					'etsy'       => array(
						'class'  => 'vendd-etsy',
						'icon'   => '<i class="fa fa-etsy" aria-hidden="true"></i>',
						'option' => esc_url( get_theme_mod( 'vendd_etsy' ) )
					),
				);
				foreach ( $social_profiles as $profile ) {
					if ( '' != $profile[ 'option' ] ) :
						echo '<a class="', $profile[ 'class' ], '" href="', $profile[ 'option' ], '">', $profile[ 'icon' ], '</a>';
					endif;
				}
			?>
		</span>
	<?php
	endif; // end check for any social profile
}
add_action( 'vendd_social_profiles', 'vendd_social_profiles' );


/**
 * Render document title for backwards compatibility
 *
 * @resource https://make.wordpress.org/core/2015/10/20/document-title-in-4-4/
 * @since 1.1.4
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function vendd_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'vendd_render_title' );
}


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
