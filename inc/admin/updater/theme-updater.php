<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package Vendd
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'Vendd_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new Vendd_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://easydigitaldownloads.com',
		'item_name' => 'Vendd',
		'theme_slug' => 'vendd',
		'version' => VENDD_VERSION,
		'author' => VENDD_AUTHOR,
		'download_id' => '', // Optional, used for generating a license renewal link
		'renew_url' => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => VENDD_NAME . _x( ' License', 'part of the WordPress dashboard Vendd menu title', 'vendd' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'vendd' ),
		'license-key'               => __( 'License Key', 'vendd' ),
		'license-action'            => __( 'License Action', 'vendd' ),
		'deactivate-license'        => __( 'Deactivate License', 'vendd' ),
		'activate-license'          => __( 'Activate License', 'vendd' ),
		'status-unknown'            => __( 'License status is unknown.', 'vendd' ),
		'renew'                     => __( 'Renew?', 'vendd' ),
		'unlimited'                 => __( 'unlimited', 'vendd' ),
		'license-key-is-active'     => __( 'License key is active.', 'vendd' ),
		'expires%s'                 => __( 'Expires %s.', 'vendd' ),
		'lifetime'                  => __( 'Lifetime License.', 'vendd' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'vendd' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'vendd' ),
		'license-key-expired'       => __( 'License key has expired.', 'vendd' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'vendd' ),
		'license-is-inactive'       => __( 'License is inactive.', 'vendd' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'vendd' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'vendd' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'vendd' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'vendd' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'vendd' )
	)
);
