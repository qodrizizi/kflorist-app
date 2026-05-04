<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bonsai_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 15, 2);
            $table->string('status')->default('pending'); // pending, diproses, dikirim, selesai, dibatalkan
            $table->text('alamat_pengiriman')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
