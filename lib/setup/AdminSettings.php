<?php

use Painwise\AdminSettings\AdminSettingsRepository;

add_filter('piklist_admin_pages', function ($pages) {
    $pages []= [
        'page_title' => 'PainWise Settings',
        'menu_title' => 'PainWise Settings',
        'capability' => 'manage_options',
        'menu_slug' => AdminSettingsRepository::WP_ADMIN_SETTINGS_NAME,
        'setting' => AdminSettingsRepository::WP_ADMIN_SETTINGS_NAME,
        'menu_icon' => plugins_url('piklist/parts/img/piklist-icon.png'),
        'page_icon' => plugins_url('piklist/parts/img/piklist-page-icon-32.png'),
        'single_line' => true,
        'default_tab' => 'General',
        'save_text' => 'Save Settings',
    ];

    return $pages;
});
