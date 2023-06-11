<?php

namespace App\ViewModels\Demo\Object;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class DemoStoreObject
{
    public function __construct(
        public array $demo
    )
    {
    }

    public function toArray(): array
    {
        $demo = $this->demo;
        return [
            'grade' => $demo["grade"],
            'student_phone' => $demo["student_phone"] ?? null,
            "facebook" => $demo["facebook"] ?? null,
            "students" => $demo["students"] ?? "",
            "teacher_id" => $demo["teacher_id"] ?? null,
            "client_id" => $demo["client_id"] ?? null,
            "staff_id" => $demo["staff_id"] ?? null,
            "supporter_id" => $demo["supporter_id"] ?? null,
            "date" => Carbon::parse($demo["date"])->toDateString(),
            "start" => $demo["start"],
            "end" => $demo["end"],
            "duration" => $demo["duration"],
            "hour_salary" => $demo["hour_salary"],
            "log_salary" => $demo["duration"] / 60 * $demo["hour_salary"],
            "lesson" => $demo["lesson"],
            "information" => $demo['information'] ?? null,
            "teacher_video" => $demo["teacher_video"] ?? null,
            "drive" => $demo["drive"] ?? null,
            "status" => json_encode($demo["status"]),
            "question" => $demo["question"] ?? null,
            "assessment" => $demo["assessment"],
            "attachments" => json_encode($demo["attachments"])
        ];
    }
}
