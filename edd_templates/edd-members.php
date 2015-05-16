<?php
/*
 * Template Name: EDD Members
 *
 * @package Vendd
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
	
				<?php get_template_part( 'content/content', 'members' ); ?>
	
			<?php endwhile; // end of the loop. ?>

		</main>
	</div>

<?php get_footer(); ?>
