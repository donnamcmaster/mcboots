<?php

namespace Painwise\Views;

class SubArticleView {
    public static function render($content) {
        ob_start();
        ?>
        <div class='article'><?= $content; ?></div>
        <?php
        return ob_get_clean();
    }
}
