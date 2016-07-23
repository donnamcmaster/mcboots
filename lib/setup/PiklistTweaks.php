<?php

add_action("init", function() {
    // fixes a problem where piklist and Wordpress' default custom fields interfere. C.f.:
    // https://piklist.com/support/topic/field-values-not-updating/
    remove_post_type_support('page', 'custom-fields');
});
