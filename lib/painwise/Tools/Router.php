<?php

namespace Painwise\Tools;

class Router {
    public static function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    public static function redirectSelf() {
        self::redirect(self::getCurrentPageUrl());
    }

    public static function goHome() {
        $this->redirect($this->getHomeUrl());
    }

    public static function reload($query="") {
        if(!empty($query)) $query = "?" . preg_replace("/^\\?/", "", $query);
        $this->redirect($this->getCurrentPageUrl() . $query);
    }

    public static function getHomeUrl() {
        return home_url('/');
    }

    public static function getCurrentPageUrl() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public static function getSearchUrl($query="", $params=[]) {
        return self::getHomeUrl("/")
            . (empty($query) && empty($params) ? "" : "?")
            . (empty($query) ? "" : "s=" . urlencode($query))
            . (empty($params) ? "" : "&" . implode("&", array_map(function($key, $value) {
                    return urlencode($key) . "=" . urlencode($value);
                }, array_keys($params), $params)));
    }
}
