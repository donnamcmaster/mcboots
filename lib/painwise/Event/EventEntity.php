<?php

namespace PainWise\Event;

use Painwise\Tools\TheDates;

class EventEntity {
    public $Id;
    public $Title;
    public $Content;
    public $Excerpt;
    public $Permalink;
    public $Cost;
    public $RsvpUrl;
    public $RsvpButtonText;
    /**
     * @var \DateTimeImmutable
     */
    public $Starts;
    /**
     * @var \DateTimeImmutable
     */
    public $Ends;
    /**
     * @var LocationEntity
     */
    public $Location;
    /**
     * @var OrganizerEntity
     */
    public $Organizer;
    public $IsAllDay;
    /**
     * @var TaxonomyEntity[]
     */
    public $Categories = [];
    /**
     * @var TaxonomyEntity[]
     */
    public $Languages = [];
    /**
     * @var TaxonomyEntity[]
     */
    public $Counties = [];

    /**
     * @return bool
     */
    public function isPast() {
        return TheDates::isPast($this->End);
    }

    public function getDateDuration() {
        if(empty($this->Starts) || empty($this->Ends)) return "";

        // starts and ends on same day
        if(TheDates::sameDay($this->Starts, $this->Ends)) {
            return $this->Starts->format('F j, Y');
        }
        // starts and ends in same month
        else if(TheDates::sameMonth($this->Starts, $this->Ends)) {
            return
                $this->Starts->format('F j') // Start month and day
                . " - "
                . $this->Ends->format('j, Y'); // End day and year
        }
        // starts and ends in same year
        else if(TheDates::sameYear($this->Starts, $this->Ends)) {
            return
                $this->Starts->format('F j') // Start month and day
                . " - "
                . $this->Ends->format('F j, Y'); // End month, day and year
        }
        // starts and ends in different year
        else {
            return
                $this->Starts->format('F j, Y') // Start month, day, and year
                . " - "
                . $this->Ends->format('F j, Y'); // End month, day and year
        }
    }

    public function getStartDateHuman() {
        return $this->Starts->format('F j, Y');
    }

    public function getStartTimeHuman() {
        return $this->Starts->format("g:iA");
    }

    public function getTimeDuration() {
        // all day
        if($this->IsAllDay) {
            return "All Day";
        }
        // same time, don't need to include the end time
        else if(TheDates::sameTime($this->Starts, $this->Ends)) {
            return $this->Starts->format("g:iA");
        }
        // same am/pm, so don't need to include it twice
        else if(TheDates::sameAmPm($this->Starts, $this->Ends)) {
            return
                $this->Starts->format("g:i") // start hour and minute
                . " - "
                . $this->Ends->format("g:iA"); // end hour, minute, am/pm
        }
        // different am/pm
        else {
            return
                $this->Starts->format("g:iA")
                . " - "
                . $this->Ends->format("g:iA");
        }
    }

    /**
     * @return bool
     */
    public function hasMap() {
        $content = tribe_embed_google_map($this->Id);
        return !empty($content);
    }

    /**
     * @param int|null $width
     * @param int|null $height
     * @return string   Empty string if no map, otherwise an iframe
     */
    public function getMap($width=null, $height=null) {
        if($this->hasMap()) return tribe_get_embedded_map($this->Id, $width, $height);
        else return "";
    }
}
