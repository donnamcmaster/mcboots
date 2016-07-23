<?php

namespace Painwise\Views;

use Painwise\Post\AttachmentEntity;
use Painwise\Page\PageRepository;
use Painwise\AdminSettings\AdminSettingsRepository;

class InfographicWidget {
    public static function render($content, $mobileContent, $buttonText, $destinationUrl, AttachmentEntity $infographicPreviewImage=null) {
        ob_start();
        ?>
        <div class='infographic-widget'>
            <div class='hero-content'>
                <div class='no-xs'>
                    <?= $content; ?>
                </div>
                <div class='only-xs'>
                    <?= $mobileContent; ?>
                </div>
                <div class='infographic-actions'>
                    <a class='btn' href='<?= $destinationUrl; ?>'><?= esc_html($buttonText); ?></a>
                </div>
            </div>
            <div class='preview-image'>
                <a href='<?= $destinationUrl; ?>'><?= $infographicPreviewImage ? $infographicPreviewImage->getAsImgElement() : ""; ?></a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public static function renderDefault() {
        $adminSettings = AdminSettingsRepository::getAll();
        $infographicDestPage = $adminSettings->InfographicDestinationPageId ? PageRepository::getOne($adminSettings->InfographicDestinationPageId) : null;
        $mobileContent = empty($adminSettings->InfographicContentMobile)
            ? $adminSettings->InfographicContent
            : $adminSettings->InfographicContentMobile;

        return $infographicDestPage
            ? self::render($adminSettings->InfographicContent, $mobileContent, $adminSettings->InfographicButtonText, $infographicDestPage->Permalink, $adminSettings->InfographicPreviewImage)
            : "";
    }
}
