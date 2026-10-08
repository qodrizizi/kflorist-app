<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CommunityReaction extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'community_reactions';

    protected $fillable = [
        'post_id',
        'user_id',
        'type', // 'subur', 'like'
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
