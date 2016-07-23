<?php

namespace Painwise\LandingPage;

class LandingPageEntity {
    public $Id;
    public $Title;
    public $Content;
    public $ContentRaw;
    public $Excerpt;
    public $Permalink;
    public $PostDate;
    public $AltLandingPageHeroContent;
    public $FeaturedArticleContent;
    /**
     * @var AttachmentEntity|null
     */
    public $FeaturedArticleImage;
    public $SubArticles = [];
}
