<?php

// a couple of simple, handy shortcodes

add_shortcode( 'author', function( $atts, $content=null ) {
    ob_start();
    ?>
    <div class='author'>
        <span class='leader'>–</span> <span class='name'><?= empty( $atts['name'] ) ? "" : esc_html( $atts['name'] ); ?></span>
    </div>
    <?php

    return ob_get_clean();
});

add_shortcode( 'highlight', function( $atts, $content=null ) {
    ob_start();
    ?>
    <div class='highlight'>
        <?= $content; ?>
    </div>
    <?php

    return ob_get_clean();
});
