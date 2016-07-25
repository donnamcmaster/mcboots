<?php
/**
 * McBoots functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package McBoots
 */

call_user_func(function() {
    $setupScripts = [
        __DIR__ . "/lib/setup/Config.php",
        __DIR__ . "/lib/setup/Autoload.php",
        __DIR__ . "/lib/setup/Assets.php",
        __DIR__ . "/lib/setup/LayoutWrapper.php",
        __DIR__ . "/lib/setup/Menus.php",
        __DIR__ . "/lib/setup/PostSlugBodyClass.php",

        __DIR__ . "/lib/setup/MiscShortcodes.php",
    ];

    foreach ($setupScripts as $setupScript) {
        include_once($setupScript);
    }
});
