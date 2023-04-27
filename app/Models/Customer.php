<?php

namespace App\Models;

use App\Models\Scopes\CustomerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $student_status
 * @property string $password
 */
class Customer extends User
{
    use HasFactory;

    protected $table = "users";
    protected $guarded = ["id"];

    public static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new CustomerScope);
    }

    public function Staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }

    public function getStatus(): string
    {
        return match ($this->student_status) {
            0 => "Tiềm năng",
            1 => "Không tiềm năng",
            2 => "Chưa học thử",
            default => "Không xác định",
        };
    }
}