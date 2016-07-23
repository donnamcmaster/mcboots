<?php

namespace Painwise\News;

use Painwise\Post\PostRepository;
use Painwise\Post\PostEntity;
use Painwise\Post\TaxonomyRepository;
use Painwise\Tools\Arr;

class NewsRepository {
    const WP_POST_TYPE = 'pw_news';
    const WP_CATEGORY_TAXONOMY = "pw_news_category";

    const WP_META_EXTERNAL_URL = 'pw_news_external_url';
    const WP_META_EXTRA_TEXT = 'pw_news_extra_text';

    private static $acceptedFilterKeys = ["category"];

    public static function getAcceptedFilterKeys() { return self::$acceptedFilterKeys; }

    public static function getAll($num=-1, $page=1, $filters=[]) {
        return array_map(
            function($post) { return self::createEntityFromPost($post); },
            PostRepository::getAllByPostType(self::WP_POST_TYPE, $num, $page, self::getTaxQueryFromFilters($filters))
        );
    }

    private static function getTaxQueryFromFilters($filters) {
        // if we don't do this, we could end up with a 'tax_query' with an array with one empty array element
        // and wordpress isn't smart enough to figure out that shouldn't contribute to the query
        $filtersWithValues = array_filter($filters, function($filterVal) { return !empty($filterVal); });

        if(empty($filtersWithValues)) return [];

        return array_merge(['relation' => 'AND']
            ,(empty($filtersWithValues['category'])
                ? []
                : [[
                    'taxonomy' => self::WP_CATEGORY_TAXONOMY,
                    'field' => 'term_id',
                    'terms' => $filtersWithValues['category'],
                ]])
        );
    }

    public static function getOne($postId, $getPreview=false, $previewUserId=0) {
        return self::createEntityFromPost(PostRepository::getOne($postId, $getPreview, $previewUserId));
    }

    public static function haveMore($num, $page, $filters=[]) {
        return PostRepository::haveMoreByPostType(self::WP_POST_TYPE, $num, $page, self::getTaxQueryFromFilters($filters));
    }

    public static function getAllCategories() { return TaxonomyRepository::getAll(self::WP_CATEGORY_TAXONOMY); }

    public static function createEntityFromPost(PostEntity $post) {
        $entity = new NewsEntity();
        $entity->Id = $post->Id;
        $entity->Title = $post->Title;
        $entity->Content = $post->Content;
        $entity->ContentRaw = $post->ContentRaw;
        $entity->Excerpt = $post->Excerpt;
        $entity->Permalink = $post->Permalink;
        $entity->PostDate = $post->PostDate;

        // categories

        $entity->Categories = TaxonomyRepository::getForPost($entity->Id, self::WP_CATEGORY_TAXONOMY);

        // meta

        $meta = get_post_meta($entity->Id);
        if(!empty($meta)) {
            $entity->ExternalUrl = Arr::getFirst($meta, self::WP_META_EXTERNAL_URL);
            $entity->ExtraText = Arr::getFirst($meta, self::WP_META_EXTRA_TEXT);
        }

        return $entity;
    }
}
