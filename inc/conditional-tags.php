<?php
/**
 * Custom conditional tags for this theme.
 *
 * @package Vendd
 */


/**
 * Is EDD activated?
 *
 * @return bool
 */
function vendd_edd_is_activated() {
	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		return true;
	} else {
		return false;
	}
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