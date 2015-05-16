<?php
/**
 * The template used for displaying page content in edd-downloads-shortcode.php
 *
 * If the Subtitles plugin is in use and a subtitle exists, it will display
 * below the store title whether it's the actual Page title or a custom
 * Store Front Title created in the customizer options.
 *
 * @package Vendd
 */
?>

<div class="store-front-header">
	<?php
		if ( '' != get_theme_mod( 'vendd_store_front_title' ) ) {
			echo '<h1 class="entry-title">
				<span class="entry-title-primary">' .
					get_theme_mod( 'vendd_store_front_title' ) .
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
</div><!-- .store-front-header -->
<div id="store-front" <?php post_class(); ?>>
	<?php the_content(); ?>
</div><!-- #post-## -->
