<?php

use Cully\AdminSettings\AdminSettingsRepository;
use Cully\Page\PageRepository;
use Cully\Views\SocialShareWidget;
use Cully\Views\EmailSignupWidget;

$privacyPage = PageRepository::getOneFromSlug('privacy');
$homePage = PageRepository::getOneFromSlug('home');
$adminSettings = AdminSettingsRepository::getAll();

?>

<footer>
    <div class='f-con'>
        <div class='row'><div class='col100 mailing-list-wrapper'>
            <div class='mailing-list'>
                <h3>Get Email Updates</h3>

                <p>Stay up to date on the latest activities, events, and news.</p>

                <?= EmailSignupWidget::renderDefault(); ?>
            </div><!-- .mailing-list -->
        </div></div>
        <div class='row'>
            <?php if (has_nav_menu('footer_menu')): ?>
                <div class='col33'>
                    <nav class='footer-menu'>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'footer_menu',
                            'container' => false,
                            'depth' => 1,
                        ]);
                        ?>
                    </nav>
                </div>
            <?php endif; ?>

            <?php if (has_nav_menu('add_your_menu')): ?>
                <div class='col33'>
                    <nav class='add-your-menu'>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'add_your_menu',
                            'container' => false,
                            'depth' => 1,
                            'show_description' => true,
                        ]);
                        ?>
                    </nav>
                </div>
            <?php endif; ?>

            <div class='col33'>
                <div class='social'>
                    <h3>Share</h3>
                    <?= SocialShareWidget::render($homePage->Title, $homePage->Permalink); ?>
                </div>
            </div>
        </div><!-- .row -->

        <div class='row'><div class='col100'>
            <div class='legal'>
                <div class='copyright'><?= esc_html($adminSettings->getFormattedFooterCopyrightText()); ?></div>
                <?php if($privacyPage): ?>
                    <div class='privacy'><a href='<?= $privacyPage->Permalink; ?>'><?= esc_html($privacyPage->Title); ?></a></div>
                <?php endif; ?>
                <div class='rights'><?= esc_html($adminSettings->FooterRightsText); ?></div>
            </div>
        </div></div>
    </div><!-- .f-con -->
</footer>
