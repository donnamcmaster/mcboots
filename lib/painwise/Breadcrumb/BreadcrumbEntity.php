<?php

namespace Cully\Breadcrumb;

class BreadcrumbEntity {
    /**
     * This will be the id of this item in the menu
     * @var int
     */
    public $Id;
    public $Title;
    public $Url;
    public $IsRoot;
    /**
     * @var BreadcrumbEntity[]
     */
    public $Siblings = [];
}
