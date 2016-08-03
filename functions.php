<?php
/**
 * McBoots functions and definitions.
 *
 * @package McBoots
 */

call_user_func( function() {
	$setupScripts = [
		'/lib/setup/config.php',
		'/lib/setup/assets.php',
		'/lib/setup/menus.php',
		'/lib/setup/sidebars.php',

		'/lib/layout-wrapper.php',
		'/lib/body-class.php',
		'/lib/shortcodes.php',
		'/lib/titles.php',
		'/lib/template.php',

		'/lib/views/base-views.php',
		'/lib/views/attachment-views.php',
		'/lib/views/page-views.php',
		'/lib/views/post-views.php',


//		'/lib/gallery.php',
    ];

	foreach ( $setupScripts as $setupScript ) {
		require_once locate_template( $setupScript );
	}
});
