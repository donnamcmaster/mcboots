<?php

namespace Painwise\County;

class CountyRepository {
    const SESSION_SELECTED_COUNTY = "painwise_selected_county";

    public static function clearSelectedCounty() {
        unset($_SESSION[self::SESSION_SELECTED_COUNTY]);
    }

    public static function hasSelectedCounty() {
        return !empty($_SESSION[self::SESSION_SELECTED_COUNTY]);
    }

    public static function getSelectedCounty() {
        return self::hasSelectedCounty() ? $_SESSION[self::SESSION_SELECTED_COUNTY] : null;
    }

    public static function getSelectedCountyName() {
        return self::hasSelectedCounty() ? self::getCountyName(self::getSelectedCounty()) : null;
    }

    public static function setSelectedCounty($countyKey) {
        if(!self::isValidCounty($countyKey)) return;
        $_SESSION[self::SESSION_SELECTED_COUNTY] = $countyKey;
    }

    public static function getCountyName($countyKey) {
        return self::isValidCounty($countyKey) ? self::getAvailableCounties()[$countyKey] : null;
    }

    public static function getAvailableCounties() {
        return [
            "benton-county" => "Benton County",
            "lincoln-county" => "Lincoln County",
            "linn-county" => "Linn County",
        ];
    }

    public static function isValidCounty($countyKey) {
        return array_key_exists($countyKey, self::getAvailableCounties());
    }
}
