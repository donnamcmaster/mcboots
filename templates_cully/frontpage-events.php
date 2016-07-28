<?php

use Cully\Event\EventRepository;
use Cully\County\CountyRepository;
use Cully\Views\OneEventView;
use Cully\Tools\Tribe;
use Cully\Tools\Wordpress;
use Cully\AdminSettings\AdminSettingsRepository;
use Cully\Views\FilterSelectWidget;

$adminSettings = AdminSettingsRepository::getAll();

$selectedCountyTaxId = !CountyRepository::hasSelectedCounty()
    ? null
    : array_reduce(EventRepository::getAllCounties(), function($acc, $taxEntity) {
        if(strtolower($taxEntity->Name) === strtolower(CountyRepository::getSelectedCountyName())) return $taxEntity->Id;
        else return $acc;
    }, null);

$filterVals = [
    "county" => empty($_REQUEST['county'])
        ? $selectedCountyTaxId
        : $_REQUEST['county']
];

$events = EventRepository::getUpcoming(3, 1, $filterVals);

$countyFilterOptions = ['' => 'All Locations'] + array_reduce(EventRepository::getAllCounties(), function($acc, $taxEntity) {
    // only show filters if they have upcoming events
    return EventRepository::countyHasUpcomingEvents($taxEntity->Id)
        ? $acc + [$taxEntity->Id => $taxEntity->Name]
        : $acc;
}, []);

$filterOptions = [
    "county" => $countyFilterOptions,
];

// the select county widget needs to float or go below the first <h3>, so squeeze it in there
$squeezeInSelectWidget = function($leaderContent, $widgetContent) {
    $didMatch = preg_match("/<\s*[hH]3\s*>/", $leaderContent);

    if($didMatch !== 1) return $widgetContent . $leaderContent;

    return preg_replace("|<\s*[hH]3\s*>.*?</\s*[hH]3\s*>|", "$0" . $widgetContent, $leaderContent, 1);
}

?>

<div class='leader'>
    <div class='only-xs'>
        <?= $squeezeInSelectWidget(
            $adminSettings->HomeEventsLeader,
            FilterSelectWidget::render(Wordpress::ajaxUrl("filter_events_frontpage", ["num" => 3]), $filterOptions, '.events .items .container', $filterVals)
        ); ?>
    </div>
    <div class='no-xs'>
        <?= FilterSelectWidget::render(Wordpress::ajaxUrl("filter_events_frontpage", ["num" => 3]), $filterOptions, '.events .items .container', $filterVals); ?>
        <?= $adminSettings->HomeEventsLeader; ?>
    </div>
</div>

<div class='items'>
    <?php if(empty($events)): ?>
        <p><em>No upcoming events.</em></p>
    <?php else: ?>
        <div class='container'>
            <?= implode("", array_map(function($event) { return OneEventView::render($event); }, $events)); ?>
        </div>
        <p><a class='btn btn-xs100' href='<?= Tribe::eventsUrl(); ?>'>See More Events</a></p>
    <?php endif; ?>
</div>
