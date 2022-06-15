<?php
/**
 * Filter Search Patch 
 */
global $wp_version;
$patches_array = array( '6.0' );
foreach( $patches_array as $patch ) {	
	if ( version_compare( $wp_version, $patch, '==' ) ) {
		require_once dirname( __FILE__ ) . '/' . $patch . '/patch.php';
	}
}