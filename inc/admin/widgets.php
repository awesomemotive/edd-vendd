<?php
/**
 * Included Widgets
 *
 * @package Vendd
 */


/**
 * Vendd Download Author Information Widget
 *
 * This widget is designed to replace the default author info widget that
 * displays in the Vendd download sidebar by default. This purely exists
 * as an alternative to the default so that you can control your sidebar
 * and rearrange items.
 *
 * @since 1.1.3
 * @package Vendd
 */
class Vendd_Author_Details extends WP_Widget {

	/**
	 * Register the widget
	 */
	public function __construct() {
		parent::__construct(
			'vendd_download_author',
			VENDD_NAME . ': ' . __( 'Download Author', 'vendd' ),
			array(
				'description' => __( 'Display the download author\'s details such as join date and social networking links.', 'vendd' ),
			)
		);
	}

	/**
	 * Output the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $post;
		$author = new WP_User( $post->post_author );
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		if ( 'on' == $instance['avatar'] ) {
			?>
			<span class="vendd-download-author"><?php echo get_avatar( $author->ID, 90 ); ?></span>
			<?php
		}
		?>
		<ul class="vendd-details-list vendd-author-info">
			<?php if ( 'on' == $instance['name'] ) { ?>
				<li class="vendd-details-list-item vendd-author-details">
					<span class="vendd-detail-name"><?php _e( 'Author:', 'vendd' ); ?></span>
					<span class="vendd-detail-info">
						<?php if ( vendd_fes_is_activated() ) {
							$vendor_url = vendd_edd_fes_author_url( get_the_author_meta( 'ID', $author->post_author ) );
							?>
							<a class="vendor-url" href="<?php echo $vendor_url; ?>">
								<?php echo $author->display_name; ?>
							</a>
						<?php } else { ?>
							<?php echo $author->display_name; ?>
						<?php } ?>
					</span>
				</li>
			<?php } ?>
			<?php if ( 'on' == $instance['signup_date'] ) { ?>
				<li class="vendd-details-list-item vendd-author-details">
					<span class="vendd-detail-name"><?php _e( 'Author since:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $author->user_registered ) ); ?></span>
				</li>
			<?php } ?>
			<?php
				if ( 'on' == $instance['links'] ) {
					$website  = get_the_author_meta( 'user_url', get_current_user_id() );
					$twitter  = get_the_author_meta( 'twitter_profile', get_current_user_id() );
					$gplus    = get_the_author_meta( 'gplus_profile', get_current_user_id() );
					$facebook = get_the_author_meta( 'facebook_profile', get_current_user_id() );
					$youtube  = get_the_author_meta( 'youtube_profile', get_current_user_id() );
					$social_profiles = array(
						'twitter'	=> array(
							'name'	=> 'twitter',
							'data'	=> $twitter,
							'icon'	=> '<i class="fa fa-twitter-square"></i>',
						),
						'gplus'	=> array(
							'name'	=> 'google-plus',
							'data'	=> $gplus,
							'icon'	=> '<i class="fa fa-google-plus-square"></i>',
						),
						'facebook'	=> array(
							'name'	=> 'facebook',
							'data'	=> $facebook,
							'icon'	=> '<i class="fa fa-facebook-square"></i>',
						),
						'youtube'	=> array(
							'name'	=> 'youtube',
							'data'	=> $youtube,
							'icon'	=> '<i class="fa fa-youtube-square"></i>',
						),
					);
	
					if (
						! empty( $website ) ||
						! empty( $twitter ) ||
						! empty( $gplus ) ||
						! empty( $facebook ) ||
						! empty( $youtube ) ) {
						?>
						<li class="vendd-details-list-item vendd-author-details">
							<div class="vendd-author-contact clear">
								<?php
									foreach ( $social_profiles as $profile ) {
										if ( '' != $profile['data'] ) {
											?>
											<span class="vendd-contact-method">
												<?php
													printf( '<a href="%1$s" class="vendd-social-profile vendd-%2$s" target="_blank">%3$s</a>',
														$profile['data'],
														$profile['name'],
														$profile['icon']
													);
												?>
											</span>
											<?php
										}
									}
								?>
								<?php if ( ! empty( $website ) ) { ?>
									<span class="vendd-contact-method vendd-author-website">
										<a href="<?php echo $website; ?>" title="<?php echo $author->display_name; echo _x( '\'s website', 'title attribute of the FES vendor\'s website link', 'vendd' ); ?>" class="vendd-social-profile vendd-website" target="_blank">
											<i class="fa fa-home"></i>
										</a>
									</span>
								<?php } ?>
							</div>
						</li>
						<?php
					}
				}
			?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		// default settings
		$defaults = array(
			'avatar'            => 'on',
			'name'              => 'on',
			'signup_date'       => 'on',
			'links'             => 'on'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'vendd' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php esc_attr_e( 'Leave empty for no title (recommended)', 'vendd' ); ?>">
		</p>
		<p>
			<input <?php checked( $instance['avatar'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php _e( 'Show Author Avatar', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $instance['name'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( 'Show Author Name', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $instance['signup_date'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'signup_date' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>"><?php _e( 'Show Author Sign-up Date', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $instance['links'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'links' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'links' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'links' ) ); ?>"><?php _e( 'Show Author Social Links', 'vendd' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['avatar']      = isset( $new_instance['avatar'] )      ? $new_instance['avatar']              : '';
		$instance['name']        = isset( $new_instance['name'] )        ? $new_instance['name']                : '';
		$instance['signup_date'] = isset( $new_instance['signup_date'] ) ? $new_instance['signup_date']         : '';
		$instance['links']       = isset( $new_instance['links'] )       ? $new_instance['links']               : '';

		return $instance;
	}
}


/**
 * Vendd Download Details Information Widget
 *
 * This widget is designed to replace the default download info widget that
 * displays in the Vendd download sidebar by default. This purely exists
 * as an alternative to the default so that you can control your sidebar
 * and rearrange items.
 *
 * @since 1.1.3
 * @package Vendd
 */
class Vendd_Download_Details extends WP_Widget {

	/**
	 * Register the widget
	 */
	public function __construct() {
		parent::__construct(
			'vendd_download_details',
			VENDD_NAME . ': ' . __( 'Download Details', 'vendd' ),
			array(
				'description' => __( 'Display the download details such as date published and total sales.', 'vendd' ),
			)
		);
	}

	/**
	 * Output the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $post;
		$author = new WP_User( $post->post_author );
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		?>
		<ul class="vendd-details-list">
			<?php if ( 'on' == $instance['published'] ) { ?>
				<li class="vendd-details-list-item">
					<?php
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
						$time_string = sprintf( $time_string,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							esc_attr( get_the_modified_date( 'c' ) ),
							esc_html( get_the_modified_date() )
						);
					?>
					<span class="vendd-detail-name"><?php _e( 'Published:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo $time_string; ?></span>
				</li>
			<?php } ?>
			<?php if ( 'on' == $instance['sales'] ) { ?>
				<li class="vendd-details-list-item">
					<?php $sales = apply_filters( 'vendd_download_sales_count', edd_get_download_sales_stats( $post->ID ), $post ); ?>
					<span class="vendd-detail-name"><?php _e( 'Sales:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo $sales; ?></span>
				</li>
			<?php } ?>
			<?php if ( vendd_SL_is_activated() ) { ?>
				<?php if ( 'on' == $instance['licensed'] ) { ?>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $licensed = apply_filters( 'vendd_download_is_licensed', get_post_meta( get_the_ID(), '_edd_sl_enabled', true ), $post ); ?>
						<span class="vendd-detail-name"><?php _e( 'Licensed:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $licensed ? __( 'Yes', 'vendd' ) : __( 'No', 'vendd' ); ?></span>
					</li>
				<?php } ?>
				<?php if ( 'on' == $instance['version'] ) { ?>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $version = apply_filters( 'vendd_download_version', get_post_meta( get_the_ID(), '_edd_sl_version', true ), $post ); ?>
						<span class="vendd-detail-name"><?php _e( 'Current Version:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $version ? $version : __( 'Unversioned', 'vendd' ); ?></span>
					</li>
				<?php } ?>
			<?php }
				if ( 'on' == $instance['categories'] ) {
					$categories = get_the_term_list( $post->ID, 'download_category', '', ', ', '' );
					if ( '' != $categories ) {
						?>
						<li class="vendd-details-list-item">
							<span class="vendd-detail-name"><?php _e( 'Categories:', 'vendd' ); ?></span>
							<span class="vendd-detail-info"><?php echo $categories; ?></span>
						</li>
						<?php
					}
				}
				if ( 'on' == $instance['tags'] ) {
					$tags = get_the_term_list( $post->ID, 'download_tag', '', ', ', '' );
					if ( '' != $tags ) {
						?>
						<li class="vendd-details-list-item">
							<span class="vendd-detail-name"><?php _e( 'Tags:', 'vendd' ); ?></span>
							<span class="vendd-detail-info"><?php echo $tags; ?></span>
						</li>
						<?php
					}
				}
			?>
		</ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		// default settings
		$defaults = array(
			'published'         => 'on',
			'sales'             => 'on',
			'licensed'          => 'on',
			'version'           => 'on',
			'categories'        => 'on',
			'tags'              => 'on',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'vendd' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<input <?php checked( $instance['published'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'published' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>"><?php _e( 'Show Published Date', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $instance['sales'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'sales' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sales' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'sales' ) ); ?>"><?php _e( 'Show Sales Total', 'vendd' ); ?></label>
		</p>
		<?php if ( vendd_SL_is_activated() ) { ?>
			<p>
				<input <?php checked( $instance['licensed'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'licensed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'licensed' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'licensed' ) ); ?>"><?php _e( 'Show License Status', 'vendd' ); ?></label>
			</p>
			<p>
				<input <?php checked( $instance['version'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'version' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'version' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'version' ) ); ?>"><?php _e( 'Show Version Number', 'vendd' ); ?></label>
			</p>
		<?php } ?>
		<p>
			<input <?php checked( $instance['categories'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php _e( 'Show Categories', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $instance['tags'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"><?php _e( 'Show Tags', 'vendd' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['published']  = isset( $new_instance['published'] )   ? $new_instance['published']           : '';
		$instance['sales']      = isset( $new_instance['sales'] )       ? $new_instance['sales']               : '';
		$instance['categories'] = isset( $new_instance['categories'] )  ? $new_instance['categories']          : '';
		$instance['tags']       = isset( $new_instance['tags'] )        ? $new_instance['tags']                : '';
		
		if ( vendd_SL_is_activated() ) {
			$instance['licensed'] = isset( $new_instance['licensed'] ) ? $new_instance['licensed'] : '';
			$instance['version']  = isset( $new_instance['version'] )  ? $new_instance['version']  : '';
		}

		return $instance;
	}
}


/**
 * register the widgets
 *
 * @package Vendd
 */
function vendd_register_widgets() {
	register_widget( 'Vendd_Author_Details' );
	register_widget( 'Vendd_Download_Details' );
}
add_action( 'widgets_init', 'vendd_register_widgets' );