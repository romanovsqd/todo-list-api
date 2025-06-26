<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'user_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    protected $attributes = [
        'is_completed' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIsCompleted(Builder $query, ?bool $isCompleted)
    {
        return is_null($isCompleted)
            ? $query
            : $query->where('is_completed', $isCompleted);
    }

    public function scopeApplySort(Builder $query, ?string $sort)
    {
        return $query->orderBy('created_at', $sort ?? 'desc');
    }
}
