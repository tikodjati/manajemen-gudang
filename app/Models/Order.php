<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Mass assignment: kolom yang boleh diisi
    protected $fillable = [
        'order_id', 
        'user_id', 
        'total_harga', 
        'status', 
        'bukti_pembayaran'
    ];

    // Relasi: Satu Order dimiliki oleh satu Sales (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu Order punya banyak rincian barang
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}