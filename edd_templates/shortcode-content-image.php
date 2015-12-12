<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
	<div class="edd_download_image">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php
				$product_image = apply_filters( 'vendd_crop_product_image', true ) ? 'vendd_product_image' : 'full';
				echo get_the_post_thumbnail( get_the_ID(), $product_image );
			?>
		</a>
	</div>
<?php endif; ?>
