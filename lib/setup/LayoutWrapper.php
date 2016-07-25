<?php

// wraps content of the template in layout.php
add_filter( 'template_include', function( $template ) {
    if( empty( $template ) || !is_string( $template ) || !is_file( $template ) ) return $template;

    $layout = include( get_template_directory() . '/layout.php' );

    ob_start();
    include( $template );
    $content = ob_get_clean();

    echo $layout( $content );

    // this will prevent wordpress from trying to include anything
    return false;
}, 109);
