<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
