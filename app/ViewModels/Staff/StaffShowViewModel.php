<?php

namespace App\ViewModels\Staff;

use App\ViewModels\Common\CalendarObject;
use App\ViewModels\Staff\Object\StaffLogsObject;
use App\ViewModels\Staff\Object\StaffShowObject;

/**
 *
 */
class StaffShowViewModel
{
    /**
     * @param StaffShowObject $staff
     * @param StaffLogsObject[] $logs
     * @param CalendarObject|null $calendarObject
     */
    public function __construct(
        private readonly StaffShowObject $staff,
        private readonly array           $logs,
        private readonly ?CalendarObject $calendarObject,
    )
    {
    }

    /**
     * @return StaffShowObject
     */
    public function getStaff(): StaffShowObject
    {
        return $this->staff;
    }

    /**
     * @return StaffLogsObject[]
     */
    public function getLogs(): array
    {
        return $this->logs;
    }

    /**
     * @return CalendarObject|null
     */
    public function getCalendarObject(): ?CalendarObject
    {
        return $this->calendarObject;
    }
}
