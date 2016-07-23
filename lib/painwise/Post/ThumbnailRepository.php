<?php

namespace Painwise\Post;

class ThumbnailRepository {
    public static function postHasThumbnail($postId) { return has_post_thumbnail($postId); }

    public static function getPostThumbnail($postId, $sizeInfo='thumbnail') {
        if(!self::postHasThumbnail($postId)) return null;

        $thumbInfo = wp_get_attachment_image_src(get_post_thumbnail_id($postId), $sizeInfo);
        return $thumbInfo
            ?  ImageEntity::createFromWpAttachmentArray($thumbInfo)
            : null;
    }
}
