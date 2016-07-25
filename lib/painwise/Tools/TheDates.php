Cully<?php

namespace Cully\Tools;

class TheDates {
    public static function sameDay(\DateTimeInterface $dt1, \DateTimeInterface $dt2) {
        return $dt1->format("Y-m-d") === $dt2->format("Y-m-d");
    }

    public static function sameMonth(\DateTimeInterface $dt1, \DateTimeInterface $dt2) {
        return $dt1->format("Y-m") === $dt2->format("Y-m");
    }

    public static function sameYear(\DateTimeInterface $dt1, \DateTimeInterface $dt2) {
        return $dt1->format("Y") === $dt2->format("Y");
    }

    /**
     * Just looks at the am/pm value of each, ignores the date portion
     *
     * @param \DateTimeInterface $dt1
     * @param \DateTimeInterface $dt2
     */
    public static function sameAmPm(\DateTimeInterface $dt1, \DateTimeInterface $dt2) {
        return $dt1->format("a") === $dt2->format("a");
    }

    /**
     * Just looks at the hours and minutes portion of each, ignores the date portion
     *
     * @param \DateTimeInterface $dt1
     * @param \DateTimeInterface $dt2
     */
    public static function sameTime(\DateTimeInterface $dt1, \DateTimeInterface $dt2) {
        return $dt1->format("H:i") === $dt2->format("H:i");
    }

    public static function isPast(\DateTimeInterface $dt) {
        $now = new \DateTimeImmutable('now', $dt->getTimezone());
        return ($dt <= $now);
    }

    public static function firstOfMonth(\DateTimeInterface $month) {
        $first = clone $month;
        return $first->modify("first day of this month");
    }

    public static function lastOfMonth(\DateTimeInterface $month) {
        $last = clone $month;
        return $last->modify("last day of this month");
    }

    public static function nextMonth(\DateTimeInterface $month) {
        $next = clone $month;
        return $next->modify("first day of next month");
    }

    public static function lastMonth(\DateTimeInterface $month) {
        $last = clone $month;
        return $last->modify("first day of last month");
    }
}
