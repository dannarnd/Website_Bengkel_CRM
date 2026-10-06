<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Pelanggan;
use App\Models\Sparepart;

// 1. Export Data Pelanggan (XLS)
$pelanggans = Pelanggan::all();
$htmlPelanggan = "<table border='1'>
<tr>
    <th>No</th>
    <th>Nama Pelanggan</th>
    <th>Nomor HP</th>
    <th>Nomor Polisi (Plat)</th>
</tr>";

$no = 1;
foreach ($pelanggans as $p) {
    $htmlPelanggan .= "<tr>
        <td>{$no}</td>
        <td>{$p->nama}</td>
        <td>{$p->nomor_hp}</td>
        <td>{$p->nomor_polisi}</td>
    </tr>";
    $no++;
}
$htmlPelanggan .= "</table>";
file_put_contents('Data_Pelanggan_Bengkel.xls', $htmlPelanggan);

// 2. Export Data Sparepart (XLS)
$spareparts = Sparepart::all();
$htmlSparepart = "<table border='1'>
<tr>
    <th>No</th>
    <th>Kategori / Nama Barang</th>
    <th>Harga (Rp)</th>
    <th>Stok Saat Ini</th>
    <th>Batas Minimum</th>
</tr>";

$no = 1;
foreach ($spareparts as $sp) {
    $htmlSparepart .= "<tr>
        <td>{$no}</td>
        <td>{$sp->nama_barang}</td>
        <td>{$sp->harga}</td>
        <td>{$sp->stok_sekarang}</td>
        <td>{$sp->batas_minimum}</td>
    </tr>";
    $no++;
}
$htmlSparepart .= "</table>";
file_put_contents('Data_Sparepart_Bengkel.xls', $htmlSparepart);

echo "BERHASIL! File XLS telah dibuat.\n";


echo "BERHASIL! Dua file CSV telah dibuat di dalam folder Backend.\n";
