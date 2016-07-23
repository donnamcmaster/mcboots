<?php

use Painwise\Event\EventRepository;
use Painwise\Views\OneEventView;
use Painwise\Tools\Wordpress;

add_action( 'wp_ajax_nopriv_filter_events', function() {
    $eventDisplay = empty($_GET['eventDisplay']) ? null : $_GET['eventDisplay'];

    $getListPayload = function() {
        ob_start();
        get_template_part("partials/events-list-just-the-list");
        return ob_get_clean();
    };

    $getMonthPayload = function() {
        ob_start();
        get_template_part("partials/events-calendar-just-the-calendar");
        return ob_get_clean();
    };

    wp_send_json([
        "payload" => $eventDisplay == 'month' ? $getMonthPayload() : $getListPayload(),
    ]);
});
