<?php
/**
 * The default template for download page content
 *
 * @package Vendd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<div class="entry-content">
		<?php
			// display featured image? if not, display default featured image?
			if (  1 == get_theme_mod( 'vendd_product_featured_image', 1 ) ) :
				if ( has_post_thumbnail() ) :
					$product_image = apply_filters( 'vendd_crop_product_image', true ) ? 'vendd_product_image' : 'full';
					the_post_thumbnail( $product_image, array( 'class' => 'featured-img' ) );
				elseif ( get_theme_mod( 'vendd_product_image_upload' ) && get_theme_mod( 'vendd_product_image' ) ) :
					?>
					<img class="featured-img" src="<?php echo get_theme_mod( 'vendd_product_image_upload' ); ?>" alt="<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>">
					<?php
				endif;
			endif;
			the_content();
		?>
	</div>
</article>
