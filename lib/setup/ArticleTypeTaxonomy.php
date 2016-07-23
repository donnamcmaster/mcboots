<?php

use Painwise\Article\ArticleRepository;

add_action('init', function() {
    register_taxonomy(ArticleRepository::WP_TYPE_TAXONOMY, ArticleRepository::WP_POST_TYPE, [
        'labels' => ['name' => 'Article Types', 'singular_name' => 'Article Type'],
        'rewrite' => ['slug' => 'type'],
        'hierarchical' => true,
        'capabilities' => [
            'assign_terms' => 'edit_posts',
            'edit_terms' => 'manage_categories',
        ],
    ]);
});
