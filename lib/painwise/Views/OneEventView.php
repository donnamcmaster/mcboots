<?php

namespace Painwise\Views;

use Painwise\Event\EventEntity;

class OneEventView {
    public static function render(EventEntity $event) {
        $renderCategory = function($category) {
            ?>
            <span class='category'><?= esc_html($category->Name); ?></span>
            <?php
        };

        ob_start();
        ?>
        <div class='event'>
            <h3><a href='<?= $event->Permalink; ?>'><?= esc_html($event->Title); ?></a></h3>
            <div class='details'>
                <span class='date'><?= $event->getStartDateHuman(); ?></span>
                <span class='time'><?= $event->getStartTimeHuman(); ?></span>
                <?php if($event->Location): ?>
                    <span class='place'><?= $event->Location->Name; ?></span>
                <?php endif; /* location */ ?>
            </div>

            <div class='the-excerpt'>
                <?= $event->Excerpt; ?>
            </div>

            <div class='categories'>
                <?php array_map($renderCategory, $event->Categories); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
