<?php
/**
 * download archive template... matches the download taxonomy template
 *
 * all changes made here should also be made to the download taxonomy template
 * found at - templates/content-download-taxonomy.php
 */
$current_page = get_query_var( 'paged' );
$per_page = intval( get_theme_mod( 'vendd_store_front_count', 9 ) );
$offset = $current_page > 0 ? $per_page * ( $current_page-1 ) : 0;
$product_args = array(
	'post_type'			=> 'download',
	'posts_per_page'	=> $per_page,
	'offset'			=> $offset
);
$products = new WP_Query( $product_args );
?>

<div id="store-front">
	<?php if ( $products->have_posts() ) : $i = 1; ?>
		<div class="edd_downloads_list">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<div itemscope itemtype="http://schema.org/Product" class="edd_download" id="edd_download_<?php echo get_the_ID(); ?>" style="width: 33.3%; float: left;">
					<div class="edd_download_inner">
						<?php
							edd_get_template_part( 'shortcode', 'content-image' );
							edd_get_template_part( 'shortcode', 'content-title' );
							edd_get_template_part( 'shortcode', 'content-excerpt' );
							edd_get_template_part( 'shortcode', 'content-price' );
							edd_get_template_part( 'shortcode', 'content-cart-button' );
						?>
					</div>
				</div>
				<?php if ( $i % 3 == 0 ) { ?><div style="clear:both;"></div><?php } ?>
				<?php $i+=1; ?>
			<?php endwhile; ?>
		</div>
		<div style="clear:both;"></div>
		<?php if ( $products->max_num_pages > 1 ) : ?>		
			<div id="edd_download_pagination" class="store-pagination navigation">
				<?php 					
					$big = 999999999; // need an unlikely integer					
					echo paginate_links( array(
						'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'	=> '?paged=%#%',
						'current'	=> max( 1, $current_page ),
						'total'		=> $products->max_num_pages,
						'prev_text'	=> '<i class="fa fa-arrow-circle-left"></i> ' . __( 'Previous', 'vendd' ),
						'next_text'	=> __( 'Next', 'vendd' ) . ' <i class="fa fa-arrow-circle-right"></i>'
					) );
				?>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<div class="store-404">
			<h2 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'vendd' ); ?></h2>
			<p><?php _e( 'It looks like nothing was found at this location. Try using the search form below.', 'vendd' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>