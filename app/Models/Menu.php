<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Book;

/**
 * @property string $name
 * @property int $parent_id
 *
 */
class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";
    protected $guarded = ["id"];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, "parent_id", "id");
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, "parent_id", "id");
    }

    public function Books(): HasMany
    {
        return $this->hasMany(Book::class, "menu_id", "id");
    }

}
