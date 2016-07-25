<?php

use Cully\Page\PageRepository;
use Cully\AdminSettings\AdminSettingsRepository;
use Cully\Tools\Wordpress;
use Cully\Tools\Router;

$homePage = PageRepository::getOne(PageRepository::getHomePageId());
$adminSettings = AdminSettingsRepository::getAll();

?>

<header>
    <div class='logo-nav-header'>
        <div class='header-logo'>
            <a href='<?= $homePage->Permalink; ?>'><img src='<?= Wordpress::assetUrl('dist/images/header-logo.svg'); ?>'></a>
        </div>

        <div class='navs'>
            <div class='topline no-xs'>
                <div class='search search-closed'>
                    <button></button>
                    <form action='<?= Router::getSearchUrl(); ?>' method='get'>
                        <input type='text' name='s' placeholder='Search'>
                    </form>
                </div><!-- .search -->
                <?php if (has_nav_menu('topline_menu')): ?>
                    <nav class='topline-menu'>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'topline_menu',
                            'container' => false,
                            'depth' => 1,
                        ]);
                        ?>
                    </nav>
                <?php endif; ?>
            </div><!-- .topline -->

            <div class='landing-and-primary-line'>
                <?php if (has_nav_menu('landing_pages_menu')): ?>
                    <nav class='landing-pages-menu no-xs'>
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'landing_pages_menu',
                            'container' => false,
                            'depth' => 1,
                        ]);
                        ?>
                    </nav>
                <?php endif; ?>

                <div class='primary-menu-wrapper'>
                    <?php if (has_nav_menu('primary_navigation')): ?>
                        <button class='open-menu'>Menu</button>

                        <nav class='primary-menu'>
                            <div class='search only-xs'>
                                <button></button>
                                <form action='<?= Router::getSearchUrl(); ?>' method='get'>
                                    <input type='text' name='s' placeholder='Search'>
                                </form>
                            </div><!-- .search -->

                            <button class='close-menu'></button>

                            <?php
                            wp_nav_menu([
                                'theme_location' => 'primary_navigation',
                                'container' => false,
                                'depth' => 2,
                            ]);
                            ?>

                        </nav>
                    <?php endif; ?>
                </div><!-- .primary-menu-wrapper -->
            </div><!-- .landing-and-primary-line -->
        </div><!-- .navs -->
    </div><!-- .logo-nav-header -->
</header>
