<?php
/**
 * replace the purchase button
 */

if ( vendd_is_store_front() ) { ?>
	<a class="product-link" href="<?php the_permalink(); ?>"><i class="fa fa-arrow-circle-right"></i></a>
	<?php
} else { ?>
	<div class="edd_download_buy_button">
		<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) ); ?>
	</div>
	<?php
}