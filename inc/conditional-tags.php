<?php
/**
 * Custom conditional tags for this theme.
 *
 * @package Vendd
 */


/*--------------------------------------------------------------
>>> General Vendd
--------------------------------------------------------------*/

/**
 * Is it a landing page template?
 *
 * @return bool
 */
function vendd_is_landing_page() {
	if ( is_page_template( 'page_templates/landing.php' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Is it a full-width page template?
 *
 * @return bool
 */
function vendd_is_full_width_page() {
	if ( is_page_template( 'page_templates/full-width.php' ) ) {
		return true;
	} else {
		return false;
	}
}


/*--------------------------------------------------------------
>>> Easy Digital Downloads
>>> https://easydigitaldownloads.com/
--------------------------------------------------------------*/

/**
 * Is EDD activated?
 *
 * @return bool
 */
function vendd_edd_is_activated() {
	return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Is it the EDD checkout page?
 *
 * @return bool
 */
function vendd_is_checkout() {
	if ( is_page_template( 'edd_templates/edd-checkout.php' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Is it the EDD Store Front template?
 *
 * @return bool
 */
function vendd_is_store_front() {
	if ( is_page_template( 'edd_templates/edd-store-front.php' ) ) {
		return true;
	} else {
		return false;
	}
}


/*--------------------------------------------------------------
>>> Frontend Submissions for Easy Digital Downloads
>>> https://easydigitaldownloads.com/extensions/frontend-submissions/
--------------------------------------------------------------*/

/**
 * Is FES activated?
 *
 * @return bool
 */
function vendd_fes_is_activated() {
	return class_exists( 'EDD_Front_End_Submissions' );
}

/**
 * Is it the FES Vendor Dashboard?
 *
 * @return bool
 */
function vendd_is_fes_dashboard() {
	if ( is_page_template( 'fes_templates/fes-dashbaord.php' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Is it the FES Vendor Template?
 *
 * @return bool
 */
function vendd_is_fes_vendor_template() {
	if ( is_page_template( 'fes_templates/fes-vendor.php' ) ) {
		return true;
	} else {
		return false;
	}
}


/*--------------------------------------------------------------
>>> Software Licensing for Easy Digital Downloads
>>> https://easydigitaldownloads.com/extensions/software-licensing/
--------------------------------------------------------------*/

/**
 * Is Software Licensing activated?
 *
 * @return bool
 */
function vendd_SL_is_activated() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (
		is_plugin_active( 'edd-software-licensing/edd-software-licenses.php' ) ||
		is_plugin_active( 'EDD-Software-Licensing/edd-software-licenses.php' )
	) {
		return true;
	} else {
		return false;
	}
}