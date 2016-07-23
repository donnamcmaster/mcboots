<?php

namespace Painwise\LandingPage;

class LandingPageWidgetEntity {
    public $HeroContent;

    /**
     * Array of arrays. See buildPageInfoItem for the format for each item.
     *
     * @var array
     */
    public $PagesInfo = [];

    public static function buildPageInfoItem($title, $titleClass, $description, $url, $isCurrentPage) {
        return [
            "Title" => $title,
            "TitleClass" => $titleClass, // used to set the icon
            "Description" => $description,
            "Url" => $url,
            "IsCurrentPage" => (bool) $isCurrentPage,
        ];
    }
}
