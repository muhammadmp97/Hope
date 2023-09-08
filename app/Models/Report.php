<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    public const REPORTABLE_TYPES = [
        'challenge' => Challenge::class,
        'comment' => Comment::class,
        'user' => User::class,
    ];

    public function reportable()
    {
        return $this->morphTo();
    }

    public function reporter()
    {
        return $this->belongsTo(User::class);
    }
}
