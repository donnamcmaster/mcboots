<?php

use Painwise\News\NewsRepository;

add_action('init', function() {
    register_post_type(NewsRepository::WP_POST_TYPE,
        [
            'labels' => [
                'name' => 'News',
                'singular_name' => 'News'
            ],
            'public' => true,
            // this allows us to have a page with slug 'news' as well
            'has_archive' => false,
            'supports' => [
                'title',
                'editor',
                'excerpt',
            ],
            'rewrite' => [
                'slug' => 'news',
            ],
        ]
    );

    flush_rewrite_rules();
});
