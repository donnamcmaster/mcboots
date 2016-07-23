<?php

use Painwise\County\CountyRepository;

/**
 * Content will be returned if we have a county set. Otherwise,
 * will return an empty string.
 *
 * If content is returned, will return do_shortcode() on it.
 */
add_shortcode('have_county', function($atts, $content=null) {
    return CountyRepository::hasSelectedCounty() ? do_shortcode($content) : "";
});

/**
 * Content will be returned if we DO NOT have a county set. If
 * a county is set, will return an empty string.
 */
add_shortcode('no_county', function($atts, $content=null) {
    return !CountyRepository::hasSelectedCounty() ? $content : "";
});

/**
 * Returns the name of the currently selected county. If none selected,
 * will return an empty string.
 */
add_shortcode('county', function($atts, $content=null) {
    return CountyRepository::hasSelectedCounty() ? CountyRepository::getSelectedCountyName() : "";
});
