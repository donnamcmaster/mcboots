<?php

namespace Painwise\Page;

use Painwise\Post\PostRepository;
use Painwise\Post\PostEntity;
use Painwise\Tools\Arr;

class PageRepository {
    const WP_POST_TYPE = 'page';
    const WP_META_SIDEBAR_CONTENT = "pw_page_sidebar_content";

    public static function getAll($num=-1, $page=1) {
        return array_map(function($post) { return self::createEntityFromPost($post); }, PostRepository::getAllByPostType(self::WP_POST_TYPE, $num, $page));
    }

    public static function getOne($postId, $getPreview=false, $previewUserId=0) {
        return self::createEntityFromPost(PostRepository::getOne($postId, $getPreview, $previewUserId));
    }

    public static function getOneFromSlug($slug) {
        return self::createEntityFromPost(PostRepository::getOneEntityFromGetPost([
            'post_type'  => 'page',
            'pagename' => $slug,
        ]));
    }

    public static function getHomePageId() {
        $page = self::getOneFromSlug("home");
        return ($page === null) ? null : $page->Id;
    }

    public static function createEntityFromPost(PostEntity $post) {
        if(!$post) return null;

        $entity = new PageEntity();
        $entity->Id = $post->Id;
        $entity->Title = $post->Title;
        $entity->Content = $post->Content;
        $entity->ContentRaw = $post->ContentRaw;
        $entity->Excerpt = $post->Excerpt;
        $entity->Permalink = $post->Permalink;
        $entity->PostDate = $post->PostDate;

        $meta = get_post_meta($entity->Id);
        if(!empty($meta)) {
            $entity->SidebarContent = self::doWordpressStuffToItem($meta, self::WP_META_SIDEBAR_CONTENT);
        }

        return $entity;
    }

    private static function doWordpressStuffToItem($meta, $key) {
        $content = Arr::getFirst($meta, $key);
        return $content ? wpautop(do_shortcode($content)) : $content;
    }
}
