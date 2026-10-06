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
                'jabatan' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_karyawan' => 'K002',
                'name' => 'Budi Mekanik',
                'username' => 'budi',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('password'),
                'jabatan' => 'Mekanik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pelanggan
        DB::table('pelanggan')->insert([
            [
                'id_pelanggan' => 'P001',
                'nama_pelanggan' => 'Dannarnd',
                'nomor_hp' => '081234567890',
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
                'nomor_polisi' => 'BL0987AAZ',
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
            ['keyword' => 'buka', 'action_type' => 'text', 'response_text' => 'Bengkel buka dari jam 08.00 hingga 17.00 setiap hari kerja.'],
            ['keyword' => 'lokasi', 'action_type' => 'text', 'response_text' => 'Lokasi bengkel kami di Jalan Lorong Himalaya, Banda Aceh.'],
            ['keyword' => 'status', 'action_type' => 'status_check', 'response_text' => 'Memeriksa status...'],
        ]);
    }
}
