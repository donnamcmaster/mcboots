<?php

namespace Painwise\LandingPage;

use Painwise\Post\AttachmentRepository;
use Painwise\Post\PostRepository;
use Painwise\Post\PostEntity;
use Painwise\AdminSettings\AdminSettingsRepository;
use Painwise\Tools\Arr;
use Painwise\Tools\Wordpress;

class LandingPageRepository {
    const WP_META_FEATURED_ARTICLE_CONTENT = "pw_landing_page_featured_article_content";
    const WP_META_FEATURED_ARTICLE_IMAGE_IDS = "pw_landing_page_featured_article_image_ids";
    const WP_META_SUB_ARTICLES = "pw_landing_page_sub_articles";
    const WP_META_ALT_LANDING_PAGE_WIDGET_HERO_CONTENT = "pw_landing_page_alt_landing_page_widget_hero_content";

    public static function getWidgetEntity($currentPageId=null, $altHeroContent=null) {
        $adminSettings = AdminSettingsRepository::getAll();

        $entity = new LandingPageWidgetEntity();
        $entity->HeroContent = !empty($altHeroContent)
            ? $altHeroContent
            : (!empty($adminSettings->LandingPageWidgetHeroContent)
                ? $adminSettings->LandingPageWidgetHeroContent
                : null
            );

        $menuId = Wordpress::getMenuIdAtLocation("landing_pages_menu");

        if(!$menuId) return $entity;

        $menuItems = wp_get_nav_menu_items($menuId);
        $entity->PagesInfo = array_map(function(\WP_Post $navItem) use ($currentPageId) {
            return LandingPageWidgetEntity::buildPageInfoItem(
                $navItem->title,
                implode(" ", $navItem->classes),
                $navItem->description,
                $navItem->url,
                ($currentPageId !== null && $navItem->object === "page")
                    ? ((int)$navItem->object_id === (int)$currentPageId)
                    : false
            );
        }, $menuItems);

        return $entity;
    }

    public static function getOne($id, $getPreview=false, $previewUserId=0) {
        $post = PostRepository::getOne($id, $getPreview=false, $previewUserId=0);
        return $post ? self::createEntityFromPost($post) : null;
    }

    public static function getOneFromSlug($slug) {
        $post = PostRepository::getOneEntityFromGetPost(['name' => $slug]);
        return $post ? self::createEntityFromPost($post) : null;
    }

    public static function createEntityFromPost(PostEntity $post) {
        $entity = new LandingPageEntity();
        $entity->Id = $post->Id;
        $entity->Title = $post->Title;
        $entity->Content = $post->Content;
        $entity->ContentRaw = $post->ContentRaw;
        $entity->Excerpt = $post->Excerpt;
        $entity->Permalink = $post->Permalink;
        $entity->PostDate = $post->PostDate;

        $meta = get_post_meta($entity->Id);
        if(!empty($meta)) {
            $entity->AltLandingPageHeroContent = self::doWordpressStuffToItem($meta, self::WP_META_ALT_LANDING_PAGE_WIDGET_HERO_CONTENT);
            $entity->FeaturedArticleContent = self::doWordpressStuffToItem($meta, self::WP_META_FEATURED_ARTICLE_CONTENT);
            $entity->SubArticles = array_map(function($content) { return wpautop(do_shortcode($content)); }, Arr::get($meta, self::WP_META_SUB_ARTICLES, []));

            $featuredImageId = Arr::getFirst($meta, self::WP_META_FEATURED_ARTICLE_IMAGE_IDS);
            $entity->FeaturedArticleImage = $featuredImageId ? AttachmentRepository::getOne($featuredImageId) : null;
        }

        return $entity;
    }

    private static function doWordpressStuffToItem($meta, $key) {
        $content = Arr::getFirst($meta, $key);
        return $content ? wpautop(do_shortcode($content)) : $content;
    }
}
