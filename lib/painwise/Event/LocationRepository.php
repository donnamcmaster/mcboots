<?php

namespace Painwise\Event;

use Painwise\Tools\Arr;

class LocationRepository {
    const WP_LOCATION_META_NAME = '_VenueVenue';
    const WP_LOCATION_META_ADDRESS = '_VenueAddress';
    const WP_LOCATION_META_CITY = '_VenueCity';
    const WP_LOCATION_META_STATE = '_VenueState';
    const WP_LOCATION_META_ZIP = '_VenueZip';

    /**
     * @param int   $venueId
     * @return LocationEntity|null
     */
    public static function getFromVenue($venueId) {
        $postData = get_post($venueId);
        if(empty($postData)) return null;
        $venueMeta = get_post_meta($venueId);
        if(empty($venueMeta)) return null;

        $location = new LocationEntity();

        $location->Name = self::getLocationName($postData, $venueMeta);
        $location->Address = Arr::getFirst($venueMeta, self::WP_LOCATION_META_ADDRESS, null);
        $location->City = Arr::getFirst($venueMeta, self::WP_LOCATION_META_CITY, null);
        $location->State = Arr::getFirst($venueMeta, self::WP_LOCATION_META_STATE, null);
        $location->Zip = Arr::getFirst($venueMeta, self::WP_LOCATION_META_ZIP, null);

        return $location;
    }

    private static function getLocationName(\WP_Post $postData, $venueMeta) {
        $name = $postData->post_title;
        if(empty($name)) $name = Arr::getFirst($venueMeta, self::WP_LOCATION_META_NAME, null);
        return $name;
    }
}
