<?php

namespace Painwise\Event;

use Painwise\Tools\Pagination;
use Painwise\Tools\TheDates;
use Painwise\Tools\Arr;
use Painwise\Post\TaxonomyRepository;

class EventRepository {
    const WP_EVENT_POST_TYPE = PW_TRIBE_EVENTS_POSTTYPE;
    const WP_EVENT_CATEGORY_TAXONOMY = PW_TRIBE_EVENTS_TAXONOMY;
    const WP_EVENT_LANGUAGE_TAXONOMY = "pw_event_lang";
    const WP_EVENT_COUNTY_TAXONOMY = "pw_event_county";
    const WP_EVENT_META_CURRENCY_SYMBOL = '_EventCurrencySymbol';
    const WP_EVENT_META_CURRENCY_SYMBOL_POSITION = '_EventCurrencyPosition';
    const WP_EVENT_META_COST = '_EventCost';
    const WP_EVENT_META_START_DATE = '_EventStartDate';
    const WP_EVENT_META_END_DATE = '_EventEndDate';
    const WP_EVENT_META_TIMEZONE = '_EventTimezone';
    const WP_EVENT_META_ALL_DAY = '_EventAllDay';
    const WP_EVENT_META_VENUE_ID = '_EventVenueID';
    const WP_EVENT_META_ORG_ID = '_EventOrganizerID';
    const WP_EVENT_META_RSVP_URL = 'pw_event_rsvp_url';
    const WP_EVENT_META_RSVP_BUTTON_TEXT = 'pw_event_rsvp_button_text';

    private static $acceptedFilterKeys = ["language", "category", "county"];

    public static function getAcceptedFilterKeys() { return self::$acceptedFilterKeys; }

    /**
     * @param   int     $num        How many to fetch. -1 will fetch all.
     * @param   int     $page
     * @param   array   $filters    Key must be a valid filter key, value is a term_id
     * @return Entity\Event[]
     */
    public static function getUpcoming($num, $page=1, $filters=[]) {
        $targs = self::getUpcomingArgs($num, $page, $filters);
        return self::getEntitiesFromTribe($targs);
    }

    public static function categoryHasUpcomingEvents($categoryTaxId) { return count(self::getUpcoming(1,1, ["category" => $categoryTaxId])) > 0; }
    public static function languageHasUpcomingEvents($languageTaxId) { return count(self::getUpcoming(1,1, ["language" => $languageTaxId])) > 0; }
    public static function countyHasUpcomingEvents($countyTaxId) { return count(self::getUpcoming(1,1, ["county" => $countyTaxId])) > 0; }

    private static function getUpcomingArgs($num, $page, $filters=[]) {
        return [
            'eventDisplay' => 'list',
            'posts_per_page' => $num,
            'offset' => Pagination::getOffset($num, $page),
            'orderby' => 'event_date',
            'order' => 'ASC',
            'tax_query' => self::getTaxQueryFromFilters($filters),
        ];
    }

    private static function getTaxQueryFromFilters($filters) {
        // if we don't do this, we could end up with a 'tax_query' with an array with one empty array element
        // and wordpress isn't smart enough to figure out that shouldn't contribute to the query
        $filtersWithValues = array_filter($filters, function($filterVal) { return !empty($filterVal); });

        if(empty($filtersWithValues)) return [];

        return array_merge(['relation' => 'AND']
            ,(empty($filtersWithValues["language"])
                ? []
                : [[
                    'taxonomy' => self::WP_EVENT_LANGUAGE_TAXONOMY,
                    'field' => 'term_id',
                    'terms' => $filtersWithValues['language'],
                ]])
            ,(empty($filtersWithValues['category'])
                ? []
                : [[
                    'taxonomy' => self::WP_EVENT_CATEGORY_TAXONOMY,
                    'field' => 'term_id',
                    'terms' => $filtersWithValues['category'],
                ]])
            ,(empty($filtersWithValues['county'])
                ? []
                : [[
                    'taxonomy' => self::WP_EVENT_COUNTY_TAXONOMY,
                    'field' => 'term_id',
                    'terms' => $filtersWithValues['county'],
                ]])
        );
    }

    /**
     * Provide the number of posts per page, and the CURRENT page, and
     * this will tell you if there are more posts (e.g. beyond the
     * current page).
     *
     * @param $num
     * @param int $page
     * @param   array   $filters    Key must be a valid filter key, value is a term_id
     * @return bool
     */
    public static function haveMoreUpcoming($num, $page=1, $filters=[]) {
        $targs = self::getUpcomingArgs($num, $page+1, $filters);
        $posts = self::queryTribe($targs);

        return (count($posts) > 0);
    }

    public static function getMonthEvents(\DateTimeInterface $month, $filters=[]) {
        $startDate = TheDates::firstOfMonth($month);
        $endDate = TheDates::lastOfMonth($month);

        $args = [
            'eventDisplay' => 'custom',
            'posts_per_page' => -1,
            'start_date' => $startDate->format('Y:m:d 00:00:00'),
            'end_date' => $endDate->format('Y:m:d 23:59:59'),
            'orderby' => 'event_date',
            'order' => 'ASC',
            'tax_query' => self::getTaxQueryFromFilters($filters),
        ];

        return self::getEntitiesFromTribe($args);
    }

    /**
     * @param   int     $num        How many to fetch. -1 will fetch all.
     * @param   int     $page
     * @return Entity\Event[]
     */
    public static function getPast($num, $page=1) {
        $targs = self::getPastArgs($num, $page);
        return self::getEntitiesFromTribe($targs);
    }

    /**
     * Provide the number of posts per page, and the CURRENT page, and
     * this will tell you if there are more posts (e.g. beyond the
     * current page).
     *
     * @param $num
     * @param int $page
     * @return bool
     */
    public static function haveMorePast($num, $page=1) {
        $targs = self::getPastArgs($num, $page+1);
        $posts = self::queryTribe($targs);

        return (count($posts) > 0);
    }

    private static function getPastArgs($num, $page) {
        return [
            'eventDisplay' => 'past',
            'posts_per_page' => $num,
            'offset' => Pagination::getOffset($num, $page),
            'orderby' => 'event_date',
            'order' => 'DESC',
        ];
    }

    private static function getEntitiesFromGetPost($args) {
        $events = [];

        $posts = self::queryGetPosts($args);

        foreach($posts as $post) {
            $events []= self::createEntityFromPost($post);
        }

        return $events;
    }

    private static function queryGetPosts($args) {
        $posts = get_posts($args);

        return $posts;
    }

    private static function getEntitiesFromTribe($args) {
        $posts = self::queryTribe($args);
        return array_map(function($post) { return self::createEntityFromPost($post); }, $posts);
    }

    private static function queryTribe($args) {
        $posts = tribe_get_events($args);

        return $posts;
    }

    /**
     * @param $eventId
     * @return Entity\Event|null
     */
    public static function getOne($eventId) {
        if(empty($eventId)) return null;

        $postInfo = get_post($eventId);
        if(!$postInfo) return null;

        return self::createEntityFromPost($postInfo);
    }

    public static function createEntityFromPost(\WP_Post $postInfo=null) {
        $event = new EventEntity();

        if($postInfo) {
            $event->Id = $postInfo->ID;
            $event->Title = $postInfo->post_title;
            $event->Permalink = get_permalink($event->Id);
            $event->Content = do_shortcode(wpautop($postInfo->post_content));
            $event->Excerpt = $postInfo->post_excerpt;
        }
        else {
            $event->Id = get_the_ID();
            $event->Title = get_the_title();
            $event->Permalink = get_the_permalink();
            $event->Content = get_the_content();
            $event->Excerpt = get_the_excerpt();
        }

        // taxonomies

        $event->Categories = TaxonomyRepository::getForPost($event->Id, self::WP_EVENT_CATEGORY_TAXONOMY);
        $event->Languages = TaxonomyRepository::getForPost($event->Id, self::WP_EVENT_LANGUAGE_TAXONOMY);
        $event->Counties = TaxonomyRepository::getForPost($event->Id, self::WP_EVENT_COUNTY_TAXONOMY);

        // meta

        $eventMeta = get_post_meta($event->Id);
        if(!empty($eventMeta)) {
            $event->IsAllDay = !empty($eventMeta[self::WP_EVENT_META_ALL_DAY][0]);
            $event->Starts = self::createDateTime($eventMeta[self::WP_EVENT_META_START_DATE][0], $eventMeta[self::WP_EVENT_META_TIMEZONE][0], null);
            $event->Ends = self::createDateTime($eventMeta[self::WP_EVENT_META_END_DATE][0], $eventMeta[self::WP_EVENT_META_TIMEZONE][0], null);
            $event->RsvpUrl = Arr::getFirst($eventMeta, self::WP_EVENT_META_RSVP_URL);
            $event->RsvpButtonText = Arr::getFirst($eventMeta, self::WP_EVENT_META_RSVP_BUTTON_TEXT);

            // cost
            $costRaw = Arr::getFirst($eventMeta, self::WP_EVENT_META_COST);
            $currencySymbolRaw = Arr::getFirst($eventMeta, self::WP_EVENT_META_CURRENCY_SYMBOL);
            $currencySymbolPosition = Arr::getFirst($eventMeta, self::WP_EVENT_META_CURRENCY_SYMBOL_POSITION);

            $currencySymbol = empty($currencySymbol)
                ? "$"
                : $currencySymbolRaw;

            $symbolPre = (empty($currencySymbolPosition) || $currencySymbolPosition !== 'suffix')
                ? $currencySymbol
                : "";

            $symbolPost = ($currencySymbolPosition === 'suffix')
                ? $currencySymbol
                : "";

            $cost = empty($costRaw)
                ? null
                : $symbolPre . $costRaw . $symbolPost;

            $event->Cost = $cost;

            // location
            if(!empty($eventMeta[self::WP_EVENT_META_VENUE_ID][0])) {
                $event->Location = LocationRepository::getFromVenue($eventMeta[self::WP_EVENT_META_VENUE_ID][0]);
            }

            // organizer
            if(!empty($eventMeta[self::WP_EVENT_META_ORG_ID][0])) {
                $event->Organizer = OrganizerRepository::getFromTribeOrgId($eventMeta[self::WP_EVENT_META_ORG_ID][0]);
            }
        }

        return $event;
    }

    public static function getAllCategories() { return TaxonomyRepository::getAll(self::WP_EVENT_CATEGORY_TAXONOMY); }
    public static function getAllLanguages() { return TaxonomyRepository::getAll(self::WP_EVENT_LANGUAGE_TAXONOMY); }
    public static function getAllCounties() { return TaxonomyRepository::getAll(self::WP_EVENT_COUNTY_TAXONOMY); }

    private static function createDateTime($dateStr, $timezoneStr, $default=null) {
        if(empty($dateStr)) return $default;

        $timezoneStr = !empty($timezoneStr) ? $timezoneStr : get_option('timezone_string');
        $timezone = !empty($timezoneStr) ? new \DateTimeZone($timezoneStr) : new \DateTimeZone("Etc/UTC");

        return new \DateTimeImmutable($dateStr, $timezone);
    }
}
