<?php

namespace App\ViewModels\Teacher;

use App\Models\Grade;
use App\Models\Log;
use App\Models\Teacher;
use App\ViewModels\Common\CalendarObject;
use App\ViewModels\Common\UserRelationObject;
use App\ViewModels\Teacher\Object\LogShowGradeObject;
use App\ViewModels\Teacher\Object\TeacherLogsObject;
use App\ViewModels\Teacher\Object\TeacherShowObject;
use Illuminate\Support\Collection;

class TeacherShowViewModel
{
    public function __construct(
        private readonly Teacher    $teacher,
        private readonly Collection $logs,
        private readonly Collection $grades,
        private readonly Collection $calendars,
    )
    {
    }

    /**
     * @return CalendarObject
     */
    public function getCalendars(): CalendarObject
    {
        return new CalendarObject(grades: $this->calendars);
    }

    /**
     * @return TeacherShowObject
     */
    public function getTeacher(): TeacherShowObject
    {

        $teacher = $this->teacher;
        return new TeacherShowObject(
            id: $teacher["id"],
            code: $teacher["code"],
            name: $teacher["name"],
            extra: json_decode($teacher["extra"]),
            address: $teacher["address"] ?? "-",
            avatar: $teacher["avatar"] ?? config("app.blank_avatar"),
            phone: $teacher["phone"] ?? "-",
            facebook: $teacher['facebook'],
            email: $teacher["email"], skills: $teacher->Skills()->get(["name"])
        );
    }

    /**
     * @return TeacherLogsObject[]
     */
    public function getLogs(): array
    {
        return $this->logs->map(
            fn(Log $log) => new TeacherLogsObject(
                id: $log['id'], title: $log["lesson"],
                teacher: new UserRelationObject(
                    id: $log->Teacher()->firstOrFail()->id ?? "-",
                    name: $log->Teacher()->firstOrFail()->name ?? "-",
                    avatar: $log->Teacher()->firstOrFail()->avatar ?? config("app.blank_avatar"),
                ),
                date: $log["date"], question: $log["question"] ?? "Không có BTVN",
                attachments: json_decode($log["attachments"]) ?? null,
            )
        )->toArray();
    }

    /**
     * @return LogShowGradeObject[]
     */
    public function getGrades(): array
    {
        return $this->grades->map(
            fn(Grade $grade) => new LogShowGradeObject(id: $grade["id"], name: $grade["name"])
        )->toArray();
    }
}
