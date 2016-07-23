<?php

namespace Painwise\Post;

class AttachmentRepository {
    /**
     * @param  int   $attachmentId
     * @return AttachmentEntity|null
     */
    public static function getOne($attachmentId) {
        $post = PostRepository::getOne($attachmentId);
        return $post ? self::createFromPost($post) : null;
    }

    private static function createFromPost(PostEntity $post) {
        $attachment = new AttachmentEntity();
        $attachment->Id = $post->Id;
        $attachment->Permalink = $post->Permalink;
        $attachment->DownloadUrl = wp_get_attachment_url($attachment->Id);

        return $attachment;
    }
}
