<?php
/*
 * facetwp.php
 */
?>

<div id="store-front">
	<div class="edd_downloads_list edd_download_columns_3">
		<?php while ( have_posts() ) : the_post(); ?>
			<div itemscope itemtype="http://schema.org/Product" class="edd_download" id="edd_download_<?php echo $post->ID; ?>">
				<div class="edd_download_inner">
					<?php
						edd_get_template_part( 'shortcode', 'content-image' );
						edd_get_template_part( 'shortcode', 'content-title' );
						edd_get_template_part( 'shortcode', 'content-excerpt' );
						edd_get_template_part( 'shortcode', 'content-price' );
						edd_get_template_part( 'shortcode', 'content-cart-button' );
					?>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>
