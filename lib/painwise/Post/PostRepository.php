<?php

namespace Painwise\Post;

use Painwise\Tools\Pagination;

class PostRepository {
    const WP_POST_TYPE = 'post';

    /**
     * @param   int     $num
     * @param   int     $page
     * @return PostEntity[]
     */
    public static function getAll($num=-1, $page=1) {
        return self::getAllByPostType(self::WP_POST_TYPE, $num, $page);
    }

    /**
     * @param   int     $num
     * @param   int     $page
     * @param   string  $postType
     * @param   array   $filters
     * @return PostEntity[]
     */
    public static function getAllByPostType($postType, $num=-1, $page=1, $taxQuery=null) {
        $args = self::getAllArgs($num, $page, $postType, $taxQuery);
        return self::getEntitiesFromGetPost($args);
    }

    public static function haveMore($num, $page) {
        $args = self::getAllArgs($num, $page+1);
        $query = new \WP_Query( $args );
        return ($query->found_posts > 0);
    }

    public static function haveMoreByPostType($postType, $num, $page, $taxQuery=null) {
        $args = self::getAllArgs($num, $page+1, $postType, $taxQuery);
        $query = new \WP_Query($args);
        return ($query->found_posts > 0);
    }

    private static function getAllArgs($num, $page, $postType=self::WP_POST_TYPE, $taxQuery=null) {
        return [
            'post_type'  => $postType,
            'orderby'    => 'name',
            'order'      => 'ASC',
            'posts_per_page' => $num,
            'post_status' => 'publish',
            'offset' => Pagination::getOffset($num, $page),
        ]
        + ($taxQuery ? ['tax_query' => $taxQuery] : []);
    }

    public static function getEntitiesFromGetPost($args) {
        $posts = [];

        $wpPosts = get_posts($args);

        foreach($wpPosts as $wpPost) {
            $posts []= self::createEntityFromPost($wpPost);
        }

        return $posts;
    }

    /**
     * @param array $args
     * @return null|PostEntity
     */
    public static function getOneEntityFromGetPost(array $args) {
        $posts = self::getEntitiesFromGetPost($args);

        if(count($posts) === 0) return null;
        else return $posts[0];
    }

    /**
     * @param \WP_Post  $postInfo
     * @param int|null  $parentPostId    If this is a preview, then provide the paren't page's id
     * (really only used to fetch the featured image)
     * @return PostEntity
     */
    public static function createEntityFromPost($postInfo=null, $parentPostId=null) {
        $thePost = new PostEntity();

        if($postInfo) {
            $thePost->Id = $postInfo->ID;
            $thePost->Title = $postInfo->post_title;
            $thePost->ContentRaw = $postInfo->post_content;
            $thePost->Content = wpautop(do_shortcode($postInfo->post_content));
            $thePost->Excerpt = $postInfo->post_excerpt;
            $thePost->Permalink = get_permalink($thePost->Id);
            $thePost->PostDate = get_the_date('', $thePost->Id);
            $thePost->PostType = get_post_type($thePost->Id);
        }
        else {
            $thePost->Id = get_the_ID();
            $thePost->Title = get_the_title();
            $thePost->Content = get_the_content();
            $thePost->Excerpt = get_the_excerpt();
            $thePost->Permalink = get_the_permalink();
            $thePost->PostDate = get_the_date();
            $thePost->PostType = get_post_type();
        }

        return $thePost;
    }

    /**
     * @param $postId
     * @param bool $getPreview  Get the preview info instead of the active info.
     * @param int  $previewUserId   If getting a preview, provide the author's id.
     * @return PostEntity|null
     */
    public static function getOne($postId, $getPreview=false, $previewUserId=0) {
        if(empty($postId)) return null;

        if($getPreview) {
            $postInfo = wp_get_post_autosave($postId, $previewUserId);
        }
        else {
            $postInfo = get_post($postId);
        }

        if(!$postInfo) return null;

        $parentPostId = $getPreview ? $postId : null;

        $thePost = self::createEntityFromPost($postInfo, $parentPostId);

        return $thePost;
    }

    /**
     * @param $slug
     * @return PostEntity|null
     */
    public static function getOneFromSlug($slug) {
        $args = [
            'name' => $slug,
            'post_status' => 'publish',
        ];

        return self::getOneEntityFromGetPost($args);
    }
}
