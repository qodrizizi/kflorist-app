<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonsais', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('category');
            $table->integer('age')->nullable(); // umur
            $table->decimal('value', 15, 2)->nullable(); // nilai/harga
            $table->string('status')->default('available');
            $table->string('image')->nullable(); // path ke file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonsais');
    }
};