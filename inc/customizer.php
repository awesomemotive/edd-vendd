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
	 * Allow arbitrary HTML controls
	 */
	class Vendd_Customizer_HTML extends WP_Customize_Control {
		public $content = '';
		public function render_content() {
			if ( isset( $this->label ) ) {
				echo '<hr><h3 class="settings-heading">' . $this->label . '</h3>';
			}
			if ( isset( $this->description ) ) {
				echo '<div class="description customize-control-description settings-description">' . $this->description . '</div>';
			}
		}
	}

	/** ===============
	 * Extends controls class to add textarea with description
	 */
	class Vendd_WP_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public $description = '';
		public function render_content() { ?>

		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ) . ' '; ?>
				<span class="vendd-toggle-wrap">
					<?php if ( ! empty( $this->description ) ) { ?>
						<a href="#" class="vendd-toggle-description">?</a>
					<?php } ?>
				</span>
			</span>
			<div class="control-description vendd-control-description"><?php echo esc_html( $this->description ); ?></div>
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
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ) . ' '; ?>
				<span class="vendd-toggle-wrap">
					<?php if ( ! empty( $this->description ) ) { ?>
						<a href="#" class="vendd-toggle-description">?</a>
					<?php } ?>
				</span>
			</span>
			<div class="control-description vendd-control-description"><?php echo esc_html( $this->description ); ?></div>
			<input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		</label>

		<?php }
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
	$wp_customize->add_setting( 'vendd_logo', array(
		'default'           => null,
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vendd_logo', array(
		'label'     => __( 'Custom Site Logo (replaces title)', 'vendd' ),
		'section'   => 'title_tagline',
		'settings'  => 'vendd_logo',
		'priority'  => 20
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
		'label'     => __( 'Hide Tagline', 'vendd' ),
		'section'   => 'title_tagline',
		'priority'  => 40,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Design Options
	 */
	$wp_customize->add_section( 'vendd_design', array(
		'title'         => __( 'Vendd Design', 'vendd' ),
		'description'   => __( 'Control the primary design color of your site.', 'vendd' ),
		'priority'      => 20,
	) );

	// full-width HTML structure
	$wp_customize->add_setting( 'vendd_full_width_html', array(
		'default'           => 0,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_full_width_html', array(
		'label'     => __( 'Enable full-width HTML structure', 'vendd' ),
		'section'   => 'vendd_design',
		'priority'  => 10,
		'type'      => 'checkbox',
	) );

	// design color
	$wp_customize->add_setting( 'vendd_design_color', array(
		'default'           => '#428bca',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback'	=> 'vendd_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vendd_design_color', array(
		'label'     => __( 'Primary Design Color', 'vendd' ),
		'section'   => 'vendd_design',
		'priority'  => 20
	) ) );

	// page-width settings
	$wp_customize->add_setting( 'page_width_settings', array(
		'sanitize_callback'	=> 'vendd_sanitize_arbitrary_html',
	) );
	$wp_customize->add_control( new Vendd_Customizer_HTML( $wp_customize, 'page_width_settings', array(
		'section'     => 'vendd_design',
		'priority'    => 30,
		'description' => __( 'The effects of the following design controls may not be apparent if the full-width HTML structure setting is enabled.', 'vendd' ),
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
		'default'           => 0,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_parallax_bg', array(
		'label'     => __( 'Enable Parallax Background Effect', 'vendd' ),
		'section'   => 'vendd_design',
		'priority'  => 60,
		'type'      => 'checkbox',
	) );


	/** ===============
	 * Content Options
	 */
	$wp_customize->add_section( 'vendd_content_section', array(
		'title'         => __( 'Content Options', 'vendd' ),
		'description'   => __( 'Adjust the display of content on your website. All options have a default value that can be left as-is but you are free to customize.', 'vendd' ),
		'priority'      => 30,
	) );

	// post content
	$wp_customize->add_setting( 'vendd_post_content', array(
		'default'           => 1,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_post_content', array(
		'label'     => __( 'Display Post Excerpts', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 10,
		'type'      => 'checkbox',
	) );

	// read more link
	$wp_customize->add_setting( 'vendd_read_more', array(
		'default'           => __( 'Continue reading', 'vendd' ),
		'sanitize_callback' => 'vendd_sanitize_text'
	) );
	$wp_customize->add_control( new Vendd_WP_Customize_Text_Control( $wp_customize, 'vendd_read_more', array(
	    'label'     => __( 'Excerpt & More Link Text', 'vendd' ),
	    'section'   => 'vendd_content_section',
		'description'   => __( 'This is the link text displayed at the end of blog post excerpts and content truncated with the "more tag." No HTML allowed.', 'vendd' ),
		'priority'  => 20,
	) ) );

	// show featured images on feed?
	$wp_customize->add_setting( 'vendd_feed_featured_image', array(
		'default'           => 1,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_feed_featured_image', array(
		'label'     => __( 'Show Featured Images in Post Listings', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 30,
		'type'      => 'checkbox',
	) );

	// show featured images on posts?
	$wp_customize->add_setting( 'vendd_single_featured_image', array(
		'default'           => 1,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_single_featured_image', array(
		'label'     => __( 'Show Featured Images on Single Posts', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 40,
		'type'      => 'checkbox',
	) );

	// show featured images on pages?
	$wp_customize->add_setting( 'vendd_page_featured_image', array(
		'default'           => 0,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_page_featured_image', array(
		'label'     => __( 'Show Featured Images on Pages', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 45,
		'type'      => 'checkbox',
	) );

	// comments on pages?
	$wp_customize->add_setting( 'vendd_page_comments', array(
		'default'           => 0,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_page_comments', array(
		'label'     => __( 'Enable Comments on Standard Pages', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 50,
		'type'      => 'checkbox',
	) );

	// show search form in main menu?
	$wp_customize->add_setting( 'vendd_menu_search', array(
		'default'			=> 0,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_menu_search', array(
		'label'     => __( 'Show search in Main Menu', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 60,
		'type'      => 'checkbox',
	) );

	// advanced search results
	$wp_customize->add_setting( 'vendd_advanced_search_results', array(
		'default'           => 0,
		'sanitize_callback' => 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_advanced_search_results', array(
		'label'     => __( 'Use Advanced Search Results', 'vendd' ),
		'section'   => 'vendd_content_section',
		'priority'  => 70,
		'type'      => 'checkbox',
	) );

	// Information Bar text
	$wp_customize->add_setting( 'vendd_info_bar', array(
		'default'           => null,
		'sanitize_callback' => 'vendd_sanitize_textarea_lite',
	) );
	$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_info_bar', array(
		'label'         => __( 'Information Bar Text', 'vendd' ),
		'section'       => 'vendd_content_section',
		'description'   => __( 'This text appears at the very top of your site aligned to the left. Allowed tags:', 'vendd' ) . ' <a>, <span>, <em>, <strong>, <i>',
		'priority'      => 80,
	) ) );

	// credits & copyright
	$wp_customize->add_setting( 'vendd_credits_copyright', array(
		'default'           => null,
		'sanitize_callback' => 'vendd_sanitize_textarea',
	) );
	$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_credits_copyright', array(
		'label'         => __( 'Footer Credits & Copyright', 'vendd' ),
		'section'       => 'vendd_content_section',
		'description'   => __( 'Displays site title, tagline, copyright, and year by default. Allowed tags: ', 'vendd' ) . ' <img>, <a>, <div>, <span>, <blockquote>, <p>, <em>, <strong>, <form>, <input>, <br>, <s>, <i>, <b>',
		'priority'      => 90,
	) ) );


	/** ===============
	 * Social Profiles
	 */
	$wp_customize->add_section( 'vendd_social_profiles_section', array(
		'title'         => __( 'Social Profiles', 'vendd' ),
		'description'   => __( 'Enter the <strong>full URLs</strong> for your social profiles. They will display in various areas around the theme.', 'vendd' ),
		'priority'      => 40,
	) );

	// show social profiles in Information Bar?
	$wp_customize->add_setting( 'vendd_info_bar_social_profiles', array(
		'default'           => 0,
		'sanitize_callback'	=> 'vendd_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'vendd_info_bar_social_profiles', array(
		'label'     => __( 'Show social profiles in Information Bar?', 'vendd' ),
		'section'   => 'vendd_social_profiles_section',
		'priority'  => 10,
		'type'      => 'checkbox',
	) );

	/**
	 * all supported social profiles
	 *
	 * Any time a new profile is added to the array, do the following:
	 *
	 * 1. create a new add_control() below for the new profile
	 * 2. update vendd_social_profiles() function in inc/extras.php
	 */
	$profiles = array(
		'twitter'    => array(
			'id'     => 'twitter',
			'label'  => __( 'Twitter', 'vendd' ),
		),
		'facebook'   => array(
			'id'     => 'facebook',
			'label'  => __( 'Facebook', 'vendd' ),
		),
		'googleplus' => array(
			'id'     => 'googleplus',
			'label'  => __( 'Google+', 'vendd' ),
		),
		'github'     => array(
			'id'     => 'github',
			'label'  => __( 'GitHub', 'vendd' ),
		),
		'instagram'  => array(
			'id'     => 'instagram',
			'label'  => __( 'Instagram', 'vendd' ),
		),
		'tumblr'     => array(
			'id'     => 'tumblr',
			'label'  => __( 'Tumblr', 'vendd' ),
		),
		'linkedin'   => array(
			'id'     => 'linkedin',
			'label'  => __( 'LinkedIn', 'vendd' ),
		),
		'youtube'    => array(
			'id'     => 'youtube',
			'label'  => __( 'YouTube', 'vendd' ),
		),
		'slack'      => array(
			'id'     => 'slack',
			'label'  => __( 'Slack', 'vendd' ),
		),
		'pinterest'  => array(
			'id'     => 'pinterest',
			'label'  => __( 'Pinterest', 'vendd' ),
		),
		'dribbble'   => array(
			'id'     => 'dribbble',
			'label'  => __( 'Dribbble', 'vendd' ),
		),
		'wordpress'  => array(
			'id'     => 'wordpress',
			'label'  => __( 'WordPress', 'vendd' ),
		),
		'etsy'       => array(
			'id'     => 'etsy',
			'label'  => __( 'Etsy', 'vendd' ),
		),
	);
	foreach ( $profiles as $setting ) {
		$wp_customize->add_setting( 'vendd_' . $setting['id'], array(
			'default'           => null,
			'sanitize_callback' => 'vendd_sanitize_text'
		) );
	}
	foreach ( $profiles as $control ) {
		$wp_customize->add_control( new Vendd_WP_Customize_Text_Control( $wp_customize, 'vendd_' . $control['id'], array(
			'label'     => $control['label'],
			'section'   => 'vendd_social_profiles_section'
		) ) );
	}


	/** ===============
	 * Easy Digital Downloads Options
	 */
	// only if EDD is activated
	if ( vendd_edd_is_activated() ) {
		$wp_customize->add_section( 'vendd_edd_options', array(
			'title'         => __( 'Easy Digital Downloads', 'vendd' ),
			'description'   => __( 'All other EDD options are under Dashboard => Downloads. If you deactivate EDD, these options will no longer appear.', 'vendd' ),
			'priority'      => 50,
		) );

		// show featured images on products?
		$wp_customize->add_setting( 'vendd_product_featured_image', array(
			'default'           => 1,
			'sanitize_callback' => 'vendd_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'vendd_product_featured_image', array(
			'label'     => __( 'Show Featured Images on Products', 'vendd' ),
			'section'   => 'vendd_edd_options',
			'priority'  => 5,
			'type'      => 'checkbox',
		) );

		// product image uploader
		$wp_customize->add_setting( 'vendd_product_image_upload', array(
			'default'           => null,
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vendd_product_image_upload', array(
			'label'        => __( 'Default Product Image', 'vendd' ),
			'section'      => 'vendd_edd_options',
			'description'  => __( 'Recommended: default product image should be the same dimensions as your uploaded Download Images (if used). Vendd default product image crop dimensions: 722px 361px.', 'vendd' ),
			'settings'     => 'vendd_product_image_upload',
			'priority'     => 10
		) ) );

		// use default image fallback
		$wp_customize->add_setting( 'vendd_product_image', array(
			'default'           => 0,
			'sanitize_callback' => 'vendd_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'vendd_product_image', array(
			'label'     => __( 'Use Default Product Image Fallback', 'vendd' ),
			'section'   => 'vendd_edd_options',
			'priority'  => 20,
			'type'      => 'checkbox',
		) );

		// show comments on downloads?
		$wp_customize->add_setting( 'vendd_download_comments', array(
			'default'           => 0,
			'sanitize_callback' => 'vendd_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'vendd_download_comments', array(
			'label'     => __( 'Show Comments on Downloads', 'vendd' ),
			'section'   => 'vendd_edd_options',
			'priority'  => 30,
			'type'      => 'checkbox',
		) );

		// show categories on [downloads] shortcode?
		$wp_customize->add_setting( 'vendd_downloads_cats', array(
			'default'           => 0,
			'sanitize_callback' => 'vendd_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'vendd_downloads_cats', array(
			'label'     => __( 'Show Categories on Downloads grid', 'vendd' ),
			'section'   => 'vendd_edd_options',
			'priority'  => 40,
			'type'      => 'checkbox',
		) );

		// show tags on [downloads] shortcode?
		$wp_customize->add_setting( 'vendd_downloads_tags', array(
			'default'           => 0,
			'sanitize_callback' => 'vendd_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'vendd_downloads_tags', array(
			'label'     => __( 'Show Tags on Downloads grid', 'vendd' ),
			'section'   => 'vendd_edd_options',
			'priority'  => 41,
			'type'      => 'checkbox',
		) );

		/**
		 * EDD button color
		 *
		 * Respect and reflect the EDD button color setting by default and
		 * only change the EDD button color if changes in the customizer.
		 */
		switch ( edd_get_option( 'checkout_color' ) ) {
			case 'white':
				$edd_button_color_hex = '#404040';
				break;
			case 'gray':
				$edd_button_color_hex = '#f1f1f1';
				break;
			case 'blue':
			default:
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
			'default'           => $edd_button_color_hex,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback'	=> 'vendd_sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vendd_edd_button_color', array(
			'label'        => __( 'EDD Button Color', 'vendd' ),
			'section'      => 'vendd_edd_options',
			'description'  => __( 'By default, this will match what you set in the EDD Style Settings. Selecting another color here will override the EDD setting. Clear the color field back to default to revert back to the EDD setting.', 'vendd' ),
			'priority'     => 50,
		) ) );

		// EDD Downloads page template title
		$wp_customize->add_setting( 'vendd_store_front_title', array(
			'default'           => null,
			'sanitize_callback' => 'vendd_sanitize_textarea_lite',
		) );
		$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_store_front_title', array(
			'label'         => __( 'EDD Downloads Template Title', 'vendd' ),
			'section'       => 'vendd_edd_options',
			'description'   => __( 'This optional field allows you to replace the title of your EDD Downloads Page Template. If left blank, the title of the page will show instead. Allowed tags:', 'vendd' ) . ' <a>, <span>, <em>, <strong>, <i>',
			'priority'      => 60,
		) ) );

		// Empty Cart Title
		$wp_customize->add_setting( 'vendd_empty_cart_title', array(
			'default'           => null,
			'sanitize_callback' => 'vendd_sanitize_textarea_lite',
		) );
		$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_empty_cart_title', array(
			'label'         => __( 'Empty Cart Title', 'vendd' ),
			'section'       => 'vendd_edd_options',
			'description'   => __( 'This is the title on the page that displays when the cart is empty. Allowed tags:', 'vendd' ) . ' <a>, <span>, <em>, <strong>, <i>',
			'priority'      => 70,
		) ) );

		// empty cart text
		$wp_customize->add_setting( 'vendd_empty_cart_text', array(
			'default'           => null,
			'sanitize_callback' => 'vendd_sanitize_textarea',
		) );
		$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_empty_cart_text', array(
			'label'        => __( 'Empty Cart Text', 'vendd' ),
			'section'      => 'vendd_edd_options',
			'description'  => __( 'Displays a custom message when the checkout cart is empty. Allowed tags: ', 'vendd' ) . ' <img>, <a>, <div>, <span>, <blockquote>, <p>, <em>, <strong>, <form>, <input>, <br>, <s>, <i>, <b>',
			'priority'     => 80,
		) ) );

		// store front item count
		$wp_customize->add_setting( 'vendd_empty_cart_downloads_count', array(
			'default'           => 4,
			'sanitize_callback' => 'vendd_sanitize_integer'
		) );
		$wp_customize->add_control( new Vendd_WP_Customize_Text_Control( $wp_customize, 'vendd_empty_cart_downloads_count', array(
			'label'        => __( 'Empty Cart Downloads Count', 'vendd' ),
			'section'      => 'vendd_edd_options',
			'description'  => __( 'Enter the number of downloads you would like to display on the checkout page when the cart is empty. Additional downloads are available through pagination.', 'vendd' ),
			'priority'     => 90,
		) ) );
	}


	/** ===============
	 * EDD Frontend Submissions Options
	 */
	// only if FES is activated
	if ( vendd_fes_is_activated() && vendd_edd_is_activated() ) {
		$wp_customize->add_section( 'vendd_fes_options', array(
	    	'title'         => __( 'EDD Frontend Submissions', 'vendd' ),
			'description'   => __( 'All other FES options are under Dashboard => EDD FES. If you deactivate EDD or FES, these options will no longer appear.', 'vendd' ),
			'priority'      => 51,
		) );

		// FES Dashboard Title
		$wp_customize->add_setting( 'vendd_fes_dashboard_title', array(
			'default'           => null,
			'sanitize_callback' => 'vendd_sanitize_textarea_lite',
		) );
		$wp_customize->add_control( new Vendd_WP_Customize_Textarea_Control( $wp_customize, 'vendd_fes_dashboard_title', array(
			'label'         => __( 'FES Dashboard Title', 'vendd' ),
			'section'       => 'vendd_fes_options',
			'description'   => __( 'This optional field allows you to replace the title of your FES Dashboard. If left blank, the title of the page will show instead. Allowed tags:', 'vendd' ) . ' <a>, <span>, <em>, <strong>, <i>',
			'priority'      => 10,
		) ) );

		// contact form on Vendor pages
		$wp_customize->add_setting( 'vendd_vendor_contact_form', array(
			'default'           => 0,
			'sanitize_callback' => 'vendd_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'vendd_vendor_contact_form', array(
			'label'     => __( 'Show contact form on Vendor template', 'vendd' ),
			'section'   => 'vendd_fes_options',
			'priority'  => 20,
			'type'      => 'checkbox',
		) );
	}


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


/** ===============
 * Sanitize integer input
 */
function vendd_sanitize_integer( $input ) {
	return absint( $input );
}


/**
 * Sanitize textarea
 */
function vendd_sanitize_textarea( $input ) {
	$allowed = array(
		's'         => array(),
		'br'        => array(),
		'em'        => array(),
		'i'         => array(),
		'strong'    => array(),
		'b'         => array(),
		'a'         => array(
			'href'          => array(),
			'title'         => array(),
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
			'target'        => array(),
		),
		'form'      => array(
			'id'            => array(),
			'class'         => array(),
			'action'        => array(),
			'method'        => array(),
			'autocomplete'  => array(),
			'style'         => array(),
		),
		'input'     => array(
			'type'          => array(),
			'name'          => array(),
			'class'         => array(),
			'id'            => array(),
			'value'         => array(),
			'placeholder'   => array(),
			'tabindex'      => array(),
			'style'         => array(),
		),
		'img'       => array(
			'src'           => array(),
			'alt'           => array(),
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
			'height'        => array(),
			'width'         => array(),
		),
		'span'      => array(
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
		),
		'p'         => array(
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
		),
		'div'       => array(
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
		),
		'blockquote' => array(
			'cite'          => array(),
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
		),
	);
	return wp_kses( $input, $allowed );
}


/**
 * Sanitize textarea lite
 */
function vendd_sanitize_textarea_lite( $input ) {
	$allowed = array(
		'em'        => array(),
		'strong'    => array(),
		'a'         => array(
			'href'          => array(),
			'title'         => array(),
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
			'target'        => array(),
		),
		'span'      => array(
			'class'         => array(),
			'id'            => array(),
			'style'         => array(),
		),
		'i'      => array(
			'class'         => array(),
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
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) :
		return $color;
	endif;

	return null;
}


/**
 * Dummy sanitization arbitrary HTML
 */
function vendd_sanitize_arbitrary_html() {
	// nothing to see here
}


/**
 * Add Customizer theme styles to <head>
 */
function vendd_customizer_head_styles() {
	$design_color       = get_option( 'vendd_design_color' );
	$bg_color           = get_option( 'vendd_background_color' );
	$edd_button_color   = get_option( 'vendd_edd_button_color' );
	$edd_color_defaults = array( '#404040', '#f1f1f1', '#E74C3C', '#2ECC71', '#F1C40F', '#E67E22', '#3d3d3d' );
	$html_structure     = get_theme_mod( 'vendd_full_width_html', 0 ) ? '#content' : '#page';
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
			<?php echo $html_structure; ?> .edd-submit.button {
				background: <?php echo vendd_sanitize_hex_color( $edd_button_color ); ?>;
				color: #fff;
			}
			<?php echo $html_structure; ?> .edd-submit.button:hover {
				background: #3d3d3d;
				color: #fff;
			}
			<?php if ( vendd_edd_is_activated() && 'inherit' == edd_get_option( 'checkout_color' ) ) : ?>
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.white { background: #404040; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.gray { background: #f1f1f1; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.blue { background: #428bca; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.red { background: #E74C3C; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.green { background: #2ECC71; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.yellow { background: #F1C40F; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.orange { background: #E67E22; }
				<?php echo $html_structure; ?> .edd_purchase_submit_wrapper .edd-submit.button.dark-gray { background: #3d3d3d; }
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( '#428bca' != $design_color && '' != $design_color ) : // Is the design color no longer the default? ?>
			#masthead,
			input[type="submit"],
			input[type="button"],
			.vendd-fes-dashboard-template .fes-form .fes-submit input[type="submit"],
			.vendd-fes-dashboard-template .fes-form .edd-submit.button,
			.vendd-edd-fes-shortcode .fes-form .fes-submit input[type="submit"],
			.vendd-edd-fes-shortcode .fes-form .edd-submit.button,
			.vendd-vendor-contact .fes-form .fes-submit input[type="submit"],
			.vendd-fes-template .fes-fields .fes-feat-image-upload a.fes-feat-image-btn,
			.vendd-edd-fes-shortcode .fes-fields .fes-feat-image-upload a.fes-feat-image-btn,
			.vendd-fes-template .fes-fields .fes-avatar-image-upload a.fes-avatar-image-btn,
			.vendd-edd-fes-shortcode .fes-fields .fes-avatar-image-upload a.fes-avatar-image-btn,
			button,
			.more-link,
			.by-post-author,
			.main-navigation:not(.toggled) ul li:hover > ul,
			#edd_download_pagination .page-numbers.current,
			.edd_pagination .page-numbers.current,
			div[class*="fes-"] > .page-numbers.current,
			div[id*="edd_commissions_"] .page-numbers.current,
			#edd_download_pagination .page-numbers:hover,
			.edd_pagination .page-numbers:hover,
			div[class*="fes-"] > .page-numbers:hover,
			div[id*="edd_commissions_"] .page-numbers:hover {
				background: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
			}
			a,
			.comment-full:hover > .reply > .comment-reply-link {
				color: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
			}
			h1, h2 {
				border-color: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
			}
			@media all and ( min-width: 860px ) {
				.main-navigation ul li:hover > ul {
					background: <?php echo vendd_sanitize_hex_color( $design_color ); ?>;
				}
			}
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'vendd_customizer_head_styles' );


/**
 * Enqueue script for custom customize control.
 */
function vendd_custom_customizer_enqueue() {
	wp_enqueue_script( 'vendd_custom_customizer', get_template_directory_uri() . '/inc/js/custom-customizer.js', array( 'jquery', 'customize-controls' ), VENDD_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'vendd_custom_customizer_enqueue' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function vendd_customize_preview_js() {
	wp_enqueue_script( 'vendd_customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), VENDD_VERSION, true );
}
add_action( 'customize_preview_init', 'vendd_customize_preview_js' );


/**
 * Add Customizer UI styles to the <head> only on Customizer page
 */
function vendd_customizer_styles() { ?>
	<style type="text/css">
		hr { margin-top: 15px; }
		.settings-heading { margin-bottom: 0; }
		.settings-description { margin-top: 6px; }
		.customize-control-checkbox { margin-bottom: 0; }
		#customize-controls #customize-theme-controls .description { display: block; color: #666;  font-style: italic; margin: 2px 0 15px; }
		#customize-controls #customize-theme-controls .customize-section-description { margin-top: 10px; }
		textarea, input, select,
		.customize-description { font-size: 12px !important; }
		.customize-control-title { font-size: 13px !important; margin: 5px 0 3px !important; }
		.customize-control label { font-size: 12px !important; }
		.customize-control { margin-bottom: 10px; }
		.vendd-toggle-wrap { display: inline-block; line-height: 1; margin-left: 2px; }
		.vendd-toggle-wrap a { display: block; background: rgba(0, 0, 0, .2); color: #fff; padding: 2px 6px; border-radius: 3px; margin-left: 6px; }
		.vendd-toggle-wrap a:hover,
		.vendd-toggle-wrap .vendd-description-opened { background: #555; color: #fff; }
		.control-description { color: #666; font-style: italic; margin-bottom: 6px; }
		.vendd-control-description { display: none; }
		.customize-control-text + .customize-control-checkbox,
		.customize-control-customtext + .customize-control-checkbox,
		.customize-control-image + .customize-control-checkbox { margin-top: 12px; }
		#customize-control-vendd_empty_cart_downloads_count input { width: 50px; }
	</style>
<?php }
add_action( 'customize_controls_print_styles', 'vendd_customizer_styles' );