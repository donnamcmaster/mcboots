<?php

use Painwise\News\NewsRepository;

add_action('init', function() {
    register_taxonomy(NewsRepository::WP_CATEGORY_TAXONOMY, NewsRepository::WP_POST_TYPE, [
        'labels' => ['name' => 'News Categories', 'singular_name' => 'News Category'],
        'rewrite' => ['slug' => 'category'],
        'hierarchical' => true,
        'capabilities' => [
            'assign_terms' => 'edit_posts',
            'edit_terms' => 'manage_categories',
        ],
    ]);
});
