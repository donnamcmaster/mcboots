<?php

add_action( 'tgmpa_register', function() {
    $plugins = [
        // ensure that Piklist plugin is installed
        [
            'name'      => 'Piklist',
            'slug'      => 'piklist',
            'required'  => true,
            'force_activation' => true,
        ],
        // Events Calendar Base
        [
            'name'              => 'The Events Calendar',
            'slug'              => 'the-events-calendar',
            'required'          => true,
            'force_activation'  => true,
        ],
        // Gravity Forms
        [
            'name'              => 'Gravity Forms',
            'slug'              => 'gravityforms',
            'required'          => true,
            'force_activation'  => true,
            'source'            => get_template_directory() . '/assets/plugins/gravityforms_2.0.2.zip',
        ],
    ];

    $config = [
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                    // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    ];

    tgmpa( $plugins, $config );
});
