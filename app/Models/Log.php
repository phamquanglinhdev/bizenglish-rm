<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * @property string $teacher_video
 * @property string $drive
 */
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
        $teacher = $this->Teacher()->first();
        if (isset($teacher->id)) {
            $partner = $teacher->Partner()->first();
            if (isset($partner->id)) {
                return $partner;
            }
        }
        return null;
    }

    public function Students(): array
    {
        return $this->Grade()->first()->students()->get()->pluck('name', "id")->toArray();
    }

    public function StudentsObject(): \Illuminate\Support\Collection
    {
        return $this->Grade()->first()->Students()->get();
    }

    public function StatusShow()
    {
        if ($this->status != null) {
            if (!is_array($this->status)) {
                $status = (array)json_decode($this->status)[0];
            } else {
                $status = $this->status[0];
            }
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
        return '';
    }

    public function StudentAccept(): string
    {
        $message = "";
        $ac = DB::table("student_log")->where("log_id", "=", $this->id);
        if ($ac->count() == 0) {
            return "Chưa có HS xác nhận";
        } else {
            $students = DB::table("student_log")->where("log_id", "=", $this->id)->get();
            foreach ($students as $student) {
                $name = DB::table("users")->where("id", "=", $student->student_id)->first()->name;
                if ($student->accept == 0) {
                    $acp = "Đúng";
                } else {
                    $acp = "Sai";
                }
                $message = "<div> Xác nhận $acp </div>";
                if ($student->comment != null) {
                    $message .= "<div>Thông tin thêm: $student->comment</div> ";
                }


            }
            return $message;
        }
    }

    public function getEmbed(): string
    {
        if ($this->teacher_video) {
            $video = json_decode($this->teacher_video);
            $id = $video->id;
            return "https://www.youtube.com/embed/$id?autoplay=1&modestbranding=1";
        }
        if ($this->drive) {
            $link = str_replace("/edit", "/preview", $this->drive);
            return str_replace("/view", "/preview", $link);
        }
        return "-";
    }
}
