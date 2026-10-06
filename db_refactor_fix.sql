-- Matatkan foreign key checks sementara agar tidak error saat merubah nama kolom
SET FOREIGN_KEY_CHECKS=0;

-- 2. PELANGGAN
ALTER TABLE pelanggan CHANGE id id_pelanggan BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

-- 3. KENDARAAN
ALTER TABLE kendaraan CHANGE id id_kendaraan BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE kendaraan CHANGE pelanggan_id id_pelanggan BIGINT UNSIGNED NOT NULL;
ALTER TABLE kendaraan ADD UNIQUE INDEX nopol_unique (nomor_polisi);

-- 4. SPAREPART
-- Add kode_barang to service_details
ALTER TABLE service_detail ADD COLUMN kode_barang VARCHAR(255) AFTER sparepart_id;
UPDATE service_detail sd JOIN sparepart sp ON sd.sparepart_id = sp.id SET sd.kode_barang = sp.kode_barang;

-- Add kode_barang to stock_adjustments
ALTER TABLE stock_adjustment ADD COLUMN kode_barang VARCHAR(255) AFTER sparepart_id;
UPDATE stock_adjustment sa JOIN sparepart sp ON sa.sparepart_id = sp.id SET sa.kode_barang = sp.kode_barang;

ALTER TABLE service_detail DROP COLUMN sparepart_id;
ALTER TABLE stock_adjustment DROP COLUMN sparepart_id;

-- Make kode_barang the new PK of sparepart
ALTER TABLE sparepart MODIFY id BIGINT UNSIGNED NOT NULL; -- remove auto_increment
ALTER TABLE sparepart DROP PRIMARY KEY;
ALTER TABLE sparepart DROP COLUMN id;
ALTER TABLE sparepart ADD PRIMARY KEY (kode_barang);

-- 5. SERVICE
ALTER TABLE service CHANGE id id_service BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE service CHANGE kendaraan_id id_kendaraan BIGINT UNSIGNED NOT NULL;
ALTER TABLE service CHANGE user_id id_karyawan BIGINT UNSIGNED NOT NULL;

-- 6. SERVICE DETAIL
ALTER TABLE service_detail CHANGE id id_service_detail BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE service_detail CHANGE service_id id_service BIGINT UNSIGNED NOT NULL;

-- 7. SERVICE PHOTO
ALTER TABLE service_photo CHANGE id id_service_photo BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE service_photo CHANGE service_id id_service BIGINT UNSIGNED NOT NULL;

-- 8. WARRANTY
ALTER TABLE warranty CHANGE id id_warranty BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE warranty CHANGE service_id id_service BIGINT UNSIGNED NOT NULL;

-- 9. CHATBOT RULES
ALTER TABLE chatbot_rule CHANGE id id_chatbot_rule BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

-- 10. PEMBELIAN & PEMBELIAN DETAIL
CREATE TABLE pembelian (
    id_pembelian BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_karyawan BIGINT UNSIGNED NOT NULL,
    tanggal_beli DATE NOT NULL,
    total_harga DECIMAL(15,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id_pembelian)
);

CREATE TABLE pembelian_detail (
    id_pembelian_detail BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_pembelian BIGINT UNSIGNED NOT NULL,
    kode_barang VARCHAR(255) NOT NULL,
    qty INT NOT NULL,
    harga_beli DECIMAL(15,2) NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id_pembelian_detail)
);

-- Migrasikan data stock_adjustment masuk ke pembelian
INSERT INTO pembelian (id_karyawan, tanggal_beli, total_harga, created_at, updated_at)
SELECT IFNULL(user_id, 1), DATE(created_at), (qty * IFNULL(harga_modal, 0)), created_at, updated_at
FROM stock_adjustment WHERE tipe_mutasi = 'masuk' OR qty > 0;

-- Migrasikan data ke pembelian_detail
INSERT INTO pembelian_detail (id_pembelian, kode_barang, qty, harga_beli, subtotal, created_at, updated_at)
SELECT p.id_pembelian, sa.kode_barang, sa.qty, IFNULL(sa.harga_modal, 0), (sa.qty * IFNULL(sa.harga_modal, 0)), sa.created_at, sa.updated_at
FROM stock_adjustment sa
JOIN pembelian p ON p.created_at = sa.created_at
WHERE sa.tipe_mutasi = 'masuk' OR sa.qty > 0;

-- Drop table stock_adjustment
DROP TABLE stock_adjustment;

-- Kembalikan foreign key checks
SET FOREIGN_KEY_CHECKS=1;
