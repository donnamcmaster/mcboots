<?php

define('PAINWISE_VENDOR_BASE', realpath(__DIR__ . "/../../vendor"));

define('PW_TRIBE_EVENTS_POSTTYPE', class_exists("\Tribe__Events__Main")
    ? \Tribe__Events__Main::POSTTYPE
    : null);

define('PW_TRIBE_EVENTS_TAXONOMY', class_exists("\Tribe__Events__Main")
    ? \Tribe__Events__Main::TAXONOMY
    : null);

// makes the featured image box show up in custom post types
add_theme_support('post-thumbnails');

// tell wordpress to output the title tag
add_theme_support('title-tag');
