<?php
/**
 * McBoots functions and definitions.
 *
 * @package McBoots
 */

call_user_func( function() {
    $setupScripts = [
        __DIR__ . "/lib/setup/config.php",
        __DIR__ . "/lib/setup/assets.php",
        __DIR__ . "/lib/setup/menus.php",
        __DIR__ . "/lib/setup/sidebars.php",

        __DIR__ . "/lib/layout-wrapper.php",
        __DIR__ . "/lib/body-class.php",
        __DIR__ . "/lib/shortcodes.php",
        __DIR__ . "/lib/titles.php",
        __DIR__ . "/lib/template.php",
        
        __DIR__ . "/lib/views/base-views.php",
        __DIR__ . "/lib/views/attachment-views.php",
        __DIR__ . "/lib/views/page-views.php",
        __DIR__ . "/lib/views/post-views.php",

//        __DIR__ . "/lib/gallery.php",
    ];

    foreach ( $setupScripts as $setupScript ) {
        include_once( $setupScript );
    }
});
