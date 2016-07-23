<?php

namespace Painwise\Views;

use Painwise\Views\OneEventView;
use Painwise\Views\OneArticleView;
use Painwise\Views\OneNewsItemView;
use Painwise\Views\OnePostView;

use Painwise\Event\EventEntity;
use Painwise\Article\ArticleEntity;
use Painwise\News\NewsEntity;

class OneSearchResultView {
    public static function render($item) {
        ob_start();
        ?>

        <div class='result'>

            <?php
            if($item instanceof EventEntity) echo OneEventView::render($item);
            else if($item instanceof ArticleEntity) echo OneArticleView::render($item);
            else if($item instanceof NewsEntity) echo OneNewsItemView::render($item);
            else if(is_object($item)) echo OnePostView::render($item);
            else echo "";
            ?>

        </div>

        <?php
        return ob_get_clean();
    }
}
