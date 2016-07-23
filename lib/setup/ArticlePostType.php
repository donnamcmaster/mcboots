<?php

use Painwise\Article\ArticleRepository;

add_action('init', function() {
    register_post_type(ArticleRepository::WP_POST_TYPE,
        [
            'labels' => [
                'name' => 'Articles',
                'singular_name' => 'Article'
            ],
            'public' => true,
            'has_archive' => false,
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'thumbnail',
            ],
            'rewrite' => [
                'slug' => 'article',
            ],
        ]
    );

    flush_rewrite_rules();
});
