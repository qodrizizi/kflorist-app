<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CommunityComment extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'community_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'is_best_solution',
    ];

    protected $casts = [
        'is_best_solution' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
