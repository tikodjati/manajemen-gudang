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
        // Tabel Header Order [cite: 292, 297]
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // ID Unik Order 
            $table->foreignId('user_id')->constrained('users'); // Relasi ke Sales [cite: 294, 295]
            $table->double('total_harga'); // Total transaksi 
            // Status: Belum_terkonfirmasi, Diterima, Ditolak [cite: 292, 297]
            $table->enum('status', ['belum_terkonfirmasi', 'diterima', 'ditolak'])->default('belum_terkonfirmasi');
            $table->string('bukti_pembayaran'); // Nama file bukti 
            $table->timestamps();
        });

        // Tabel Detail Item [cite: 292, 297]
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('nama_item'); // Atribut namaItem 
            $table->integer('qty'); // Atribut qty 
            $table->double('harga'); // Atribut harga 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_and_items_tables');
    }
};
