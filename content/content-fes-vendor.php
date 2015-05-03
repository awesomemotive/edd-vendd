<?php
/**
 * The template used for displaying page content in fes-vendor.php
 *
 * @package Vendd
 */

// check to see if this is an actual vendor profile and if so, gather information
if ( function_exists( 'fes_get_vendor' ) && false !== fes_get_vendor() ) {
	
	global $current_user;
	
	$the_vendor = get_query_var( 'vendor' );
	$the_vendor = get_user_by( 'slug', $the_vendor );
	
	if ( ! $the_vendor ) {
		$the_vendor = new WP_User( get_current_user_id() );
		$is_vendor_profile = '';
	}
	
	$vendor_avatar = get_avatar( $the_vendor->ID, 100 );
	
	$is_vendor_profile = 'is-vendor-profile';
}
?>

<div class="vendor-header<?php echo empty( $is_vendor_profile ) ? '' : ' ' . $is_vendor_profile; ?>">
	<?php
		// output the vendor's avatar
		if ( ! empty( $vendor_avatar ) ) {
			echo '<span class="vendor-avatar">' . $vendor_avatar . '</span>';
		}

		the_title( '<h1 class="vendor-store-title">', '</h1>' );

		// output the vendor's profile bio
		if ( ! empty( $the_vendor->description ) ) {
			echo '<span class="vendor-bio">' . $the_vendor->description . '</span>';
		}
	?>
</div><!-- .vendor-header -->
<div id="vendd-vendor" <?php post_class(); ?>>
	<?php the_content(); ?>
</div><!-- #post-## -->