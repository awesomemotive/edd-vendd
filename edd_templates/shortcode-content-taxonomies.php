<?php
/**
 * Add Categories/Tags to [downloads] shortcode
 */

$download_categories = get_the_term_list( // get the download categories
	$post->ID,
	'download_category',
	'<span class="download-categories-title"><i class="fa fa-archive"></i></span>',
	', ',
	''
);
$download_tags = get_the_term_list( // get the download tags
	$post->ID,
	'download_tag',
	'<span class="download-categories-title"><i class="fa fa-tags"></i></span>',
	', ',
	''
);

if ( $download_categories || $download_tags ) {
	?>
	<div class="downloads-footer">
		<div class="vendd-download-terms">
			<?php echo $download_categories ?>
		</div>
		<div class="vendd-download-terms">
			<?php echo $download_tags ?>
		</div>
	</div>
	<?php
}
