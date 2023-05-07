<?php

namespace App\ViewModels\Common;

use App\Models\Grade;
use Illuminate\Support\Collection;

class CalendarObject
{
    private ?array $monday = [];
    private ?array $tuesday = [];
    private ?array $wednesday = [];
    private ?array $thursday = [];
    private ?array $friday = [];
    private ?array $saturday = [];
    private ?array $sunday = [];

    public function __construct(Collection $grades)
    {
        /**
         * @var Grade $grade
         * @var array $time
         */
        foreach ($grades as $grade) {
            foreach ($grade["time"] as $time) {
                switch ($time["day"]) {
                    case "mon":
                        $this->monday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                    case "tue":
                        $this->tuesday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                    case "wed":
                        $this->wednesday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                    case "thu":
                        $this->thursday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                    case "fri":
                        $this->friday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                    case "sat":
                        $this->saturday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                    case "sun":
                        $this->sunday[] = new TimeObject(id: $grade["id"], grade: $grade["name"], time: $time["value"]);
                        break;
                }
            }
        }
    }

    /**
     * @return TimeObject[]|null
     */
    public function getMonday(): ?array
    {
        return $this->monday;
    }

    /**
     * @return TimeObject[]|null
     */
    public function getTuesday(): ?array
    {
        return $this->tuesday;
    }

    /**
     * @return TimeObject[]|null
     */
    public function getWednesday(): ?array
    {
        return $this->wednesday;
    }

    /**
     * @return TimeObject[]|null
     */
    public function getThursday(): ?array
    {
        return $this->thursday;
    }

    /**
     * @return TimeObject[]|null
     */
    public function getFriday(): ?array
    {
        return $this->friday;
    }

    /**
     * @return TimeObject[]|null
     */
    public function getSaturday(): ?array
    {
        return $this->saturday;
    }

    /**
     * @return TimeObject[]|null
     */
    public function getSunday(): ?array
    {
        return $this->sunday;
    }

}
