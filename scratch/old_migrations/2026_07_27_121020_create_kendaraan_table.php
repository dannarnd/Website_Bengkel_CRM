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
        Schema::create('kendaraan', function (Blueprint $table) {
            // Plat nomor sebagai Primary Key
            $table->string('nomor_polisi', 11)->primary();
            
            // Relasi ke tabel pelanggan
            $table->unsignedBigInteger('pelanggan_id');
            
            // Model kendaraan (contoh: Avanza, Brio)
            $table->string('model', 50);
            
            $table->timestamps();

            // Foreign Key
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
