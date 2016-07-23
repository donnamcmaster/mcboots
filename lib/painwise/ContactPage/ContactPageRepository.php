<?php

namespace Painwise\ContactPage;

use Painwise\Post\PostRepository;
use Painwise\Post\PostEntity;
use Painwise\Tools\Arr;

class ContactPageRepository {
    const WP_META_SELECTED_FORM_ID = "pw_contact_page_selected_form_id";

    public static function getOne($id, $getPreview=false, $previewUserId=0) {
        $post = PostRepository::getOne($id, $getPreview=false, $previewUserId=0);
        return $post ? self::getEntityFromPost($post) : null;
    }

    public static function getOneFromSlug($slug) {
        $post = PostRepository::getOneEntityFromGetPost(['name' => $slug]);
        return $post ? self::getEntityFromPost($post) : null;
    }

    private static function getEntityFromPost(PostEntity $post) {
        $entity = new ContactPageEntity();
        $entity->Id = $post->Id;
        $entity->Title = $post->Title;
        $entity->Content = $post->Content;
        $entity->ContentRaw = $post->ContentRaw;
        $entity->Excerpt = $post->Excerpt;
        $entity->Permalink = $post->Permalink;
        $entity->PostDate = $post->PostDate;

        $meta = get_post_meta($entity->Id);
        if(!empty($meta)) {
            $entity->SelectedFormId = Arr::getFirst($meta, self::WP_META_SELECTED_FORM_ID);
        }

        return $entity;
    }
}
