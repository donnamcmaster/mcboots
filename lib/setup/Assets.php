<?php

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script("jquery");
    wp_enqueue_style("painwise/css", get_template_directory_uri() . "/dist/style/main.css", [], null);
    wp_enqueue_script("painwise/js", get_template_directory_uri() . "/dist/js/main.js", [], null);
});
