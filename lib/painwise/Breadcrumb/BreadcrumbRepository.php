<?php

namespace Cully\Breadcrumb;

use Cully\Post\PostRepository;
use Cully\Post\PostEntity;
use Cully\Page\PageRepository;
use Cully\Event\EventRepository;
use Cully\Article\ArticleRepository;
use Cully\News\NewsRepository;
use Cully\Tools\Wordpress;
use Cully\Tools\Tribe;
use Cully\Tools\Url;

class BreadcrumbRepository {
    public static function getCrumbsForPost($postId) {
        $menuItems = self::getMenuItems();
        $homeMenuItem = self::getMenuItemByObjectId(PageRepository::getHomePageId(), $menuItems);
        $postMenuItem = self::getMenuItemByObjectId($postId, $menuItems);

        // if this item isn't in the menu, there's still a chance it has
        // some applicable parents (e.g. Events, Articles, News)
        if(!$postMenuItem) {
            $entity = self::getEntityFromType($postId);

            if(!$entity) return [];

            $pathToRoot = self::getMenuItemsToRootFromType($postId, $homeMenuItem, $menuItems);

            return array_merge(
                [self::getEntityFromMenuItem($homeMenuItem)],
                array_map(function($x) { return self::getEntityFromMenuItem($x); }, $pathToRoot),
                [$entity]
            );
        }
        else {
            // no crumbs for Home page
            if($postMenuItem->ID === $homeMenuItem->ID) return [];

            // don't include siblings for root elements
            $postSiblings = self::menuItemHasParent($postMenuItem)
                ? self::getMenuItemSiblings($postMenuItem, $menuItems)
                : [];

            $pathToRoot = self::getMenuItemsToRoot($postMenuItem, $homeMenuItem, $menuItems, $postMenuItem);

            return array_merge(
                [self::getEntityFromMenuItem($homeMenuItem)],
                array_map(function($x) { return self::getEntityFromMenuItem($x); }, $pathToRoot),
                [self::getEntityFromMenuItem($postMenuItem, $postSiblings)]
            );
        }
    }

    private static function getEntityFromType($postId) {
        $post = PostRepository::getOne($postId);

        if(!$post) return null;

        switch($post->PostType) {
            case EventRepository::WP_EVENT_POST_TYPE:
            case ArticleRepository::WP_POST_TYPE:
            case NewsRepository::WP_POST_TYPE:
                $entity = new BreadcrumbEntity();
                $entity->Id = null;
                $entity->Title = $post->Title;
                $entity->Url = $post->Permalink;

                return $entity;
            default:
                return null;
        }
    }

    private static function getMenuItemsToRootFromType($postId, $homeMenuItem, array $menuItems) {
        $post = PostRepository::getOne($postId);

        if(!$post) return [];

        $postParent = self::getParentFromPost($post, $menuItems);

        if(!$postParent) return [];

        return self::getMenuItemsToRoot($postParent, $homeMenuItem, $menuItems);
    }

    private static function getParentFromPost(PostEntity $post, array $menuItems) {
        switch($post->PostType) {
            case EventRepository::WP_EVENT_POST_TYPE:
                return self::getEventsMenuItem($menuItems);
            case ArticleRepository::WP_POST_TYPE:
                return self::getArticlesMenuItem($menuItems);
            case NewsRepository::WP_POST_TYPE:
                return self::getNewsMenuItem($menuItems);
            default:
                return null;
        }
    }

    private static function getEventsMenuItem(array $menuItems) {
        return self::getMenuItemByUrl(Tribe::eventsUrl(), $menuItems);
    }

    private static function getArticlesMenuItem(array $menuItems) {
        $articlePage = PageRepository::getOneFromSlug("articles");
        return $articlePage
            ? self::getMenuItemByUrl($articlePage->Permalink, $menuItems)
            : null;
    }

    private static function getNewsMenuItem(array $menuItems) {
        $newsPage = PageRepository::getOneFromSlug("news");
        return $newsPage
            ? self::getMenuItemByUrl($newsPage->Permalink, $menuItems)
            : null;
    }

    private static function getMenuItemByUrl($url, array $menuItems) {
        $onePostArray = array_filter($menuItems, function($item) use ($url) {
            return Url::same($item->url, $url);
        });

        return empty($onePostArray)
            ? null
            : reset($onePostArray); // returns the first item of the array
    }

    /**
     * Will return an array of items, starting at $startItem, back up to root.  Will skip $skipItem, so if you
     * don't want to include the start item, make that the skip item.
     *
     * @param \WP_Post $startItem
     * @param \WP_Post $homeItem    We don't want to include the home item in this list, so we neeed to know what it is.
     * @param array $menuItems
     * @param \WP_Post $skipItem    Will not include this item in the path.
     */
    private static function getMenuItemsToRoot(\WP_Post $startItem, \WP_Post $homeItem, array $menuItems, \WP_Post $skipItem=null) {
        // at home
        if($startItem->ID === $homeItem->ID) return [];
        // at root
        if(!self::menuItemHasParent($startItem)) return ($skipItem && $skipItem->ID === $startItem->ID)
            ? []
            : [$startItem];

        $itemsFromParentToRoot = self::getMenuItemsToRoot(
            self::getMenuItemParent($startItem, $menuItems),
            $homeItem,
            $menuItems,
            $skipItem
        );

        // don't include the item if it's the skip item
        $currentItem = ($skipItem && $skipItem->ID === $startItem->ID)
            ? []
            : [$startItem];

        return array_merge($itemsFromParentToRoot, $currentItem);
    }

    private static function menuItemHasParent(\WP_Post $item) { return $item->menu_item_parent != 0; }
    private static function getMenuItemParent(\WP_Post $item, array $menuItems) {
        if(!self::menuItemHasParent($item)) return null;
        else return self::getMenuItemById($item->menu_item_parent, $menuItems);
    }

    private static function getMenuItemSiblings(\WP_Post $item, array $menuItems) {
        $parentId = $item->menu_item_parent;

        return array_filter($menuItems, function($x) use ($item, $parentId) {
            // include items with same parent. we want to include the current item too, so that the siblings list looks the same as the main menu list
            return $x->menu_item_parent === $parentId;
        });
    }

    /**
     * @param \WP_Post $item
     * @param \WP_Post[] $siblings
     *
     * @return BreadcrumbEntity
     */
    private static function getEntityFromMenuItem(\WP_Post $item, array $siblings = []) {
        $entity = new BreadcrumbEntity();
        $entity->Id = $item->ID;
        $entity->Title = $item->title;
        $entity->Url = $item->url;
        $entity->IsRoot = !self::menuItemHasParent($item);
        $entity->Siblings = array_map(function($x) { return self::getEntityFromMenuItem($x); }, $siblings);

        return $entity;
    }

    private static function getMenuItems() {
        $menuId = Wordpress::getMenuIdAtLocation("primary_navigation");
        return $menuId
           ? wp_get_nav_menu_items($menuId)
           : [];
    }

    private static function getMenuItemByObjectId($postId, array $menuItems) {
        $onePostArray = array_filter($menuItems, function($item) use ($postId) {
            return $item->object_id == $postId;
        });

        return empty($onePostArray)
            ? null
            : reset($onePostArray); // returns the first item of the array
    }

    private static function getMenuItemById($itemId, array $menuItems) {
        $onePostArray = array_filter($menuItems, function($item) use ($itemId) {
            return $item->ID == $itemId;
        });

        return empty($onePostArray)
            ? null
            : reset($onePostArray); // returns the first item of the array
    }
}
