SET FOREIGN_KEY_CHECKS=0;

-- Drop constraints
ALTER TABLE service_detail DROP FOREIGN KEY service_detail_sparepart_id_foreign;
ALTER TABLE stock_adjustment DROP FOREIGN KEY stock_adjustment_sparepart_id_foreign;
ALTER TABLE stock_adjustment DROP FOREIGN KEY stock_adjustment_user_id_foreign;

ALTER TABLE service_detail DROP COLUMN sparepart_id;

-- Make kode_barang the new PK of sparepart
ALTER TABLE sparepart MODIFY id BIGINT UNSIGNED NOT NULL; -- remove auto_increment
ALTER TABLE sparepart DROP PRIMARY KEY;
ALTER TABLE sparepart DROP COLUMN id;
ALTER TABLE sparepart ADD PRIMARY KEY (kode_barang);

-- SERVICE
ALTER TABLE service DROP FOREIGN KEY services_user_id_foreign;
ALTER TABLE service DROP FOREIGN KEY services_kendaraan_id_foreign;

ALTER TABLE service CHANGE id id_service BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE service CHANGE kendaraan_id nomor_polisi VARCHAR(11) NOT NULL; -- karena kendaraan pakai nomor_polisi
ALTER TABLE service CHANGE user_id id_karyawan BIGINT UNSIGNED NOT NULL;

-- SERVICE DETAIL
ALTER TABLE service_detail DROP FOREIGN KEY service_detail_service_id_foreign;
ALTER TABLE service_detail CHANGE id id_service_detail BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE service_detail CHANGE service_id id_service BIGINT UNSIGNED NOT NULL;

-- SERVICE PHOTO
ALTER TABLE service_photo DROP FOREIGN KEY service_photos_service_id_foreign;
ALTER TABLE service_photo CHANGE id id_service_photo BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE service_photo CHANGE service_id id_service BIGINT UNSIGNED NOT NULL;

-- WARRANTY
ALTER TABLE warranty DROP FOREIGN KEY warranties_service_id_foreign;
ALTER TABLE warranty CHANGE id id_warranty BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE warranty CHANGE service_id id_service BIGINT UNSIGNED NOT NULL;

-- CHATBOT RULES
ALTER TABLE chatbot_rule CHANGE id id_chatbot_rule BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

-- PEMBELIAN & PEMBELIAN DETAIL
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

INSERT INTO pembelian (id_karyawan, tanggal_beli, total_harga, created_at, updated_at)
SELECT IFNULL(user_id, 1), DATE(created_at), (qty * IFNULL(harga_modal, 0)), created_at, updated_at
FROM stock_adjustment WHERE tipe = 'Masuk' OR qty > 0;

INSERT INTO pembelian_detail (id_pembelian, kode_barang, qty, harga_beli, subtotal, created_at, updated_at)
SELECT p.id_pembelian, sa.kode_barang, sa.qty, IFNULL(sa.harga_modal, 0), (sa.qty * IFNULL(sa.harga_modal, 0)), sa.created_at, sa.updated_at
FROM stock_adjustment sa
JOIN pembelian p ON p.created_at = sa.created_at
WHERE sa.tipe = 'Masuk' OR sa.qty > 0;

DROP TABLE stock_adjustment;

SET FOREIGN_KEY_CHECKS=1;
