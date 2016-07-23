<?php

namespace Painwise\Article;

class ArticleEntity {
    public $Id;
    public $Title;
    public $Content;
    public $ContentRaw;
    public $Excerpt;
    public $Permalink;
    public $PostDate;
    /**
     * @var TaxonomyEntity[]
     */
    public $Categories = [];
    /**
     * @var TaxonomyEntity[]
     */
    public $Types = [];
}
