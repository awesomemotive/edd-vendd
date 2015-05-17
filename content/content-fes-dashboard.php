<?php
/**
 * The template used for displaying the FES dashboard
 *
 * @package Vendd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="fes-dashboard-header">
		<?php
			if ( '' != get_theme_mod( 'vendd_fes_dashboard_title' ) ) {
				echo '<h1 class="entry-title">
						<span class="entry-title-primary">' .
							get_theme_mod( 'vendd_fes_dashboard_title' ) .
						'</span>';
						$subtitle = get_post_meta( get_the_ID(), '_subtitle', true );
						if ( class_exists( 'Subtitles' ) && ! empty( $subtitle ) ) {
							echo '<span class="entry-subtitle">' . $subtitle . '</span>';
						}
				echo '</h1>';
			} else {
				the_title( '<h1 class="entry-title">', '</h1>' );
			}
		?>
	</header><!-- .fes-dashboard-header -->
	<div class="entry-content fes-dashboard-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
