<?php

return function($content) {
    ob_start();
    ?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part( 'partials/head' ); ?>
  <body <?php body_class(); ?>>
    <?php
      do_action( 'get_header' );
      get_template_part( 'partials/header' );
    ?>

    <main>
      <?= $content; ?>
    </main>

    <?php
      do_action( 'get_footer' );
      get_template_part( 'partials/footer' );
      wp_footer();
    ?>
  </body>
</html>

    <?php
    return ob_get_clean();
};
