<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $id
 */
class Skill extends Model
{

    use HasFactory;

    protected $table = 'skills';
    protected $guarded = ['id'];
}
