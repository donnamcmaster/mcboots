<?php

namespace Painwise\Views;

use Painwise\Tools\Arr;
use Painwise\Tools\Wordpress;

class BreadcrumbsWidget {
    /**
     * @param CrumbEnitity[] $crumbs     Each post is a crumb.
     */
    public static function render(array $crumbs) {
        $lastCrumb = Arr::last($crumbs);

        // dont output the breadcrumbs if the only menu item is a root item
        if($lastCrumb->IsRoot) return "";

        $renderOption = function($crumb) {
            $titleEsc = esc_html($crumb->Title);
            $url = $crumb->Url;

            return "<div class='item'><a href='{$url}'>{$titleEsc}</a></div>";
        };

        $renderBackItem = function() use ($crumbs) {
            $back = Arr::secondLast($crumbs);

            return $back
                ? "<div class='crumb crumb-back'><a href='{$back->Url}'>" . esc_html($back->Title) . "</a></div>"
                : "";
        };

        $renderOne = function($crumb) use ($lastCrumb, $renderOption) {
            ob_start();

            // not the last item
            if($crumb->Id !== $lastCrumb->Id) {
            ?>
                <div class='crumb'><a href='<?= $crumb->Url; ?>'><?= esc_html($crumb->Title); ?></a></div>
            <?php
            }
            // only output the last item if we have some siblings, output as a dropdown select
            else if(!empty($crumb->Siblings)) {
            ?>
                <div class='crumb crumb-select'>
                    <div class='visible-item'>
                        <div class='item'>
                            <?= esc_html($crumb->Title); ?>
                        </div>
                    </div>
                    <div class='dropdown'>
                        <?= implode("", array_map($renderOption, $crumb->Siblings)); ?>
                    </div>
                </div>
            <?php
            }

            return ob_get_clean();
        };

        $sepIconUrl = Wordpress::assetUrl("dist/images/icons/icon-breadcrumbs-sep.svg");

        $sep = "<div class='crumb-sep'><img src='{$sepIconUrl}'></div>";

        ob_start();
        ?>
        <div class='breadcrumbs-widget no-xs'>
            <?= implode($sep, array_filter(array_map($renderOne, $crumbs))); ?>
        </div>

        <div class='breadcrumbs-widget only-xs'>
            <?= $renderBackItem(); ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
