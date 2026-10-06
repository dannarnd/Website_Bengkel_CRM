<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotRule;

class ChatbotRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama jika ada
        ChatbotRule::truncate();

        $rules = [
            [
                'keyword' => 'jam buka',
                'respons_teks' => 'Halo! Bengkel Doles Radiator buka setiap hari Senin - Sabtu mulai pukul 08:30 pagi hingga 17:30 sore. Hari Minggu dan libur nasional kami tutup. Ada yang bisa dibantu?',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'buka jam',
                'respons_teks' => 'Halo! Bengkel Doles Radiator buka setiap hari Senin - Sabtu mulai pukul 08:30 pagi hingga 17:30 sore. Hari Minggu dan libur nasional kami tutup. Ada yang bisa dibantu?',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'lokasi',
                'respons_teks' => 'Lokasi bengkel kami berada di Jalan Utama Otomotif No. 12, Pusat Kota. Anda juga bisa mencari "Doles Radiator" di Google Maps untuk panduan arah. Kami tunggu kedatangannya!',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'alamat',
                'respons_teks' => 'Alamat lengkap Doles Radiator adalah di Jalan Utama Otomotif No. 12, Pusat Kota. Bersebelahan dengan Pom Bensin Utama. Apakah Anda ingin reservasi servis?',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'kontak',
                'respons_teks' => 'Anda dapat menghubungi Admin bengkel kami melalui WhatsApp di nomor 0821-6344-4129 untuk reservasi atau pertanyaan lebih lanjut.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'whatsapp',
                'respons_teks' => 'Tentu, silakan hubungi WhatsApp bengkel kami di 0821-6344-4129. Admin kami siap membantu Anda.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'harga',
                'respons_teks' => '',
                'action_type' => 'check_price' // Fitur dinamis (cek ke database)
            ],
            [
                'keyword' => 'biaya',
                'respons_teks' => '',
                'action_type' => 'check_price' // Fitur dinamis (cek ke database)
            ],
            [
                'keyword' => 'stok',
                'respons_teks' => '',
                'action_type' => 'check_stock' // Fitur dinamis (cek ke database)
            ],
            [
                'keyword' => 'sisa',
                'respons_teks' => '',
                'action_type' => 'check_stock' // Fitur dinamis (cek ke database)
            ],
            [
                'keyword' => 'booking',
                'respons_teks' => 'Untuk melakukan booking servis, mohon chat ke WhatsApp 0821-6344-4129 dengan format: Nama / Plat Nomor / Keluhan / Jadwal. Admin akan segera memproses antrean Anda.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'daftar servis',
                'respons_teks' => 'Pendaftaran servis saat ini hanya bisa dilakukan secara langsung di bengkel atau melalui WhatsApp 0821-6344-4129 agar mekanik bisa mengestimasi waktu pengerjaan.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'overheat',
                'respons_teks' => 'Mesin overheat (panas berlebih) sangat berbahaya jika dipaksakan jalan. Sebaiknya segera tepikan kendaraan, tunggu mesin dingin, lalu periksa air radiator. Jika kosong, isi perlahan. Jika terus terjadi, silakan bawa ke Doles Radiator untuk dianalisis kebocorannya.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'panas',
                'respons_teks' => 'Indikator suhu mesin naik (panas) bisa disebabkan oleh radiator mampet, kipas mati, atau ada kebocoran air. Kami sangat menyarankan untuk dibawa ke bengkel untuk ditiup saluran radiatornya (korok) atau dicek secara menyeluruh.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'bocor',
                'respons_teks' => 'Radiator yang bocor bisa diperbaiki dengan dilas kuningan atau aluminium di tempat kami. Waktu pengerjaan las biasanya 1-2 jam tergantung tingkat keparahannya. Segera bawa ke bengkel sebelum merusak mesin (turun mesin)!',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'air habis',
                'respons_teks' => 'Air radiator yang cepat habis menandakan adanya kebocoran atau penguapan berlebih akibat tutup radiator rusak. Jangan abaikan masalah ini, mekanik kami siap mengecek dan memperbaikinya.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'ac',
                'respons_teks' => 'AC kurang dingin kadang berkaitan dengan kipas (extra fan) radiator yang mati, sehingga suhu kondensor naik. Kami bisa mengecek apakah kipas radiator kendaraan Anda masih berfungsi normal.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'berapa lama',
                'respons_teks' => 'Lama pengerjaan sangat bervariasi. Untuk servis ringan (korok/bersih radiator) biasanya butuh 1-2 jam. Untuk perbaikan las berat atau ganti upper tank bisa setengah hari. Silakan datang langsung agar mekanik bisa cek.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'pembayaran',
                'respons_teks' => 'Kami menerima pembayaran tunai (Cash), Transfer Bank (BCA/Mandiri), dan juga memfasilitasi scan QRIS. Semua transaksi dijamin transparan dan ada nota resmi bengkel.',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'garansi',
                'respons_teks' => 'Setiap pengerjaan berat seperti las radiator atau penggantian suku cadang utama di Doles Radiator selalu disertai GARANSI (biasanya 1 bulan atau 3 bulan). Status garansi dapat dilacak langsung dari halaman "Home" website ini dengan memasukkan plat kendaraan Anda!',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'bantuan',
                'respons_teks' => 'Saya adalah Bot Asisten Doles! Anda bisa bertanya: "Jam buka", "Harga coolant", "Stok tutup radiator", "Alamat", atau "Solusi overheat". Coba ketik salah satunya!',
                'action_type' => 'text'
            ],
            [
                'keyword' => 'halo',
                'respons_teks' => 'Halo! Selamat datang di Doles Radiator. Ada yang bisa saya bantu terkait masalah pendinginan mesin kendaraan Anda?',
                'action_type' => 'text'
            ]
        ];

        foreach ($rules as $rule) {
            ChatbotRule::create($rule);
        }
    }
}
