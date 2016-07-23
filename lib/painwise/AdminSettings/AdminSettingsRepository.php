<?php

namespace Painwise\AdminSettings;

use Painwise\Post\AttachmentRepository;
use Painwise\Tools\Arr;

class AdminSettingsRepository {
    const WP_ADMIN_SETTINGS_NAME = "painwise_settings";
    const WP_META_LANDING_PAGE_HERO_CONTENT = "pw_landing_page_widget_hero_content";
    const WP_META_SELECT_COUNTY_EXPLANATION = "pw_select_county_widget_explanation";
    const WP_META_INFOGRAPHIC_CONTENT = "pw_infographic_content";
    const WP_META_INFOGRAPHIC_CONTENT_MOBILE = "pw_infographic_content_mobile";
    const WP_META_INFOGRAPHIC_BUTTON_TEXT = "pw_infographic_button_text";
    const WP_META_INFOGRAPHIC_PREVIEW_IMAGE_IDS = "pw_infographic_preview_image_ids";
    const WP_META_INFOGRAPHIC_DESTINATION_PAGE_ID = "pw_infographic_destination_page_id";
    const WP_META_HOME_HERO_IMAGE_IDS = "pw_home_hero_image_ids";
    const WP_META_HOME_EVENTS_LEADER = "pw_home_events_leader";
    const WP_META_HOME_NEWS_LEADER = "pw_home_news_leader";
    const WP_META_HOME_ABOUT_CONTENT = "pw_home_about_content";
    const WP_META_FOOTER_COPYRIGHT_TEXT = "pw_footer_copyright_text";
    const WP_META_FOOTER_RIGHTS_TEXT = "pw_footer_rights_text";
    const WP_META_FACEBOOK_SHARE_URL = "pw_facebook_share_url";
    const WP_META_TWITTER_SHARE_URL = "pw_twitter_share_url";
    const WP_META_LINKEDIN_SHARE_URL = "pw_linkedin_share_url";
    const WP_META_EMAIL_SIGNUP_URL = "pw_email_signup_url";
    const WP_META_EMAIL_FIELD_NAME = "pw_email_field_name";
    const WP_META_EMAIL_FIELD_EMAIL = "pw_email_field_email";
    const WP_META_EMAIL_FIELD_COUNTY = "pw_email_field_county";
    const WP_META_EVENTS_PAGE_TITLE = "pw_events_page_title";
    const WP_META_EVENTS_PAGE_CONTENT = "pw_events_page_content";
    const WP_META_GOOGLE_ANALYTICS_ID = "pw_google_analytics_id";
    const WP_META_GOOGLE_ANALYTICS_COUNTY_DIMENSION_INDEX = "pw_google_analytics_county_dimension_index";

    /**
     * @return Entity\AdminSettings
     */
    public static function getAll() {
        $settingsArr = self::fetchSettings();

        $settings = new AdminSettingsEntity();
        $settings->LandingPageWidgetHeroContent = Arr::get($settingsArr, self::WP_META_LANDING_PAGE_HERO_CONTENT);
        $settings->SelectCountyExplanation = Arr::get($settingsArr, self::WP_META_SELECT_COUNTY_EXPLANATION);
        $settings->FacebookShareUrl = Arr::get($settingsArr, self::WP_META_FACEBOOK_SHARE_URL);
        $settings->LinkedinShareUrl = Arr::get($settingsArr, self::WP_META_LINKEDIN_SHARE_URL);
        $settings->TwitterShareUrl = Arr::get($settingsArr, self::WP_META_TWITTER_SHARE_URL);
        $settings->EmailSignupUrl = Arr::get($settingsArr, self::WP_META_EMAIL_SIGNUP_URL);
        $settings->EmailFieldName = Arr::get($settingsArr, self::WP_META_EMAIL_FIELD_NAME);
        $settings->EmailFieldEmail = Arr::get($settingsArr, self::WP_META_EMAIL_FIELD_EMAIL);
        $settings->EmailFieldCounty = Arr::get($settingsArr, self::WP_META_EMAIL_FIELD_COUNTY);
        $settings->GoogleAnalyticsId = Arr::get($settingsArr, self::WP_META_GOOGLE_ANALYTICS_ID);
        $settings->GoogleAnalyticsCountyDimensionIndex = Arr::get($settingsArr, self::WP_META_GOOGLE_ANALYTICS_COUNTY_DIMENSION_INDEX);

        /*
         * Footer
         */

        $settings->FooterCopyrightText = Arr::get($settingsArr, self::WP_META_FOOTER_COPYRIGHT_TEXT);
        $settings->FooterRightsText = Arr::get($settingsArr, self::WP_META_FOOTER_RIGHTS_TEXT);

        /*
         * Infographic
         */

        $settings->InfographicContent = self::doWordpressStuffToItem($settingsArr, self::WP_META_INFOGRAPHIC_CONTENT);
        $settings->InfographicContentMobile = self::doWordpressStuffToItem($settingsArr, self::WP_META_INFOGRAPHIC_CONTENT_MOBILE);
        $settings->InfographicButtonText = Arr::get($settingsArr, self::WP_META_INFOGRAPHIC_BUTTON_TEXT);
        $settings->InfographicDestinationPageId = Arr::get($settingsArr, self::WP_META_INFOGRAPHIC_DESTINATION_PAGE_ID);

        $infographicImageId = Arr::getFirst($settingsArr, self::WP_META_INFOGRAPHIC_PREVIEW_IMAGE_IDS);
        $settings->InfographicPreviewImage = $infographicImageId ? AttachmentRepository::getOne($infographicImageId) : null;

        /*
         * Home Page
         */

        $settings->HomeEventsLeader = self::doWordpressStuffToItem($settingsArr, self::WP_META_HOME_EVENTS_LEADER);
        $settings->HomeNewsLeader = self::doWordpressStuffToItem($settingsArr, self::WP_META_HOME_NEWS_LEADER);
        $settings->HomeAboutContent = self::doWordpressStuffToItem($settingsArr, self::WP_META_HOME_ABOUT_CONTENT);

        /*
         * Events Page
         */

        $settings->EventsPageTitle = Arr::get($settingsArr, self::WP_META_EVENTS_PAGE_TITLE);
        $settings->EventsPageContent = self::doWordpressStuffToItem($settingsArr, self::WP_META_EVENTS_PAGE_CONTENT);

        /*
         * Done!
         */

        return $settings;
    }

    private static function fetchSettings() {
        return get_option(self::WP_ADMIN_SETTINGS_NAME);
    }

    private static function doWordpressStuffToItem($settingsArr, $key) {
        $content = Arr::get($settingsArr, $key);
        return $content ? wpautop(do_shortcode($content)) : $content;
    }

    /**
     * @return AttachmentEntity[]
     */
    public static function getHomepageHeroImages() {
        $settingsArr = self::fetchSettings();

        return empty($settingsArr[self::WP_META_HOME_HERO_IMAGE_IDS])
            ? []
            : array_map(function($id) {
                return AttachmentRepository::getOne($id);
            }, $settingsArr[self::WP_META_HOME_HERO_IMAGE_IDS]);
    }
}
