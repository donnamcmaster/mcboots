<?php

namespace Painwise\Views;

use Painwise\ContactForm\ContactFormEntity;

class ContactFormView {
    public static function render(ContactFormEntity $form) {
        return do_shortcode("[gravityform id={$form->Id}]");
    }
}
