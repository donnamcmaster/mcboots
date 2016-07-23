<?php

use Painwise\Article\ArticleRepository;
use Painwise\Views\OneArticleView;
use Painwise\Tools\Wordpress;

add_action( 'wp_ajax_nopriv_load_more_articles', function() {
    $pageRaw = empty($_GET['page']) ? 1 : (int) $_GET['page'];
    $numRaw = empty($_GET['num']) ? 1 : (int) $_GET['num'];

    $page = ($pageRaw <= 0) ? 1 : $pageRaw;
    $num = ($numRaw <= 0) ? Wordpress::getPostsPerPage() : $numRaw;

    $filters = array_filter($_REQUEST, function($key) { return in_array($key, ArticleRepository::getAcceptedFilterKeys()); }, ARRAY_FILTER_USE_KEY);
    $items = ArticleRepository::getAll($num, $page, $filters);

    wp_send_json([
        "haveMore" => empty($items) ? false : ArticleRepository::haveMore($num, $page, $filters),
        "payload" => implode("", array_map(function($item) { return OneArticleView::render($item); }, $items)),
    ]);
});
