<?php

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_style( 'mcboots/css', get_template_directory_uri() . '/assets/css/app.css', [], null );
    wp_enqueue_script( 'mcboots/js', get_template_directory_uri() . '/assets/js/app.js', [], null );
});
