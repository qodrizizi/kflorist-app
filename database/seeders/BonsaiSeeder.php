<?php

namespace Database\Seeders;

use App\Models\Bonsai;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BonsaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indoor = Category::where('name', 'Indoor')->first();
        $outdoor = Category::where('name', 'Outdoor')->first();
        $premium = Category::where('name', 'Premium')->first();
        $bibit = Category::where('name', 'Bibit')->first();

        $bonsais = [
            // Indoor
            [
                'code' => 'BNS-IND-001',
                'name' => 'Ficus Microcarpa Style',
                'category_id' => $indoor->id,
                'species' => 'Ficus microcarpa',
                'age_years' => 7,
                'height_cm' => 35,
                'current_value' => 1250000,
                'status' => 'available',
                'health_status' => 'Excellent',
                'light_requirement' => 'Partial Shade',
                'watering_frequency' => 'Daily',
            ],
            [
                'code' => 'BNS-IND-002',
                'name' => 'Fukien Tea Classic',
                'category_id' => $indoor->id,
                'species' => 'Carmona retusa',
                'age_years' => 5,
                'height_cm' => 25,
                'current_value' => 850000,
                'status' => 'available',
                'health_status' => 'Good',
                'light_requirement' => 'Bright Indirect',
            ],

            // Outdoor
            [
                'code' => 'BNS-OUT-001',
                'name' => 'Juniper Shimpaku',
                'category_id' => $outdoor->id,
                'species' => 'Juniperus chinensis',
                'age_years' => 12,
                'height_cm' => 45,
                'current_value' => 3500000,
                'status' => 'available',
                'health_status' => 'Excellent',
                'light_requirement' => 'Full Sun',
            ],
            [
                'code' => 'BNS-OUT-002',
                'name' => 'Black Pine Cascade',
                'category_id' => $outdoor->id,
                'species' => 'Pinus thunbergii',
                'age_years' => 15,
                'height_cm' => 50,
                'current_value' => 4500000,
                'status' => 'sold',
                'health_status' => 'Excellent',
                'light_requirement' => 'Full Sun',
            ],

            // Premium
            [
                'code' => 'BNS-PRM-001',
                'name' => 'Anting Putri Masterpiece',
                'category_id' => $premium->id,
                'species' => 'Wrightia religiosa',
                'age_years' => 25,
                'height_cm' => 70,
                'current_value' => 15000000,
                'status' => 'available',
                'health_status' => 'Perfect',
                'light_requirement' => 'Full Sun',
            ],
            [
                'code' => 'BNS-PRM-002',
                'name' => 'Japanese Maple Red',
                'category_id' => $premium->id,
                'species' => 'Acer palmatum',
                'age_years' => 20,
                'height_cm' => 60,
                'current_value' => 12000000,
                'status' => 'available',
                'health_status' => 'Excellent',
                'light_requirement' => 'Partial Sun',
            ],

            // Bibit
            [
                'code' => 'BNS-BBT-001',
                'name' => 'Bibit Santigi Karang',
                'category_id' => $bibit->id,
                'species' => 'Pemphis acidula',
                'age_years' => 1,
                'height_cm' => 15,
                'current_value' => 150000,
                'status' => 'available',
                'health_status' => 'Good',
                'light_requirement' => 'Full Sun',
            ],
            [
                'code' => 'BNS-BBT-002',
                'name' => 'Bibit Lohansung Blue',
                'category_id' => $bibit->id,
                'species' => 'Podocarpus macrophyllus',
                'age_years' => 2,
                'height_cm' => 20,
                'current_value' => 250000,
                'status' => 'available',
                'health_status' => 'Good',
            ],
        ];

        foreach ($bonsais as $bonsai) {
            Bonsai::create($bonsai);
        }
    }
}
