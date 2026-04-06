<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'nama_item', 
        'qty', 
        'harga'
    ];

    // Relasi balik: Item ini milik Order yang mana
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}