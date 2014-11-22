<?php
/**
 * The sidebar containing the single download widget area.
 *
 * @package Vendd
 */
?>

<div id="secondary" class="widget-area" role="complementary">

	<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

		<div class="widget product-info-wrapper">
			<div class="product-sidebar-price">
				<span class="widget-title"><?php _e( 'Purchase this Item', 'vendd' ); ?></h3>	
			</div>	
			<div class="product-download-buy-button">
				<?php echo edd_get_purchase_link( array( 'id' => get_the_ID() ) ); ?>
			</div>
		</div>

	<?php endif; // end sidebar widget area ?>

</div><!-- #secondary -->