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
        // Membuat tabel 'pelanggan'
        Schema::create('pelanggan', function (Blueprint $table) {
            // ID unik untuk setiap pelanggan
            $table->id(); 
            
            // Menyimpan nama lengkap pelanggan (Maks 100 Karakter)
            $table->string('nama', 100); 

            // Menyimpan nomor HP pelanggan (Maks 15 Karakter Internasional)
            $table->string('nomor_hp', 15); 
            
            // Mencatat waktu data dibuat dan diupdate
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
