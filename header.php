<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Vendd
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'vendd' ); ?></a>

	<?php if ( ! vendd_is_checkout() ) { ?>
		<div id="info-bar" class="info-bar">
			<?php if ( '' != get_theme_mod( 'vendd_info_bar' ) ) : ?>
				<span class="info-bar-text"><?php echo get_theme_mod( 'vendd_info_bar' ); ?></span>
			<?php endif; ?>

			<?php if ( has_nav_menu( 'info_bar' ) ) { ?>
				<div id="info-bar-navigation" class="secondary-navigation" role="navigation">
					<?php
						wp_nav_menu( array(
							'theme_location'	=> 'info_bar',
							'menu_class'		=> 'info-bar-navigation',
							'fallback_cb'		=> '__return_false',
							'depth'				=> -1,
						) );
					?>
				</div><!-- #info-bar-navigation -->
			<?php } ?>
		</div>
	<?php } ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<span class="site-title">
				<?php echo ! vendd_is_checkout() || false === edd_get_cart_contents() ? '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' : ''; ?>
					<?php if ( get_theme_mod( 'vendd_logo' ) ) : ?>
							<img src="<?php echo get_theme_mod( 'vendd_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php else : ?>
							<?php bloginfo( 'name' ); ?>
					<?php endif; ?>
				<?php echo ! vendd_is_checkout() || false === edd_get_cart_contents() ? '</a>' : ''; ?>
			</span>
			<?php if ( 1 != get_theme_mod( 'vendd_hide_tagline' ) ) : ?>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
		</div>

		<?php if ( vendd_edd_is_activated() && ! vendd_is_checkout() ) : ?>
			<a href="<?php echo edd_get_checkout_uri(); ?>" class="header-cart">
				<i class="fa fa-shopping-cart"></i>
				<?php
					echo __( 'Cart total:', 'vendd' ) . ' ';
					edd_cart_total();
				?>
			</a>
		<?php endif; ?>

		<?php if ( ! vendd_is_checkout() && has_nav_menu( 'main_menu' ) ) { ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<span class="menu-toggle"><span class="vendd-menu-toggle-text"><?php _e( 'Menu', 'vendd' ); ?></span><i class="fa fa-bars vendd-menu-icon"></i></span>
				<?php
					wp_nav_menu( array(
						'theme_location'	=> 'main_menu',
						'menu_class'		=> 'clear',
						'fallback_cb'		=> '__return_false'
					) );
				?>
			</nav><!-- #site-navigation -->
		<?php } ?>

	</header><!-- #masthead -->

	<?php
		if ( vendd_simple_notices_is_activated() && ! vendd_is_checkout() ) {
			get_template_part( 'content/content', 'announcement' );
		}
	?>

	<div id="content" class="site-content">
