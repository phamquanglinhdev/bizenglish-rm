<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $minutes
 */
class Grade extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "grades";
    /**
     * @var string[]
     */
    protected $casts = [
        'time' => 'array'
    ];
    /**
     * @var string[]
     */
    protected $guarded = ["id"];

    /**
     * @return BelongsToMany
     */
    public function Students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "student_grade", "grade_id", "student_id");
    }

    /**
     * @return BelongsToMany
     */
    public function Staffs(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, "staff_grade", "grade_id", "staff_id");
    }

    /**
     * @return BelongsToMany
     */
    public function Teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, "teacher_grade", "grade_id", "teacher_id");
    }

    /**
     * @return BelongsToMany
     */
    public function Clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, "client_grade", "grade_id", "client_id");
    }

    /**
     * @return BelongsToMany
     */
    public function Supporters(): BelongsToMany
    {
        return $this->belongsToMany(Supporter::class, "supporter_grade", "grade_id", "supporter_id");
    }

    /**
     * @return BelongsToMany
     */
    public function Menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, "grade_menus", "grade_id", "menu_id");
    }

    /**
     * @return string|void
     */
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

    /**
     * @return bool
     */
    public function fewDates(): bool
    {
        $durations = $this->Logs()->sum("duration");
        return ($this->minutes) - $durations > 60;
    }

    /**
     * @return mixed
     */
    public function getRs()
    {
        $durations = $this->Logs()->sum("duration");
        return ($this->minutes) - $durations;
    }

    /**
     * @return float|int
     */
    public function percentCount(): float|int
    {
        $durations = $this->Logs()->sum("duration");
        if ($durations != 0) {
            return $durations / $this->minutes * 100;
        } else {
            return 0;
        }

    }

    public function Logs()
    {
        return $this->hasMany(Log::class, "grade_id", "id");
    }
}
