<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Category extends Model
{
    use HasFactory, HasUuids;

    /**
     * Atribut yang dapat diisi secara massal.
     * Sesuaikan dengan kolom pada tabel 'categories' Anda.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'icon', // Tambahkan kolom icon
        'color', // Tambahkan kolom color
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Bonsai.
     * Satu kategori bisa memiliki banyak bonsai.
     */
    public function bonsais()
    {
        return $this->hasMany(Bonsai::class);
    }
}

