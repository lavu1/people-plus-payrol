<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];

    public function scopeByUser(Builder $query, $userId) {
        return $query->where('user_id', $userId);
    }

    protected static function booted() {
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
