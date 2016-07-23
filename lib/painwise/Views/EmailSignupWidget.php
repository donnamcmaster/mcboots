<?php

namespace Painwise\Views;

use Painwise\County\CountyRepository;
use Painwise\AdminSettings\AdminSettingsRepository;

class EmailSignupWidget {
    public static function render($signupUrl, array $formFieldNames, array $counties, $selectedCounty=null) {
        $renderOption = function($value, $text, $selected) {
            $valueEsc = esc_html($value);
            $textEsc = esc_html($text);
            $selectedEsc = $selected ? "selected='selected'" : "";

            return "<option value='{$valueEsc}' {$selectedEsc}>{$textEsc}</option>";
        };

        $options = ["" => "Select County..."] + $counties;

        ob_start();
        ?>
        <div class='email-signup-widget widget-closed'>
            <form action='<?= $signupUrl; ?>' method='post'>
                <div class='initial-fields'>
                    <div class='i-field field-email'><input class='i-tex' name="<?= esc_html($formFieldNames['email']); ?>" type="email" placeholder="Email" required /></div>
                </div>
                <div class='other-fields'>
                    <div class='i-field field-name'><input class='i-tex' name="<?= esc_html($formFieldNames['name']); ?>" type="text" placeholder="Your Name" required /></div>
                    <div class='i-field field-county'>
                        <select class='i-sel' name='<?= $formFieldNames['county']; ?>'>
                            <?= implode("", array_map(function($key, $value) use ($selectedCounty, $renderOption) {
                                $selected = ($selectedCounty && $key == $selectedCounty);
                                return $renderOption($key, $value, $selected);
                            }, array_keys($options), $options)); ?>
                        </select>
                    </div>
                    <div class='i-field field-join'>
                        <button type='submit' class='btn btn-dark'>Join</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    public static function renderDefault() {
        $adminSettings = AdminSettingsRepository::getAll();

        $formFieldNames = [
            "name" => $adminSettings->EmailFieldName,
            "email" => $adminSettings->EmailFieldEmail,
            "county" => $adminSettings->EmailFieldCounty,
        ];

        return empty($adminSettings->EmailSignupUrl)
            ? ""
            : self::render($adminSettings->EmailSignupUrl, $formFieldNames, CountyRepository::getAvailableCounties(), CountyRepository::getSelectedCounty());
    }
}
