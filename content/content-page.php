<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Vendd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			// display featured image?
			if ( has_post_thumbnail() && 1 == get_theme_mod( 'vendd_page_featured_image', 0 ) ) :
				the_post_thumbnail( 'vendd_featured_image', array( 'class' => 'featured-img' ) );
			endif;

			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'vendd' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
