<?php

namespace Painwise\Post;

class AttachmentEntity {
    public $Id;
    public $Permalink;
    public $DownloadUrl;

    public function getAsImgElement($size='full') {
        return wp_get_attachment_image($this->Id, $size);
    }
}
