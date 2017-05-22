<?php
/**
 * Template name: Full-width Page
 *
 * A single column, full-width page template
 *
 * @package Vendd
 */

get_header(); ?>

	<div id="full-width-page">

		<div id="full-width-page-primary" class="full-width-page-content-area">
			<main id="full-width-page-main" class="full-width-page-site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<section id="post-<?php the_ID(); ?>" <?php post_class( 'full-width-page-section' ); ?>>
						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php
								// display featured image?
								if ( has_post_thumbnail() && 1 == get_theme_mod( 'vendd_page_featured_image', 0 ) ) :
									the_post_thumbnail( 'vendd_featured_image_full_width', array( 'class' => 'featured-img featured-img-full-width' ) );
								endif;

								the_content();

								wp_link_pages( array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'vendd' ),
									'after'  => '</div>',
								) );
							?>
						</div><!-- .entry-content -->
					</section><!-- #post-## -->

				<?php endwhile; // end of the loop. ?>

			</main><!-- #full-width-page-main -->
		</div><!-- #full-width-page-primary -->

	</div>

<?php get_footer(); ?>
