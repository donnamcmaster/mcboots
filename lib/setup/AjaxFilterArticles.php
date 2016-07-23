<?php

add_action( 'wp_ajax_nopriv_filter_articles', function() {
    $getPayload = function() {
        ob_start();
        get_template_part("partials/article-list");
        return ob_get_clean();
    };

    wp_send_json([
        "payload" => $getPayload(),
    ]);
});
