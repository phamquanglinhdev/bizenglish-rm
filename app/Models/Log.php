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
        return $this->Grade()->first()->clients()->get()->pluck('name',"id")->toArray();
    }

    public function Partner(): ?string
    {
//        return $this->Teacher()->first()->Partner()->first();
        return null;
    }
    public function Students(): array
    {
        return $this->Grade()->first()->students()->get()->pluck('name',"id")->toArray();
    }
}
