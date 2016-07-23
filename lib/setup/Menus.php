<?php

add_action('init', function() {
    register_nav_menu('primary_navigation', "Primary Navigation");
    register_nav_menu('topline_menu', "Top Line Menu");
    register_nav_menu('landing_pages_menu', "Landing Pages Menu");
    register_nav_menu('footer_menu', "Footer Menu");
    register_nav_menu('add_your_menu', "Add-Your Menu");
});

// output menu item descriptions if flag set
add_filter('walker_nav_menu_start_el', function($itemOutput, $item, $depth, $args) {
    if(empty($args->show_description)) return $itemOutput;

    $description = empty($item->description) ? "" : $item->description;

    ob_start();
    ?>
    <?= $itemOutput; ?>
    <div class='description'><?= esc_html($description); ?></div>
    <?php

    return ob_get_clean();
}, 10, 4);
