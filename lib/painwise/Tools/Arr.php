<?php

namespace Painwise\Tools;

class Arr {
    /**
     * Assumes that $arr[$key] is itself an array. Will get the first item, if
     * it isn't empty. Otherwise will return $default.
     *
     * @param array $arr
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getFirst(array $arr, $key, $default=null) {
        return !empty($arr[$key][0]) ? $arr[$key][0] : $default;
    }

    /**
     * If the $key is set and isn't empty in the $arr, then return
     * the value.  Otherwise, return $default.
     *
     * @param array $arr
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(array $arr, $key, $default=null) {
        return !empty($arr[$key]) ? $arr[$key] : $default;
    }

    /**
     * Fetches the last item of an array, without modifying it.
     *
     * @param array $arr
     * @return mixed|null null if there aren't any elements.
     */
    public static function last(array $arr) {
        return count($arr) == 0
            ? null
            : array_pop((array_slice($arr, -1)));
    }

    /**
     * Fetches the second to last item of an array, without modifying it.
     *
     * @param array $arr
     * @return mixed|null null if there aren't two element
     */
    public static function secondLast(array $arr) {
        return count($arr) < 2
            ? null
            : array_pop((array_slice($arr, -2, 1)));
    }

    /**
     * Fetches all the items in an array, except the last.
     * 
     * @param array $arr
     */
    public static function allButLast(array $arr) {
        return array_slice($arr, 0, count($arr)-1);
    }

    /**
     * Returns all of $arr, just without any items with a key in $notTheseKeys.
     *
     * @param array $arr
     * @param array $notTheseKeys
     * @return array
     */
    public static function allBut(array $arr, array $notTheseKeys) {
        return array_filter($arr, function($key) use ($notTheseKeys) {
            return !in_array($key, $notTheseKeys);
        }, ARRAY_FILTER_USE_KEY);
    }
}
