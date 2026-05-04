<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'order_code',
        'user_id',
        'bonsai_id',
        'quantity',
        'total_price',
        'status',
        'alamat_pengiriman',
        'metode_pembayaran',
        'catatan',
        'payment_type',
        'payment_bank',
        'payment_va_number',
        'payment_bill_key',
        'payment_biller_code',
        'payment_qr_url',
        'payment_expiry_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bonsai()
    {
        return $this->belongsTo(Bonsai::class);
    }
}
