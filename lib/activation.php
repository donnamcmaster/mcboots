<?php
/**
 *	Activation Options
 *
 * @package McBoots
 */

// set uploads path
add_action( 'admin_init', function() {
	update_option( 'uploads_use_yearmonth_folders', 0 );
	if ( !is_multisite() ) {
		update_option( 'upload_path', 'assets' );
	} else {
		update_option( 'upload_path', '' );
	}
});

