<?php
/**
 * Advanced search results template
 *
 * @package Vendd
 */
$last_type = '';
$typecount = 0;
$i = 1;

while ( have_posts() ) : the_post();
	if ( ! is_admin() && $last_type != $post->post_type ) :
		$typecount = $typecount + 1;

		// if there are at least two result types, close all containers but the last
		if ( $typecount > 1 ) :
			echo $last_type == 'download' ? '</div>' : '</ul>';
			echo '</div>';
		endif;

		// save the post type.
		$last_type = $post->post_type;

		// open type container
		switch ( $last_type ) :
			case 'post':
				?>
				<div class="vendd-post-search-results vendd-search-results-container">
					<span class="vendd-search-results-title">
						<?php echo ucfirst( $last_type ) . ' ' . __( 'Results:', 'vendd' ); ?>
					</span>
					<ul class="vendd-search-results-list">
				<?php
				break;
			case 'page':
				?>
				<div class="vendd-page-search-results vendd-search-results-container">
					<span class="vendd-search-results-title">
						<?php echo ucfirst( $last_type ) . ' ' . __( 'Results:', 'vendd' ); ?>
					</span>
					<ul class="vendd-search-results-list">
				<?php
				break;
			case 'download':
				?>
				<div id="store-front" class="vendd-download-search-results">
					<div class="edd_downloads_list edd_download_columns_3">
				<?php
				break;
		endswitch;
	endif;

	if ( 'download' == $last_type ) : // download results
		?>
		<div itemscope itemtype="http://schema.org/Product" class="edd_download" id="edd_download_<?php echo get_the_ID(); ?>" style="width: 33.03%; float: left;">
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
		<?php if ( $i % 3 == 0 ) { ?>
			<div style="clear:both;"></div>
		<?php } $i+=1;
	else : // post and page results
		?>
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
	endif;
endwhile;

// if there is only one post type result OR all three types, close the last container
if ( $typecount >= 2 || $typecount == 1 ) :
	echo $last_type == 'download' ? '</div>' : '</ul>';
	echo '</div>';
endif;
