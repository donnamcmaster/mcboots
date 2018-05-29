<?php
/**
 * McBoots functions and definitions.
 *
 * @package McBoots
 */

call_user_func( function() {
	$setupScripts = [
		// initialization & configuration
		'/lib/setup/config.php',
		'/lib/setup/assets.php',
		'/lib/setup/images.php',
		'/lib/setup/menus.php',
		'/lib/setup/sidebars.php',

		// core template files
		'/lib/layout-wrapper.php',
		'/lib/body-class.php',
		'/lib/nav-walker.php',
		'/lib/titles.php',
		'/lib/template.php',
		'/lib/views.php',

		// extras
		'/lib/shortcodes.php',
		'/lib/gallery.php',
		
		// some options for initial activation
//		'/lib/activation.php',
    ];

	foreach ( $setupScripts as $setupScript ) {
		require_once locate_template( $setupScript );
	}

	if ( is_admin() ) {
		include_once locate_template( '/lib/setup/admin.php' );
	}
});
