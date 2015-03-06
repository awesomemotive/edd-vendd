<?php
/**
 * Add Categories/Tags to [downloads] shortcode
 */
?>
<div class="downloads-footer">
	<div class="vendd-download-terms">
		<?php
			the_terms(
				$post->ID,
				'download_category',
				'<span class="download-categories-title"><i class="fa fa-archive"></i></span>',
				', ',
				''
			);
		?>
	</div>
	<div class="vendd-download-terms">
		<?php
			the_terms(
				$post->ID,
				'download_tag',
				'<span class="download-tags-title"><i class="fa fa-tags"></i></span>',
				', ',
				'' 
			);
		?>
	</div>
</div>