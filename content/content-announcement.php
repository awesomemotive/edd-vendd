<?php
/**
 * Simple Notices template
 */

// get the number of published notices
$count_notices = wp_count_posts( 'notices', 'readable' );
$published_noticed = $count_notices->publish;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'simple-notices/simple-notices.php' ) || is_plugin_active( 'simple-notices-pro/simple-notices.php' ) ) {
	if ( 0 != $published_noticed ) { // only output notices area if there are published notices ?>
		<div class="vendd-notifications">
			<i class="fa fa-bullhorn vendd-notifications-icon"></i>
			<?php do_action( 'vendd_announcement_hook' ); ?>
		</div>
		<?php
	}
}