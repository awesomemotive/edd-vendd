<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Vendd
 */
?>
		</div><!-- .page-inner [content] -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="page-inner">
			<div class="site-info">
				<?php
					$site_info = get_bloginfo( 'description' ) . ' - ' . get_bloginfo( 'name' ) . ' &copy; ' . date( 'Y' );
					if ( '' != get_theme_mod( 'vendd_credits_copyright' ) ) :
						echo get_theme_mod( 'vendd_credits_copyright' );
					else :
						echo $site_info;
					endif;
				?>
			</div><!-- .site-info -->
		</div><!-- .page-inner [footer] -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
