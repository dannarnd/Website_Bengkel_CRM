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
        // Membuat tabel 'service_detail' (Rincian Sparepart yang Dipakai)
        Schema::create('service_detail', function (Blueprint $table) {
            // ID unik untuk baris detail
            $table->id(); 
            
            // Menyambungkan rincian ini dengan nota servis yang mana
            $table->unsignedBigInteger('service_id'); 
            
            // Menyambungkan rincian ini dengan barang apa yang diambil
            $table->unsignedBigInteger('sparepart_id'); 
            
            // Jumlah/Quantity barang yang digunakan
            $table->integer('qty'); 
            
            // Total harga dari barang tersebut (qty dikali harga satuan pada saat itu)
            $table->integer('subtotal'); 
            
            $table->timestamps(); 

            // Aturan Foreign Key: Jika data nota servis induknya dihapus, rincian ini wajib ikut terhapus agar tidak ada data yatim (orphan data)
            $table->foreign('service_id')->references('id')->on('service')->onDelete('cascade');
            
            // Aturan Foreign Key ke tabel sparepart
            $table->foreign('sparepart_id')->references('id')->on('sparepart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_detail');
    }
};
