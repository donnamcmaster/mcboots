<?php

use Cully\Article\ArticleRepository;
use Cully\Tools\Wordpress;
use Cully\Tools\Arr;
use Cully\Views\OneArticleView;
use Cully\Views\LoadMoreWidget;

$filters = array_filter($_REQUEST, function($key) { return in_array($key, ArticleRepository::getAcceptedFilterKeys()); }, ARRAY_FILTER_USE_KEY);
$numPerPage = Wordpress::getPostsPerPage();
$items = ArticleRepository::getAll($numPerPage, 1, $filters);
$haveMore = ArticleRepository::haveMore($numPerPage, 1, $filters);

$loadMoreParams = Arr::allBut($_GET, ["action", "page", "num"]);

?>

<div class='articles'>
    <div class='items'>
        <?php if(empty($items)): ?>
            <p><em>No articles or videos.</em></p>
        <?php else: ?>
            <?= implode("", array_map(function($item) { return OneArticleView::render($item); }, $items)); ?>
        <?php endif; ?>
    </div>

    <?= $haveMore ? LoadMoreWidget::render("Show More", Wordpress::ajaxUrl("load_more_articles", $loadMoreParams), $numPerPage, '.articles .items') : ""; ?>
</div>
