<?php
/**
 * The "Orders" tab for the FES Vendor Dashboard
 *
 * @package Vendd
 */
global $orders;

if ( count( $orders ) > 0 ) {
	foreach ( $orders as $order ) :
		?>
		<div class="vendor-order clear">
			<div class="vendor-order-info">
				<h5 class="vendor-order-header">
					<span class="vendor-order-number">
						<?php echo EDD_FES()->dashboard->order_list_title( $order->ID ); ?>
					</span>
					<span class="vendor-order-status">
						<?php echo EDD_FES()->dashboard->order_list_status( $order->ID ); ?>
					</span>
				</h5>
				<div class="vendor-order-details">
					<div class="vendor-order-info-group">
						<span class="vendor-order-label">
							<?php echo _x( 'Price', 'FES vendor dashboard Order display', 'vendd' ) . ': '; ?>
						</span>
						<span class="vendor-order-price">
							<?php echo EDD_FES()->dashboard->order_list_total( $order->ID ); ?>
						</span>
					</div>
					<div class="vendor-order-info-group">
						<span class="vendor-order-label">
							<?php echo _x( 'Customer', 'FES vendor dashboard Order display', 'vendd' ) . ': '; ?>
						</span>
						<span class="vendor-order-customer">
							<?php echo EDD_FES()->dashboard->order_list_customer( $order->ID ); ?>
						</span>
					</div>
					<div class="vendor-order-info-group">
						<span class="vendor-order-label">
							<?php echo _x( 'Details', 'FES vendor dashboard Order display', 'vendd' ) . ': '; ?>
						</span>
						<span class="vendor-order-status-details">
							<?php echo EDD_FES()->dashboard->order_list_date( $order->ID ); ?>
						</span>
					</div>
				</div>
				<div class="vendor-order-actions">
					<span class="vendor-order-action-links">
						<?php EDD_FES()->dashboard->order_list_actions( $order->ID ); ?>
					</span>
				</div>
				<?php do_action( 'fes-order-table-column-value', $order ); ?>
			</div>
		</div>
		<?php
	endforeach;
} else {
	echo '<div>' . __( 'No orders found', 'vendd' ) . '</div>';
}

EDD_FES()->dashboard->order_list_pagination();
