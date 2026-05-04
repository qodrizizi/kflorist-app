<?php

namespace Database\Seeders;

use App\Models\Perawatan;
use App\Models\Bonsai;
use Illuminate\Database\Seeder;

class PerawatanSeeder extends Seeder
{
    public function run(): void
    {
        $bonsais = Bonsai::all();

        $jenisPerawatan = ['Penyiraman', 'Pemupukan', 'Pemangkasan', 'Repotting', 'Pengendalian Hama'];

        foreach ($bonsais as $bonsai) {
            // Buat 2-3 catatan perawatan untuk setiap bonsai
            $count = rand(2, 3);
            for ($i = 0; $i < $count; $i++) {
                Perawatan::create([
                    'bonsai_id' => $bonsai->id,
                    'tanggal_perawatan' => now()->subDays(rand(1, 30)),
                    'jenis_perawatan' => $jenisPerawatan[array_rand($jenisPerawatan)],
                    'catatan' => 'Perawatan rutin untuk ' . $bonsai->name,
                    'status' => rand(0, 1) ? 'selesai' : 'dijadwalkan',
                ]);
            }
        }
    }
}
