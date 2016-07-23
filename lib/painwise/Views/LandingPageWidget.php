<?php

namespace Painwise\Views;

use Painwise\LandingPage\LandingPageWidgetEntity;

class LandingPageWidget {
    public static function render(LandingPageWidgetEntity $entity) {
        $isOnlyTwo = count(array_filter($entity->PagesInfo, function($pageInfo) { return $pageInfo['IsCurrentPage']; })) > 0;

        $onlyTwoClass = $isOnlyTwo ? "only-two" : "";

        ob_start();
        ?>
        <div class='landing-page-widget'>
            <div class='hero-content'><div class='inner'><?= $entity->HeroContent; ?></div></div>
            <div class='landing-pages'>
                <?php array_map(function($pageInfo) use ($onlyTwoClass) {
                    if($pageInfo['IsCurrentPage']) return;

                    ?>
                    <a href='<?= $pageInfo['Url']; ?>' class='landing-page <?= $onlyTwoClass; ?> <?= $pageInfo['IsCurrentPage'] ? 'is-current-page' : 'not-current-page'; ?>'><div class='inner'>
                            <h4 class='<?= $pageInfo['TitleClass']; ?>'><?= esc_html($pageInfo['Title']); ?></h4>
                            <p><?= esc_html($pageInfo['Description']); ?></p>
                    </div></a>
                    <?php
                }, $entity->PagesInfo); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
