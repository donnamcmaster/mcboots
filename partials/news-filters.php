<?php

use Cully\Views\FilterSelectWidget;
use Cully\News\NewsRepository;
use Cully\Tools\Wordpress;

$categoryFilterOptions = ['' => 'All News'] + array_reduce(NewsRepository::getAllCategories(), function($acc, $taxEntity) {
    return $acc + [$taxEntity->Id => $taxEntity->Name];
}, []);

$filters = [
    "category" => $categoryFilterOptions,
];

?>

<div class='filters-by-fields filters-closed'>
    <button class='open-filters only-xs'><span>View Filters</span></button>
    <button class='close-filters only-xs'><span>Hide Filters</span></button>

    <h3>Filters</h3>

    <?= FilterSelectWidget::render(Wordpress::ajaxUrl("filter_news"), $filters, '.news-items', $_GET); ?>
</div>
