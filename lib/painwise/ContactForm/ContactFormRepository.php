<?php

namespace Painwise\ContactForm;

class ContactFormRepository {
    public static function getAll() {
        return array_map(function($gravityForm) {
            return self::getEntityFromGravityForm($gravityForm);
        }, \GFAPI::get_forms());
    }

    public static function getOne($id) {
        $gravityForm = \GFAPI::get_form($id);

        return (!$gravityForm || $gravityForm instanceof \WP_Error)
            ? null
            : self::getEntityFromGravityForm($gravityForm);
    }

    public static function getEntityFromGravityForm(array $gravityForm) {
        $entity = new ContactFormEntity();

        $entity->Id = $gravityForm['id'];
        $entity->Title = $gravityForm['title'];

        return $entity;
    }
}
