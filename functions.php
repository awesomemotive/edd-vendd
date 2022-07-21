<?php
/**
 * Vendd functions and definitions
 *
 * @package Vendd
 */


/**
 * Constants and important files
 */
define( 'VENDD_NAME', 'Vendd' );
define( 'VENDD_AUTHOR', 'Easy Digital Downloads' );
define( 'VENDD_VERSION', '1.2.7' );
define( 'VENDD_HOME', 'https://easydigitaldownloads.com/downloads/vendd' );


if ( ! function_exists( 'vendd_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features
 */
function vendd_setup() {
	global $content_width;

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = 722; /* pixels */
	}

	/**
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'vendd', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	// add a hard cropped (for uniformity) image size for posts & some pages
	add_image_size( 'vendd_featured_image', 722, 361, true );
	// add a hard cropped (for uniformity) image size for full width pages
	add_image_size( 'vendd_featured_image_full_width', 1120, 361, true );
	// add a hard cropped (for uniformity) image size for content lists
	add_image_size( 'vendd_featured_image_thumb', 200, 200, true );
	// add a hard cropped (for uniformity) image size for the single downloads
	add_image_size( 'vendd_product_image', 722, 361, true );
	// add a hard cropped (for uniformity) image size for the product grid
	add_image_size( 'vendd_downloads_shortcode_grid_image', 520, 260, true );

	/**
	 * Theme nav menus
	 */
	register_nav_menus( array(
		'info_bar'	=> __( 'Information Bar Menu', 'vendd' ),
		'main_menu'	=> __( 'Main Menu', 'vendd' ),
	) );

	/**
	 * Switch default core markup to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'vendd_custom_background_args', array(
		'default-color' => 'f1f1f1',
		'default-image' => /* get_template_directory_uri() . '/inc/images/your_image.png' */ '',
	) ) );

	/**
	 * Add theme support for title tag
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Split [downloads] taxonomy display into separate settings
	 */
	if ( get_theme_mod( 'vendd_downloads_taxonomies' ) ) {
		set_theme_mod( 'vendd_downloads_cats', 1 );
		set_theme_mod( 'vendd_downloads_tags', 1 );
		remove_theme_mod( 'vendd_downloads_taxonomies' );
	}
}
endif; // vendd_setup
add_action( 'after_setup_theme', 'vendd_setup' );


/**
 * Add search to main menu
 */
function vendd_main_menu_search_form( $items, $location ) {
	if ( 'main_menu' == $location->theme_location && 1 == get_theme_mod( 'vendd_menu_search' ) ) {
		$items .= '<li class="nav-search-form-list-item"><span class="nav-search-form"><a class="nav-search-anchor" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>' . get_search_form( false ) . '</span></li>';
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'vendd_main_menu_search_form', 10, 2 );


/**
 * Register widget area
 */
function vendd_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'vendd' ),
		'id'            => 'sidebar-main',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
	// only register download sidebar if EDD is activated
	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		register_sidebar( array(
			'name'          => __( 'Download Sidebar', 'vendd' ),
			'id'            => 'sidebar-download',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',
		) );
	}
}
add_action( 'widgets_init', 'vendd_widgets_init' );


/**
 * Enqueue scripts and styles
 */
function vendd_scripts() {

	// Theme stylesheet
	wp_enqueue_style( 'vendd-style', get_stylesheet_uri() );

	// Font Awesome
	wp_enqueue_style( 'vendd-fontawesome', get_template_directory_uri() . '/inc/fonts/font-awesome/css/font-awesome.min.css', array(), VENDD_VERSION, 'all' );

	// Vendd scripts
	wp_enqueue_script( 'vendd-scripts', get_template_directory_uri() . '/inc/js/vendd-scripts.js', array( 'jquery' ), VENDD_VERSION, true );

	// parallax background
	if ( 1 == get_theme_mod( 'vendd_parallax_bg' ) ) :
		wp_enqueue_script( 'vendd-parallax', get_template_directory_uri() . '/inc/js/parallax.js', array( 'jquery' ), VENDD_VERSION, true );
	endif;

	// Comment reply behavior
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vendd_scripts' );


/**
 * Admin page
 */
function vendd_updater() {
	require( get_template_directory() . '/inc/admin/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'vendd_updater' );


/**
 * Custom conditional tags
 */
require get_template_directory() . '/inc/conditional-tags.php';

/**
 * Custom EDD functions
 *
 * Only require if Easy Digital Downloads is activated
 */
if ( vendd_edd_is_activated() ) {
	require get_template_directory() . '/inc/edd-functions.php';
}

/**
 * Custom FES for EDD functions
 *
 * Only require if Frontend Submissions for Easy Digital Downloads is activated
 */
if ( vendd_fes_is_activated() ) {
	require get_template_directory() . '/inc/fes-functions.php';
}

/**
 * Vendd's widgets
 */
if ( vendd_edd_is_activated() ) {
	require get_template_directory() . '/inc/admin/widgets.php';
}

/**
 * Custom template tags
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';
