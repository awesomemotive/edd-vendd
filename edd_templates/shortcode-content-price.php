<?php if ( edd_has_variable_prices( get_the_ID() ) ) : ?>
	<span class="product-price"><?php _e( 'Starting at: ', 'vendd'); edd_price( get_the_ID() ); ?></span>					
<?php elseif ( '0' != edd_get_download_price( get_the_ID() ) && ! edd_has_variable_prices( get_the_ID() ) ) : ?>	
	<span class="product-price"><?php _e( 'Price: ', 'vendd' ); edd_price( get_the_ID() ); ?></span> 
<?php else : ?>
	<span class="product-price"><?php _e( 'Free Download','vendd' ); ?></span>
<?php endif;  ?>