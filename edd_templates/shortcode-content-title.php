<?php if ( vendd_fes_is_activated() ) { ?>
	<div class="edd_download_byline">
		<span class="edd_byline_author_avatar"><?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), 25, null ); ?></span>
		<span class="edd_byline_by"><?php _e( 'by', 'vendd' ) . ' '; ?></span>
		<span class="edd_byline_author">
			<a class="edd_byline_author_url" href="<?php echo vendd_edd_fes_author_url( get_the_author_meta( 'ID', $post->post_author ) ); ?>">
				<?php echo get_the_author_meta( 'display_name', $post->post_author ); ?>
			</a>
		</span>
	</div>
<?php } ?>
<h3 itemprop="name" class="edd_download_title">
	<a title="<?php the_title_attribute(); ?>" itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</h3>
<?php
	if ( 1 == get_theme_mod( 'vendd_downloads_taxonomies' ) ) {
		get_template_part( 'edd_templates/shortcode', 'content-taxonomies' );
	}
?>
