<?php

use Cully\News\NewsRepository;
use Cully\Tools\Wordpress;
use Cully\Tools\Arr;
use Cully\Views\OneNewsItemView;
use Cully\Views\LoadMoreWidget;

$filters = array_filter($_REQUEST, function($key) { return in_array($key, NewsRepository::getAcceptedFilterKeys()); }, ARRAY_FILTER_USE_KEY);
$numPerPage = Wordpress::getPostsPerPage();
$items = NewsRepository::getAll($numPerPage, 1, $filters);
$haveMore = NewsRepository::haveMore($numPerPage, 1, $filters);

$loadMoreParams = Arr::allBut($_GET, ["action", "page", "num"]);

?>

<div class='news-items'>
    <div class='items'>
        <?php if(empty($items)): ?>
            <p><em>No news items.</em></p>
        <?php else: ?>
            <?= implode("", array_map(function($item) { return OneNewsItemView::render($item); }, $items)); ?>
        <?php endif; ?>
    </div>

    <?= $haveMore ? LoadMoreWidget::render("Show More", Wordpress::ajaxUrl("load_more_news", $loadMoreParams), $numPerPage, '.news-items .items') : ""; ?>
</div>
