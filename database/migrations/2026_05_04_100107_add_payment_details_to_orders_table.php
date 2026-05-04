<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('metode_pembayaran');
            $table->string('payment_bank')->nullable()->after('payment_type');
            $table->string('payment_va_number')->nullable()->after('payment_bank');
            $table->string('payment_bill_key')->nullable()->after('payment_va_number');
            $table->string('payment_biller_code')->nullable()->after('payment_bill_key');
            $table->text('payment_qr_url')->nullable()->after('payment_biller_code');
            $table->timestamp('payment_expiry_time')->nullable()->after('payment_qr_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type', 
                'payment_bank', 
                'payment_va_number', 
                'payment_bill_key', 
                'payment_biller_code', 
                'payment_qr_url', 
                'payment_expiry_time'
            ]);
        });
    }
};
