<?php

call_user_func(function() {
    $setupScripts = [
        __DIR__ . "/lib/setup/Config.php",
        __DIR__ . "/lib/setup/Autoload.php",
        __DIR__ . "/lib/setup/DependencyChecks.php",
        __DIR__ . "/lib/setup/Sessions.php",
        __DIR__ . "/lib/setup/Assets.php",
        __DIR__ . "/lib/setup/AdminSettings.php",
        __DIR__ . "/lib/setup/LayoutWrapper.php",
        __DIR__ . "/lib/setup/Menus.php",
        __DIR__ . "/lib/setup/PiklistTweaks.php",
        __DIR__ . "/lib/setup/PostSlugBodyClass.php",

        __DIR__ . "/lib/setup/MiscShortcodes.php",

        __DIR__ . "/lib/setup/HandleSelectCounty.php",
        __DIR__ . "/lib/setup/SelectedCountyShortcodes.php",

        __DIR__ . "/lib/setup/NewsPostType.php",
        __DIR__ . "/lib/setup/NewsCategoryTaxonomy.php",
        __DIR__ . "/lib/setup/AjaxLoadMoreNews.php",
        __DIR__ . "/lib/setup/AjaxFilterNews.php",

        __DIR__ . "/lib/setup/ArticlePostType.php",
        __DIR__ . "/lib/setup/ArticleCategoryTaxonomy.php",
        __DIR__ . "/lib/setup/ArticleTypeTaxonomy.php",
        __DIR__ . "/lib/setup/AjaxLoadMoreArticles.php",
        __DIR__ . "/lib/setup/AjaxFilterArticles.php",

        __DIR__ . "/lib/setup/EventLanguageTaxonomy.php",
        __DIR__ . "/lib/setup/EventCountyTaxonomy.php",
        __DIR__ . "/lib/setup/AjaxLoadMoreEvents.php",
        __DIR__ . "/lib/setup/AjaxFilterEvents.php",
        __DIR__ . "/lib/setup/AjaxFilterEventsFrontpage.php",

        __DIR__ . "/lib/setup/AjaxLoadMoreSearch.php",
    ];

    foreach ($setupScripts as $setupScript) {
        include_once($setupScript);
    }
});
