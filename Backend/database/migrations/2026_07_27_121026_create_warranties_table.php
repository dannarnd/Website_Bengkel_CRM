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
        // Membuat tabel 'warranty' (Garansi)
        Schema::create('warranty', function (Blueprint $table) {
            $table->id(); 
            
            // Menyambungkan garansi dengan histori servis tertentu
            $table->unsignedBigInteger('service_id'); 
            
            // Tanggal mulainya garansi (di-set otomatis saat servis selesai)
            $table->date('tanggal_mulai'); 
            
            // Tanggal hangusnya garansi (misal 30 hari dari tanggal mulai)
            $table->date('tanggal_berakhir'); 
            
            // Status apakah garansi masih berlaku, sudah habis, atau sudah pernah diklaim
            $table->enum('status_garansi', ['Aktif', 'Habis', 'Diklaim'])->default('Aktif'); 
            
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
        Schema::dropIfExists('warranty');
    }
};
