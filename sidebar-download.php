<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Vendd
 */
?>

<div id="secondary" class="widget-area" role="complementary">
	<div class="widget product-info-wrapper">
		<div class="product-sidebar-price">
			<?php if ( edd_has_variable_prices( get_the_ID() ) ) : ?>
				<h3 class="widget-title"><?php _e( 'Starting at: ', 'vendd'); edd_price( get_the_ID() ); ?></h3>						
			<?php elseif ( '0' != edd_get_download_price( get_the_ID() ) && ! edd_has_variable_prices( get_the_ID() ) ) : ?>	
				<h3 class="widget-title"><?php _e( 'Price: ', 'vendd' ); edd_price( get_the_ID() ); ?></h3> 
			<?php else : ?>
				<h3 class="widget-title"><?php _e( 'Free','vendd' ); ?></h3>
			<?php endif; ?>
		</div>	
		<div class="product-download-buy-button">
			<?php echo edd_get_purchase_link( array( 'id' => get_the_ID() ) ); ?>
		</div>
	</div>
	<?php if ( is_active_sidebar( 'sidebar-download' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-download' ); ?>
	<?php endif; ?>	
</div><!-- #secondary -->