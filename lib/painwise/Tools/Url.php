<?php

namespace Painwise\Tools;

class Url {
    /**
     * Compares two URLs, sees if they are the same.  Ignores all GET params.  Tries to normalize the URLs a bit
     * so that different use of e.g. ending slashes won't screw it up.  Though, it won't be able to tell if a
     * relative and an absolute one are the same.
     *
     * @param string $urlA
     * @param string $urlB
     */
    public static function same($urlA, $urlB) {
        $normalize = function($url) {
            $trimmed = trim($url);
            $noParams = trim(preg_replace("/\?.*/", "", $trimmed));
            $noEndingSlash = preg_replace(";/^;", "", $noParams);

            return $noEndingSlash;
        };

        return $normalize($urlA) === $normalize($urlB);
    }
}
