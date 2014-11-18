<?php
/**
 * The default template for download page content
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
				the_post_thumbnail( 'vendd_product_image', array( 'class' => 'featured-img' ) );
			endif; 
		?>
		<div class="widget product-info-wrapper">
			<div class="product-download-buy-button">
				<?php echo edd_get_purchase_link( array( 'id' => get_the_ID() ) ); ?>
			</div>
		</div>
		<?php the_content(); ?>
	</div>
</article>