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
        // Membuat tabel 'users' di dalam database
        Schema::create('users', function (Blueprint $table) {
            // Membuat primary key 'id' dengan tipe Big Integer yang auto-increment (bertambah otomatis)
            $table->id(); 
            
            // Membuat kolom 'name' untuk menyimpan nama user dengan tipe string (teks)
            $table->string('name', 100); 
            
            // Membuat kolom 'email' yang harus unik (tidak boleh ada email ganda)
            $table->string('email', 100)->unique(); 
            
            // Kolom opsional (boleh kosong/nullable) untuk mencatat kapan email diverifikasi
            $table->timestamp('email_verified_at')->nullable(); 
            
            // Membuat kolom 'password' untuk menyimpan kata sandi yang sudah dienkripsi
            $table->string('password'); 
            
            // Membuat kolom 'role' dengan tipe ENUM untuk membatasi nilai yang masuk hanya boleh 'admin' atau 'mekanik'
            // Default-nya diset 'mekanik' jika tidak diisi
            $table->enum('role', ['admin', 'mekanik'])->default('mekanik'); 
            
            // Membuat kolom 'remember_token' untuk fitur "ingat saya" saat login
            $table->rememberToken(); 
            
            // Membuat kolom 'created_at' dan 'updated_at' otomatis untuk mencatat waktu data dibuat & diubah
            $table->timestamps(); 
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
