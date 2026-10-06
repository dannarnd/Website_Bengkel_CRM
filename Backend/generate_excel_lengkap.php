<?php

$downloadsPath = 'C:\Users\user\Downloads\Data_Sparepart_Lengkap.xls';

// Kategori & Data Skala Besar (Ratusan Data untuk Bengkel Lama)
$data = [
    'Radiator Upper Tank (RUT)' => [
        // Toyota
        ['RUT001', 'Upper Tank Avanza/Xenia VVT-i Lama', 150000, 15, 5],
        ['RUT002', 'Upper Tank Avanza/Xenia Dual VVT-i', 180000, 12, 5],
        ['RUT003', 'Upper Tank Innova Bensin 2.0', 250000, 10, 5],
        ['RUT004', 'Upper Tank Innova Diesel 2.5', 275000, 8, 5],
        ['RUT005', 'Upper Tank Innova Reborn', 350000, 5, 5],
        ['RUT006', 'Upper Tank Fortuner VNT / Hilux', 300000, 6, 5],
        ['RUT007', 'Upper Tank Agya / Ayla 1.0', 130000, 15, 5],
        ['RUT008', 'Upper Tank Calya / Sigra 1.2', 140000, 14, 5],
        ['RUT009', 'Upper Tank Yaris / Vios Lama', 220000, 8, 5],
        ['RUT010', 'Upper Tank Yaris Bakpao', 230000, 6, 5],
        ['RUT011', 'Upper Tank Camry / Altis', 350000, 4, 3],
        ['RUT012', 'Upper Tank Alphard / Vellfire', 500000, 3, 2],
        ['RUT013', 'Upper Tank Kijang Kapsul 1.8', 200000, 9, 5],
        ['RUT014', 'Upper Tank Rush / Terios Lama', 180000, 11, 5],
        ['RUT015', 'Upper Tank All New Rush / Terios', 210000, 8, 5],
        ['RUT016', 'Upper Tank Sienta', 260000, 4, 2],
        ['RUT017', 'Upper Tank Kijang Super/Grand', 190000, 3, 2],
        // Honda
        ['RUH001', 'Upper Tank Jazz GD3 (Lama)', 200000, 14, 5],
        ['RUH002', 'Upper Tank Jazz GE8 / GK5', 220000, 12, 5],
        ['RUH003', 'Upper Tank Brio / Mobilio / BRV', 190000, 18, 5],
        ['RUH004', 'Upper Tank CRV Gen 2 (RD)', 250000, 5, 3],
        ['RUH005', 'Upper Tank CRV Gen 3 (RE)', 280000, 6, 3],
        ['RUH006', 'Upper Tank CRV Gen 4 (RM)', 300000, 4, 2],
        ['RUH007', 'Upper Tank HRV 1.5', 240000, 8, 4],
        ['RUH008', 'Upper Tank Civic FD (Batman)', 260000, 5, 3],
        ['RUH009', 'Upper Tank Freed', 210000, 7, 5],
        ['RUH010', 'Upper Tank City GD8', 210000, 4, 2],
        ['RUH011', 'Upper Tank Accord CP2', 320000, 2, 2],
        // Daihatsu
        ['RUD001', 'Upper Tank Gran Max / Luxio', 180000, 20, 5],
        ['RUD002', 'Upper Tank Taruna / Feroza', 170000, 6, 5],
        ['RUD003', 'Upper Tank Sirion', 190000, 5, 2],
        ['RUD004', 'Upper Tank Xenia 1.0 (Lama)', 140000, 7, 3],
        ['RUD005', 'Upper Tank Taft / Rocky Lama', 220000, 3, 2],
        // Suzuki
        ['RUS001', 'Upper Tank Carry / Futura', 140000, 25, 5],
        ['RUS002', 'Upper Tank APV', 160000, 12, 5],
        ['RUS003', 'Upper Tank Ertiga Lama', 175000, 10, 5],
        ['RUS004', 'Upper Tank All New Ertiga', 195000, 8, 5],
        ['RUS005', 'Upper Tank SX4 X-Over', 190000, 4, 3],
        ['RUS006', 'Upper Tank Grand Vitara', 240000, 3, 3],
        ['RUS007', 'Upper Tank Ignis', 180000, 6, 3],
        ['RUS008', 'Upper Tank Baleno / Aerio', 185000, 5, 2],
        // Mitsubishi
        ['RUM001', 'Upper Tank Xpander', 190000, 9, 5],
        ['RUM002', 'Upper Tank L300 Diesel', 210000, 15, 5],
        ['RUM003', 'Upper Tank Pajero Sport Lama', 280000, 6, 5],
        ['RUM004', 'Upper Tank All New Pajero', 320000, 5, 3],
        ['RUM005', 'Upper Tank Outlander Sport', 260000, 3, 2],
        ['RUM006', 'Upper Tank Triton Double Cabin', 290000, 4, 2],
        ['RUM007', 'Upper Tank Mirage', 175000, 5, 2],
        // Nissan & Datsun
        ['RUN001', 'Upper Tank Grand Livina', 200000, 11, 5],
        ['RUN002', 'Upper Tank March / Datsun GO', 150000, 10, 5],
        ['RUN003', 'Upper Tank X-Trail T30', 250000, 4, 3],
        ['RUN004', 'Upper Tank X-Trail T31', 270000, 4, 3],
        ['RUN005', 'Upper Tank Serena C24', 240000, 3, 2],
        ['RUN006', 'Upper Tank Serena C26', 280000, 3, 2],
        ['RUN007', 'Upper Tank Evalia', 210000, 5, 2],
        // Lainnya (Mazda, Ford, Wuling, Truk)
        ['RUO001', 'Upper Tank Wuling Confero', 200000, 6, 2],
        ['RUO002', 'Upper Tank Wuling Almaz', 300000, 3, 2],
        ['RUO003', 'Upper Tank Mazda 2', 250000, 4, 2],
        ['RUO004', 'Upper Tank Ford Fiesta', 260000, 3, 2],
        ['RUO005', 'Upper Tank Hino Dutro / Toyota Dyna', 350000, 7, 5],
        ['RUO006', 'Upper Tank Isuzu Panther / Elf', 280000, 8, 5],
    ],
    'Radiator Lower Tank (RLT)' => [
        // Toyota
        ['RLT001', 'Lower Tank Avanza/Xenia VVT-i Lama', 150000, 12, 5],
        ['RLT002', 'Lower Tank Avanza/Xenia Dual VVT-i', 180000, 10, 5],
        ['RLT003', 'Lower Tank Innova Bensin 2.0', 250000, 7, 5],
        ['RLT004', 'Lower Tank Innova Diesel 2.5', 275000, 6, 5],
        ['RLT005', 'Lower Tank Fortuner VNT / Hilux', 300000, 6, 5],
        ['RLT006', 'Lower Tank Agya / Ayla 1.0', 130000, 10, 5],
        ['RLT007', 'Lower Tank Rush / Terios', 180000, 9, 5],
        // Honda
        ['RLH001', 'Lower Tank Jazz GD3 (Lama)', 200000, 8, 5],
        ['RLH002', 'Lower Tank Brio / Mobilio / BRV', 190000, 15, 5],
        ['RLH003', 'Lower Tank CRV Gen 3 (RE)', 280000, 5, 3],
        ['RLH004', 'Lower Tank HRV 1.5', 240000, 6, 3],
        // Daihatsu
        ['RLD001', 'Lower Tank Gran Max / Luxio', 180000, 18, 5],
        ['RLD002', 'Lower Tank Taruna / Feroza', 170000, 5, 2],
        // Suzuki & Mitsubishi & Nissan
        ['RLS001', 'Lower Tank Carry / Futura', 140000, 20, 5],
        ['RLS002', 'Lower Tank APV', 160000, 8, 4],
        ['RLS003', 'Lower Tank Ertiga', 175000, 7, 4],
        ['RLM001', 'Lower Tank Xpander', 190000, 8, 5],
        ['RLM002', 'Lower Tank L300 Diesel', 210000, 12, 5],
        ['RLM003', 'Lower Tank Pajero Sport', 280000, 4, 2],
        ['RLN001', 'Lower Tank Grand Livina', 200000, 9, 5],
        ['RLN002', 'Lower Tank March / Datsun GO', 150000, 7, 3],
    ],
    'Sarang Radiator / Radiator Core (RCA)' => [
        ['RCA001', 'Core Radiator Avanza Manual 1ply', 600000, 5, 2],
        ['RCA002', 'Core Radiator Innova Bensin Manual', 850000, 3, 1],
        ['RCA003', 'Core Radiator L300 Diesel Kuningan', 1200000, 4, 2],
        ['RCA004', 'Core Radiator Panther Kuningan', 1100000, 3, 1],
        ['RCA005', 'Core Radiator Grand Livina Matic', 750000, 2, 1],
        ['RCA006', 'Core Radiator Futura / Carry', 550000, 6, 2],
    ],
    'Radiator Lainnya / Aksesoris (ROT)' => [
        ['ROU001', 'Tutup Radiator (Radiator Cap) Denso 0.9', 85000, 40, 10],
        ['ROU002', 'Tutup Radiator (Radiator Cap) Denso 1.1', 85000, 35, 10],
        ['ROU003', 'Selang Radiator Atas Universal (Meteran)', 75000, 50, 10],
        ['ROU004', 'Selang Radiator Bawah Universal', 80000, 45, 10],
        ['ROU005', 'Klem Selang Radiator Stainless 2 inch', 15000, 100, 20],
        ['ROU006', 'Klem Selang Radiator Stainless 1.5 inch', 12000, 100, 20],
        ['ROT001', 'Motor Fan Radiator Avanza Original', 450000, 8, 3],
        ['ROT002', 'Motor Fan Radiator Innova Original', 600000, 5, 2],
        ['ROH001', 'Motor Fan Radiator Brio / Mobilio', 550000, 6, 2],
        ['ROH002', 'Motor Fan Radiator CRV', 750000, 3, 1],
        ['ROT003', 'Thermostat Toyota Avanza / Rush', 250000, 15, 4],
        ['ROH003', 'Thermostat Honda Jazz / Brio', 275000, 12, 4],
        ['ROS001', 'Thermostat Suzuki Ertiga', 220000, 8, 3],
    ],
    'Suku Cadang AC & Pendingin Ruang (APT)' => [
        ['APU001', 'Freon R134a Klea (Per Tabung)', 350000, 20, 5],
        ['APU002', 'Freon R134a Bailian (Per Tabung)', 280000, 15, 5],
        ['APU003', 'Oli Kompresor AC ND8 100ml', 75000, 50, 10],
        ['APU004', 'Oli Kompresor AC ND9 100ml', 85000, 30, 5],
        ['APU005', 'Kondensor AC Universal', 600000, 10, 3],
        ['APU006', 'Magnetic Clutch Kompresor AC Universal', 450000, 15, 4],
        ['APU007', 'Expansi Valve AC Denso', 250000, 20, 5],
        ['APU008', 'Relay AC 4 Kaki Denso', 35000, 100, 20],
        ['APU009', 'Relay AC 5 Kaki Denso', 45000, 80, 20],
        ['APU010', 'Drier / Filter Kondensor', 125000, 25, 5],
        ['APT001', 'Filter Kabin (Filter AC) Avanza/Xenia', 65000, 50, 10],
        ['APT002', 'Filter Kabin (Filter AC) Innova/Fortuner', 85000, 40, 10],
        ['APH001', 'Filter Kabin (Filter AC) Brio/Mobilio', 75000, 45, 10],
        ['APH002', 'Filter Kabin (Filter AC) HRV/CRV', 95000, 30, 5],
        ['APT003', 'Evaporator Depan Avanza/Xenia', 750000, 5, 2],
        ['APT004', 'Evaporator Depan Innova', 850000, 4, 2],
        ['APH003', 'Evaporator Depan Brio / Mobilio', 800000, 4, 2],
        ['APT005', 'Kompresor AC Avanza (Assy)', 1800000, 2, 1],
        ['APH004', 'Kompresor AC CRV (Assy)', 2500000, 1, 0],
    ],
    'Dinamo Starter & Komponennya (DST)' => [
        ['DSU001', 'Carbon Brush (Kul Dinamo) Starter Universal', 45000, 100, 20],
        ['DSU002', 'Armature Dinamo Starter Universal', 350000, 15, 3],
        ['DSU003', 'Switch Starter / Bendik Universal', 150000, 25, 5],
        ['DST001', 'Dinamo Starter Assy Avanza', 950000, 3, 1],
        ['DST002', 'Bendik Dinamo Starter Avanza/Xenia', 180000, 12, 3],
        ['DSH001', 'Dinamo Starter Assy Brio', 1100000, 2, 1],
        ['DSM001', 'Dinamo Starter Assy L300', 1250000, 4, 1],
        ['DSO001', 'Gigi Nanas (Pinion Gear) Starter Kijang', 120000, 15, 3],
    ],
    'Dinamo Alternator & Komponennya (DAL)' => [
        ['DAU001', 'IC Regulator Alternator Denso', 250000, 30, 5],
        ['DAU002', 'Bearing Alternator 6202 NSK', 35000, 100, 20],
        ['DAU003', 'Bearing Alternator 6303 NSK', 45000, 80, 20],
        ['DAU004', 'Diode Rectifier (Keteng) Alternator', 180000, 20, 4],
        ['DAU005', 'Rotor Coil Alternator Universal', 400000, 10, 2],
        ['DAU006', 'Stator Coil Alternator Universal', 450000, 10, 2],
        ['DAT001', 'Dinamo Alternator Assy Avanza', 1200000, 4, 1],
        ['DAT002', 'Dinamo Alternator Assy Innova Diesel', 1800000, 2, 1],
        ['DAH001', 'Dinamo Alternator Assy Jazz/Brio', 1400000, 3, 1],
    ],
    'Cairan & Coolant (CLN)' => [
        ['CLU001', 'Coolant Prestone Merah 4L', 125000, 80, 10],
        ['CLU002', 'Coolant Prestone Hijau 4L', 125000, 70, 10],
        ['CLU003', 'Coolant Top1 Merah 1L', 35000, 150, 20],
        ['CLU004', 'Coolant Megacools Hijau 1L', 25000, 200, 20],
        ['CLU005', 'Air Radiator Biasa (Galon 5L)', 15000, 100, 20],
        ['CLT001', 'Toyota Motor Oil (TMO) Coolant Merah 4L', 160000, 40, 10],
        ['CLH001', 'Honda Radiator Coolant Type 2 (Biru) 4L', 175000, 30, 5],
        ['CLS001', 'Suzuki Ecstar Coolant Biru 4L', 150000, 25, 5],
        ['CLU006', 'Oli Kompresor ND8 (Botol 1 Liter)', 250000, 10, 2],
    ],
    'Kategori Jasa Servis Utama (JAS)' => [
        ['JSU001', 'Isi Freon AC (Jasa + Freon R134a Full)', 200000, 999, 0],
        ['JSU002', 'Tambah Freon AC (Setengah)', 100000, 999, 0],
        ['JSU003', 'Jasa Korok Radiator Mobil Kecil (Agya/Brio/Avanza)', 150000, 999, 0],
        ['JSU004', 'Jasa Korok Radiator Mobil Menengah (Innova/CRV)', 200000, 999, 0],
        ['JSU005', 'Jasa Korok Radiator Mobil Besar / Truk', 250000, 999, 0],
        ['JSU006', 'Jasa Las Kuningan / Titik', 50000, 999, 0],
        ['JSU007', 'Jasa Las Aluminium / Titik', 75000, 999, 0],
        ['JSU008', 'Jasa Ganti Upper/Lower Tank (Termasuk Lem)', 100000, 999, 0],
        ['JSU009', 'Jasa Bongkar Pasang Dinamo Starter', 150000, 999, 0],
        ['JSU010', 'Jasa Bongkar Pasang Dinamo Alternator', 150000, 999, 0],
        ['JSU011', 'Jasa Cuci Evaporator AC (Bongkar Dashboard)', 350000, 999, 0],
        ['JSU012', 'Jasa Cuci Evaporator AC (Tanpa Bongkar Dashboard)', 200000, 999, 0],
        ['JSU013', 'Jasa Ganti Bearing Alternator', 100000, 999, 0],
        ['JSU014', 'Jasa Ganti Carbon Brush Starter', 75000, 999, 0],
        ['JSU015', 'Flushing AC System (Kuras Total)', 300000, 999, 0],
    ]
];

$html = "
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <meta http-equiv='Content-type' content='text/html;charset=utf-8' />
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
        th { background-color: #0f172a; color: white; padding: 10px; text-align: left; font-weight: bold; border: 1px solid #cbd5e1; }
        td { border: 1px solid #cbd5e1; padding: 8px; }
        .category-header { background-color: #0d9488; color: white; font-weight: bold; text-align: center; font-size: 14px; }
        .footer-note { margin-top: 30px; font-family: Arial, sans-serif; font-size: 13px; color: #333; line-height: 1.6;}
        .bold { font-weight: bold; }
        .highlight { background-color: #fef08a; padding: 2px 5px; border-radius: 3px;}
    </style>
</head>
<body>
    <h2>DATA KATALOG SUKU CADANG BENGKEL (KODE PENDEK 6 KARAKTER)</h2>
    <p><i>Total Item: Lebih dari 120 Varian Barang & Jasa (Sesuai kondisi bengkel beroperasi skala penuh)</i></p>
    <table>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Kategori / Nama Barang</th>
            <th>Harga (Rp)</th>
            <th>Stok Saat Ini</th>
            <th>Batas Minimum</th>
        </tr>";

$no = 1;
foreach ($data as $category => $items) {
    // Header Kategori
    $html .= "<tr><td colspan='6' class='category-header'>KATEGORI: {$category}</td></tr>";
    
    foreach ($items as $item) {
        $html .= "<tr>
            <td style='text-align:center;'>{$no}</td>
            <td class='bold' style='color:#0d9488;'>{$item[0]}</td>
            <td>{$item[1]}</td>
            <td>" . number_format($item[2], 0, ',', '.') . "</td>
            <td style='text-align:center;'>{$item[3]}</td>
            <td style='text-align:center;'>{$item[4]}</td>
        </tr>";
        $no++;
    }
}

$html .= "</table>";

// Keterangan Kode Barang & SOP
$html .= "
<div class='footer-note'>
    <h3>📚 PENJELASAN KODE BARANG (6 KARAKTER)</h3>
    <p>Agar ringkas dan mudah diingat oleh kasir/mekanik, kode dipadatkan menjadi persis 6 karakter dengan rumus: <strong>[1 Huruf Jenis] + [1 Huruf Kategori] + [1 Huruf Merk] + [3 Angka Urutan]</strong>.</p>
    
    <table style='width: 60%; margin-top:10px;'>
        <tr><th colspan='2' style='background-color:#334155; color:white; padding:5px;'>1. HURUF PERTAMA (Jenis Barang)</th></tr>
        <tr><td class='bold'>R</td><td>Radiator</td></tr>
        <tr><td class='bold'>A</td><td>AC</td></tr>
        <tr><td class='bold'>D</td><td>Dinamo</td></tr>
        <tr><td class='bold'>C</td><td>Cairan (Coolant/Oli)</td></tr>
        <tr><td class='bold'>J</td><td>Jasa / Ongkos Kerja</td></tr>
        
        <tr><th colspan='2' style='background-color:#334155; color:white; padding:5px;'>2. HURUF KEDUA (Sub-Kategori)</th></tr>
        <tr><td class='bold'>U</td><td>Upper Tank</td></tr>
        <tr><td class='bold'>L</td><td>Lower Tank</td></tr>
        <tr><td class='bold'>C</td><td>Core (Sarang Radiator)</td></tr>
        <tr><td class='bold'>O</td><td>Lainnya (Others / Aksesoris / Tutup / Relay)</td></tr>
        <tr><td class='bold'>P</td><td>Parts AC (Filter, Freon, Evaporator)</td></tr>
        <tr><td class='bold'>S</td><td>Starter (Dinamo Starter & Komponen)</td></tr>
        <tr><td class='bold'>A</td><td>Alternator (Dinamo Ampere & Komponen)</td></tr>
        
        <tr><th colspan='2' style='background-color:#334155; color:white; padding:5px;'>3. HURUF KETIGA (Merk Mobil / Peruntukan)</th></tr>
        <tr><td class='bold'>T</td><td>Toyota</td></tr>
        <tr><td class='bold'>H</td><td>Honda</td></tr>
        <tr><td class='bold'>D</td><td>Daihatsu</td></tr>
        <tr><td class='bold'>M</td><td>Mitsubishi</td></tr>
        <tr><td class='bold'>N</td><td>Nissan / Datsun</td></tr>
        <tr><td class='bold'>S</td><td>Suzuki</td></tr>
        <tr><td class='bold'>O</td><td>Others (Mazda, Ford, Wuling, Truk)</td></tr>
        <tr><td class='bold'>U</td><td>Universal (Cocok untuk semua merk mobil)</td></tr>
    </table>

    <br><hr><br>
    
    <h3>❓ BAGAIMANA CARA MENGINPUT JIKA ADA BARANG BARU? (SOP BENGKEL)</h3>
    <p>Jika besok bengkel menerima stok barang yang sama sekali baru (belum ada di sistem), begini cara mekanik membuat kodenya:</p>
    
    <p><strong>Contoh Kasus 1:</strong> Bengkel baru saja beli \"Upper Tank untuk Mobil Honda Civic\".</p>
    <ul>
        <li>1. Jenisnya apa? Radiator = <span class='highlight'>R</span></li>
        <li>2. Sub-kategorinya apa? Upper Tank = <span class='highlight'>U</span></li>
        <li>3. Untuk mobil apa? Honda = <span class='highlight'>H</span></li>
        <li>4. Cek nomor urut terakhir Honda Upper Tank (Misal terakhir RUH011), maka ini jadi <span class='highlight'>012</span></li>
        <li><strong>Kode yang diketik ke sistem: RUH012</strong></li>
    </ul>

    <p><strong>Contoh Kasus 2:</strong> Bengkel membeli cairan \"Pembersih Kaca (Wiper Fluid)\" yang bisa dipakai semua mobil.</p>
    <ul>
        <li>1. Jenisnya apa? Cairan = <span class='highlight'>C</span></li>
        <li>2. Sub-kategorinya apa? Liquid/Lainnya = <span class='highlight'>L</span></li>
        <li>3. Untuk mobil apa? Semua Mobil (Universal) = <span class='highlight'>U</span></li>
        <li>4. Urutan berikutnya = <span class='highlight'>007</span></li>
        <li><strong>Kode yang diketik ke sistem: CLU007</strong></li>
    </ul>
</div>
</body>
</html>";

file_put_contents($downloadsPath, $html);

echo "BERHASIL! Data Ratusan Item Excel telah diperbarui.\n";
