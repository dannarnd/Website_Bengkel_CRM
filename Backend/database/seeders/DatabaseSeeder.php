<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Karyawan
        DB::table('karyawan')->insert([
            [
                'id_karyawan' => 'K001',
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'jabatan' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_karyawan' => 'K002',
                'name' => 'Budi Mekanik',
                'username' => 'budi',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('password'),
                'jabatan' => 'mekanik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pelanggan
        DB::table('pelanggan')->insert([
            [
                'id_pelanggan' => 'P001',
                'nama_pelanggan' => 'Dannarnd',
                'nomor_hp' => '081234564546', // HP ends in 4546 (from screenshot)
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_pelanggan' => 'P002',
                'nama_pelanggan' => 'Andi',
                'nomor_hp' => '0853472893',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Kendaraan
        DB::table('kendaraan')->insert([
            [
                'id_kendaraan' => 'M001',
                'id_pelanggan' => 'P001',
                'nomor_polisi' => 'BL1234AD', // from screenshot
                'merk_mobil' => 'Toyota Avanza',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_kendaraan' => 'M002',
                'id_pelanggan' => 'P002',
                'nomor_polisi' => 'BK1234CD',
                'merk_mobil' => 'Honda Jazz',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Sparepart
        DB::table('sparepart')->insert([
            [
                'kode_barang' => 'SP001',
                'nama_barang' => 'Oli Mesin',
                'harga' => 50000,
                'stok' => 100,
                'batas_minimum' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_barang' => 'SP002',
                'nama_barang' => 'Kampas Rem Depan',
                'harga' => 150000,
                'stok' => 50,
                'batas_minimum' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Distributor
        DB::table('distributor')->insert([
            [
                'id_distributor' => 'D001',
                'nama_distributor' => 'PT Astra Honda',
                'alamat' => 'Jl. Jenderal Sudirman',
                'no_hp' => '08111222333',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Chatbot Rules
        DB::table('chatbot_rule')->insert([
            ['keyword' => 'buka', 'action_type' => 'text', 'response_text' => 'Bengkel Doles Radiator buka dari jam 08.00 hingga 18.00 setiap hari Senin-Sabtu.'],
            ['keyword' => 'lokasi', 'action_type' => 'text', 'response_text' => 'Lokasi bengkel Doles Radiator berada di Jalan Lorong Himalaya, Banda Aceh.'],
            ['keyword' => 'status', 'action_type' => 'status_check', 'response_text' => 'Memeriksa status perbaikan...'],
            ['keyword' => 'harga', 'action_type' => 'text', 'response_text' => 'Harga servis bervariasi tergantung jenis kerusakan. Silakan bawa kendaraan Anda untuk estimasi.'],
            ['keyword' => 'radiator', 'action_type' => 'text', 'response_text' => 'Kami spesialis servis radiator. Bisa korok, tambal, dan ganti upper tank.'],
            ['keyword' => 'halo', 'action_type' => 'text', 'response_text' => 'Halo! Ada yang bisa kami bantu seputar servis radiator kendaraan Anda?'],
        ]);

        // Service
        DB::table('service')->insert([
            [
                'id_service' => 'S001',
                'id_kendaraan' => 'M001',
                'id_karyawan' => 'K002',
                'invoice_number' => 'INV-202610-001',
                'status' => 'Diproses',
                'total_biaya' => 200000,
                'catatan' => 'Radiator bocor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        
        DB::table('service_detail')->insert([
            [
                'id_service' => 'S001',
                'kode_barang' => 'SP001',
                'qty' => 1,
                'subtotal' => 50000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_service' => 'S001',
                'kode_barang' => 'SP002',
                'qty' => 1,
                'subtotal' => 150000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
