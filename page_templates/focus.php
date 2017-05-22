<?php
/**
 * Template name: Focus Page
 *
 * A full-width page template with a narrow, centered content column
 *
 * @package Vendd
 */

get_header(); ?>

	<div id="focus-page">

		<div id="focus-page-primary" class="focus-page-content-area">
			<main id="focus-page-main" class="focus-page-site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<section id="post-<?php the_ID(); ?>" <?php post_class( 'focus-page-section' ); ?>>
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
					</section><!-- #post-## -->

				<?php endwhile; // end of the loop. ?>

			</main><!-- #focus-page-main -->
		</div><!-- #focus-page-primary -->

	</div>

<?php get_footer(); ?>
