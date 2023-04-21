<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Collection\Collection;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $guarded = ["id"];
    protected $casts = [
        'status' => 'array',
    ];

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, "teacher_id", "id");
    }

    public function Grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, "grade_id", "id");
    }

    public function Clients(): array
    {
        return $this->Grade()->first()->clients()->get()->pluck('name', "id")->toArray();
    }

    public function Partner(): ?string
    {
//        return $this->Teacher()->first()->Partner()->first();
        return null;
    }

    public function Students(): array
    {
        return $this->Grade()->first()->students()->get()->pluck('name', "id")->toArray();
    }

    public function StatusShow()
    {
        if ($this->status != null) {
            $status = $this->status[0];
            if ($status["name"] == "") {
                $status["name"] = 9;
            }
            $time = $status["time"];
            $name = $status["name"] * 1;
            switch ($name * 1) {
                case 0:
                    return "Học viên và giáo viên vào đúng giờ.";
                case 1:
                    return "Học viên vào muộn $time phút";
                case 2:
                    return "Giáo viên vào muộn $time phút";
                case 3:
                    return "Học viên hủy buổi học trước $time giờ";
                case 4:
                    return "Giáo viên hủy buổi học trước $time giờ";
                case 9:
                    return "Lỗi";
                default:
                    return $status["message"];
            }
        }

    }
}
