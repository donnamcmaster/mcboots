<?php

use Painwise\County\CountyRepository;
use Painwise\Tools\Router;

add_action('init', function() {
    if(isset($_POST['selected-county-key'])) {
        empty($_POST['selected-county-key'])
            ? CountyRepository::clearSelectedCounty()
            : CountyRepository::setSelectedCounty($_POST['selected-county-key']);

        Router::redirectSelf();
    }
});
