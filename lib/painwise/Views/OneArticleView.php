<?php

namespace Painwise\Views;

use Painwise\Article\ArticleEntity;
use Painwise\Post\ThumbnailRepository;

class OneArticleView {
    public static function render(ArticleEntity $item) {
        $gotoUrl = empty($item->ExternalUrl) ? $item->Permalink : $item->ExternalUrl;
        $thumbnail = ThumbnailRepository::postHasThumbnail($item->Id)
            ? ThumbnailRepository::getPostThumbnail($item->Id, 'thumbnail')
            : null;

        ob_start();
        ?>
        <div class='article'>
            <?php if($thumbnail): ?>
                <div class='the-thumbnail'><img src='<?= $thumbnail->Url; ?>'></div>
            <?php endif; ?>
            <div class='content'>
                <h3><a href='<?= $gotoUrl; ?>'><?= esc_html($item->Title); ?></a></h3>

                <div class='the-excerpt'>
                    <?= $item->Excerpt; ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
