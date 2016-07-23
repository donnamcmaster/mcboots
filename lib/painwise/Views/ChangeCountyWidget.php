<?php

namespace Painwise\Views;

use Painwise\Tools\Router;

class ChangeCountyWidget {
    public static function render(array $availableCounties, $selectedCountyName, $selectedCountyKey) {
        ob_start();
        ?>
        <div class='change-county-widget'>
            <div class='current'>My location: <?= esc_html($selectedCountyName); ?> | <a class='change-county' href='#'>Change</a></div>

            <form class='item-hidden' method='post' action='<?= Router::getCurrentPageUrl(); ?>'>
                <div class='field-county'>
                    <select class='i-sel' name='selected-county-key'>
                        <option value=''>Select your county</option>
                        <?= implode("", array_map(function($key, $name) use ($selectedCountyKey) {
                            $keyEsc = esc_html($key);
                            $nameEsc = esc_html($name);
                            $selected = ($selectedCountyKey && $selectedCountyKey === $key) ? "selected='selected'" : "";

                            return "<option {$selected} value='{$keyEsc}'>{$nameEsc}</option>";
                        }, array_keys($availableCounties), $availableCounties)); ?>
                    </select>
                </div>
                <div class='field-save'>
                    <button class='btn' type='submit'>Save</button>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}
