<?php

namespace Painwise\Views;

class OnePostView {
    public static function render($item) {
        $gotoUrl = empty($item->ExternalUrl) ? $item->Permalink : $item->ExternalUrl;

        ob_start();
        ?>
        <div class='post-item'>
            <h3><a href='<?= $gotoUrl; ?>'><?= esc_html($item->Title); ?></a></h3>

            <div class='the-excerpt'>
                <?= $item->Excerpt; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
