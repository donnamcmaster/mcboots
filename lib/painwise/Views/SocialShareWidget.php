<?php

namespace Cully\Views;

use Cully\Tools\Wordpress;
use Cully\AdminSettings\AdminSettingsRepository;

class SocialShareWidget {
    public static function render($pageTitle, $pageUrl) {
        $adminSettings = AdminSettingsRepository::getAll();

        ob_start();
        ?>
        <div class='social-share-widget'>
            <?= self::renderTwitter($adminSettings->TwitterShareUrl, $pageTitle, $pageUrl); ?>
            <?= self::renderFacebook($adminSettings->TwitterShareUrl, $pageTitle, $pageUrl); ?>
            <?= self::renderLinkedin($adminSettings->TwitterShareUrl, $pageTitle, $pageUrl); ?>
        </div>
        <?php
        return ob_get_clean();
    }

    private static function renderFacebook($shareUrlRaw, $pageTitle, $pageUrl) {
        return self::renderOne(
            Wordpress::assetUrl("dist/images/icons/icon-facebook.svg"),
            self::processShareUrl($shareUrlRaw, $pageTitle, $pageUrl),
            "facebook"
        );
    }

    private static function renderTwitter($shareUrlRaw, $pageTitle, $pageUrl) {
        return self::renderOne(
            Wordpress::assetUrl("dist/images/icons/icon-twitter.svg"),
            self::processShareUrl($shareUrlRaw, $pageTitle, $pageUrl),
            "twitter"
        );
    }

    private static function renderLinkedin($shareUrlRaw, $pageTitle, $pageUrl) {
        return self::renderOne(
            Wordpress::assetUrl("dist/images/icons/icon-linkedin.svg"),
            self::processShareUrl($shareUrlRaw, $pageTitle, $pageUrl),
            "twitter"
        );
    }

    private static function processShareUrl($shareUrlRaw, $pageTitle, $pageUrl) {
        return str_replace("{{title}}", urlencode($pageTitle),
            str_replace("{{url}}", urlencode($pageUrl), $shareUrlRaw)
        );
    }

    private static function renderOne($iconUrl, $linkUrl, $className='') {
        return empty($linkUrl)
            ? ""
            : "<span class='social-item {$className}'><a href='{$linkUrl}'><img src='{$iconUrl}'></a></span>";
    }
}
