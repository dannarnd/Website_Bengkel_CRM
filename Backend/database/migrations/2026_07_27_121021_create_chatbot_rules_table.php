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
        // Membuat tabel 'chatbot_rule'
        Schema::create('chatbot_rule', function (Blueprint $table) {
            // ID unik aturan chatbot
            $table->id(); 
            
            // Kolom 'keyword' menyimpan kata kunci dari pertanyaan pelanggan (contoh: "harga", "buka jam berapa")
            $table->string('keyword', 100); 
            
            // Kolom 'respons_teks' bertipe text (bisa panjang) berisi jawaban balasan dari bot
            $table->text('respons_teks')->nullable(); 
            
            // Kolom 'action_type' menentukan apakah bot hanya membalas teks (text) atau harus mengambil data dari database (fetch_data)
            $table->string('action_type', 50)->default('text'); 
            
            // Mencatat waktu pembuatan dan perubahan aturan
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_rule');
    }
};
