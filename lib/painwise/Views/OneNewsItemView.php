<?php

namespace Painwise\Views;

use Painwise\News\NewsEntity;

class OneNewsItemView {
    public static function render(NewsEntity $item) {
        $gotoUrl = empty($item->ExternalUrl) ? $item->Permalink : $item->ExternalUrl;

        ob_start();
        ?>
        <div class='news-item'>
            <h3><a href='<?= $gotoUrl; ?>'><?= esc_html($item->Title); ?></a></h3>
            <h4 class='the-date'><?= esc_html($item->PostDate); ?></h4>

            <div class='the-excerpt'>
                <?= $item->Excerpt; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
