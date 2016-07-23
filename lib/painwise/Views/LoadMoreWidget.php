<?php

namespace Painwise\Views;

class LoadMoreWidget {
    public static function render($buttonText, $apiUrl, $numPerPage, $appendToSelector) {
        ob_start();
        ?>
        <div class='load-more-widget'>
            <button
                class='btn btn-dark load-more-button'
                data-num-per-page='<?= esc_html($numPerPage); ?>'
                data-current-page='1'
                data-api-url='<?= $apiUrl; ?>'
                data-append-to-selector='<?= esc_html($appendToSelector); ?>'
                data-fetching='false'
                ><?= esc_html($buttonText); ?></button>
        </div>
        <?php
        return ob_get_clean();
    }
}
