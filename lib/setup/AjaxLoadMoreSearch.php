<?php

use Painwise\Search\SearchRepository;
use Painwise\Views\OneSearchResultView;
use Painwise\Tools\Wordpress;

add_action( 'wp_ajax_nopriv_load_more_search', function() {
    $pageRaw = empty($_GET['page']) ? 1 : (int) $_GET['page'];
    $numRaw = empty($_GET['num']) ? 1 : (int) $_GET['num'];

    $page = ($pageRaw <= 0) ? 1 : $pageRaw;
    $num = ($numRaw <= 0) ? Wordpress::getPostsPerPage() : $numRaw;

    $searchQuery = empty($_GET['s']) ? null : $_GET['s'];

    if($searchQuery === null) {
        wp_send_json([
            "haveMore" => empty($items) ? false : SearchRepository::haveMore($page, $num, $searchQuery, $filters),
            "payload" => implode("", array_map(function($item) { return OneSearchResultView::render($item); }, $items)),
        ]);
    }

    $filters = array_filter($_REQUEST, function($key) { return in_array($key, SearchRepository::getAcceptedFilterKeys()); }, ARRAY_FILTER_USE_KEY);

    $items = SearchRepository::search($page, $num, $searchQuery, $filters);

    wp_send_json([
        "haveMore" => empty($items) ? false : SearchRepository::haveMore($page, $num, $searchQuery, $filters),
        "payload" => implode("", array_map(function($item) { return OneSearchResultView::render($item); }, $items)),
    ]);
});
