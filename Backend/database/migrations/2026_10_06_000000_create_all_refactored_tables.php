<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. KARYAWAN
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('id_karyawan', 20)->primary();
            $table->string('name', 100);
            $table->string('username', 255)->unique();
            $table->string('password', 255);
            $table->string('jabatan', 255);
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. PELANGGAN
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('id_pelanggan', 20)->primary();
            $table->string('nama_pelanggan', 100);
            $table->string('nomor_hp', 15);
            $table->timestamps();
        });

        // 3. KENDARAAN
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->string('id_kendaraan', 20)->primary();
            $table->string('id_pelanggan', 20);
            $table->string('nomor_polisi', 11)->unique();
            $table->string('merk_mobil', 50);
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });

        // 4. SPAREPART
        Schema::create('sparepart', function (Blueprint $table) {
            $table->string('kode_barang', 50)->primary();
            $table->string('nama_barang', 100);
            $table->integer('harga');
            $table->integer('stok');
            $table->integer('batas_minimum');
            $table->timestamps();
        });

        // 5. DISTRIBUTOR
        Schema::create('distributor', function (Blueprint $table) {
            $table->string('id_distributor', 20)->primary();
            $table->string('nama_distributor', 100);
            $table->text('alamat');
            $table->string('no_hp', 15);
            $table->timestamps();
        });

        // 6. PEMBELIAN (BARANG MASUK)
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id_pembelian', 20)->primary();
            $table->string('id_distributor', 20);
            $table->string('id_karyawan', 20);
            $table->date('tanggal_beli');
            $table->decimal('total_bayar', 15, 2);
            $table->timestamps();

            $table->foreign('id_distributor')->references('id_distributor')->on('distributor')->onDelete('cascade');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });

        // 7. PEMBELIAN DETAIL
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->id('id_pembelian_detail');
            $table->string('id_pembelian', 20);
            $table->string('kode_barang', 50);
            $table->integer('qty_masuk');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('sparepart')->onDelete('cascade');
        });

        // 8. SERVICE (BARANG KELUAR 1)
        Schema::create('service', function (Blueprint $table) {
            $table->string('id_service', 20)->primary();
            $table->string('id_kendaraan', 20);
            $table->string('id_karyawan', 20);
            $table->string('invoice_number', 50)->unique();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai']);
            $table->integer('total_biaya');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('kendaraan')->onDelete('cascade');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });

        // 9. SERVICE DETAIL
        Schema::create('service_detail', function (Blueprint $table) {
            $table->id('id_service_detail');
            $table->string('id_service', 20);
            $table->string('kode_barang', 50);
            $table->integer('qty');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('sparepart')->onDelete('cascade');
        });

        // 10. PENJUALAN LANGSUNG (BARANG KELUAR 2)
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('id_penjualan', 20)->primary();
            $table->string('id_karyawan', 20);
            $table->string('nama_pembeli_umum', 100);
            $table->date('tanggal_penjualan');
            $table->decimal('total_bayar', 15, 2);
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });

        // 11. PENJUALAN DETAIL
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id('id_penj_detail');
            $table->string('id_penjualan', 20);
            $table->string('kode_barang', 50);
            $table->integer('qty');
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('sparepart')->onDelete('cascade');
        });

        // 12. SERVICE PHOTO
        Schema::create('service_photo', function (Blueprint $table) {
            $table->id('id_service_photo');
            $table->string('id_service', 20);
            $table->enum('tipe_foto', ['Sebelum', 'Sesudah']);
            $table->string('photo_path');
            $table->timestamps();

            $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
        });

        // 13. WARRANTY
        Schema::create('warranty', function (Blueprint $table) {
            $table->id('id_warranty');
            $table->string('id_service', 20);
            $table->date('tanggal_selesai');
            $table->enum('status', ['Aktif', 'Habis']);
            $table->timestamps();

            $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
        });

        // 14. CHATBOT RULES
        Schema::create('chatbot_rule', function (Blueprint $table) {
            $table->id('id_chatbot_rule');
            $table->string('keyword', 100)->unique();
            $table->string('action_type', 50);
            $table->text('response_text')->nullable();
            $table->timestamps();
        });

        // 15. CHATBOT HISTORY
        Schema::create('chatbot_history', function (Blueprint $table) {
            $table->id('id_chat');
            $table->string('nomor_polisi', 11)->nullable();
            $table->unsignedBigInteger('id_chatbot_rule')->nullable();
            $table->dateTime('waktu_chat');
            $table->timestamps();

            $table->foreign('nomor_polisi')->references('nomor_polisi')->on('kendaraan')->onDelete('set null');
            $table->foreign('id_chatbot_rule')->references('id_chatbot_rule')->on('chatbot_rule')->onDelete('set null');
        });
        
        // Sanctum tokens
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('tokenable_type');
            $table->string('tokenable_id', 20);
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['tokenable_type', 'tokenable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('chatbot_history');
        Schema::dropIfExists('chatbot_rule');
        Schema::dropIfExists('warranty');
        Schema::dropIfExists('service_photo');
        Schema::dropIfExists('penjualan_detail');
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('service_detail');
        Schema::dropIfExists('service');
        Schema::dropIfExists('pembelian_detail');
        Schema::dropIfExists('pembelian');
        Schema::dropIfExists('distributor');
        Schema::dropIfExists('sparepart');
        Schema::dropIfExists('kendaraan');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('karyawan');
    }
};
