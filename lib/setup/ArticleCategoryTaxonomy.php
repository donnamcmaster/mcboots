<?php

use Painwise\Article\ArticleRepository;

add_action('init', function() {
    register_taxonomy(ArticleRepository::WP_CATEGORY_TAXONOMY, ArticleRepository::WP_POST_TYPE, [
        'labels' => ['name' => 'Article Categories', 'singular_name' => 'Article Category'],
        'rewrite' => ['slug' => 'category'],
        'hierarchical' => true,
        'capabilities' => [
            'assign_terms' => 'edit_posts',
            'edit_terms' => 'manage_categories',
        ],
    ]);
});
