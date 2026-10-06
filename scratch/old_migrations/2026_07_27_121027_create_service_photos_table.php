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
        // Membuat tabel 'service_photo' (Transparansi Visual)
        Schema::create('service_photo', function (Blueprint $table) {
            $table->id(); 
            
            // Berelasi ke nota servis
            $table->unsignedBigInteger('service_id'); 
            
            // Menyimpan nama/path file gambar kondisi mesin yang rusak (Sebelum)
            $table->string('foto_before'); 
            
            // Menyimpan nama/path file gambar kondisi mesin yang sudah beres (Sesudah). 
            // Boleh kosong karena foto ini baru di-upload saat perbaikan selesai.
            $table->string('foto_after')->nullable(); 
            
            $table->timestamps(); 

            // Relasi ke tabel service
            $table->foreign('service_id')->references('id')->on('service')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_photo');
    }
};
