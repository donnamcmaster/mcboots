<?php

namespace Cully\Tools;

class Wordpress {
    /**
     * Get url to an asset in the theme folder.
     *
     * @param string $relativeUrl   Relative path to the asset
     * @return string
     */
    public static function assetUrl($relativeUrl) {
        $templateUrl = get_bloginfo('template_directory');

        return
            preg_replace(";/$;", "", $templateUrl)
            . "/"
            . preg_replace(";^/;", "", $relativeUrl);
    }

    /**
     * Converts a WP week day to a PHP one
     */
    public static function wpWeekdayToPhp($wpStartOfWeek) {
        return ($wpStartOfWeek == 0) ? 7 : $wpStartOfWeek;
    }

    /**
     * Does not verify nonce.  Will just return $_GET['preview_id'] or null.
     *
     * @return int|null
     */
    public static function getPreviewId() {
        return empty($_GET['preview_id']) ? null : (int) $_GET['preview_id'];
    }

    public static function isPreview() {
        $previewId = self::getPreviewId();

        // wordpress doesn't think it's a preview
        if(!is_preview()) return false;

        // no preview_id
        if(empty($previewId) || empty(isset($_GET['preview_nonce']))) return false;

        // not logged in
        if(!is_user_logged_in()) return false;

        // can't edit this post
        if(!self::currentUserCanEditPost($previewId)) return false;

        // nonce not verified
        if(!wp_verify_nonce( $_GET['preview_nonce'], 'post_preview_' . $previewId )) return false;

        // all good!
        return true;
    }

    public static function ajaxUrl($action=null, $params=[]) {
        return admin_url('admin-ajax.php')
            . "?"
            . ($action ? "action=" . urlencode($action) . "&" : "")
            . implode("&", array_map(function($paramName) use ($params) {
                $paramValue = $params[$paramName];
                return urlencode($paramName) . "=" . urlencode($paramValue);
            }, array_keys($params)));
    }

    public static function currentUserCanEditPost($postId) {
        $post = get_post($postId);
        $currentUserId = get_current_user_id();

        if(empty($currentUserId)) return false;
        if(empty($post)) return false;

        if($post->post_type === "page") {
            $userCanEditOther = current_user_can( 'edit_others_pages', $postId );
        }
        else {
            $userCanEditOther = current_user_can( 'edit_others_posts', $postId );
        }

        return $userCanEditOther || $post->post_author == $currentUserId;
    }

    /**
     * Get the timezone set in Wordpress.
     *
     * @return \DateTimeZone
     */
    public static function getTimezone() {
        $timezoneStr = get_option('timezone_string');
        return !empty($timezoneStr) ? new \DateTimeZone($timezoneStr) : new \DateTimeZone("Etc/UTC");
    }

    /**
     * @param string $location The location name/id.
     * @return null|int
     */
    public static function getMenuIdAtLocation($location) {
        $locations = get_nav_menu_locations();
        return empty($locations[$location]) ? null : $locations[$location];
    }

    public static function getPostsPerPage() { return get_option('posts_per_page'); }
}
