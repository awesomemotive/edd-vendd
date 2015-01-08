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
define( 'VENDD_AUTHOR', 'Sean Davis' );
define( 'VENDD_VERSION', '0.1' );
define( 'VENDD_HOME', '' );


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

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'vendd', get_template_directory() . '/languages' );

	/*
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	// add a hard cropped (for uniformity) image size for singulars
	add_image_size( 'vendd_featured_image', 722, 450, true );
	// add a hard cropped (for uniformity) image size for content lists
	add_image_size( 'vendd_featured_image_thumb', 200, 200, true );
	// add a hard cropped (for uniformity) image size for the product grid
	add_image_size( 'vendd_product_image', 722, 450, true );

	/*
	 * Theme nav menus
	 */
	register_nav_menus( array(
		'main_menu'	=> __( 'Main Menu', 'vendd' ),
		'info_bar'	=> __( 'Info Bar Menu', 'vendd' ),
	) );
	
	/*
	 * Switch default core markup to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'vendd_custom_background_args', array(
		'default-color' => 'f1f1f1',
		'default-image' => /* get_template_directory_uri() . '/inc/images/bg.png' */ '',
	) ) );
}
endif; // vendd_setup
add_action( 'after_setup_theme', 'vendd_setup' );


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
add_action( 'widgets_init', 'vendd_widgets_init' );


/**
 * Enqueue scripts and styles
 */
function vendd_scripts() {
	// Theme stylesheet
	wp_enqueue_style( 'vendd-style', get_stylesheet_uri() );
	// Font Awesome
	wp_enqueue_style( 'vendd-fontawesome', get_template_directory_uri() . '/inc/fonts/font-awesome/css/font-awesome.min.css' );
	// Responsive navigation
	wp_enqueue_script( 'vendd-navigation', get_template_directory_uri() . '/inc/js/navigation.js', array(), VENDD_VERSION, true );
	// parallax background
	if ( 1 == get_theme_mod( 'vendd_parallax_bg' ) ) :
		wp_enqueue_script( 'vendd-parallax', get_template_directory_uri() . '/inc/js/parallax.js', array( 'jquery' ), VENDD_VERSION, true );
	endif;
	// Skip link focus fix
	wp_enqueue_script( 'vendd-skip-link-focus-fix', get_template_directory_uri() . '/inc/js/skip-link-focus-fix.js', array(), VENDD_VERSION, true );
	// Comment reply behavior
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vendd_scripts' );


/**
 * Custom conditional tags
 */
require get_template_directory() . '/inc/conditional-tags.php';


/**
 * Custom EDD functions
 */
if ( vendd_edd_is_activated() ) {
	require get_template_directory() . '/inc/edd-functions.php';
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