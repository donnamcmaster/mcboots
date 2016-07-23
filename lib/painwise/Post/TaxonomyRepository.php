<?php

namespace Painwise\Post;

class TaxonomyRepository {
    public static function getForPost($postId, $taxonomy) {
        $items = wp_get_post_terms($postId, $taxonomy);
        return array_map(function($item) { return self::wpTermToEntity($item); }, $items);
    }

    public static function getAll($taxonomy) {
        $items = get_terms($taxonomy);
        return array_map(function($item) { return self::wpTermToEntity($item); }, $items);
    }

    private static function wpTermToEntity(\WP_Term $term) {
        $entity = new TaxonomyEntity();

        $entity->Id = $term->term_id;
        $entity->Name = $term->name;
        $entity->Slug = $term->slug;

        return $entity;
    }
}
