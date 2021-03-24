<?php
/**
 * Advanced search results template
 *
 * @package Vendd
 */

if ( isset( $_GET['s'] ) ) :
	$download_args = array(
		'post_type'      => 'download',
		'posts_per_page' => -1,
		's'              => $_GET['s']
	);
	$download_results = new WP_Query( $download_args );
	$excerpt_length   = apply_filters( 'excerpt_length', 35 );
	$item_prop        = ! function_exists( 'edd_get_order' ) && edd_add_schema_microdata() ? ' itemprop="description"' : '';

	if ( ! empty( $download_results->post_count ) ) : ?>
		<div id="store-front" class="vendd-download-search-results">
			<div class="edd_downloads_list edd_download_columns_3">
				<?php
					foreach ( $download_results->posts as $index => $post ) : ?>
						<div itemscope itemtype="http://schema.org/Product" class="edd_download" id="edd_download_<?php echo $post->ID; ?>">
							<div class="edd_download_inner">
								<?php
									edd_get_template_part( 'shortcode', 'content-image' );
									edd_get_template_part( 'shortcode', 'content-title' );
									if ( has_excerpt() ) :
										?>
										<div<?php echo $item_prop; ?> class="edd_download_excerpt">
											<?php echo $post->post_excerpt; ?>
										</div>
										<?php
									else :
										?>
										<div<?php echo $item_prop; ?> class="edd_download_excerpt">
											<?php echo apply_filters( 'edd_downloads_excerpt', wp_trim_words( get_post_field( 'post_content', get_the_ID() ), $excerpt_length ) ); ?>
										</div>
										<?php
									endif;
									edd_get_template_part( 'shortcode', 'content-price' );
									edd_get_template_part( 'shortcode', 'content-cart-button' );
								?>
							</div>
						</div>
						<?php
					endforeach;
				?>
			</div>
		</div>
		<?php
	endif;
endif;

if ( isset( $_GET['s'] ) ) :
	$page_args = array(
		'post_type'      => 'page',
		'posts_per_page' => -1,
		's'              => $_GET['s']
	);
	$page_results = new WP_Query( $page_args );

	if ( ! empty( $page_results->post_count ) ) : ?>
		<div class="vendd-page-search-results vendd-search-results-container">
			<span class="vendd-search-results-title">
				<?php _ex( 'Page Results', 'advanced search results page search results title', 'vendd' ); ?>
			</span>
			<ul class="vendd-search-results-list">
				<?php
					foreach ( $page_results->posts as $index => $post ) : ?>
						<li class="vendd-search-result-item">
							<?php
								the_title( sprintf(
								'<span class="vendd-search-result">
									<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>
								</span>'
								);
							?>
						</li>
						<?php
					endforeach;
				?>
			</ul>
		</div>
		<?php
	endif;
endif;


if ( isset( $_GET['s'] ) ) :
	$post_args = array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		's'              => $_GET['s']
	);
	$post_results = new WP_Query( $post_args );

	if ( ! empty( $post_results->post_count ) ) : ?>
		<div class="vendd-post-search-results vendd-search-results-container">
			<span class="vendd-search-results-title">
				<?php _ex( 'Post Results', 'advanced search results post search results title', 'vendd' ); ?>
			</span>
			<ul class="vendd-search-results-list">
				<?php
					foreach ( $post_results->posts as $index => $post ) : ?>
						<li class="vendd-search-result-item">
							<?php
								the_title( sprintf(
								'<span class="vendd-search-result">
									<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>
								</span>'
								);
							?>
						</li>
						<?php
					endforeach;
				?>
			</ul>
		</div>
		<?php
	endif;
endif;
