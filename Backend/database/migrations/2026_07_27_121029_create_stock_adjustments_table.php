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
        // Membuat tabel 'stock_adjustment' (Riwayat Keluar/Masuk Barang)
        Schema::create('stock_adjustment', function (Blueprint $table) {
            $table->id(); 
            
            // Berelasi dengan sparepart mana yang berubah stoknya
            $table->unsignedBigInteger('sparepart_id'); 
            
            // Jumlah barang yang ditambah atau dikurangi
            $table->integer('qty'); 
            
            // Tipe penyesuaian: 'Masuk' (contoh: kulakan/pembelian) atau 'Keluar' (contoh: dipakai servis/rusak)
            $table->enum('tipe', ['Masuk', 'Keluar']); 
            
            // Alasan kenapa barang berubah jumlahnya (contoh: "Dipakai untuk Service ID #12", "Kulakan dari supplier")
            $table->string('keterangan'); 
            
            // Mencatat kapan pergerakan barang ini terjadi
            $table->dateTime('tanggal'); 
            
            $table->timestamps(); 

            // Relasi ke tabel sparepart
            $table->foreign('sparepart_id')->references('id')->on('sparepart')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment');
    }
};
