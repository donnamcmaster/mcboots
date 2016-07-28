<?php

use Cully\Views\FilterSelectWidget;
use Cully\Article\ArticleRepository;
use Cully\Tools\Wordpress;

$categoryFilterOptions = ['' => 'All Categories'] + array_reduce(ArticleRepository::getAllCategories(), function($acc, $taxEntity) {
    return $acc + [$taxEntity->Id => $taxEntity->Name];
}, []);

$typeFilterOptions = ['' => 'All Types'] + array_reduce(ArticleRepository::getAllTypes(), function($acc, $taxEntity) {
    return $acc + [$taxEntity->Id => $taxEntity->Name];
}, []);

$filters = [
    "category" => $categoryFilterOptions,
    "type" => $typeFilterOptions,
];

?>

<div class='filters-by-fields filters-closed'>
    <button class='open-filters only-xs'><span>View Filters</span></button>
    <button class='close-filters only-xs'><span>Hide Filters</span></button>

    <h3>Filters</h3>

    <?= FilterSelectWidget::render(Wordpress::ajaxUrl("filter_articles"), $filters, '.articles', $_GET); ?>
</div>
