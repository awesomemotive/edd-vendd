<?php
/**
 * The template used for displaying page content in fes-vendor.php
 *
 * @package Vendd
 */

if ( vendd_fes_is_activated() ) {

	// check to see if this is an actual vendor profile and if so, gather information
	if ( function_exists( 'fes_get_vendor' ) && false !== fes_get_vendor() ) {

		global $current_user;

		$the_vendor = get_query_var( 'vendor' );
		$the_vendor = get_user_by( 'slug', $the_vendor );

		if ( !$the_vendor ) {
			$the_vendor = new WP_User( get_current_user_id() );
		}

		$vendor_avatar = get_avatar( $the_vendor->ID, 100 );

		$is_vendor_profile = 'is-vendor-profile';
		?>

		<div class="vendor-header<?php echo empty( $is_vendor_profile ) ? '' : ' ' . $is_vendor_profile; ?>">
			<?php
			// output the vendor's avatar
			if ( !empty( $vendor_avatar ) ) {
				echo '<span class="vendor-avatar">' . $vendor_avatar . '</span>';
			}

			the_title( '<h1 class="vendor-store-title">', '</h1>' );

			// output the vendor's profile bio
			if ( !empty( $the_vendor->description ) ) {
				echo '<span class="vendor-bio">' . $the_vendor->description . '</span>';
			}

			// vendor's store name
			$store_name = get_user_meta( $the_vendor->ID, 'name_of_store', true );
			$store = !empty( $store_name ) ? $store_name : $the_vendor->display_name;

			// output vendor profiles
			$website = get_user_meta( $the_vendor->ID, 'user_url', true );
			$twitter = get_user_meta( $the_vendor->ID, 'twitter_profile', true );
			$gplus = get_user_meta( $the_vendor->ID, 'gplus_profile', true );
			$facebook = get_user_meta( $the_vendor->ID, 'facebook_profile', true );
			$youtube = get_user_meta( $the_vendor->ID, 'youtube_profile', true );
			$profiles = array( 'twitter' => array( 'id' => 'twitter', 'name' => 'Twitter', 'data' => $twitter, 'icon' => '<i class="fa fa-twitter-square"></i>', ), 'gplus' => array( 'id' => 'google-plus', 'name' => 'Google Plus', 'data' => $gplus, 'icon' => '<i class="fa fa-google-plus-square"></i>', ), 'facebook' => array( 'id' => 'facebook', 'name' => 'Facebook', 'data' => $facebook, 'icon' => '<i class="fa fa-facebook-square"></i>', ), 'youtube' => array( 'id' => 'youtube', 'name' => 'YouTube', 'data' => $youtube, 'icon' => '<i class="fa fa-youtube-square"></i>', ), 'url' => array( 'id' => 'website', 'name' => 'Homepage', 'data' => $website, 'icon' => '<i class="fa fa-home"></i>', ), );

			if ( !empty( $twitter ) || !empty( $gplus ) || !empty( $facebook ) || !empty( $youtube ) || !empty( $website ) ) {
				?>
				<div class="vendd-vendor-profiles">
					<?php
					foreach ( $profiles as $profile ) {
						if ( '' != $profile['data'] ) {
							?>
							<span class="vendd-contact-method">
									<?php
									printf( '<a href="%1$s" class="vendd-social-profile vendd-%2$s" target="_blank" title="' . $store . ' - %3$s">%4$s</a>', esc_url( $profile['data'] ), $profile['id'], $profile['name'], $profile['icon'] );
									?>
								</span>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
			?>
		</div><!-- .vendor-header -->
		<?php
	}
}
?>

<div id="vendd-vendor" <?php post_class(); ?>>
	<?php the_content(); ?>
</div><!-- .post-## -->
<?php
	if ( get_theme_mod( 'vendd_vendor_contact_form' ) ) {
		if ( function_exists( 'fes_get_vendor' ) && false !== fes_get_vendor() && $the_vendor ) {
			?>
			<div class="vendd-vendor-contact">
				<?php echo do_shortcode( '[fes_vendor_contact_form id=' . $the_vendor->ID . ']' ); ?>
			</div><!-- .vendd-vendor-contact -->
			<?php
		}
	}
?>
