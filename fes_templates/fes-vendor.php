<?php
/**
 * Template Name: FES Vendor
 *
 * This page template is ready for use with EDD's [downloads] shortcode for single Vendors.
 *
 * @package Vendd
 */
 
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content/content', 'fes-vendor' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
