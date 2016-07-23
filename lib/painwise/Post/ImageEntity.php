<?php

namespace Painwise\Post;

class ImageEntity {
    public $Url;
    public $Width;
    public $Height;

    public static function createFromWpAttachmentArray(array $info) {
        $image = new ImageEntity();
        $image->Url = isset($info['0']) ? $info['0'] : null;
        $image->Width = isset($info['1']) ? $info['1'] : null;
        $image->Height = isset($info['2']) ? $info['2'] : null;

        return $image;
    }
}
