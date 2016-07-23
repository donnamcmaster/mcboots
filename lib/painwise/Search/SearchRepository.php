<?php

namespace Painwise\Search;

use Painwise\Post\PostRepository;
use Painwise\Page\PageRepository;
use Painwise\Event\EventRepository;
use Painwise\Article\ArticleRepository;
use Painwise\News\NewsRepository;
use Painwise\Tools\Pagination;

class SearchRepository {
    private static $filterKeys = ["pt"];

    public static function getAcceptedFilterKeys() { return self::$filterKeys; }

    public static function search($page, $num, $searchQuery, array $filters=[]) {
        $query = new \WP_Query(self::getArgs($page, $num, $searchQuery, $filters));

        return array_map(function($post) { return self::createEntityFromPost($post); }, $query->get_posts());
    }

    public static function getResultSummary($searchQuery) {
        $totalResults = self::getNumResults($searchQuery);
        $numArticleResults = self::numArticleResults($searchQuery);
        $numNewsResults = self::numNewsResults($searchQuery);
        $numEventResults = self::numEventResults($searchQuery);

        $numOtherResults = $totalResults
            - $numArticleResults
            - $numNewsResults;

        return [
            "total" => $totalResults,
            "events" => $numEventResults,
            "articles" => $numArticleResults,
            "news" => $numNewsResults,
            "other" => $numOtherResults,
        ];
    }

    public static function numPageResults($searchQuery) { $query = new \WP_Query(self::getArgs(1, -1, $searchQuery, ["pt" => PageRepository::WP_POST_TYPE])); return $query->found_posts; }
    public static function numArticleResults($searchQuery) { $query = new \WP_Query(self::getArgs(1, -1, $searchQuery, ["pt" => ArticleRepository::WP_POST_TYPE])); return $query->found_posts; }
    public static function numNewsResults($searchQuery) { $query = new \WP_Query(self::getArgs(1, -1, $searchQuery, ["pt" => NewsRepository::WP_POST_TYPE])); return $query->found_posts; }
    public static function numEventResults($searchQuery) { $query = new \WP_Query(self::getArgs(1, -1, $searchQuery, ["pt" => EventRepository::WP_EVENT_POST_TYPE])); return $query->found_posts; }

    public static function haveMore($page, $num, $searchQuery, array $filters=[]) {
        $query = new \WP_Query(self::getArgs($page+1, $num, $searchQuery, $filters));
        return ($query->found_posts > 0);
    }

    public static function getNumResults($searchQuery) {
        $query = new \WP_Query(self::getArgs(1, -1, $searchQuery));
        return $query->found_posts;
    }

    private static function getArgs($page, $num, $searchQuery, array $filters=[]) {
        return [
            's' => $searchQuery,
            'orderby'    => 'name',
            'order'      => 'ASC',
            'posts_per_page' => $num,
            'post_status' => 'publish',
            'offset' => Pagination::getOffset($num, $page),
        ]
        + (empty($filters['pt']) ? [] : ['post_type' => $filters['pt']]);
    }

    private static function createEntityFromPost(\WP_Post $post) {
        $postEntity = PostRepository::createEntityFromPost($post);

        switch($postEntity->PostType) {
            case PageRepository::WP_POST_TYPE: return PageRepository::createEntityFromPost($postEntity);
            case ArticleRepository::WP_POST_TYPE: return ArticleRepository::createEntityFromPost($postEntity);
            case NewsRepository::WP_POST_TYPE: return NewsRepository::createEntityFromPost($postEntity);
            // takes a WP_Post, not a PostEntity
            case EventRepository::WP_EVENT_POST_TYPE: return EventRepository::createEntityFromPost($post);
            default: return $postEntity;
        }
    }
}
