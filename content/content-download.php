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
			// display featured image?
			if ( has_post_thumbnail() ) :
				$product_image = apply_filters( 'vendd_crop_product_image', true ) ? 'vendd_product_image' : 'full';
				the_post_thumbnail( $product_image, array( 'class' => 'featured-img' ) );
			endif;
			the_content();
		?>
	</div>
</article>
