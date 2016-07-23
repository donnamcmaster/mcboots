<?php

namespace Painwise\News;

class NewsEntity {
    public $Id;
    public $Title;
    public $Content;
    public $ContentRaw;
    public $Excerpt;
    public $Permalink;
    public $PostDate;
    public $ExternalUrl;
    /**
     * @var TaxonomyEntity[]
     */
    public $Categories = [];
}
