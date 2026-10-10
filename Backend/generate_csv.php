<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fp = fopen('C:/Users/user/.gemini/antigravity-ide/brain/59a74f74-f88f-417f-b7f0-7c798767eabc/Data_Sparepart_Bengkel.csv', 'w');
fputcsv($fp, ['Kode Barang', 'Nama Barang', 'Distributor', 'Harga Jual', 'Stok Awal', 'Batas Minimum']);
$spareparts = App\Models\Sparepart::all();
foreach ($spareparts as $sp) {
    fputcsv($fp, [$sp->kode_barang, $sp->nama_barang, 'Stok Lama', $sp->harga, $sp->stok, $sp->batas_minimum]);
}
fclose($fp);
echo 'CSV Generated successfully.';
