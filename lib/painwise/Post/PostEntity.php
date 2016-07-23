<?php

namespace Painwise\Post;

class PostEntity {
    public $Id;
    public $Title;
    public $Content;
    public $ContentRaw;
    public $Excerpt;
    public $Permalink;
    public $PostDate;
    public $PostType;

    public function getContentShortcodedOnly() {
        return do_shortcode($this->ContentRaw);
    }

    public function getContentAutoPThenShortcoded() {
        return do_shortcode(wpautop($this->ContentRaw));
    }
}
