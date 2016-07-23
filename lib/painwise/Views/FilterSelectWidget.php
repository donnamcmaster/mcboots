<?php

namespace PainWise\Views;

class FilterSelectWidget {
    public static function render($apiUrl, $filters, $replaceSelector, $selectedItems=[]) {
        $renderOption = function($value, $title, $selectedValue=null) {
            $valueEsc = esc_html($value);
            $titleEsc = esc_html($title);
            $selected = ($selectedValue !== null && $value == $selectedValue) ? "selected=selected" : "";
            return "<option value='{$valueEsc}' {$selected}>{$titleEsc}</option>";
        };

        $hasNonEmptyOptions = function($options) {
            return !(count($options) == 1 && isset($options['']));
        };

        $renderSelect = function($paramName, $options) use ($renderOption, $selectedItems, $hasNonEmptyOptions) {
            // don't output if no options
            if(!$hasNonEmptyOptions($options)) return "";

            ob_start();
            ?>
            <div class='filter-select'>
                <select class='i-sel' name='<?= esc_html($paramName); ?>'>
                    <?php foreach($options as $value => $title) echo $renderOption($value, $title, isset($selectedItems[$paramName]) ? $selectedItems[$paramName] : null); ?>
                </select>
            </div>
            <?php
            return ob_get_clean();
        };

        ob_start();
        ?>
        <div
            class='filter-select-widget'
            data-api-url='<?= $apiUrl; ?>'
            data-replace-selector='<?= esc_html($replaceSelector); ?>'>

            <?php foreach($filters as $paramName => $options) echo $renderSelect($paramName, $options); ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
