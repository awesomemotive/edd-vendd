<?php
/**
 * The sidebar containing the single download widget area.
 *
 * If no widget is used, the sidebar will output a placeholder
 * download details area that copies the layout of the native
 * EDD "Download Details" widget and also the actual EDD
 * "Download Cart" widget.
 *
 * @package Vendd
 */
?>

<div id="secondary" class="widget-area" role="complementary">

	<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

		<div class="widget widget_edd_product_details">
			<span class="widget-title"><?php _e( 'Download Details', 'vendd' ); ?></span>
			<?php
				the_title( '<h3 class="download-title">', '</h3>' );
				echo edd_get_purchase_link( array( 'id' => get_the_ID() ) );
				$download_cats = get_the_term_list( $post->ID, 'download_category', '<span class="download-categories-title">' . __( 'Categories', 'vendd' ) . ':</span> ', ', ', '' );
				$download_tags = get_the_term_list( $post->ID, 'download_tag', '<span class="download-tags-title">' . __( 'Tags', 'vendd' ) . ':</span> ', ', ', '' );
			?>
			<p class="edd-meta">
				<?php
					echo ! empty( $download_cats ) ? '<span class="download-terms download-category-terms">' . $download_cats . '</span>' : '';
					echo ! empty( $download_tags ) ? '<span class="download-terms download-tag-terms">' . $download_tags . '</span>' : '';
				?>
			</p>
		</div>
		<?php the_widget( 'edd_cart_widget' ); ?>

	<?php endif; // end sidebar widget area ?>

</div><!-- #secondary -->