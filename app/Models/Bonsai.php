<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonsai extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'species',
        'age_years',
        'age_months',
        'height_cm',
        'trunk_diameter_cm',
        'pot_size',
        'pot_type',
        'health_status',
        'location',
        'light_requirement',
        'last_watered_at',
        'last_fertilized_at',
        'last_pruned_at',
        'last_repotted_at',
        'watering_frequency',
        'fertilizing_frequency',
        'pruning_frequency',
        'repotting_frequency',
        'acquisition_price',
        'acquisition_date',
        'current_value',
        'status',
        'image_path',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_watered_at' => 'datetime',
        'last_fertilized_at' => 'datetime',
        'last_pruned_at' => 'datetime',
        'last_repotted_at' => 'datetime',
        'acquisition_date' => 'date',
    ];

    /**
     * Get the category that owns the bonsai.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
