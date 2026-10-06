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
        // Membuat tabel 'sparepart' di dalam database
        Schema::create('sparepart', function (Blueprint $table) {
            // Membuat primary key (ID unik) untuk setiap jenis sparepart
            $table->id(); 
            
            // Membuat kolom 'kode_barang' (SKU)
            $table->string('kode_barang', 10)->unique();
            
            // Membuat kolom 'nama_barang' dengan tipe string (Maks 100 Karakter) untuk menyimpan nama sparepart
            $table->string('nama_barang', 100);
            
            // Membuat kolom 'harga' dengan tipe integer untuk menyimpan harga jual sparepart
            $table->integer('harga'); 
            
            // Membuat kolom 'stok_sekarang' dengan tipe integer untuk melacak sisa barang
            $table->integer('stok_sekarang'); 
            
            // Membuat kolom 'batas_minimum' untuk fitur "Warning Threshold". 
            // Jika stok menyentuh angka ini, sistem akan memberikan alert/peringatan.
            $table->integer('batas_minimum'); 
            
            // Otomatis mencatat waktu barang ditambahkan atau datanya diperbarui
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparepart');
    }
};
