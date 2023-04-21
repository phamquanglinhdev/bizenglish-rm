<?php

namespace App\Models;

use App\Models\Scopes\ClientScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends User
{
    use HasFactory;

    protected $table = "users";
    protected $guarded = ["id"];
    public static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new ClientScope);
    }
}
