<?php

namespace Painwise\Event;

use Painwise\Tools\Arr;

class OrganizerRepository {
    const WP_META_NAME = '_OrganizerOrganizer';
    const WP_META_PHONE = '_OrganizerPhone';
    const WP_META_WEBSITE = '_OrganizerWebsite';
    const WP_META_EMAIL = '_OrganizerEmail';

    /**
     * @param int   $orgId
     * @return OrganizerEntity|null
     */
    public static function getFromTribeOrgId($orgId) {
        $postData = get_post($orgId);
        if(empty($postData)) return null;
        $orgMeta = get_post_meta($orgId);
        if(empty($orgMeta)) return null;

        $entity = new OrganizerEntity();

        $entity->Id = $orgId;
        $entity->Name = Arr::getFirst($orgMeta, self::WP_META_NAME, null);
        $entity->Phone = Arr::getFirst($orgMeta, self::WP_META_PHONE, null);
        $entity->Website = Arr::getFirst($orgMeta, self::WP_META_WEBSITE, null);
        $entity->Email = Arr::getFirst($orgMeta, self::WP_META_EMAIL, null);

        return $entity;
    }
}
