<?php

namespace PainWise\Tools;

class Tribe {
    private static function haveTribe() {
        return class_exists("\Tribe__Events__Main");
    }
    public static function eventsUrl() {
        return self::haveTribe()
            ? \Tribe__Events__Main::instance()->getLink()
            : null;
    }

    public static function havePrevMonth() {
        if(!self::haveTribe()) return null;

        $date = \Tribe__Events__Main::instance()->previousMonth(tribe_get_month_view_date());
        $earliestEventDate = tribe_events_earliest_date(\Tribe__Date_Utils::DBYEARMONTHTIMEFORMAT);
        return ($earliestEventDate && $date >= $earliestEventDate);
    }

    public static function haveNextMonth() {
        if(!self::haveTribe()) return null;

        $date = \Tribe__Events__Main::instance()->nextMonth(tribe_get_month_view_date());
        $latestEventDate = tribe_events_latest_date(\Tribe__Date_Utils::DBYEARMONTHTIMEFORMAT);
		return ($latestEventDate && $date <= $latestEventDate);
    }
}
