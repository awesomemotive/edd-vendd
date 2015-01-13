<?php
/**
 * site-wide announcement template
 */
?>

<?php if ( get_theme_mod( 'vendd_announcement' ) && ! vendd_is_checkout() ) : ?>
	<div class="announcement-area">
		<i class="fa fa-bullhorn announcement-icon"></i>
		<?php echo get_theme_mod( 'vendd_announcement_text' ); ?>
	</div>
<?php endif; ?>