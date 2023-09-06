<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['user'];

    protected $casts = [
        'continued_at' => 'datetime',
    ];

    public function scopeByUserId(Builder $query, $userId = null): void
    {
        if ($userId !== null) {
            $query->where('user_id', $userId);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
