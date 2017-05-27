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
		$author       = new WP_User( $post->post_author );
		if ( vendd_fes_is_activated() ) {
			$vendor_url = vendd_edd_fes_author_url( get_the_author_meta( 'ID', $author->post_author ) );
		}
		$vendor_store = get_the_author_meta( 'name_of_store', $post->post_author );
		$avatar       = isset( $instance['avatar'] )      ? $instance['avatar']      : 1;
		$store_name   = isset( $instance['store_name'] )  ? $instance['store_name']  : 1;
		$name         = isset( $instance['name'] )        ? $instance['name']        : 1;
		$signup_date  = isset( $instance['signup_date'] ) ? $instance['signup_date'] : 1;
		$links        = isset( $instance['links'] )       ? $instance['links']       : 1;

		// return early if not a single download
		if ( 'download' != get_post_type( $post ) ) {
			return;
		}

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		if ( $avatar ) {
			?>
			<?php if ( vendd_fes_is_activated() ) { ?>
				<span class="vendd-download-author">
					<a class="vendor-url" href="<?php echo esc_url( $vendor_url ); ?>"><?php echo get_avatar( $author->ID, 90 ); ?></a>
				</span>
			<?php } else { ?>
				<span class="vendd-download-author">
					<?php echo get_avatar( $author->ID, 90 ); ?>
				</span>
			<?php } ?>
			<?php
		}
		if ( $store_name ) {
			?>
			<span class="store-name-heading"><?php echo $vendor_store; ?></span>
			<?php
		}
		?>
		<ul class="vendd-details-list vendd-author-info">
			<?php if ( $name ) { ?>
				<li class="vendd-details-list-item vendd-author-details">
					<span class="vendd-detail-name"><?php _e( 'Author:', 'vendd' ); ?></span>
					<span class="vendd-detail-info">
						<?php if ( vendd_fes_is_activated() ) { ?>
							<a class="vendor-url" href="<?php echo esc_url( $vendor_url ); ?>">
								<?php echo $author->display_name; ?>
							</a>
						<?php } else { ?>
							<?php echo $author->display_name; ?>
						<?php } ?>
					</span>
				</li>
			<?php } ?>
			<?php if ( $signup_date ) { ?>
				<li class="vendd-details-list-item vendd-author-details">
					<span class="vendd-detail-name"><?php _e( 'Author since:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $author->user_registered ) ); ?></span>
				</li>
			<?php } ?>
			<?php
				if ( $links ) {
					$website  = get_the_author_meta( 'user_url', $post->post_author );
					$twitter  = get_the_author_meta( 'twitter_profile', $post->post_author );
					$gplus    = get_the_author_meta( 'gplus_profile', $post->post_author );
					$facebook = get_the_author_meta( 'facebook_profile', $post->post_author );
					$youtube  = get_the_author_meta( 'youtube_profile', $post->post_author );
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
														esc_url( $profile['data'] ),
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
										<a href="<?php echo esc_url( $website ); ?>" title="<?php echo esc_attr( $author->display_name ); echo _x( '\'s website', 'title attribute of the FES vendor\'s website link', 'vendd' ); ?>" class="vendd-social-profile vendd-website" target="_blank">
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
			'avatar'      => 1,
			'store_name'  => 1,
			'name'        => 1,
			'signup_date' => 1,
			'links'       => 1
		);
		$instance    = wp_parse_args( (array) $instance, $defaults );
		$avatar      = isset( $instance['avatar'] )      ? (bool) $instance['avatar']      : true;
		$store_name  = isset( $instance['store_name'] )  ? (bool) $instance['store_name']  : true;
		$name        = isset( $instance['name'] )        ? (bool) $instance['name']        : true;
		$signup_date = isset( $instance['signup_date'] ) ? (bool) $instance['signup_date'] : true;
		$links       = isset( $instance['links'] )       ? (bool) $instance['links']       : true;
		?>
		<p class="vendd-widget-usage"><em><?php _e( 'Only for use in Download Sidebar', 'vendd' ); ?></em></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'vendd' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php esc_attr_e( 'Leave empty for no title (recommended)', 'vendd' ); ?>">
		</p>
		<p>
			<input <?php checked( $avatar ); ?> id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php _e( 'Show Author Avatar', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $store_name ); ?> id="<?php echo esc_attr( $this->get_field_id( 'store_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'store_name' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'store_name' ) ); ?>"><?php _e( 'Show Store Name', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $name ); ?> id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( 'Show Author Name', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $signup_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'signup_date' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>"><?php _e( 'Show Author Sign-up Date', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $links ); ?> id="<?php echo esc_attr( $this->get_field_id( 'links' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'links' ) ); ?>" type="checkbox" />
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
		$instance['avatar']      = ! empty( $new_instance['avatar'] )      ? 1 : 0;
		$instance['store_name']  = ! empty( $new_instance['store_name'] )  ? 1 : 0;
		$instance['name']        = ! empty( $new_instance['name'] )        ? 1 : 0;
		$instance['signup_date'] = ! empty( $new_instance['signup_date'] ) ? 1 : 0;
		$instance['links']       = ! empty( $new_instance['links'] )       ? 1 : 0;

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
		$author          = new WP_User( $post->post_author );
		$published       = isset( $instance['published'] )  ? $instance['published']  : 1;
		$sales           = isset( $instance['sales'] )      ? $instance['sales']      : 1;
		$licensed        = isset( $instance['licensed'] )   ? $instance['licensed']   : 1;
		$version         = isset( $instance['version'] )    ? $instance['version']    : 1;
		$show_categories = isset( $instance['categories'] ) ? $instance['categories'] : 1;
		$show_tags       = isset( $instance['tags'] )       ? $instance['tags']       : 1;

		// return early if not a single download
		if ( 'download' != get_post_type( $post ) ) {
			return;
		}

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		?>
		<ul class="vendd-details-list">
			<?php if ( $published ) { ?>
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
			<?php if ( $sales ) { ?>
				<li class="vendd-details-list-item">
					<?php $sales = apply_filters( 'vendd_download_sales_count', edd_get_download_sales_stats( $post->ID ), $post ); ?>
					<span class="vendd-detail-name"><?php _e( 'Sales:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo $sales; ?></span>
				</li>
			<?php } ?>
			<?php if ( vendd_SL_is_activated() ) { ?>
				<?php if ( $licensed ) { ?>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $licensed = apply_filters( 'vendd_download_is_licensed', get_post_meta( get_the_ID(), '_edd_sl_enabled', true ), $post ); ?>
						<span class="vendd-detail-name"><?php _e( 'Licensed:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $licensed ? __( 'Yes', 'vendd' ) : __( 'No', 'vendd' ); ?></span>
					</li>
				<?php } ?>
				<?php if ( $version ) { ?>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $version = apply_filters( 'vendd_download_version', get_post_meta( get_the_ID(), '_edd_sl_version', true ), $post ); ?>
						<span class="vendd-detail-name"><?php _e( 'Current Version:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $version ? $version : __( 'Unversioned', 'vendd' ); ?></span>
					</li>
				<?php } ?>
			<?php }
				if ( $show_categories ) {
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
				if ( $show_tags ) {
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
			'published'  => 1,
			'sales'      => 1,
			'licensed'   => 1,
			'version'    => 1,
			'categories' => 1,
			'tags'       => 1,
		);
		$instance   = wp_parse_args( (array) $instance, $defaults );
		$published  = isset( $instance['published'] )  ? (bool) $instance['published']  : true;
		$sales      = isset( $instance['sales'] )      ? (bool) $instance['sales']      : true;
		$licensed   = isset( $instance['licensed'] )   ? (bool) $instance['licensed']   : true;
		$version    = isset( $instance['version'] )    ? (bool) $instance['version']    : true;
		$categories = isset( $instance['categories'] ) ? (bool) $instance['categories'] : true;
		$tags       = isset( $instance['tags'] )       ? (bool) $instance['tags']       : true;
		?>
		<p class="vendd-widget-usage"><em><?php _e( 'Only for use in Download Sidebar', 'vendd' ); ?></em></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'vendd' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<input <?php checked( $published ); ?> id="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'published' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>"><?php _e( 'Show Published Date', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $sales ); ?> id="<?php echo esc_attr( $this->get_field_id( 'sales' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sales' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'sales' ) ); ?>"><?php _e( 'Show Sales Total', 'vendd' ); ?></label>
		</p>
		<?php if ( vendd_SL_is_activated() ) { ?>
			<p>
				<input <?php checked( $licensed ); ?> id="<?php echo esc_attr( $this->get_field_id( 'licensed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'licensed' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'licensed' ) ); ?>"><?php _e( 'Show License Status', 'vendd' ); ?></label>
			</p>
			<p>
				<input <?php checked( $version ); ?> id="<?php echo esc_attr( $this->get_field_id( 'version' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'version' ) ); ?>" type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'version' ) ); ?>"><?php _e( 'Show Version Number', 'vendd' ); ?></label>
			</p>
		<?php } ?>
		<p>
			<input <?php checked( $categories ); ?> id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>" type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php _e( 'Show Categories', 'vendd' ); ?></label>
		</p>
		<p>
			<input <?php checked( $tags ); ?> id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" type="checkbox" />
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
		$instance['published']  = ! empty( $new_instance['published'] )   ? 1 : 0;
		$instance['sales']      = ! empty( $new_instance['sales'] )       ? 1 : 0;
		$instance['categories'] = ! empty( $new_instance['categories'] )  ? 1 : 0;
		$instance['tags']       = ! empty( $new_instance['tags'] )        ? 1 : 0;

		if ( vendd_SL_is_activated() ) {
			$instance['licensed'] = ! empty( $new_instance['licensed'] ) ? 1 : 0;
			$instance['version']  = ! empty( $new_instance['version'] )  ? 1 : 0;
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