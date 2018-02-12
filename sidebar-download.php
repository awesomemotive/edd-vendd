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
				echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) );
			?>
		</div>

		<?php if ( vendd_fes_is_activated() || apply_filters( 'vendd_show_single_download_author_details', false, $post ) ) { ?>
			<div class="widget widget_download_author">
				<?php
					$user       = new WP_User( $post->post_author );
					$vendor_url = '';
					if ( vendd_fes_is_activated() ) {
						$vendor_url = vendd_edd_fes_author_url( get_the_author_meta( 'ID', $post->post_author ) );
					}
				?>
				<?php if ( apply_filters( 'vendd_show_single_download_author_avatar', true, $post ) ) { ?>
					<span class="vendd-download-author">
						<?php if ( vendd_fes_is_activated() ) { ?>
							<a href="<?php echo $vendor_url; ?>">
								<?php echo get_avatar( $user->ID, 90 ); ?>
							</a>
						<?php } else { ?>
							<?php echo get_avatar( $user->ID, 90 ); ?>
						<?php } ?>
					</span>
				<?php } ?>
				<?php
					// only display store name if it exists and is set to show
					$vendor_store_name  = get_the_author_meta( 'name_of_store', $post->post_author );
					if ( apply_filters( 'vendd_show_single_download_store_name', true, $post ) && ! empty( $vendor_store_name ) ) {
						?>
						<span class="store-name-heading"><?php echo $vendor_store_name; ?></span>
						<?php
					}
				?>
				<ul class="vendd-details-list vendd-author-info">
					<?php if ( apply_filters( 'vendd_show_single_download_author_name', true, $post ) ) { ?>
						<li class="vendd-details-list-item vendd-author-details">
							<span class="vendd-detail-name"><?php _e( 'Author:', 'vendd' ); ?></span>
							<span class="vendd-detail-info">
								<?php if ( vendd_fes_is_activated() ) { ?>
									<a class="vendor-url" href="<?php echo $vendor_url; ?>">
										<?php echo $user->display_name; ?>
									</a>
								<?php } else { ?>
									<?php echo $user->display_name; ?>
								<?php } ?>
							</span>
						</li>
					<?php } ?>
					<?php if ( apply_filters( 'vendd_show_single_download_author_since', true, $post ) ) { ?>
						<li class="vendd-details-list-item vendd-author-details">
							<span class="vendd-detail-name"><?php _e( 'Author since:', 'vendd' ); ?></span>
							<span class="vendd-detail-info"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></span>
						</li>
					<?php } ?>
					<?php
						if ( apply_filters( 'vendd_show_single_download_author_links', true, $post ) ) {
							$store    = ! empty( $vendor_store_name ) ? $vendor_store_name : $user->display_name;
							$website  = get_the_author_meta( 'user_url', $post->post_author );
							$twitter  = get_the_author_meta( 'twitter_profile', $post->post_author );
							$gplus    = get_the_author_meta( 'gplus_profile', $post->post_author );
							$facebook = get_the_author_meta( 'facebook_profile', $post->post_author );
							$youtube  = get_the_author_meta( 'youtube_profile', $post->post_author );
							$social_profiles = array(
								'twitter'   => array(
									'id'    => 'twitter',
									'name'  => 'Twitter',
									'data'  => $twitter,
									'icon'  => '<i class="fa fa-twitter-square"></i>',
								),
								'gplus'	=> array(
									'id'	=> 'google-plus',
									'name'  => 'Google Plus',
									'data'  => $gplus,
									'icon'  => '<i class="fa fa-google-plus-square"></i>',
								),
								'facebook'  => array(
									'id'	=> 'facebook',
									'name'  => 'Facebook',
									'data'  => $facebook,
									'icon'  => '<i class="fa fa-facebook-square"></i>',
								),
								'youtube'   => array(
									'id'    => 'youtube',
									'name'  => 'YouTube',
									'data'  => $youtube,
									'icon'  => '<i class="fa fa-youtube-square"></i>',
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
															printf( '<a href="%1$s" class="vendd-social-profile vendd-%2$s" target="_blank" title="' . $store . ' - %3$s">%4$s</a>',
																esc_url( $profile['data'] ),
																$profile['id'],
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
												<a href="<?php echo $website; ?>" title="<?php echo $store . ' - ' . __( 'Homepage', 'vendd' ); ?>" class="vendd-social-profile vendd-website" target="_blank">
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
			</div>
		<?php } ?>

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
				<?php if ( vendd_fes_is_activated() || apply_filters( 'vendd_show_sales_in_sidebar', false, $post ) ) { ?>
					<li class="vendd-details-list-item">
						<?php $sales = apply_filters( 'vendd_download_sales_count', edd_get_download_sales_stats( $post->ID ), $post ); ?>
						<span class="vendd-detail-name"><?php _e( 'Sales:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $sales; ?></span>
					</li>
				<?php } ?>
				<?php if ( vendd_SL_is_activated() ) { ?>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $licensed = apply_filters( 'vendd_download_is_licensed', get_post_meta( get_the_ID(), '_edd_sl_enabled', true ), $post ); ?>
						<span class="vendd-detail-name"><?php _e( 'Licensed:', 'vendd' ); ?></span>
						<span class="vendd-detail-info"><?php echo $licensed ? __( 'Yes', 'vendd' ) : __( 'No', 'vendd' ); ?></span>
					</li>
					<li class="vendd-details-list-item vendd-license-details">
						<?php $version = apply_filters( 'vendd_download_version', get_post_meta( get_the_ID(), '_edd_sl_version', true ), $post ); ?>
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
