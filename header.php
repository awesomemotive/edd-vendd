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

	<?php if ( ! is_page_template( 'edd_templates/edd-checkout.php' ) ) { ?>
		<div id="info-bar" class="info-bar">
			<?php if ( '' != get_theme_mod( 'vendd_info_bar' ) ) : ?>
				<span class="info-bar-text"><?php echo get_theme_mod( 'vendd_info_bar' ); ?></span>
			<?php endif; ?>
	
			<?php if ( ! is_page_template( 'edd_templates/edd-checkout.php' ) ) { ?>
				<div id="info-bar-navigation" class="secondary-navigation" role="navigation">
					<?php
						wp_nav_menu( array(
							'theme_location'	=> 'info_bar',
							'menu_class'		=> 'info-bar-navigation',
							'fallback_cb'		=> '__return_false',
							'depth'				=> -1,
						) );
					?>
				</div><!-- #site-navigation -->
			<?php } ?>
		</div>
	<?php } ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<span class="site-title">
				<?php if ( ! is_page_template( 'edd_templates/edd-checkout.php' ) ) { ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php } ?>
					<?php if ( get_theme_mod( 'vendd_logo' ) ) : ?>
							<img src="<?php echo get_theme_mod( 'vendd_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php else : ?>
							<?php bloginfo( 'name' ); ?>
					<?php endif; ?>
				<?php if ( ! is_page_template( 'edd_templates/edd-checkout.php' ) ) { ?>
					</a>
				<?php } ?>
			</span>
			<?php if ( 1 != get_theme_mod( 'vendd_hide_tagline' ) ) : ?>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
		</div>
		
		<?php if ( class_exists( 'Easy_Digital_Downloads' ) && ! is_page_template( 'edd_templates/edd-checkout.php' ) ) : ?>
			<a href="<?php echo edd_get_checkout_uri(); ?>" class="header-cart">
				<i class="fa fa-shopping-cart"></i>
				<?php echo __( 'Cart total:', 'vendd' ) . ' '; ?>
				<span class="cart_item edd_subtotal">
					<span class="subtotal">
						<?php edd_cart_total(); ?>
					</span>
				</span>
			</a>
		<?php endif; ?>

		<?php if ( ! is_page_template( 'edd_templates/edd-checkout.php' ) ) { ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<span class="menu-toggle"><?php _e( 'Navigation', 'vendd' ); ?></span>
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

	<div id="content" class="site-content">
