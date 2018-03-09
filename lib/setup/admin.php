<?php
/**
 *	Admin Functionality
 *	- this file is included only if is_admin()
 *
 * @package McBoots
 */

// soften post lock to post warning
add_filter( 'show_post_locked_dialog', '__return_false' );

add_filter( 'admin_init', function () {
	// block access to /wp-admin if current user can't edit 
	// (also check Ajax: http://pento.net/2011/06/19/preventing-users-from-accessing-wp-admin/)
	if ( !current_user_can( 'edit_posts' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( '/' );
        exit;
    }
});
	
