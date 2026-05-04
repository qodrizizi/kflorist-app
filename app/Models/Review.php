<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'bonsai_id',
        'rating',
        'comment',
        'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bonsai()
    {
        return $this->belongsTo(Bonsai::class);
    }
}
