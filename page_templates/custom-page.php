<?php
/**
 * Template name: Front Page
 *
 * An optional front page template
 *
 * @package Vendd
 */

get_header(); ?>

	<div id="front-page-content" class="front-page-site-content">

		<div id="front-page-primary" class="front-page-content-area">
			<main id="front-page-main" class="front-page-site-main" role="main">
	
				<?php while ( have_posts() ) : the_post(); ?>
	
					<section class="front-page-section">
						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</header><!-- .entry-header -->
					
						<div class="entry-content">
							<?php the_content(); ?>
							<?php
								wp_link_pages( array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'vendd' ),
									'after'  => '</div>',
								) );
							?>
						</div><!-- .entry-content -->
					</section><!-- #post-## -->
	
				<?php endwhile; // end of the loop. ?>
				
				<section class="front-page-section">
					Testing
				</section>
				
				<section class="front-page-section">
					Testing 2
				</section>
				
				<section class="front-page-section">
					Testing 3
				</section>
	
			</main><!-- #main -->
		</div><!-- #primary -->

	</div>

<?php get_footer(); ?>
