<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CommunityPoll extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'community_polls';

    protected $fillable = [
        'post_id',
        'question',
        'options',
        'total_votes',
    ];

    protected $casts = [
        'options' => 'array',
        'total_votes' => 'integer',
    ];

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    public function votes()
    {
        return $this->hasMany(CommunityPollVote::class, 'post_id', 'post_id');
    }

    public function userVotedOption($userId)
    {
        if (!$userId) return null;
        $vote = $this->votes()->where('user_id', $userId)->first();
        return $vote ? $vote->option_id : null;
    }
}
