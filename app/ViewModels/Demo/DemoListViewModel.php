<?php

namespace App\ViewModels\Demo;

use App\Models\Demo;
use App\ViewModels\Demo\Object\DemoListObject;
use Illuminate\Database\Eloquent\Collection;

class DemoListViewModel
{
    public function __construct(
        private readonly Collection|array $demos,
    )
    {
    }

    /**
     * @return array
     */
    public function getDemos(): array
    {
        return $this->demos->map(fn(Demo $demo) => (new DemoListObject(
            id: $demo["id"],
            date: $demo["date"],
            start: $demo["start"],
            end: $demo["end"],
            grade: $demo["grade"],
            students: $demo["students"],
            teacher_id: $demo->Teacher()->first(),
            staff_id: $demo->Staff()->first(),
            supporter_id: $demo->Supporter()->first(),
            client_id: $demo->Client()->first(),
            customers: $demo->Customer()->get()->pluck("name", "id")->toArray(),
            student_phone: $demo["student_phone"] ?? "0",
            facebook: $demo["facebook"],
            lesson: $demo["lesson"],
            teacher_video: $demo["teacher_video"],
            drive: $demo["drive"],
            duration: $demo["duration"],
            hour_salary: $demo["hour_salary"],
            log_salary: $demo["log_salary"],
            assessment: $demo["assessment"],
            attachments: json_decode($demo["attachments"]),
            status: $demo->StatusShow()
        ))->toArray())->toArray();
    }
}
