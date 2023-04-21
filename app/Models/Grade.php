<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grade extends Model
{
    use HasFactory;

    protected $table = "grades";
    protected $casts = [
        'time' => 'array'
    ];
    protected $guarded = ["id"];

    public function Students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "student_grade", "grade_id", "student_id");
    }

    public function Staffs(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, "staff_grade", "grade_id", "staff_id");
    }

    public function Teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, "teacher_grade", "grade_id", "teacher_id");
    }

    public function Clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, "client_grade", "grade_id", "client_id");
    }
    public function Supporters(): BelongsToMany
    {
        return $this->belongsToMany(Supporter::class, "supporter_grade", "grade_id", "supporter_id");
    }

    public function Menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, "grade_menus", "grade_id", "menu_id");
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return "Đang hoạt động";
            case 1:
                return "Đã kết thúc";
            case 2:
                return "Đang bảo lưu";
        }
    }
}
