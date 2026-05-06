<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Perawatan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'bonsai_id',
        'user_id',
        'tanggal_perawatan',
        'jenis_perawatan',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_perawatan' => 'date',
    ];

    public function bonsai()
    {
        return $this->belongsTo(Bonsai::class);
    }
}
