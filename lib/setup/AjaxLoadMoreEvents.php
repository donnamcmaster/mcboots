<?php

use Painwise\Event\EventRepository;
use Painwise\Views\OneEventView;
use Painwise\Tools\Wordpress;

add_action( 'wp_ajax_nopriv_load_more_events', function() {
    $pageRaw = empty($_GET['page']) ? 1 : (int) $_GET['page'];
    $numRaw = empty($_GET['num']) ? 1 : (int) $_GET['num'];

    $page = ($pageRaw <= 0) ? 1 : $pageRaw;
    $num = ($numRaw <= 0) ? Wordpress::getPostsPerPage() : $numRaw;

    $filters = array_filter($_REQUEST, function($key) { return in_array($key, EventRepository::getAcceptedFilterKeys()); }, ARRAY_FILTER_USE_KEY);
    $events = EventRepository::getUpcoming($num, $page, $filters);

    wp_send_json([
        "haveMore" => empty($events) ? false : EventRepository::haveMoreUpcoming($num, $page, $filters),
        "payload" => implode("", array_map(function($event) { return OneEventView::render($event); }, $events)),
    ]);
});
