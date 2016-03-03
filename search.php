<?php
/**
 * The template for displaying search results pages.
 *
 * @package Vendd
 */
$advanced_search = get_theme_mod( 'vendd_advanced_search_results', 0 );
get_header(); ?>

	<section id="primary" class="content-area<?php echo $advanced_search ? ' advanced-search-content' : ''; ?>">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search results for: %s', 'vendd' ), '<span><strong>' . get_search_query() . '</strong></span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
				if ( ! $advanced_search ) :
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'content/content', 'search' );

					endwhile;
				else :
					get_template_part( 'content/content', 'advanced-search' );
				endif;
			?>

			<?php ! $advanced_search ? vendd_paging_nav() : ''; ?>

		<?php else : ?>

			<?php get_template_part( 'content/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php ! $advanced_search ? get_sidebar() : ''; ?>
<?php get_footer(); ?>
