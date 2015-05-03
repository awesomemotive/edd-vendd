<?php
/**
 * The "Products" tab for the FES Vendor Dashboard
 */
global $products;

if ( count( $products ) > 0 ) {
	echo EDD_FES()->dashboard->product_list_status_bar();
	foreach ( $products as $product ) :
	?>
		<div class="vendor-product clear">
			<div class="vendor-product-image">
				<?php echo get_the_post_thumbnail( $product->ID, array(150,150)); ?>
			</div>
			<div class="vendor-product-info">
				<h5 class="vendor-product-title">
					<span class="vendor-product-status"><?php echo EDD_FES()->dashboard->product_list_status($product->ID); ?> </span>
					<?php echo EDD_FES()->dashboard->product_list_title($product->ID); ?>
				</h5>
				<div class="vendor-product-details">
					<div class="vendor-product-info-group">
						<span class="vendor-product-label">
							<?php echo __( 'Price', 'vendd' ) . ': '; ?>
						</span>
						<span class="vendor-product-price">
							<?php echo EDD_FES()->dashboard->product_list_price($product->ID); ?>
						</span>
					</div>
					<div class="vendor-product-info-group">
						<span class="vendor-product-label">
							<?php echo __( 'Purchases', 'vendd' ) . ': '; ?>
						</span>
						<span class="vendor-product-sales">
							<?php echo EDD_FES()->dashboard->product_list_sales_esc($product->ID); ?>
						</span>
					</div>
					<div class="vendor-product-info-group">
						<span class="vendor-product-label">
							<?php echo __( 'Details', 'vendd' ) . ': '; ?>
						</span>
						<span class="vendor-product-status-details">
							<?php echo EDD_FES()->dashboard->product_list_date($product->ID); ?>
						</span>
					</div>
				</div>
				<div class="vendor-product-actions">
					<span class="vendor-product-action-links">
						<?php EDD_FES()->dashboard->product_list_actions($product->ID); ?>
					</span>
				</div>
			</div>
		</div>
		<?php
	do_action('fes-product-table-column-value');
	endforeach;
} else {
	echo sprintf( __('No %s found','vendd'),
		EDD_FES()->vendors->get_product_constant_name( $plural = true, $uppercase = false ) );
}

EDD_FES()->dashboard->product_list_pagination();