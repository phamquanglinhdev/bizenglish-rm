<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Demo extends Model
{
    use HasFactory;

    protected $table = "demos";
    protected $guarded = ["id"];

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, "teacher_id", "id");
    }

    public function Client(): BelongsTo
    {
        return $this->belongsTo(Client::class, "client_id", "id");
    }

    public function Customer(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, "customer_demo", "demo_id", "customer_id");
    }

    public function Staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, "staff_id");
    }

    public function Supporter(): BelongsTo
    {
        return $this->belongsTo(Supporter::class, "supporter_id", "id");
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
}
