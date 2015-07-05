<?php
/**
 * The default template part for displaying content lists.
 *
 * @package Vendd
 */
$last_type = '';
$typecount = 0;

while ( have_posts() ) : the_post();
	if ( ! is_admin() && $last_type != $post->post_type ) :
		$typecount = $typecount + 1;

		if ( $typecount > 1 ) :
			echo '</ul></div>'; // close type container
		endif;

		// save the post type.
		$last_type = $post->post_type;

		//open type container
		switch ( $post->post_type ) :
			case 'post':
				?>
				<div class="vendd-search-results-container">
					<span class="vendd-search-results-title"><?php echo ucfirst( $post->post_type ) . ' ' . __( 'Results:', 'vendd' ); ?></span>
					<ul class="vendd-search-results-list">
				<?php
				break;
			case 'page':
				?>
				<div class="vendd-search-results-container">
					<span class="vendd-search-results-title"><?php echo ucfirst( $post->post_type ) . ' ' . __( 'Results:', 'vendd' ); ?></span>
					<ul class="vendd-search-results-list">
				<?php
				break;
			case 'download':
				?>
				<div class="vendd-search-results-container">
					<span class="vendd-search-results-title"><?php echo edd_get_label_singular() . ' ' . __( 'Results:', 'vendd' ); ?></span>
					<ul class="vendd-search-results-list">
				<?php
				break;
		endswitch;
	endif;
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
endwhile;
