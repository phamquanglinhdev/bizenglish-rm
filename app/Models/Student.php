<?php

namespace App\Models;

use App\Models\Scopes\StudentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends User
{
    use HasFactory;

    protected $table = "users";
    protected $guarded = ["id"];

    public static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new StudentScope);
    }

    public function Grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, "student_grade", "student_id", "grade_id");
    }

    public function Staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }

    public function Supporter(): ?string
    {
        $grades = $this->Grades()->first();
        if (isset($grades->id)) {
            return $grades->Supporters()->first();
        }
        return null;
    }

    public function getStatus(): string
    {
        return match ($this->student_status) {
            "0" => "Đang học",
            "1" => "Đã ngừng học",
            "2" => "Đang bảo lưu",
            default => "Không xác định",
        };
    }
}
