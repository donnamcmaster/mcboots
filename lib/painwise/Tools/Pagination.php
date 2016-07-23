<?php

namespace Painwise\Tools;

class Pagination {
    public static function getOffset($num, $page) { return ($num * ($page-1)); }
}
