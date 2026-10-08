<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CommunityPost extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'community_posts';

    protected $fillable = [
        'user_id',
        'category',
        'species',
        'post_type',
        'content',
        'images',
        'before_image',
        'after_image',
        'bonsai_id',
        'discount_code',
        'discount_percent',
        'flash_sale_ends_at',
        'likes_count',
        'subur_count',
        'comments_count',
    ];

    protected $casts = [
        'images' => 'array',
        'flash_sale_ends_at' => 'datetime',
        'likes_count' => 'integer',
        'subur_count' => 'integer',
        'comments_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bonsai()
    {
        return $this->belongsTo(Bonsai::class);
    }

    public function comments()
    {
        return $this->hasMany(CommunityComment::class, 'post_id')->latest();
    }

    public function reactions()
    {
        return $this->hasMany(CommunityReaction::class, 'post_id');
    }

    public function poll()
    {
        return $this->hasOne(CommunityPoll::class, 'post_id');
    }

    public function isReactedBy($userId, $type)
    {
        if (!$userId) return false;
        return $this->reactions()->where('user_id', $userId)->where('type', $type)->exists();
    }
}
