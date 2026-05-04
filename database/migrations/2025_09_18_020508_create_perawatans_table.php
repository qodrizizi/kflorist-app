<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perawatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bonsai_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_perawatan');
            $table->string('jenis_perawatan'); // penyiraman, pemupukan, pemangkasan, repotting
            $table->text('catatan')->nullable();
            $table->string('status')->default('selesai'); // selesai, dijadwalkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perawatans');
    }
};
