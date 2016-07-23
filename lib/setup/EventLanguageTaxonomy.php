<?php

use Painwise\Event\EventRepository;

add_action('init', function() {
    register_taxonomy(EventRepository::WP_EVENT_LANGUAGE_TAXONOMY, EventRepository::WP_EVENT_POST_TYPE, [
        'labels' => ['name' => 'Event Languages', 'singular_name' => 'Event Language'],
        'rewrite' => ['slug' => 'language'],
        'hierarchical' => true,
        'capabilities' => [
            'assign_terms' => 'edit_posts',
            'edit_terms' => 'manage_categories',
        ],
    ]);
});
