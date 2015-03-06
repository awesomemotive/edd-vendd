<?php
/**
 * The sidebar containing the single download widget area.
 *
 * If no widget is used, the sidebar will output a placeholder
 * download details area that copies the layout of the native
 * EDD "Download Details" widget and also the actual EDD
 * "Download Cart" widget.
 *
 * @package Vendd
 */
?>

<div id="secondary" class="widget-area" role="complementary">

	<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

		<div class="widget widget_edd_product_details">
			<?php
				the_title( '<h3 class="download-title">', '</h3>' );
				echo edd_get_purchase_link( array( 'id' => get_the_ID() ) );
			?>
		</div>

		<div class="widget widget_download_author">
			<?php $user = new WP_User( $post->post_author ); ?>
			<span class="vendd-download-author"><?php echo get_avatar( $user->ID, 90 ); ?></span>
			<ul class="vendd-details-list vendd-author-info">
				<li class="vendd-details-list-item vendd-author-details">
					<span class="vendd-detail-name"><?php _e( 'Author:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo $user->display_name; ?></span>
				</li>
				<li class="vendd-details-list-item vendd-author-details">
					<span class="vendd-detail-name"><?php _e( 'Author since:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></span>
				</li>
				<?php 
					$social_profiles = array(
						'twitter'	=> array(
							'name'	=> 'twitter',
							'data'	=> get_the_author_meta( 'twitter_profile', get_current_user_id() ),
							'icon'	=> '<i class="fa fa-twitter-square"></i>',
						),
						'gplus'	=> array(
							'name'	=> 'google-plus',
							'data'	=> get_the_author_meta( 'gplus_profile', get_current_user_id() ),
							'icon'	=> '<i class="fa fa-google-plus-square"></i>',
						),
						'facebook'	=> array(
							'name'	=> 'facebook',
							'data'	=> get_the_author_meta( 'facebook_profile', get_current_user_id() ),
							'icon'	=> '<i class="fa fa-facebook-square"></i>',
						),
						'youtube'	=> array(
							'name'	=> 'youtube',
							'data'	=> get_the_author_meta( 'youtube_profile', get_current_user_id() ),
							'icon'	=> '<i class="fa fa-youtube-square"></i>',
						),
					);
				?>
				<?php if ( '' != $social_profiles ) { ?>
					<li class="vendd-details-list-item vendd-author-details">
						<div class="vendd-author-contact">
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
							<?php if ( '' != $user->user_url ) { ?>
								<span class="vendd-contact-method vendd-author-website">
									<a href="<?php echo $user->user_url; ?>" class="vendd-social-profile vendd-website" target="_blank">
										<i class="fa fa-home"></i>
									</a>
								</span>
							<?php } ?>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>

		<div class="widget widget_download_details">
			<span class="widget-title"><?php _e( 'Download Details', 'vendd' ); ?></span>
			<ul class="vendd-details-list">
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
				<li class="vendd-details-list-item">
					<?php $sales = edd_get_download_sales_stats( $post->ID ); ?>
					<span class="vendd-detail-name"><?php _e( 'Sales:', 'vendd' ); ?></span>
					<span class="vendd-detail-info"><?php echo $sales; ?></span>
				</li>
				<?php if ( vendd_SL_is_activated() ) { ?>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $licensed = get_post_meta( get_the_ID(), '_edd_sl_enabled', true ); ?>
						<span class="vendd-detail-name"><?php _e( 'Licensed:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $licensed ? __( 'Yes', 'vendd' ) : __( 'No', 'vendd' ); ?></span>
					</li>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $version = get_post_meta( get_the_ID(), '_edd_sl_version', true ); ?>
						<span class="vendd-detail-name"><?php _e( 'Current Version:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $version ? $version : __( 'Unversioned', 'vendd' ); ?></span>
					</li>
				<?php }
					
					$categories = get_the_term_list( $post->ID, 'download_category', '', ', ', '' );
					if ( '' != $categories ) {
						?>
						<li class="vendd-details-list-item">
							<span class="vendd-detail-name"><?php _e( 'Categories:', 'vendd' ); ?></span>
							<span class="vendd-detail-info"><?php echo $categories; ?></span>
						</li>
						<?php
					}
					
					$tags = get_the_term_list( $post->ID, 'download_tag', '', ', ', '' );
					if ( '' != $tags ) {
						?>
						<li class="vendd-details-list-item">
							<span class="vendd-detail-name"><?php _e( 'Tags:', 'vendd' ); ?></span>
							<span class="vendd-detail-info"><?php echo $tags; ?></span>
						</li>
						<?php
					}
				?>
			</ul>
		</div>
		
		<?php the_widget( 'edd_cart_widget' ); ?>

	<?php endif; // end sidebar widget area ?>

</div><!-- #secondary -->