<?php if ( vendd_fes_is_activated() || apply_filters( 'vendd_show_downloads_byline', false ) ) { ?>
	<div class="edd_download_byline">
		<span class="edd_byline_author_avatar"><?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), 25, null ); ?></span>
		<span class="edd_byline_by"><?php _e( 'by', 'vendd' ) . ' '; ?></span>
		<?php if ( vendd_fes_is_activated() ) {
			$vendor_url         = vendd_edd_fes_author_url( get_the_author_meta( 'ID', $post->post_author ) );
			$vendor_name        = get_the_author_meta( 'display_name', $post->post_author );
			$vendor_store_name  = get_the_author_meta( 'name_of_store', $post->post_author );
			?>
			<span class="edd_byline_author">
				<a class="edd_byline_author_url" href="<?php echo $vendor_url; ?>">
					<?php echo ! empty( $vendor_store_name ) ? $vendor_store_name : $vendor_name; ?>
				</a>
			</span>
		<?php } else { ?>
			<span class="edd_byline_author">
				<?php echo get_the_author_meta( 'display_name', $post->post_author ); ?>
			</span>
		<?php } ?>
	</div>
<?php } ?>
<h3 itemprop="name" class="edd_download_title">
	<a title="<?php the_title_attribute(); ?>" itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</h3>
<?php
	if ( get_theme_mod( 'vendd_downloads_cats', 0 ) || get_theme_mod( 'vendd_downloads_tags', 0 ) ) {
		get_template_part( 'edd_templates/shortcode', 'content-taxonomies' );
	}
?>
