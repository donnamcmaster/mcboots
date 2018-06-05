<?php
/**
 * Wraps content of the template in layout.php.
 *
 * @package McBoots
 */

add_filter( 'template_include', function( $template ) {
    if ( empty( $template ) || !is_string( $template ) || !is_file( $template ) ) return $template;
    
    $layout = include locate_template( '/layout.php' );

    echo $layout( $template );

    // this will prevent wordpress from trying to include anything
    return false;
}, 109);
