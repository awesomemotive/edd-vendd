<?php
/**
 * Vendd Customizer
 *
 * @package Vendd
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function vendd_customize_register( $wp_customize ) {
	global $edd_options;

	/** ===============
	 * Extends controls class to add textarea with description
	 */
	class Vendd_WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public $description = '';
		public function render_content() { ?>
	
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
			<textarea rows="5" style="width:98%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	
		<?php }
	}

	/** ===============
	 * Extends controls class to add descriptions to text input controls
	 */
	class Vendd_WP_Customize_Text_Control extends WP_Customize_Control {
		public $type = 'customtext';
		public $description = '';
		public function render_content() { ?>
		
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		</label>
		
		<?php }
	}

	/** ===============
	 * Extends controls class to add descriptions to color picker controls
	 */
	class Vendd_WP_Customize_Color_Control extends WP_Customize_Control {
		public $type = 'color';
		public $description = '';
		public $statuses;
		public function __construct( $manager, $id, $args = array() ) {
			$this->statuses = array( '' => __('Default') );
			parent::__construct( $manager, $id, $args );
		}
		public function enqueue() {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}
		public function to_json() {
			parent::to_json();
			$this->json['statuses'] = $this->statuses;
		}
		public function render_content() {
			$this_default = $this->setting->default;
			$default_attr = '';
			if ( $this_default ) {
				if ( false === strpos( $this_default, '#' ) )
					$this_default = '#' . $this_default;
				$default_attr = ' data-default-color="' . esc_attr( $this_default ) . '"';
			}
			// The input's value gets set by JS. Don't fill it.
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<div class="control-description"><?php echo esc_html( $this->description ); ?></div>
				<div class="customize-control-content">
					<input class="color-picker-hex" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value' ); ?>"<?php echo $default_attr; ?> />
				</div>
			</label>
			<?php
		}
	}

	/** ===============
	 * Site Title (Logo) & Tagline
	 */
	// section adjustments
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Title (Logo) & Tagline', 'vendd' );
	$wp_customize->get_section( 'title_tagline' )->priority = 10;

	// site title
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_control( 'blogname' )->priority = 10;

	// logo uploader
	$wp_customize->add_setting( 'vendd_logo', array( 'default' => null ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vendd_logo', array(
		'label'		=> __( 'Custom Site Logo (replaces title)', 'vendd' ),
		'section'	=> 'title_tagline',
		'settings'	=> 'vendd_logo',
		'priority'	=> 20
	) ) );

	// site tagline
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';	
	$wp_customize->get_control( 'blogdescription' )->priority = 30;
	
	// hide the tagline?
	$wp_customize->add_setting( 'vendd_hide_tagline', array( 
		'default'			=> 0,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'vendd_hide_tagline', array(
		'label'		=> __( 'Hide Tagline', 'vendd' ),
		'section'	=> 'title_tagline',
		'priority'	=> 40,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Design Options
	 */
	$wp_customize->add_section( 'vendd_design', array(
    	'title'       	=> __( 'Vendd Design', 'vendd' ),
		'description' 	=> __( 'Control the primary design color of your site.', 'vendd' ),
		'priority'   	=> 20,
	) );
	
	// design color	
	$wp_customize->add_setting( 'vendd_design_color', array(
		'default'		=> '#428bca',
		'type'			=> 'option', 
		'capability'	=> 'edit_theme_options',
	) );		
	$wp_customize->add_control( new Vendd_WP_Customize_Color_Control( $wp_customize, 'vendd_design_color', array(
		'label'		=> __( 'Primary Design Color', 'vendd' ), 
		'section'	=> 'vendd_design',
		'priority'	=> 20
	) ) );
	
	/**
	 * restructure the default Colors section/control
	 */
	// get rid of the default Colors section
	$wp_customize->remove_section( 'colors' );
		// move Colors option to vendd custom section
		$wp_customize->get_control( 'background_color' )->section = 'vendd_design';
		// change the Colors label
		$wp_customize->get_control( 'background_color' )->label = __( 'Full Site Background Color', 'vendd' );
		// put Colors option in a logical spot
		$wp_customize->get_control( 'background_color' )->priority = 40;
		
	/**
	 * restructure the default Background Image section
	 */
	// get rid of the default Background Image section
	$wp_customize->remove_section( 'background_image' );
		// move Background Image uploader to vendd custom section
		$wp_customize->get_control( 'background_image' )->section = 'vendd_design';
		// change the Background Image label
		$wp_customize->get_control( 'background_image' )->label = __( 'Full Site Background Image', 'vendd' );
		// put Background Image uploader in a logical spot
		$wp_customize->get_control( 'background_image' )->priority = 50;
		
	// parallax background image
	$wp_customize->add_setting( 'vendd_parallax_bg', array( 
		'default'			=> 0,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'vendd_parallax_bg', array(
		'label'		=> __( 'Enable Parallax Background Effect', 'vendd' ),
		'section'	=> 'vendd_design',
		'priority'	=> 60,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Content Options
	 */
	$wp_customize->add_section( 'vendd_content_section', array(
    	'title'       	=> __( 'Content Options', 'vendd' ),
		'description' 	=> __( 'Adjust the display of content on your website. All options have a default value that can be left as-is but you are free to customize.', 'vendd' ),
		'priority'   	=> 30,
	) );
	
	// post content
	$wp_customize->add_setting( 'vendd_post_content', array( 
		'default'			=> 1,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'vendd_post_content', array(
		'label'		=> __( 'Display Post Excerpts', 'vendd' ),
		'section'	=> 'vendd_content_section',
		'priority'	=> 10,
		'type'      => 'checkbox',
	) );
	
	// read more link
	$wp_customize->add_setting( 'vendd_read_more', array( 
		'default'			=> __( 'Continue reading', 'vendd' ),
		'sanitize_callback'	=> 'vendd_sanitize_text' 
	) );		
	$wp_customize->add_control( new Vendd_WP_Customize_Text_Control( $wp_customize, 'vendd_read_more', array(
	    'label' 	=> __( 'Excerpt & More Link Text', 'vendd' ),
	    'section' 	=> 'vendd_content_section',
		'priority'	=> 20,
	) ) );
	
	// show featured images on feed?
	$wp_customize->add_setting( 'vendd_feed_featured_image', array( 
		'default'			=> 1,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'vendd_feed_featured_image', array(
		'label'		=> __( 'Show Featured Images in Post Listings', 'vendd' ),
		'section'	=> 'vendd_content_section',
		'priority'	=> 30,
		'type'      => 'checkbox',
	) );
	
	// show featured images on posts?
	$wp_customize->add_setting( 'vendd_single_featured_image', array( 
		'default'			=> 1,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'vendd_single_featured_image', array(
		'label'		=> __( 'Show Featured Images on Single Posts', 'vendd' ),
		'section'	=> 'vendd_content_section',
		'priority'	=> 40,
		'type'      => 'checkbox',
	) );
	
	// comments on pages?
	$wp_customize->add_setting( 'vendd_page_comments', array( 
		'default'			=> 0,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
	) );
	$wp_customize->add_control( 'vendd_page_comments', array(
		'label'		=> __( 'Enable Comments on Standard Pages', 'vendd' ),
		'section'	=> 'vendd_content_section',
		'priority'	=> 50,
		'type'      => 'checkbox',
	) );
	
	// Information Bar text
	$wp_customize->add_setting( 'vendd_info_bar', array(
		'default'			=> null,
		'sanitize_callback'	=> 'vendd_sanitize_textarea_lite',
	) );
	$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_info_bar', array(
		'label'			=> __( 'Information Bar Text', 'vendd' ),
		'section'		=> 'vendd_content_section',
		'priority'		=> 60,
		'description'	=> __( 'This text appears at the very top of your site aligned to the left. Allowed tags:', 'vendd' ) . ' <a>, <span>, <em>, <strong>',
	) ) );	
	
	// credits & copyright
	$wp_customize->add_setting( 'vendd_credits_copyright', array(
		'default'			=> null,
		'sanitize_callback'	=> 'vendd_sanitize_textarea',
	) );
	$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_credits_copyright', array(
		'label'			=> __( 'Footer Credits & Copyright', 'vendd' ),
		'section'		=> 'vendd_content_section',
		'priority'		=> 70,
		'description'	=> __( 'Displays site title, tagline, copyright, and year by default. Allowed tags: ', 'vendd' ) . ' <img>, <a>, <div>, <span>, <blockquote>, <p>, <em>, <strong>, <form>, <input>, <br>, <s>, <i>, <b>',
	) ) );	
	
	
	/** ===============
	 * Easy Digital Downloads Options
	 */
	// only if EDD is activated
	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		$wp_customize->add_section( 'vendd_edd_options', array(
	    	'title'       	=> __( 'Easy Digital Downloads', 'vendd' ),
			'description' 	=> __( 'All other EDD options are under Dashboard => Downloads. If you deactivate EDD, these options will no longer appear.', 'vendd' ),
			'priority'   	=> 40,
		) );
		
		// show comments on downloads?
		$wp_customize->add_setting( 'vendd_download_comments', array( 
			'default'			=> 0,
			'sanitize_callback'	=> 'vendd_sanitize_checkbox'  
		) );
		$wp_customize->add_control( 'vendd_download_comments', array(
			'label'		=> __( 'Show Comments on Downloads', 'vendd' ),
			'section'	=> 'vendd_edd_options',
			'priority'	=> 10,
			'type'      => 'checkbox',
		) );
		
		/**
		 * EDD button color
		 *
		 * Respect and reflect the EDD button color setting by default and
		 * only change the EDD button color if changes in the customizer.
		 */
		switch ( $edd_options['checkout_color'] ){
			case 'white':
				$edd_button_color_hex = '#404040';
				break;
			case 'gray':
				$edd_button_color_hex = '#f1f1f1';
				break;
			case 'blue':
				$edd_button_color_hex = '#428bca';
				break;
			case 'red':
				$edd_button_color_hex = '#E74C3C';
				break;
			case 'green':
				$edd_button_color_hex = '#2ECC71';
				break;
			case 'yellow':
				$edd_button_color_hex = '#F1C40F';
				break;
			case 'orange':
				$edd_button_color_hex = '#E67E22';
				break;
			case 'dark-gray':
				$edd_button_color_hex = '#3d3d3d';
				break;
		}
		$wp_customize->add_setting( 'vendd_edd_button_color', array(
			'default'		=> $edd_button_color_hex,
			'type'			=> 'option', 
			'capability'	=> 'edit_theme_options',
		) );		
		$wp_customize->add_control( new Vendd_WP_Customize_Color_Control( $wp_customize, 'vendd_edd_button_color', array(
			'label'			=> __( 'EDD Button Color', 'vendd' ), 
			'section'		=> 'vendd_edd_options',
			'description'	=> __( 'By default, this will match what you set in the EDD Style Settings. Selecting another color here will override the EDD setting. Click "Default" to revert back to the default EDD setting.', 'vendd' ),
			'priority'		=> 30
		) ) );
	
		// Store Front Title
		$wp_customize->add_setting( 'vendd_store_front_title', array(
			'default'			=> null,
			'sanitize_callback'	=> 'vendd_sanitize_textarea_lite',
		) );
		$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_store_front_title', array(
			'label'			=> __( 'Store Front Title', 'vendd' ),
			'section'		=> 'vendd_edd_options',
			'priority'		=> 40,
			'description'	=> __( 'This optional field allows you to replace the title of your Store Front (EDD Store Front page template). If left blank, the title of the page will show instead. Allowed tags:', 'vendd' ) . ' <a>, <span>, <em>, <strong>',
		) ) );	
	}
	

	/** ===============
	 * Navigation Menus
	 */
	// section adjustments
	$wp_customize->get_section( 'nav' )->title = __( 'Navigation Menus', 'vendd' );
	$wp_customize->get_section( 'nav' )->priority = 50;
	
	

	/** ===============
	 * Static Front Page
	 */
	// section adjustments
	$wp_customize->get_section( 'static_front_page' )->priority = 60;
}
add_action( 'customize_register', 'vendd_customize_register' );


/** 
 * Sanitize checkbox options
 */
function vendd_sanitize_checkbox( $input ) {
    return 1 == $input ? 1 : 0;
}


/**
 * Sanitize text input
 */
function vendd_sanitize_text( $input ) {
    return strip_tags( stripslashes( $input ) );
}


/**
 * Sanitize text input to allow anchors
 */
function vendd_sanitize_link_text( $input ) {
    return strip_tags( stripslashes( $input ), '<a>' );
}


/**
 * Sanitize textarea
 */
function vendd_sanitize_textarea( $input ) {
	$allowed = array(
		's'			=> array(),
		'br'		=> array(),
		'em'		=> array(),
		'i'			=> array(),
		'strong'	=> array(),
		'b'			=> array(),
		'a'			=> array(
			'href'			=> array(),
			'title'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'form'		=> array(
			'id'			=> array(),
			'class'			=> array(),
			'action'		=> array(),
			'method'		=> array(),
			'autocomplete'	=> array(),
			'style'			=> array(),
		),
		'input'		=> array(
			'type'			=> array(),
			'name'			=> array(),
			'class' 		=> array(),
			'id'			=> array(),
			'value'			=> array(),
			'placeholder'	=> array(),
			'tabindex'		=> array(),
			'style'			=> array(),
		),
		'img'		=> array(
			'src'			=> array(),
			'alt'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'height'		=> array(),
			'width'			=> array(),
		),
		'span'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'p'			=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'div'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'blockquote' => array(
			'cite'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
	);
    return wp_kses( $input, $allowed );
}


/**
 * Sanitize textarea lite
 */
function vendd_sanitize_textarea_lite( $input ) {
	$allowed = array(
		'em'		=> array(),
		'strong'	=> array(),
		'a'			=> array(
			'href'			=> array(),
			'title'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'span'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
	);
    return wp_kses( $input, $allowed );
}


/**
 * sanitize hex colors
 */
function vendd_sanitize_hex_color( $color ) {
	if ( '' === $color ) :
		return '';
    endif;

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) :
		return $color;
    endif;

	return null;
}


/**
 * Add Customizer theme styles to <head>
 */
function vendd_customizer_head_styles() {
	$design_color		= get_option( 'vendd_design_color' );
	$bg_color			= get_option( 'vendd_background_color' );
	$edd_button_color	= get_option( 'vendd_edd_button_color' );
	$edd_color_defaults	= array( '#404040', '#f1f1f1', '#E74C3C', '#2ECC71', '#F1C40F', '#E67E22', '#3d3d3d' );
	?>

	<style type="text/css">
		<?php if ( 1 == get_theme_mod( 'vendd_hide_tagline' ) ) : // if no tagline, reposition the header cart total ?>
			.header-cart {
				top: 26px;
			}
		<?php endif; ?>
		<?php if ( '#f1f1f1' != $bg_color && '' != $bg_color ) : // Is the background color no longer the default? ?>
			body {
				background: <?php echo vendd_sanitize_hex_color( $bg_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( '' != $edd_button_color && ! in_array( $edd_button_color, $edd_color_defaults ) ) : ?>
			.edd-submit.button {
				background: <?php echo vendd_sanitize_hex_color( $edd_button_color ); ?> !important;
			}			
			.edd-submit.button:hover {
				background: #3d3d3d !important; color: #fff;
			}
			.edd_download .edd_download_inner:hover .product-link:hover {
				color: <?php echo vendd_sanitize_hex_color( $edd_button_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( '#428bca' != $design_color && '' != $design_color ) : // Is the design color no longer the default? ?>
			#masthead,
			input[type="submit"],
			input[type="button"],
			button,
			.more-link,
			.product-price,
			.by-post-author {
				background: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
			}			
			a,
			.comment-full:hover > .reply > .comment-reply-link,
			#edd_download_pagination .page-numbers:hover {
				color: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
			}			
			h1,
			h2 {
				border-color: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
			}
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'vendd_customizer_head_styles' );


/** 
 * Add Customizer UI styles to the <head> only on Customizer page
 */
function vendd_customizer_styles() { ?>
	<style type="text/css">
		#customize-controls #customize-theme-controls .description { display: block; color: #999; margin: 2px 0 15px; font-style: italic; }
		textarea, input, select,
		.customize-description { font-size: 12px !important; }
		.customize-control-title { font-size: 13px !important; margin: 5px 0 3px !important; }
		.customize-control label { font-size: 12px !important; }
		.customize-control { margin-bottom: 10px; }
		.control-description { color: #999; font-style: italic; margin-bottom: 6px; }
		.customize-control-text + .customize-control-checkbox,
		.customize-control-customtext + .customize-control-checkbox,
		.customize-control-image + .customize-control-checkbox { margin-top: 12px; }
	</style>
<?php }
add_action( 'customize_controls_print_styles', 'vendd_customizer_styles' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function vendd_customize_preview_js() {
	wp_enqueue_script( 'vendd_customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), VENDD_VERSION, true );
}
add_action( 'customize_preview_init', 'vendd_customize_preview_js' );
