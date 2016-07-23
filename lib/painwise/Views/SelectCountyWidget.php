<?php

namespace Painwise\Views;

use Painwise\Tools\Router;

class SelectCountyWidget {
    public static function render($explanationText, array $availableCounties, $selectedCountyKey=null) {
        ob_start();
        ?>
        <div class='select-county-widget'>
            <div class='explanation'><?= esc_html($explanationText); ?></div>
            <form method='post' action='<?= Router::getCurrentPageUrl(); ?>'>
                <select name='selected-county-key'>
                    <option value=''>Select your county</option>
                    <?= implode("", array_map(function($key, $name) use ($selectedCountyKey) {
                        $keyEsc = esc_html($key);
                        $nameEsc = esc_html($name);
                        $selected = ($selectedCountyKey && $selectedCountyKey === $key) ? "selected='selected'" : "";

                        return "<option {$selected} value='{$keyEsc}'>{$nameEsc}</option>";
                    }, array_keys($availableCounties), $availableCounties)); ?>
                </select>
                <button type='submit'>Save</button>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}
