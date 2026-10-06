## 1. Tabel Utama (Master Data)

Kita memiliki 3 tabel *Master* yang berdiri sendiri dan menyimpan data pokok:

### A. Tabel `users`
- **Fungsi:** Menyimpan data pegawai bengkel (Mekanik & Admin) untuk keperluan *Login*.
- **Kolom Penting:** `name`, `email`, `password`, `role` (enum: admin/mekanik).

### B. Tabel `pelanggans`
- **Fungsi:** Menyimpan identitas pelanggan dan kendaraannya.
- **Kolom Penting:** `nama`, `nomor_hp`, `nomor_polisi`.

### C. Tabel `spareparts`
- **Fungsi:** Menyimpan katalog suku cadang dan stok yang tersedia di gudang.
- **Kolom Penting:** `nama_barang`, `harga`, `stok_sekarang`, `batas_minimum`.

---

## 2. Tabel Transaksi & Relasinya (Transaction Data)

Bagian ini adalah inti dari aplikasi bengkel kita. Data dari tabel-tabel master di atas digabungkan di sini.

### A. Tabel `services` (Nota Induk Servis)
Tabel ini mencatat kapan sebuah mobil masuk, apa keluhannya, dan siapa mekanik yang mengerjakannya.

- **Foreign Key (Kunci Tamu):**
  - `pelanggan_id`: Merujuk ke tabel `pelanggans`. (Milik siapa mobil ini?)
  - `user_id`: Merujuk ke tabel `users`. (Siapa mekanik yang memperbaiki?)
- **Relasi Database:**
  - **One-to-Many:** Satu Pelanggan bisa melakukan banyak Servis.
  - **One-to-Many:** Satu Mekanik bisa mengerjakan banyak Servis.

**Contoh Kode Pemanggilan Relasi di Laravel (Model `Service.php`):**
```php
// Di dalam file App\Models\Service.php

// 1 Servis ini milik 1 Pelanggan (BelongsTo)
public function pelanggan() {
    return $this->belongsTo(Pelanggan::class);
}

// 1 Servis ini dikerjakan oleh 1 Mekanik (BelongsTo)
public function mekanik() {
    return $this->belongsTo(User::class, 'user_id');
}
```

### B. Tabel `service_details` (Rincian Suku Cadang yang Dipakai)
Karena satu kali servis (satu nota) bisa menghabiskan banyak jenis suku cadang, kita membutuhkan tabel *pivot* (penghubung) bernama `service_details`.

- **Foreign Key (Kunci Tamu):**
  - `service_id`: Merujuk ke nota `services`.
  - `sparepart_id`: Merujuk ke barang `spareparts`.
- **Relasi Database:**
  - **One-to-Many:** Satu `services` memiliki BANYAK `service_details`.
  - **Many-to-Many:** Tabel ini pada dasarnya menciptakan relasi *Many-to-Many* antara `services` dan `spareparts`.

**Contoh Kode Pemanggilan Relasi di Laravel:**
```php
// Di dalam file App\Models\Service.php
public function details() {
    return $this->hasMany(ServiceDetail::class);
}

// Di dalam file App\Models\ServiceDetail.php
public function sparepart() {
    return $this->belongsTo(Sparepart::class);
}
```

---

## 3. Bagaimana Cara Kode Kita Memanggil Semuanya Sekaligus? (Eager Loading)

Ini adalah bagian kodingan (*Controller*) *"Bagaimana caramu menampilkan Nota Servis, nama pelanggannya, nama mekaniknya, sekaligus daftar sparepart yang dibelinya dalam satu kali proses?"*

Di Laravel, kita memanggil semua relasi yang sudah kita buat di Model tadi menggunakan teknik bernama **Eager Loading** (menggunakan fungsi `with`). Ini mencegah aplikasi menjadi lambat (menghindari masalah *N+1 Query*).

**Kodingan Asli di `ServiceController.php` (Fungsi Show):**
```php
public function show($id)
{
    // Cari servis berdasarkan ID, sekaligus (with) 
    // tarik data pelanggannya, mekaniknya, dan detail barangnya!
    $service = Service::with([
        'pelanggan', 
        'mekanik', 
        'details.sparepart' // Menarik relasi bersarang (Nested Relation)
    ])->findOrFail($id);

    return response()->json($service);
}
```

saat halaman Detail Servis dibuka, Laravel tidak melakukan *query SELECT* berulang-ulang yang bikin lambat. Saya menggunakan fungsi `with()` di Eloquent. Fungsi ini akan langsung melakukan operasi `SQL JOIN` di belakang layar. Jadi, dengan satu kali pemanggilan kode, sistem sudah otomatis menarik data Nota Servis (services), dikaitkan dengan nama pemilik mobil (pelanggans), nama montir (users), dan seluruh rincian barang (spareparts) yang terkait dengan nota tersebut."*

---

## Ringkasan Relasi Database

1. `users` **(1...N)** `services` 
   (Satu mekanik mengerjakan banyak servis).
2. `pelanggans` **(1...N)** `services` 
   (Satu pelanggan memiliki banyak riwayat servis).
3. `services` **(1...N)** `service_details` 
   (Satu nota servis memiliki banyak rincian barang).
4. `spareparts` **(1...N)** `service_details` 
   (Satu jenis suku cadang bisa tercatat di banyak rincian servis).
