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
        // Membuat tabel 'service' (Nota Pengerjaan Utama)
        Schema::create('service', function (Blueprint $table) {
            // ID unik transaksi servis
            $table->id(); 
            
            // Kolom Foreign Key yang menghubungkan servis ini dengan kendaraan yang diservis
            $table->string('nomor_polisi', 11); 
            
            // Kolom Foreign Key yang menghubungkan siapa mekanik yang mengerjakan mobil ini.
            $table->unsignedBigInteger('user_id'); 
            
            // Menyimpan deskripsi kerusakan atau permintaan dari pelanggan
            $table->text('keluhan'); 
            
            // Status pengerjaan servis, default-nya 'Menunggu'
            $table->enum('status', ['Menunggu', 'Dikerjakan', 'Selesai', 'Batal'])->default('Menunggu'); 
            
            // Menyimpan total biaya akhir (jasa + sparepart), default 0
            $table->integer('total_biaya')->default(0); 
            
            // Mencatat kapan mobil masuk ke bengkel
            $table->dateTime('tanggal_masuk'); 
            
            // Mencatat kapan mobil selesai diperbaiki (boleh kosong sebelum mobil benar-benar selesai)
            $table->dateTime('tanggal_selesai')->nullable(); 
            
            // timestamps (created_at & updated_at)
            $table->timestamps(); 

            // Definisi relasi ke kendaraan (onDelete cascade)
            $table->foreign('nomor_polisi')->references('nomor_polisi')->on('kendaraan')->onDelete('cascade');
            // Relasi ke tabel users (mekanik).
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
