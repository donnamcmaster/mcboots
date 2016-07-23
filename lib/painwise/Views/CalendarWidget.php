<?php

namespace Painwise\Views;

use Painwise\Tools\TheDates;

class CalendarWidget {
    private static $dayNumbersToNames = [
        1 => "monday",
        2 => "tuesday",
        3 => "wednesday",
        4 => "thursday",
        5 => "friday",
        6 => "saturday",
        7 => "sunday",
    ];

    private static $dayNumbersToAbbrevs = [
        1 => "Mon",
        2 => "Tue",
        3 => "Wed",
        4 => "Thu",
        5 => "Fri",
        6 => "Sat",
        7 => "Sun",
    ];

    public static function render($baseCalendarUrl, array $urlParams, \DateTimeInterface $month, array $events, $hasPrevMonth, $hasNextMonth, $startOfWeek=7) {
        $endOfWeek = ($startOfWeek - 1 === 0) ? 7 : $startOfWeek - 1;

        $dayName = $month->format("l");
        $dayNumber = $month->format("j");
        $monthName = $month->format("F");
        $year = $month->format("Y");

        $eventsByDay = self::getEventsByDay($events);

        $calStart = self::getFirstCalendarDay($month, $startOfWeek);
        // php doesn't include the last day in the interval, and we want to
        // so we need to add a day
        $calEnd = self::getLastCalendarDay($month, $endOfWeek)->modify("+1 day");
        $calendarPeriod = new \DatePeriod($calStart, new \DateInterval("P1D"), $calEnd);

        $insertDateIntoUrl = function($url, $date, array $params=[]) {
            $pieces = explode("?", $url);

            $addTheseParams =
                (!empty($pieces[1]) ? $pieces[1] . "&" : "")
                . implode("&", array_map(function($key, $value) {
                        return urlencode($key) . "=" . urlencode($value);
                    }, array_keys($params), $params));

            return
                $pieces[0]
                . ((substr($pieces[0], -1) === '/') ? "" : "/")
                . "{$date}/"
                . (!empty($addTheseParams) ? "?{$addTheseParams}" : "");
        };

        $prevMonthName = TheDates::lastMonth($month)->format("F");
        $prevMonthUrl = $insertDateIntoUrl($baseCalendarUrl, TheDates::lastMonth($month)->format("Y-m"), $urlParams);

        $nextMonthName = TheDates::nextMonth($month)->format("F");
        $nextMonthUrl = $insertDateIntoUrl($baseCalendarUrl, TheDates::nextMonth($month)->format("Y-m"), $urlParams);

        ob_start();

        ?>
        <div class="event-calendar">
            <div class="event-calendar-header">
                <div class="header-prev"><?= $hasPrevMonth ? "<a href='{$prevMonthUrl}'>{$prevMonthName}</a>" : ""; ?></div>
                <div class="header-title"><?= esc_html("{$monthName} {$year}"); ?></div>
                <div class="header-next"><?= $hasNextMonth ? "<a href='{$nextMonthUrl}'>{$nextMonthName}</a>" : ""; ?></div>
            </div>
            <div class="event-calendar-content">
                <table>
                    <thead>
                        <tr>
                            <?php
                            $currentDay = $startOfWeek;
                            for($i=0; $i < 7; $i++) {
                                ?>
                                <th><span class="day"><?= self::$dayNumbersToAbbrevs[$currentDay]; ?></span></th>
                                <?php

                                $currentDay++;
                                if($currentDay > 7) $currentDay = 1;
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $previousStartDay = null;
                        foreach($calendarPeriod as $cDay) {
                            $eventsForDay = empty($eventsByDay[$cDay->format('Y-m-d')]) ? [] : $eventsByDay[$cDay->format('Y-m-d')];
                            $isThisMonth = ($cDay->format("Y-m") === $month->format("Y-m"));
                            $isToday = ($cDay->format("Y-m-d") === $month->format("Y-m-d"));
                            $isEventful = !empty($eventsForDay);
                            $isStartDay = ($cDay->format("N") == $startOfWeek);

                            $cDayNumber = $cDay->format("j");

                            // end previous row, start new row
                            if ($previousStartDay === null || $isStartDay) {
                                if ($previousStartDay !== null) {
                                    echo "</tr>";
                                }

                                echo "<tr>";

                                $previousStartDay  = $cDay;
                            }

                            if($isThisMonth) $currentMonthClass = "is-current-month";
                            else             $currentMonthClass = "not-current-month";

                            if($isToday) $todayClass = "is-today";
                            else         $todayClass = "not-today";

                            if($isEventful) $eventfulClass = "is-eventful";
                            else            $eventfulClass = "not-eventful";

                            ?>
                            <td class="<?= "{$currentMonthClass} {$todayClass} {$eventfulClass}"; ?>">
                                <div class="number"><?= esc_html($cDayNumber); ?></div>
                                <div class='events'>
                                    <?php foreach($eventsForDay as $event): ?>
                                        <div class='event'>
                                            <div class='event-title'><a href='<?= $event->Permalink; ?>'><?= esc_html($event->Title); ?></a></div>
                                        </div>
                                    <?php endforeach; /* events */ ?>
                                </div>
                            </td>
                        <?php
                        }

                        // end the last row
                        echo "</tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    private static function getFirstCalendarDay($month, $dayOfWeek) {
        $firstOfMonth = TheDates::firstOfMonth($month);
        // if it's the day we're looking for, return it
        if($firstOfMonth->format("N") == $dayOfWeek) return $firstOfMonth;
        // otherwise, get the last of this day of last month
        else return self::getLastDayOfPreviousMonth($month, $dayOfWeek);
    }

    private static function getLastCalendarDay($month, $dayOfWeek) {
        $lastOfMonth = TheDates::lastOfMonth($month);
        // if it's the day we're looking for, return it
        if($lastOfMonth->format("N") == $dayOfWeek) return $lastOfMonth;
        // otherwise, return the first of this day of next month
        else return self::getFirstDayOfNextMonth($month, $dayOfWeek);
    }

    private static function getFirstDayOfNextMonth(\DateTimeInterface $thisMonth, $dayOfWeek) {
        $first = clone $thisMonth;
        return $first->modify("first " . self::$dayNumbersToNames[$dayOfWeek] . " of next month");
    }

    private static function getLastDayOfPreviousMonth(\DateTimeInterface $thisMonth, $dayOfWeek) {
        $last = clone $thisMonth;
        return $last->modify("last " . self::$dayNumbersToNames[$dayOfWeek] . " of previous month");
    }

    /**
     * @param EventEntity[] $events
     * @return array
     */
    private static function getEventsByDay(array $events) {
        $eventsByDay = [];

        foreach($events as $event) {
            $eventKey = $event->Starts->format("Y-m-d");
            if(empty($eventsByDay[$eventKey])) $eventsByDay[$eventKey] = [$event];
            else $eventsByDay[$eventKey] []= $event;
        }

        return $eventsByDay;
    }
}
