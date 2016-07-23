<?php

use Painwise\Event\EventRepository;

add_action('init', function() {
    register_taxonomy(EventRepository::WP_EVENT_COUNTY_TAXONOMY, EventRepository::WP_EVENT_POST_TYPE, [
        'labels' => ['name' => 'Event Counties', 'singular_name' => 'Event County'],
        'rewrite' => ['slug' => 'county'],
        'hierarchical' => true,
        'capabilities' => [
            'assign_terms' => 'edit_posts',
            'edit_terms' => 'manage_categories',
        ],
    ]);
});
