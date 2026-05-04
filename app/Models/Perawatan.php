<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bonsai_id',
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
