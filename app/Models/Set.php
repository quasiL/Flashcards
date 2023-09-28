<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static where(string $string, int $newNumber)
 */
class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'user_id'
    ];

    public function flashcards(): HasMany
    {
        return $this->hasMany(Flashcard::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
