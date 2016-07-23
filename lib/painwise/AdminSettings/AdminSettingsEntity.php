<?php

namespace Painwise\AdminSettings;

class AdminSettingsEntity {
    public $LandingPageWidgetHeroContent;
    public $SelectCountyExplanation;

    public $InfographicContent;
    public $InfographicContentMobile;
    public $InfographicButtonText;
    /**
     * @var Painwise\Post\AttachmentEntity
     */
    public $InfographicPreviewImage;
    public $InfographicDestinationPageId;

    public $HomeEventsLeader;
    public $HomeNewsLeader;
    public $HomeAboutContent;

    public $FooterCopyrightText;
    public $FooterRightsText;

    public $FacebookShareUrl;
    public $TwitterShareUrl;
    public $LinkedinShareUrl;

    public $EmailSignupUrl;
    public $EmailFieldName;
    public $EmailFieldEmail;
    public $EmailFieldCounty;

    public $EventsPageTitle;
    public $EventsPageContent;

    public $GoogleAnalyticsId;
    public $GoogleAnalyticsCountyDimensionIndex;

    public function getFormattedFooterCopyrightText() {
        $year = date('Y');

        return str_replace("{{year}}", $year, $this->FooterCopyrightText);
    }
}
