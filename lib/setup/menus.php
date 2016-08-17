<?php
/**
 *	Configure Navigation Menus
 *
 * @package McBoots
 */

add_action( 'init', function() {
    register_nav_menu( 'primary_navigation', 'Primary Navigation' );
    register_nav_menu( 'utility_menu', 'Utility Menu' );
    register_nav_menu( 'footer_menu', 'Footer Menu' );
});
