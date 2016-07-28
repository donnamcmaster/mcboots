<?php
/**
 * McBoots functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package McBoots
 */

call_user_func( function() {
    $setupScripts = [
        __DIR__ . "/lib/setup/config.php",
        __DIR__ . "/lib/setup/assets.php",
        __DIR__ . "/lib/setup/layout-wrapper.php",
        __DIR__ . "/lib/setup/menus.php",
        __DIR__ . "/lib/setup/body-class.php",

        __DIR__ . "/lib/setup/shortcodes.php",
    ];

    foreach ( $setupScripts as $setupScript ) {
        include_once( $setupScript );
    }
});
