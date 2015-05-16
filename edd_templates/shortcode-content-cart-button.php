<?php
/**
 * hide purchase button behind a toggle button
 *
 * @package Vendd
 */
?>

<a class="product-link vendd-show-button" href="#"><i class="fa fa-plus-circle vendd-price-button-icon"></i></a>
<div class="vendd-price-button-container">
	<span class="vendd-price-button">
		<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
	</span>
</div>
