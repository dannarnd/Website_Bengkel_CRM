-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: Smart_Workshop
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chatbot_rule`
--

DROP TABLE IF EXISTS `chatbot_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chatbot_rule` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respons_teks` text COLLATE utf8mb4_unicode_ci,
  `action_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatbot_rule`
--

LOCK TABLES `chatbot_rule` WRITE;
/*!40000 ALTER TABLE `chatbot_rule` DISABLE KEYS */;
INSERT INTO `chatbot_rule` VALUES (1,'berapa',NULL,'check_price','2026-08-26 10:15:36','2026-08-26 10:15:36'),(2,'harga',NULL,'check_price','2026-08-26 10:15:36','2026-08-26 10:15:36'),(3,'biaya',NULL,'check_price','2026-08-26 10:15:36','2026-08-26 10:15:36'),(4,'stok',NULL,'check_stock','2026-08-26 10:15:36','2026-08-26 10:15:36'),(5,'sisa',NULL,'check_stock','2026-08-26 10:15:36','2026-08-26 10:15:36'),(6,'ada',NULL,'check_stock','2026-08-26 10:15:36','2026-08-26 10:15:36'),(7,'halo','Halo! Saya Asisten Virtual Doles Radiator. Ada yang bisa saya bantu hari ini? Anda bisa tanya \"berapa harga radiator\" atau \"jam berapa bengkel buka\".','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(8,'hai','Hai! Selamat datang di layanan asisten pintar Doles Radiator. Silakan tanyakan keluhan mobil Anda atau info stok barang yang Anda butuhkan.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(9,'pagi','Selamat pagi! Bengkel Doles Radiator siap melayani kendaraan Anda. Ada yang mau ditanyakan soal servis atau stok barang?','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(10,'siang','Selamat siang! Silakan tanyakan apa saja seputar servis atau stok suku cadang, asisten Doles Radiator siap membantu.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(11,'malam','Selamat malam! Saat ini bengkel kami sudah tutup (buka 08:00 - 18:00), tapi Anda tetap bisa bertanya soal estimasi harga barang atau info servis di sini.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(12,'buka','Bengkel Doles Radiator buka setiap hari Senin - Sabtu, mulai jam 08:00 WIB sampai dengan 18:00 WIB. Hari Minggu kami libur ya.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(13,'jam tutup','Kami tutup pada jam 18:00 WIB dan libur setiap hari Minggu. Silakan datang di jam operasional kami!','text_only','2026-08-26 10:15:36','2026-09-30 00:45:38'),(14,'jam','Jam operasional kami: Senin-Sabtu (08:00 - 18:00 WIB). Hari Minggu libur.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(15,'alamat','Lokasi bengkel kami berada di Jl. Pembangunan, Lorong Himalaya, Banda Aceh. Anda bisa ketik \"Doles Radiator\" di Google Maps biar lebih gampang!','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(16,'lokasi','Kami berlokasi di Jl. Pembangunan, Lorong Himalaya, Banda Aceh. Ditunggu kedatangannya ya!','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(17,'posisi','Posisi bengkel ada di Jl. Pembangunan, Lorong Himalaya, Banda Aceh.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(18,'garansi','Semua pengerjaan servis di tempat kami mendapatkan garansi! Jangan lupa simpan nomor resi/tracking Anda untuk mengecek status garansi lewat website ini.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(19,'klaim','Untuk klaim garansi, silakan bawa kendaraan kembali ke bengkel kami dan tunjukkan status servis dari halaman website kami yang menyatakan garansi Anda masih \"Aktif\".','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(20,'terima kasih','Sama-sama! Semoga informasi yang diberikan bermanfaat. Jangan ragu hubungi kami lagi jika ada masalah suhu mesin ya!','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(21,'makasih','Sama-sama kak! Sehat selalu dan rawat terus kendaraan kesayangannya ya!','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(22,'oke','Siap! Jika masih ada yang kurang jelas, silakan tanyakan lagi atau langsung Whatsapp admin kami.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(23,'bocor','Radiator bocor itu bahaya! Jangan dipaksa jalan jika air radiator cepat habis. Bawa saja mobilnya langsung ke bengkel agar dicek dan dilas (tambal) oleh ahlinya.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(24,'overheat','Jangan dipaksa kalau mesin sering overheat! Segera menepi, matikan mesin, lalu bawa ke Doles Radiator. Kami akan menguras dan mendeteksi sumbatan di sistem pendingin Anda.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(25,'panas','Jika jarum temperatur nyaris mentok merah atau mobil terasa sangat panas, itu tanda sirkulasi pendingin ngadat. Segera jadwalkan pengecekan di bengkel kami.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(26,'kontak','Anda bisa langsung menghubungi admin atau mekanik kami lewat Whatsapp/Telepon di nomor: 0821-6344-4129.','text_only','2026-08-26 10:15:36','2026-08-26 10:15:36'),(27,'no hp','Silakan hubungi atau Whatsapp ke nomor 081230970997 ya kak.','text_only','2026-08-26 10:15:36','2026-09-25 21:40:47'),(28,'wa','Nomor WhatsApp resmi Doles Radiator adalah 081230970997','text_only','2026-08-26 10:15:36','2026-09-25 21:41:02'),(29,'padum',NULL,'check_price','2026-09-25 21:06:42','2026-09-25 21:06:42'),(30,'assalamualaikum','Waalaikumsalam warahmatullah. Selamat datang di Doles Radiator. Ada yang bisa kami bantu terkait perbaikan radiator atau AC Anda?','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(31,'dimana','Bengkel Doles Radiator berlokasi di Jl. Pembangunan lorong himalaya, Peunayong, Kec. Kuta Alam, Kota Banda Aceh.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(32,'habis','Air radiator yang cepat habis menandakan adanya kebocoran atau penguapan berlebih (overheat). Segera periksa slang, tutup radiator, atau bawa ke bengkel kami untuk di-cek tekanannya.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(33,'amper','Amper suhu mobil yang naik mendekati atau mencapai batas H (High) adalah tanda mesin overheat (terlalu panas). Segera menepi dan matikan mesin. Jika butuh bantuan pengecekan, hubungi kami di WA 0812-3097-0997.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(34,'kotor','Air radiator yang kotor, keruh, atau berwarna karat tebal berarti sirkulasi tidak lancar. Kami sangat menyarankan Anda mengambil jasa servis Korok Radiator agar saluran pendingin bersih seperti baru.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(35,'mampet','Radiator yang mampet bisa dikorok (dibersihkan salurannya satu per satu). Bawa kendaraan Anda ke Doles Radiator, kami ahli dalam jasa servis korok radiator mobil kecil maupun truk/alat berat.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(36,'ac','Selain spesialis radiator, bengkel kami juga melayani servis AC mobil, seperti pengecekan kebocoran, isi freon R134a, dan pembersihan kondensor AC.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(37,'freon','AC mobil kurang dingin? Kami menyediakan layanan pengisian Freon R134a dan pengecekan kebocoran kompresor AC Anda. Silakan bawa mobilnya ke bengkel untuk dicek.','text_only','2026-09-25 21:20:04','2026-09-25 21:20:04'),(38,'piro',NULL,'check_price','2026-09-25 21:20:04','2026-09-25 21:20:04'),(39,'ready',NULL,'check_stock','2026-09-25 21:20:04','2026-09-25 21:20:04'),(40,'amper panas','Jika indikator amper suhu mesin mobil Anda naik (panas) dan air radiator habis, kemungkinan besar ada kebocoran pada sistem pendingin atau kipas mati. Sebaiknya segera hentikan mobil agar mesin tidak jebol (overheat) dan bawa ke bengkel kami untuk pengecekan.','text_only','2026-09-29 22:10:02','2026-09-29 22:10:02'),(41,'bocor','Jika radiator Anda mengalami kebocoran (misalnya menetes dari bawah atau bocor pada tutup atasnya), jangan dipaksakan jalan jauh. Silakan bawa ke Doles Radiator, kami melayani servis tambal radiator, ganti upper/lower tank, hingga ganti radiator baru.','text_only','2026-09-29 22:10:02','2026-09-29 22:10:02'),(42,'ganti','Komponen yang sering diganti saat radiator bermasalah biasanya adalah Upper/Lower Tank (jika retak atau pecah), selang radiator, thermostat, atau terkadang cukup kuras air radiator (korok) saja. Untuk pastinya, sebaiknya dicek langsung di bengkel.','text_only','2026-09-29 22:20:50','2026-09-29 22:20:50'),(43,'masalah','Masalah pada sistem pendingin biasanya bermacam-macam, mulai dari kipas mati, radiator mampet, selang bocor, hingga waterpump rusak. Bawa mobil Anda ke Doles Radiator agar kami bisa mendiagnosa masalah pastinya!','text_only','2026-09-29 22:20:50','2026-09-29 22:20:50'),(44,'kenapa','Mesin overheat atau sering tambah air biasanya karena ada jalur sirkulasi pendingin yang bocor atau tersumbat kotoran. Jika dibiarkan bisa turun mesin lho! Yuk, cek di Doles Radiator.','text_only','2026-09-29 22:20:50','2026-09-29 22:20:50'),(45,'pergantian','Komponen yang sering diganti saat radiator bermasalah biasanya adalah Upper/Lower Tank (jika retak atau pecah), selang radiator, thermostat, atau terkadang cukup kuras air radiator (korok) saja. Untuk pastinya, sebaiknya dicek langsung di bengkel.','text_only','2026-09-29 22:23:56','2026-09-29 22:23:56'),(46,'diganti','Komponen yang sering diganti saat radiator bermasalah biasanya adalah Upper/Lower Tank (jika retak atau pecah), selang radiator, thermostat, atau terkadang cukup kuras air radiator (korok) saja. Untuk pastinya, sebaiknya dicek langsung di bengkel.','text_only','2026-09-29 22:23:56','2026-09-29 22:23:56'),(47,'tutup atas','Jika kebocoran terjadi pada tutup atas radiator (upper tank), solusinya adalah mengganti upper tank tersebut dengan yang baru agar air tidak merembes keluar saat mesin panas. Anda bisa membawa mobilnya kemari untuk kami ganti upper tank-nya.','text_only','2026-09-30 00:45:38','2026-09-30 00:45:38'),(48,'bocor di tutup','Jika kebocoran terjadi pada tutup atas radiator (upper tank), solusinya adalah mengganti upper tank tersebut dengan yang baru agar air tidak merembes keluar saat mesin panas. Anda bisa membawa mobilnya kemari untuk kami ganti upper tank-nya.','text_only','2026-09-30 00:45:38','2026-09-30 00:45:38'),(49,'spil',NULL,'check_stock','2026-09-30 19:30:47','2026-09-30 19:30:47'),(50,'jam buka','Doles Radiator buka setiap hari Senin hingga Sabtu mulai pukul 08:00 hingga 18:00 WIB. Hari Minggu kami libur.','text','2026-09-30 20:32:16','2026-09-30 20:32:16');
/*!40000 ALTER TABLE `chatbot_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kendaraan`
--

DROP TABLE IF EXISTS `kendaraan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kendaraan` (
  `nomor_polisi` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelanggan_id` bigint unsigned NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nomor_polisi`),
  KEY `kendaraan_pelanggan_id_foreign` (`pelanggan_id`),
  CONSTRAINT `kendaraan_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kendaraan`
--

LOCK TABLES `kendaraan` WRITE;
/*!40000 ALTER TABLE `kendaraan` DISABLE KEYS */;
INSERT INTO `kendaraan` VALUES ('A7890MNO',5,'Daihatsu Sigra','2026-08-22 11:14:10','2026-08-22 11:14:10'),('B1234ABC',1,'Toyota Avanza','2026-08-22 11:14:10','2026-08-22 11:14:10'),('B3456JKL',4,'Toyota Innova Reborn','2026-08-22 11:14:10','2026-08-22 11:14:10'),('BL0904QQ',7,'Toyota Avanza','2026-08-27 08:00:35','2026-08-27 08:00:35'),('BL0987AAZ',9,'Rush','2026-09-30 23:36:06','2026-09-30 23:36:06'),('BL0987JA',8,'fortuner Vnt','2026-09-25 21:34:08','2026-09-25 21:34:08'),('BL1234AD',6,'Toyota Reborn','2026-08-26 09:40:56','2026-08-26 09:40:56'),('D5678DEF',2,'Honda Brio','2026-08-22 11:14:10','2026-08-22 11:14:10'),('F9012GHI',3,'Mitsubishi Xpander','2026-08-22 11:14:10','2026-08-22 11:14:10');
/*!40000 ALTER TABLE `kendaraan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_27_121017_create_spareparts_table',1),(5,'2026_07_27_121019_create_pelanggans_table',1),(6,'2026_07_27_121020_create_kendaraan_table',1),(7,'2026_07_27_121021_create_chatbot_rules_table',1),(8,'2026_07_27_121022_create_services_table',1),(9,'2026_07_27_121024_create_service_details_table',1),(10,'2026_07_27_121026_create_warranties_table',1),(11,'2026_07_27_121027_create_service_photos_table',1),(12,'2026_07_27_121029_create_stock_adjustments_table',1),(13,'2026_07_27_130307_create_personal_access_tokens_table',1),(14,'2026_07_27_152423_make_foto_before_nullable_in_service_photos_table',1),(15,'2026_08_01_154154_add_catatan_to_service_table',1),(16,'2026_08_19_064137_add_user_id_to_stock_adjustments_table',1),(17,'2026_09_07_133834_add_bukti_foto_to_stock_adjustment_table',2),(18,'2026_09_07_150039_add_harga_modal_to_stock_adjustment_table',3),(19,'2026_09_26_042645_add_username_to_users_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pelanggan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggan`
--

LOCK TABLES `pelanggan` WRITE;
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
INSERT INTO `pelanggan` VALUES (1,'Andi','081234567890','2026-08-22 11:14:10','2026-09-07 08:24:50'),(2,'Ratna','081298765432','2026-08-22 11:14:10','2026-09-07 08:24:55'),(3,'Budi Santoso','085712349876','2026-08-22 11:14:10','2026-09-07 08:25:00'),(4,'Dimas','081345678901','2026-08-22 11:14:10','2026-09-07 08:25:05'),(5,'Sari','081912345678','2026-08-22 11:14:10','2026-09-07 08:25:12'),(6,'danil','082277034546','2026-08-26 09:39:54','2026-08-26 09:39:54'),(7,'Fahri','081231231234','2026-08-27 08:00:08','2026-08-27 08:00:08'),(8,'johan','089812345678','2026-09-25 21:33:45','2026-09-25 21:33:45'),(9,'Dannarnd','082277034748','2026-09-30 23:35:37','2026-09-30 23:35:37');
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (9,'App\\Models\\User',1,'auth_token','4b73a68af71627b8f9dc063e2e3f3e3755c6813c42bb464096980df7a6f7dd2a','[\"*\"]','2026-08-27 08:25:35',NULL,'2026-08-27 07:58:43','2026-08-27 08:25:35'),(35,'App\\Models\\User',1,'auth_token','5b261786511a600b389ed4e681f325a4842a486a373fa3aa3e981e3320535c42','[\"*\"]','2026-09-30 20:43:13',NULL,'2026-09-30 20:40:36','2026-09-30 20:43:13');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_polisi` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Menunggu','Dikerjakan','Selesai','Batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `total_biaya` int NOT NULL DEFAULT '0',
  `tanggal_masuk` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_nomor_polisi_foreign` (`nomor_polisi`),
  KEY `service_user_id_foreign` (`user_id`),
  CONSTRAINT `service_nomor_polisi_foreign` FOREIGN KEY (`nomor_polisi`) REFERENCES `kendaraan` (`nomor_polisi`) ON DELETE CASCADE,
  CONSTRAINT `service_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (8,'A7890MNO',1,'Service Rdiator','[SISTEM - 2026-08-26 16:31] Nota direvisi / dibuka kembali oleh admin.\n\n[SISTEM - 2026-08-26 16:34] Nota direvisi / dibuka kembali oleh admin.','Selesai',200000,'2026-08-26 00:00:00','2026-08-26 00:00:00','2026-08-26 08:45:04','2026-08-26 09:35:54'),(9,'F9012GHI',1,'Service','[SISTEM - 2026-08-26 16:02] Nota direvisi / dibuka kembali oleh admin.','Selesai',150000,'2026-08-26 00:00:00','2026-08-26 00:00:00','2026-08-26 09:00:05','2026-08-26 09:02:33'),(10,'BL1234AD',1,'Service',NULL,'Selesai',250000,'2026-08-26 00:00:00','2026-08-26 00:00:00','2026-08-26 09:41:18','2026-08-26 09:45:02'),(11,'BL0904QQ',1,'Hidup Sensor Amper Panas','[SISTEM - 2026-08-27 15:29] Nota direvisi / dibuka kembali oleh admin.\n\n[SISTEM - 2026-08-27 15:36] Nota direvisi / dibuka kembali oleh admin.\n\n[KLAIM GARANSI - 2026-08-27 15:36]\nLem Kurang Rapat','Selesai',490000,'2026-08-27 00:00:00','2026-08-27 00:00:00','2026-08-27 08:01:41','2026-08-27 08:36:26'),(12,'F9012GHI',1,'Service Radiator','[SISTEM - 2026-08-27 17:36] Nota direvisi / dibuka kembali oleh admin.','Selesai',450000,'2026-08-27 00:00:00','2026-08-27 00:00:00','2026-08-27 08:39:46','2026-08-27 10:36:16'),(13,'BL0987JA',1,'Service radiator dan pergantian upertank',NULL,'Selesai',540000,'2026-09-26 00:00:00','2026-09-26 00:00:00','2026-09-25 21:34:33','2026-09-25 21:37:57'),(14,'A7890MNO',1,'service',NULL,'Selesai',150000,'2026-09-30 00:00:00','2026-09-30 00:00:00','2026-09-29 21:54:54','2026-09-29 21:59:41'),(16,'BL0987AAZ',1,'Service Radiator dan isi freon',NULL,'Selesai',350000,'2026-10-01 00:00:00','2026-10-01 00:00:00','2026-10-01 00:17:49','2026-10-01 00:24:40');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_detail`
--

DROP TABLE IF EXISTS `service_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `sparepart_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_detail_service_id_foreign` (`service_id`),
  KEY `service_detail_sparepart_id_foreign` (`sparepart_id`),
  CONSTRAINT `service_detail_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_detail_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `sparepart` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_detail`
--

LOCK TABLES `service_detail` WRITE;
/*!40000 ALTER TABLE `service_detail` DISABLE KEYS */;
INSERT INTO `service_detail` VALUES (5,8,399,1,200000,'2026-08-26 08:45:37','2026-08-26 08:45:37'),(6,9,401,1,150000,'2026-08-26 09:00:46','2026-08-26 09:00:46'),(7,10,402,1,250000,'2026-08-26 09:44:09','2026-08-26 09:44:09'),(8,11,1,1,290000,'2026-08-27 08:13:13','2026-08-27 08:13:13'),(9,11,399,1,200000,'2026-08-27 08:34:04','2026-08-27 08:34:04'),(10,12,402,1,250000,'2026-08-27 08:41:41','2026-08-27 08:41:41'),(11,12,399,1,200000,'2026-08-27 10:36:12','2026-08-27 10:36:12'),(12,13,11,1,440000,'2026-09-25 21:34:49','2026-09-25 21:34:49'),(13,13,403,1,100000,'2026-09-25 21:35:00','2026-09-25 21:35:00'),(14,14,401,1,150000,'2026-09-29 21:59:05','2026-09-29 21:59:05'),(17,16,399,1,200000,'2026-10-01 00:21:08','2026-10-01 00:21:08'),(18,16,401,1,150000,'2026-10-01 00:24:33','2026-10-01 00:24:33');
/*!40000 ALTER TABLE `service_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_photo`
--

DROP TABLE IF EXISTS `service_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_photo` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `foto_before` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_after` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_photo_service_id_foreign` (`service_id`),
  CONSTRAINT `service_photo_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_photo`
--

LOCK TABLES `service_photo` WRITE;
/*!40000 ALTER TABLE `service_photo` DISABLE KEYS */;
INSERT INTO `service_photo` VALUES (1,8,'/storage/photos/r9pUYv22N0FgTGEpDtLW5LkXCB0oOwZG27HGxEsD.heic','/storage/photos/mzzwnDjgIZ8PhUqUilXEcm8RCga6FfSxFJeHeY6r.jpg','2026-08-26 08:45:24','2026-08-26 09:35:43'),(2,10,'/storage/photos/V0AnOlWrXUUxBDfAf9cbIHCqFxHRTI4MVGbIIFE4.jpg','/storage/photos/pZSJ9ZrbJcdXpotWgyzwAkjfGMMs1Sq6DLhFTbCN.jpg','2026-08-26 09:43:35','2026-08-26 09:43:35'),(3,11,'/storage/photos/5zDGnq9SWucV5SR3iV78Fikepq7aXDS7zp3NSxaL.jpg','/storage/photos/hk7BxZ0eRu9ZW02GupTqxfrqxe5m8jL2GrAjfgIL.jpg','2026-08-27 08:35:44','2026-08-27 08:35:44'),(4,12,'/storage/photos/2tD2hKvYcloJ3bwzsPI04sWuSkv3kEUUIBR45irU.jpg','/storage/photos/wgOHIQCuIl1Vxy5iiCKS90jvdkTbgFzqHSdd5cP3.jpg','2026-08-27 08:41:31','2026-08-27 08:41:31'),(5,13,'/storage/photos/iqwo3tRhTzSYveIg5fxabrFzpO7JxEkvxjGbsyel.jpg','/storage/photos/MiGiNSAri4ssT4kyK3Khq9iF9iLwvpx4dsbtNKaI.jpg','2026-09-25 21:37:52','2026-09-25 21:37:52'),(6,14,'/storage/photos/sM2yXpIbha6ugRBMOZ14y0iBFbVXs5H9id9eGtWe.jpg','/storage/photos/pEuKZn2W3NHA1OQAUX2V9eNmUm4Pe9R9yGztTUdJ.jpg','2026-09-29 21:59:15','2026-09-29 21:59:15'),(8,16,'/storage/photos/S5YSUcg8Bj3i5kbYpdb1SJvhpeoFSJDaBDpntG3T.jpg','/storage/photos/TINK39Ee9w8s6BGXic0GvBrJnWE6v4onZRAEu2md.jpg','2026-10-01 00:20:23','2026-10-01 00:24:37');
/*!40000 ALTER TABLE `service_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('b3aEmy1zq9Cmx8CWhTDE7gwqf7wLh2XbIgrxPoVU',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJQMFJ2U29RVWYyS1RpZ1NUVE9EdjlqbFhuVFhzb1JiV0ZlT3pOeTNMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1790743564),('L1Rt8anfujtDfXRPEN5MF3DXbORmML0Gbs2f6SFQ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJNOHdOWmFwN0g5Y1Q1Z243ZnR1ckJKQzdPWk52Q0lxMk4xbHNxUk5vIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1788787303),('ZzSjEM0FsVPrOklpV7ioYcHRCDzgcTxnQeWzyEaO',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJVRVhVOXRKalBHdFlaWmJJUG1kMmZUMWdSMGtIREZFTEZCQmxXWVdLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1790835529);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sparepart`
--

DROP TABLE IF EXISTS `sparepart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sparepart` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `stok_sekarang` int NOT NULL,
  `batas_minimum` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sparepart_kode_barang_unique` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=405 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sparepart`
--

LOCK TABLES `sparepart` WRITE;
/*!40000 ALTER TABLE `sparepart` DISABLE KEYS */;
INSERT INTO `sparepart` VALUES (1,'RUT001','Upper Tank Avanza Lama',290000,23,3,'2026-08-22 11:14:10','2026-09-07 08:08:44'),(2,'RUT002','Upper Tank Avanza VVT-i',170000,12,3,'2026-08-22 11:14:10','2026-09-07 08:08:44'),(3,'RUT003','Upper Tank Avanza Dual VVT-i',320000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(4,'RUT004','Upper Tank All New Avanza',420000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(5,'RUT005','Upper Tank Innova Bensin 2.0',170000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(6,'RUT006','Upper Tank Innova Diesel 2.5',330000,1,3,'2026-08-22 11:14:10','2026-08-26 07:02:52'),(7,'RUT007','Upper Tank Innova Reborn Bensin',290000,17,3,'2026-08-22 11:14:10','2026-09-07 08:15:25'),(8,'RUT008','Upper Tank Innova Reborn Diesel',430000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(9,'RUT009','Upper Tank Innova Zenix',440000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(10,'RUT010','Upper Tank Fortuner Non-VNT',190000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(11,'RUT011','Upper Tank Fortuner VNT',440000,2,3,'2026-08-22 11:14:10','2026-09-25 21:37:57'),(12,'RUT012','Upper Tank Fortuner VRZ',170000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(13,'RUT013','Upper Tank Hilux Single Cabin',270000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(14,'RUT014','Upper Tank Hilux Double Cabin',150000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(15,'RUT015','Upper Tank Agya 1.0',440000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(16,'RUT016','Upper Tank Agya 1.2',160000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(17,'RUT017','Upper Tank Calya 1.2',390000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(18,'RUT018','Upper Tank Rush Lama',230000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(19,'RUT019','Upper Tank All New Rush',220000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(20,'RUT020','Upper Tank Raize 1.0 Turbo',190000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(21,'RUT021','Upper Tank Raize 1.2',340000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(22,'RUT022','Upper Tank Yaris Bakpao',340000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(23,'RUT023','Upper Tank Yaris Lele',170000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(24,'RUT024','Upper Tank Yaris Joker',450000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(25,'RUT025','Upper Tank Vios Gen 1',400000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(26,'RUT026','Upper Tank Vios Gen 2',210000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(27,'RUT027','Upper Tank Vios Gen 3',260000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(28,'RUT028','Upper Tank Camry 2.4',170000,21,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(29,'RUT029','Upper Tank Camry 2.5',280000,2,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(30,'RUT030','Upper Tank Altis Gen 1',250000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(31,'RUT031','Upper Tank Altis Gen 2',190000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(32,'RUT032','Upper Tank Alphard 2.4',450000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(33,'RUT033','Upper Tank Alphard 2.5',380000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(34,'RUT034','Upper Tank Vellfire',240000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(35,'RUT035','Upper Tank Sienta',430000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(36,'RUT036','Upper Tank Voxy',200000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(37,'RCT001','Core Radiator Avanza Manual 1ply',600000,5,2,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(38,'RCT002','Core Radiator Innova Bensin Manual',850000,3,1,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(39,'RCM001','Core Radiator L300 Diesel Kuningan',1200000,4,2,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(40,'RCO001','Core Radiator Panther Kuningan',1100000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(41,'RCN001','Core Radiator Grand Livina Matic',750000,2,2,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(42,'RCS001','Core Radiator Futura / Carry',550000,6,6,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(43,'RUT037','Upper Tank Nav1',250000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(44,'RUT038','Upper Tank Harrier 2.4',160000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(45,'RUT039','Upper Tank Kijang Super',220000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(46,'RUT040','Upper Tank Kijang Grand Extra',370000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(47,'RUT041','Upper Tank Kijang Kapsul 1.8',150000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(48,'RUT042','Upper Tank Kijang Kapsul 2.0',200000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(49,'RUT043','Upper Tank Kijang Kapsul Diesel',380000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(50,'RUT044','Upper Tank Hiace Commuter',410000,21,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(51,'RUT045','Upper Tank Hiace Premio',230000,20,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(52,'RUT046','Upper Tank Land Cruiser VX80',240000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(53,'RUH001','Upper Tank Jazz GD3',290000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(54,'RUH002','Upper Tank Jazz GE8',270000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(55,'RUH003','Upper Tank Jazz GK5',180000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(56,'RUH004','Upper Tank Brio 1.2',360000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(57,'RUH005','Upper Tank Mobilio',420000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(58,'RUH006','Upper Tank BRV Lama',150000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(59,'RUH007','Upper Tank All New BRV',160000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(60,'RUH008','Upper Tank HRV 1.5',440000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(61,'RUH009','Upper Tank HRV 1.8',160000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(62,'RUH010','Upper Tank HRV Turbo',320000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(63,'RUH011','Upper Tank CRV Gen 1',360000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(64,'RUH012','Upper Tank CRV Gen 2',360000,2,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(65,'RUH013','Upper Tank CRV Gen 3 2.0',370000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(66,'RUH014','Upper Tank CRV Gen 3 2.4',290000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(67,'RUH015','Upper Tank CRV Gen 4',390000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(68,'RUH016','Upper Tank CRV Gen 5 Turbo',190000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(69,'RUH017','Upper Tank Civic Ferio',420000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(70,'RUH018','Upper Tank Civic FD1',210000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(71,'RUH019','Upper Tank Civic FD2',410000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(72,'RUH020','Upper Tank Civic FB',260000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(73,'RUH021','Upper Tank Civic Turbo FC',200000,20,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(74,'RUH022','Upper Tank City GD8',290000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(75,'RUH023','Upper Tank City GM2',360000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(76,'RUH024','Upper Tank City GM6',380000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(77,'RUH025','Upper Tank Accord CP2',220000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(78,'RUH026','Upper Tank Accord CR2',440000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(79,'RUH027','Upper Tank Freed',440000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(80,'RUH028','Upper Tank Odyssey RB1',360000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(81,'RUH029','Upper Tank Odyssey RC1',390000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(82,'RUH030','Upper Tank Stream 1.7',190000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(83,'RUH031','Upper Tank Stream 2.0',350000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(84,'RUH032','Upper Tank Elyson',310000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(85,'RUD001','Upper Tank Xenia 1.0',380000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(86,'RUD002','Upper Tank Xenia 1.3',310000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(87,'RUD003','Upper Tank All New Xenia',200000,21,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(88,'RUD004','Upper Tank Terios Lama',320000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(89,'RUD005','Upper Tank All New Terios',210000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(90,'RUD006','Upper Tank Gran Max 1.3',260000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(91,'RUD007','Upper Tank Gran Max 1.5',210000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(92,'RUD008','Upper Tank Luxio',340000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(93,'RUD009','Upper Tank Ayla 1.0',260000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(94,'RUD010','Upper Tank Ayla 1.2',370000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(95,'RUD011','Upper Tank Sigra 1.0',450000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(96,'RUD012','Upper Tank Sigra 1.2',300000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(97,'RUD013','Upper Tank Sirion Lama',310000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(98,'RUD014','Upper Tank All New Sirion',320000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(99,'RUD015','Upper Tank Taruna Karburator',240000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(100,'RUD016','Upper Tank Taruna EFI',440000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(101,'RUD017','Upper Tank Feroza',380000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(102,'RUD018','Upper Tank Taft GT',150000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(103,'RUD019','Upper Tank Taft Independent',250000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(104,'RUD020','Upper Tank Rocky Lama',210000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(105,'RUD021','Upper Tank Rocky Baru 1.0',180000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(106,'RUD022','Upper Tank Rocky Baru 1.2',260000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(107,'RUD023','Upper Tank Zebra 1.3',320000,21,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(108,'RUS001','Upper Tank Carry 1.0',390000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(109,'RUS002','Upper Tank Carry Futura 1.5',190000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(110,'RUS003','Upper Tank New Carry (Tayu)',230000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(111,'RUS004','Upper Tank APV',250000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(112,'RUS005','Upper Tank APV Arena',430000,21,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(113,'RUS006','Upper Tank Ertiga Lama',340000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(114,'RUS007','Upper Tank All New Ertiga',370000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(115,'RUS008','Upper Tank XL7',170000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(116,'RUS009','Upper Tank SX4 X-Over',160000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(117,'RUS010','Upper Tank SX4 S-Cross',180000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(118,'RUS011','Upper Tank Grand Vitara 2.0',170000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(119,'RUS012','Upper Tank Grand Vitara 2.4',200000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(120,'RUS013','Upper Tank Ignis',300000,2,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(121,'RUS014','Upper Tank Baleno Lama',250000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(122,'RUS015','Upper Tank Baleno Hatchback',250000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(123,'RUS016','Upper Tank Aerio',380000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(124,'RUS017','Upper Tank Swift ST',410000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(125,'RUS018','Upper Tank Swift GT3',270000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(126,'RUS019','Upper Tank Splash',260000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(127,'RUS020','Upper Tank Jimny Katana',210000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(128,'RUS021','Upper Tank Jimny JB74',210000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(129,'RUS022','Upper Tank Karimun Kotak',340000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(130,'RUS023','Upper Tank Karimun Wagon R',300000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(131,'RUM001','Upper Tank Xpander',390000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(132,'RUM002','Upper Tank Xpander Cross',420000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(133,'RUM003','Upper Tank L300 Bensin',300000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(134,'RUM004','Upper Tank L300 Diesel',400000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(135,'RUM005','Upper Tank Pajero Sport Lama',240000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(136,'RUM006','Upper Tank Pajero Sport Dakar',280000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(137,'RUM007','Upper Tank All New Pajero Sport',190000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(138,'RUM008','Upper Tank Outlander Sport',280000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(139,'RUM009','Upper Tank Triton GLS',370000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(140,'RUM010','Upper Tank Triton HDX',280000,19,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(141,'RUM011','Upper Tank Mirage',160000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(142,'RUM012','Upper Tank Kuda Bensin 1.6',320000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(143,'RUM013','Upper Tank Kuda Diesel 2.5',290000,2,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(144,'RUM014','Upper Tank Kuda Grandia 2.0',230000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(145,'RUM015','Upper Tank Lancer DanGan',250000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(146,'RUM016','Upper Tank Lancer Evo 3',440000,21,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(147,'RUM017','Upper Tank Lancer Evo 4',210000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(148,'RUM018','Upper Tank Galant Hiu',190000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(149,'RUM019','Upper Tank Colt Diesel Canter',440000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(150,'RUN001','Upper Tank Grand Livina 1.5',430000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(151,'RUN002','Upper Tank Grand Livina 1.8',380000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(152,'RUN003','Upper Tank All New Livina',350000,20,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(153,'RUN004','Upper Tank March 1.2',370000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(154,'RUN005','Upper Tank March 1.5',330000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(155,'RUN006','Upper Tank Datsun Go',190000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(156,'RUN007','Upper Tank Datsun Go+',200000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(157,'RUN008','Upper Tank X-Trail T30',300000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(158,'RUN009','Upper Tank X-Trail T31',430000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(159,'RUN010','Upper Tank X-Trail T32',350000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(160,'RUN011','Upper Tank Serena C24',320000,2,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(161,'RUN012','Upper Tank Serena C26',320000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(162,'RUN013','Upper Tank Evalia',190000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(163,'RUN014','Upper Tank Juke',220000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(164,'RUN015','Upper Tank Navara D40',210000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(165,'RUN016','Upper Tank Navara NP300',420000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(166,'RUN017','Upper Tank Terrano',220000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(167,'RUO001','Upper Tank Isuzu Panther 2.3',330000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(168,'RUO002','Upper Tank Isuzu Panther 2.5',190000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(169,'RUO003','Upper Tank Isuzu Elf NKR',180000,12,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(170,'RUO004','Upper Tank Isuzu MU-X',290000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(171,'RUO005','Upper Tank Wuling Confero',320000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(172,'RUO006','Upper Tank Wuling Cortez',440000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(173,'RUO007','Upper Tank Wuling Almaz',160000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(174,'RUO008','Upper Tank Wuling Formo',420000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(175,'RUO009','Upper Tank Ford Fiesta 1.4',230000,10,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(176,'RUO010','Upper Tank Ford Fiesta 1.5',320000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(177,'RUO011','Upper Tank Ford Everest',440000,2,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(178,'RUO012','Upper Tank Ford Ranger 2.2',320000,11,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(179,'RUO013','Upper Tank Ford Ranger 2.5',420000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(180,'RUO014','Upper Tank Mazda 2 Non-Skyactiv',220000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(181,'RUO015','Upper Tank Mazda 2 Skyactiv',150000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(182,'RUO016','Upper Tank Mazda CX5',320000,18,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(183,'RUO017','Upper Tank Mazda Biante',310000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(184,'RUO018','Upper Tank Hyundai Avega',350000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(185,'RUO019','Upper Tank Hyundai Grand Avega',240000,15,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(186,'RUO020','Upper Tank Hyundai Stargazer',310000,16,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(187,'RUO021','Upper Tank Hyundai Creta',270000,13,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(188,'RUO022','Upper Tank Kia Picanto',220000,9,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(189,'RUO023','Upper Tank Kia Rio',380000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(190,'RUO024','Upper Tank Kia Sonet',190000,17,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(191,'RUO025','Upper Tank Chevrolet Spin',340000,6,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(192,'RUO026','Upper Tank Chevrolet Captiva',310000,3,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(193,'RLT001','Lower Tank Avanza Lama',400000,14,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(194,'RLT002','Lower Tank Avanza VVT-i',160000,7,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(195,'RLT003','Lower Tank Avanza Dual VVT-i',310000,4,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(196,'RLT004','Lower Tank All New Avanza',440000,5,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(197,'RLT005','Lower Tank Innova Bensin 2.0',390000,8,3,'2026-08-22 11:14:10','2026-08-22 11:14:10'),(198,'RLT006','Lower Tank Innova Diesel 2.5',430000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(199,'RLT007','Lower Tank Innova Reborn Bensin',380000,7,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(200,'RLT008','Lower Tank Innova Reborn Diesel',350000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(201,'RLT009','Lower Tank Innova Zenix',270000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(202,'RLT010','Lower Tank Fortuner Non-VNT',310000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(203,'RLT011','Lower Tank Fortuner VNT',210000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(204,'RLT012','Lower Tank Fortuner VRZ',390000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(205,'RLT013','Lower Tank Hilux Single Cabin',170000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(206,'RLT014','Lower Tank Hilux Double Cabin',380000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(207,'RLT015','Lower Tank Agya 1.0',450000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(208,'RLT016','Lower Tank Agya 1.2',350000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(209,'RLT017','Lower Tank Calya 1.2',270000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(210,'RLT018','Lower Tank Rush Lama',390000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(211,'RLT019','Lower Tank All New Rush',380000,14,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(212,'RLT020','Lower Tank Raize 1.0 Turbo',360000,16,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(213,'RLT021','Lower Tank Raize 1.2',330000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(214,'RLT022','Lower Tank Yaris Bakpao',220000,16,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(215,'RLT023','Lower Tank Yaris Lele',390000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(216,'RLT024','Lower Tank Yaris Joker',340000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(217,'RLT025','Lower Tank Vios Gen 1',390000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(218,'RLT026','Lower Tank Vios Gen 2',180000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(219,'RLT027','Lower Tank Vios Gen 3',330000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(220,'RLT028','Lower Tank Camry 2.4',260000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(221,'RLT029','Lower Tank Camry 2.5',190000,7,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(222,'RLT030','Lower Tank Altis Gen 1',390000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(223,'RLT031','Lower Tank Altis Gen 2',250000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(224,'RLT032','Lower Tank Alphard 2.4',450000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(225,'RLT033','Lower Tank Alphard 2.5',170000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(226,'RLT034','Lower Tank Vellfire',420000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(227,'RLT035','Lower Tank Sienta',270000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(228,'RLT036','Lower Tank Voxy',310000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(229,'RLT037','Lower Tank Nav1',410000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(230,'RLT038','Lower Tank Harrier 2.4',450000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(231,'RLT039','Lower Tank Kijang Super',280000,14,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(232,'RLT040','Lower Tank Kijang Grand Extra',230000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(233,'RLT041','Lower Tank Kijang Kapsul 1.8',450000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(234,'RLT042','Lower Tank Kijang Kapsul 2.0',340000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(235,'RLT043','Lower Tank Kijang Kapsul Diesel',280000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(236,'RLT044','Lower Tank Hiace Commuter',310000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(237,'RLT045','Lower Tank Hiace Premio',200000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(238,'RLT046','Lower Tank Land Cruiser VX80',330000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(239,'RLH001','Lower Tank Jazz GD3',410000,16,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(240,'RLH002','Lower Tank Jazz GE8',280000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(241,'RLH003','Lower Tank Jazz GK5',260000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(242,'RLH004','Lower Tank Brio 1.2',420000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(243,'RLH005','Lower Tank Mobilio',350000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(244,'RLH006','Lower Tank BRV Lama',200000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(245,'RLH007','Lower Tank All New BRV',240000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(246,'RLH008','Lower Tank HRV 1.5',210000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(247,'RLH009','Lower Tank HRV 1.8',160000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(248,'RLH010','Lower Tank HRV Turbo',420000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(249,'RLH011','Lower Tank CRV Gen 1',240000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(250,'RLH012','Lower Tank CRV Gen 2',150000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(251,'RLH013','Lower Tank CRV Gen 3 2.0',300000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(252,'RLH014','Lower Tank CRV Gen 3 2.4',230000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(253,'RLH015','Lower Tank CRV Gen 4',400000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(254,'RLH016','Lower Tank CRV Gen 5 Turbo',410000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(255,'RLH017','Lower Tank Civic Ferio',270000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(256,'RLH018','Lower Tank Civic FD1',390000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(257,'RLH019','Lower Tank Civic FD2',220000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(258,'RLH020','Lower Tank Civic FB',200000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(259,'RLH021','Lower Tank Civic Turbo FC',450000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(260,'RLH022','Lower Tank City GD8',350000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(261,'RLH023','Lower Tank City GM2',330000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(262,'RLH024','Lower Tank City GM6',200000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(263,'RLH025','Lower Tank Accord CP2',390000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(264,'RLH026','Lower Tank Accord CR2',420000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(265,'RLH027','Lower Tank Freed',320000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(266,'RLH028','Lower Tank Odyssey RB1',380000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(267,'RLH029','Lower Tank Odyssey RC1',280000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(268,'RLH030','Lower Tank Stream 1.7',400000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(269,'RLH031','Lower Tank Stream 2.0',410000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(270,'RLH032','Lower Tank Elyson',390000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(271,'RLD001','Lower Tank Xenia 1.0',450000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(272,'RLD002','Lower Tank Xenia 1.3',370000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(273,'RLD003','Lower Tank All New Xenia',200000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(274,'RLD004','Lower Tank Terios Lama',250000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(275,'RLD005','Lower Tank All New Terios',390000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(276,'RLD006','Lower Tank Gran Max 1.3',440000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(277,'RLD007','Lower Tank Gran Max 1.5',330000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(278,'RLD008','Lower Tank Luxio',400000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(279,'RLD009','Lower Tank Ayla 1.0',290000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(280,'RLD010','Lower Tank Ayla 1.2',290000,14,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(281,'RLD011','Lower Tank Sigra 1.0',410000,16,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(282,'RLD012','Lower Tank Sigra 1.2',260000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(283,'RLD013','Lower Tank Sirion Lama',430000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(284,'RLD014','Lower Tank All New Sirion',390000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(285,'RLD015','Lower Tank Taruna Karburator',420000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(286,'RLD016','Lower Tank Taruna EFI',350000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(287,'RLD017','Lower Tank Feroza',390000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(288,'RLD018','Lower Tank Taft GT',270000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(289,'RLD019','Lower Tank Taft Independent',450000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(290,'RLD020','Lower Tank Rocky Lama',310000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(291,'RLD021','Lower Tank Rocky Baru 1.0',170000,16,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(292,'RLD022','Lower Tank Rocky Baru 1.2',390000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(293,'RLD023','Lower Tank Zebra 1.3',230000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(294,'RLS001','Lower Tank Carry 1.0',240000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(295,'RLS002','Lower Tank Carry Futura 1.5',280000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(296,'RLS003','Lower Tank New Carry (Tayu)',410000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(297,'RLS004','Lower Tank APV',410000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(298,'RLS005','Lower Tank APV Arena',160000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(299,'RLS006','Lower Tank Ertiga Lama',310000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(300,'RLS007','Lower Tank All New Ertiga',260000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(301,'RLS008','Lower Tank XL7',350000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(302,'RLS009','Lower Tank SX4 X-Over',300000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(303,'RLS010','Lower Tank SX4 S-Cross',380000,14,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(304,'RLS011','Lower Tank Grand Vitara 2.0',200000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(305,'RLS012','Lower Tank Grand Vitara 2.4',350000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(306,'RLS013','Lower Tank Ignis',360000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(307,'RLS014','Lower Tank Baleno Lama',440000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(308,'RLS015','Lower Tank Baleno Hatchback',380000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(309,'RLS016','Lower Tank Aerio',230000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(310,'RLS017','Lower Tank Swift ST',380000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(311,'RLS018','Lower Tank Swift GT3',200000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(312,'RLS019','Lower Tank Splash',190000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(313,'RLS020','Lower Tank Jimny Katana',400000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(314,'RLS021','Lower Tank Jimny JB74',410000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(315,'RLS022','Lower Tank Karimun Kotak',450000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(316,'RLS023','Lower Tank Karimun Wagon R',350000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(317,'RLM001','Lower Tank Xpander',190000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(318,'RLM002','Lower Tank Xpander Cross',180000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(319,'RLM003','Lower Tank L300 Bensin',330000,8,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(320,'RLM004','Lower Tank L300 Diesel',430000,15,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(321,'RLM005','Lower Tank Pajero Sport Lama',360000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(322,'RLM006','Lower Tank Pajero Sport Dakar',450000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(323,'RLM007','Lower Tank All New Pajero Sport',160000,8,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(324,'RLM008','Lower Tank Outlander Sport',170000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(325,'RLM009','Lower Tank Triton GLS',440000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(326,'RLM010','Lower Tank Triton HDX',440000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(327,'RLM011','Lower Tank Mirage',320000,7,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(328,'RLM012','Lower Tank Kuda Bensin 1.6',390000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(329,'RLM013','Lower Tank Kuda Diesel 2.5',270000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(330,'RLM014','Lower Tank Kuda Grandia 2.0',300000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(331,'RLM015','Lower Tank Lancer DanGan',380000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(332,'RLM016','Lower Tank Lancer Evo 3',430000,8,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(333,'RLM017','Lower Tank Lancer Evo 4',180000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(334,'RLM018','Lower Tank Galant Hiu',390000,18,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(335,'RLM019','Lower Tank Colt Diesel Canter',380000,14,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(336,'RLN001','Lower Tank Grand Livina 1.5',370000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(337,'RLN002','Lower Tank Grand Livina 1.8',280000,13,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(338,'RLN003','Lower Tank All New Livina',190000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(339,'RLN004','Lower Tank March 1.2',440000,7,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(340,'RLN005','Lower Tank March 1.5',340000,17,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(341,'RLN006','Lower Tank Datsun Go',380000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(342,'RLN007','Lower Tank Datsun Go+',200000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(343,'RLN008','Lower Tank X-Trail T30',430000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(344,'RLN009','Lower Tank X-Trail T31',270000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(345,'RLN010','Lower Tank X-Trail T32',320000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(346,'RLN011','Lower Tank Serena C24',150000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(347,'RLN012','Lower Tank Serena C26',150000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(348,'RLN013','Lower Tank Evalia',230000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(349,'RLN014','Lower Tank Juke',400000,19,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(350,'RLN015','Lower Tank Navara D40',300000,8,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(351,'RLN016','Lower Tank Navara NP300',300000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(352,'RLN017','Lower Tank Terrano',390000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(353,'RLO001','Lower Tank Isuzu Panther 2.3',210000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(354,'RLO002','Lower Tank Isuzu Panther 2.5',290000,7,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(355,'RLO003','Lower Tank Isuzu Elf NKR',450000,10,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(356,'RLO004','Lower Tank Isuzu MU-X',270000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(357,'RLO005','Lower Tank Wuling Confero',370000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(358,'RLO006','Lower Tank Wuling Cortez',350000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(359,'RLO007','Lower Tank Wuling Almaz',280000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(360,'RLO008','Lower Tank Wuling Formo',260000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(361,'RLO009','Lower Tank Ford Fiesta 1.4',380000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(362,'RLO010','Lower Tank Ford Fiesta 1.5',270000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(363,'RLO011','Lower Tank Ford Everest',220000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(364,'RLO012','Lower Tank Ford Ranger 2.2',330000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(365,'RLO013','Lower Tank Ford Ranger 2.5',170000,12,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(366,'RLO014','Lower Tank Mazda 2 Non-Skyactiv',350000,16,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(367,'RLO015','Lower Tank Mazda 2 Skyactiv',240000,8,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(368,'RLO016','Lower Tank Mazda CX5',400000,20,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(369,'RLO017','Lower Tank Mazda Biante',440000,2,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(370,'RLO018','Lower Tank Hyundai Avega',190000,4,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(371,'RLO019','Lower Tank Hyundai Grand Avega',430000,21,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(372,'RLO020','Lower Tank Hyundai Stargazer',260000,11,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(373,'RLO021','Lower Tank Hyundai Creta',380000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(374,'RLO022','Lower Tank Kia Picanto',420000,9,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(375,'RLO023','Lower Tank Kia Rio',260000,6,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(376,'RLO024','Lower Tank Kia Sonet',390000,7,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(377,'RLO025','Lower Tank Chevrolet Spin',220000,3,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(378,'RLO026','Lower Tank Chevrolet Captiva',230000,5,3,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(379,'CLU001','Coolant Prestone Merah 4L',125000,54,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(380,'CLU002','Coolant Prestone Hijau 4L',125000,13,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(381,'CLU003','Coolant Top1 Merah 1L',35000,36,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(382,'CLU004','Coolant Top1 Hijau 1L',35000,55,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(383,'CLU005','Coolant Megacools Hijau 1L',25000,41,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(384,'CLU006','Coolant Megacools Merah 1L',25000,28,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(385,'CLU007','Air Radiator Aquadest 5L',20000,88,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(386,'CLU008','Coolant Wurth Biru 5L',200000,16,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(387,'CLU009','Coolant Jumbo Hijau 4L',80000,20,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(388,'CLT001','Toyota Motor Oil (TMO) Coolant Merah 4L',160000,43,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(389,'CLT002','Toyota Motor Oil (TMO) Coolant Merah 1L',45000,23,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(390,'CLH001','Honda Radiator Coolant Type 2 (Biru) 4L',175000,26,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(391,'CLH002','Honda Radiator Coolant Type 1 (Hijau) 4L',165000,72,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(392,'CLH003','Honda Radiator Coolant (Biru) 1L',50000,30,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(393,'CLD001','Daihatsu Genuine Coolant Merah 4L',155000,78,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(394,'CLS001','Suzuki Ecstar Coolant Biru 4L',150000,72,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(395,'CLS002','Suzuki Ecstar Coolant Biru 1L',40000,13,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(396,'CLM001','Mitsubishi Motors Genuine Coolant Hijau 4L',180000,55,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(397,'CLM002','Mitsubishi Motors Genuine Coolant Hijau 1L',55000,40,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(398,'CLN001','Nissan Genuine Coolant Biru 4L',170000,69,10,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(399,'JSU001','Isi Freon AC (Jasa + Freon R134a Full)',200000,992,0,'2026-08-22 11:14:11','2026-10-01 00:24:40'),(400,'JSU002','Tambah Freon AC (Setengah)',100000,999,0,'2026-08-22 11:14:11','2026-08-22 11:14:11'),(401,'JSU003','Jasa Korok Radiator Mobil Kecil',150000,993,0,'2026-08-22 11:14:11','2026-10-01 00:24:40'),(402,'JSU004','Jasa Korok Radiator Mobil Besar/Truk',250000,997,0,'2026-08-22 11:14:11','2026-08-27 10:36:16'),(403,'JSU008','Jasa Ganti Upper/Lower Tank (Termasuk Lem)',100000,998,0,'2026-08-22 11:14:11','2026-09-25 21:37:57'),(404,'OLI-001','Oli Mesin TMO 10W-40',85000,15,5,'2026-09-30 20:32:31','2026-09-30 20:32:31');
/*!40000 ALTER TABLE `sparepart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_adjustment`
--

DROP TABLE IF EXISTS `stock_adjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_adjustment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `sparepart_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `harga_modal` int DEFAULT NULL,
  `tipe` enum('Masuk','Keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_adjustment_sparepart_id_foreign` (`sparepart_id`),
  KEY `stock_adjustment_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_adjustment_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `sparepart` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_adjustment_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_adjustment`
--

LOCK TABLES `stock_adjustment` WRITE;
/*!40000 ALTER TABLE `stock_adjustment` DISABLE KEYS */;
INSERT INTO `stock_adjustment` VALUES (1,1,401,1,NULL,'Keluar','Dipakai otomatis untuk Nota Servis ID #1',NULL,'2026-08-26 13:52:50','2026-08-26 06:52:50','2026-08-26 06:52:50'),(2,1,6,1,NULL,'Keluar','Beli',NULL,'2026-08-26 14:02:52','2026-08-26 07:02:52','2026-08-26 07:02:52'),(3,1,399,1,NULL,'Keluar','Dipakai otomatis untuk Nota Servis ID #2',NULL,'2026-08-26 14:12:47','2026-08-26 07:12:47','2026-08-26 07:12:47'),(4,1,401,1,NULL,'Keluar','Dipakai otomatis untuk Nota Servis ID #5',NULL,'2026-08-26 15:08:29','2026-08-26 08:08:29','2026-08-26 08:08:29'),(5,1,399,1,NULL,'Keluar','Dipakai otomatis untuk Nota Servis ID #7',NULL,'2026-08-26 15:18:10','2026-08-26 08:18:10','2026-08-26 08:18:10'),(6,1,399,1,NULL,'Masuk','Retur otomatis: Revisi / Buka Kembali Nota Servis ID #7',NULL,'2026-08-26 15:24:04','2026-08-26 08:24:04','2026-08-26 08:24:04'),(7,1,399,1,NULL,'Keluar','Dipakai otomatis untuk Nota Servis ID #7',NULL,'2026-08-26 15:44:39','2026-08-26 08:44:39','2026-08-26 08:44:39'),(8,1,399,1,NULL,'Keluar','Dipakai otomatis untuk Nota Servis ID #8',NULL,'2026-08-26 15:45:40','2026-08-26 08:45:40','2026-08-26 08:45:40'),(9,1,401,1,NULL,'Keluar','Servis Selesai - Kendaraan: F9012GHI (Nota #9)',NULL,'2026-08-26 16:00:59','2026-08-26 09:00:59','2026-08-26 09:00:59'),(10,1,401,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: F9012GHI (Nota #9)',NULL,'2026-08-26 16:02:21','2026-08-26 09:02:21','2026-08-26 09:02:21'),(11,1,401,1,NULL,'Keluar','Servis Selesai - Kendaraan: F9012GHI (Nota #9)',NULL,'2026-08-26 16:02:33','2026-08-26 09:02:33','2026-08-26 09:02:33'),(12,1,399,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: A7890MNO (Nota #8)',NULL,'2026-08-26 16:31:12','2026-08-26 09:31:13','2026-08-26 09:31:13'),(13,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: A7890MNO (Nota #8)',NULL,'2026-08-26 16:31:41','2026-08-26 09:31:41','2026-08-26 09:31:41'),(14,1,399,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: A7890MNO (Nota #8)',NULL,'2026-08-26 16:34:59','2026-08-26 09:34:59','2026-08-26 09:34:59'),(15,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: A7890MNO (Nota #8)',NULL,'2026-08-26 16:35:54','2026-08-26 09:35:54','2026-08-26 09:35:54'),(16,1,402,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL1234AD (Nota #10)',NULL,'2026-08-26 16:45:02','2026-08-26 09:45:02','2026-08-26 09:45:02'),(17,1,1,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:26:33','2026-08-27 08:26:33','2026-08-27 08:26:33'),(18,1,1,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:29:02','2026-08-27 08:29:02','2026-08-27 08:29:02'),(19,1,1,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:35:48','2026-08-27 08:35:48','2026-08-27 08:35:48'),(20,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:35:48','2026-08-27 08:35:48','2026-08-27 08:35:48'),(21,1,1,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:36:04','2026-08-27 08:36:04','2026-08-27 08:36:04'),(22,1,399,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:36:04','2026-08-27 08:36:04','2026-08-27 08:36:04'),(23,1,1,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:36:10','2026-08-27 08:36:10','2026-08-27 08:36:10'),(24,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0904QQ (Nota #11)',NULL,'2026-08-27 15:36:10','2026-08-27 08:36:10','2026-08-27 08:36:10'),(25,1,402,1,NULL,'Keluar','Servis Selesai - Kendaraan: F9012GHI (Nota #12)',NULL,'2026-08-27 15:41:51','2026-08-27 08:41:51','2026-08-27 08:41:51'),(26,2,7,1,NULL,'Keluar','Jual Langsung',NULL,'2026-08-27 17:35:35','2026-08-27 10:35:35','2026-08-27 10:35:35'),(27,1,402,1,NULL,'Masuk','Retur Revisi Nota - Kendaraan: F9012GHI (Nota #12)',NULL,'2026-08-27 17:36:05','2026-08-27 10:36:05','2026-08-27 10:36:05'),(28,1,402,1,NULL,'Keluar','Servis Selesai - Kendaraan: F9012GHI (Nota #12)',NULL,'2026-08-27 17:36:16','2026-08-27 10:36:16','2026-08-27 10:36:16'),(29,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: F9012GHI (Nota #12)',NULL,'2026-08-27 17:36:16','2026-08-27 10:36:16','2026-08-27 10:36:16'),(30,1,1,5,NULL,'Masuk','Pesanan Bulan 9 Medan hendri Tanaka','bukti_stok/p6GqWonlDV4t7rjGFNlV7X7DNuu0D4I8N6ayA6Pe.jpg','2026-09-07 13:50:05','2026-09-07 06:50:05','2026-09-07 06:50:05'),(31,1,1,1,250000,'Masuk','Beli Bulan 9 Hendri tanaka','bukti_stok/Z63YvJ4da1C248skpxiV2nYvzcWbHWvb0QvKCj7g.jpg','2026-09-07 15:08:44','2026-09-07 08:08:44','2026-09-07 08:08:44'),(32,1,2,1,150000,'Masuk','Beli Bulan 9 Hendri tanaka','bukti_stok/Z63YvJ4da1C248skpxiV2nYvzcWbHWvb0QvKCj7g.jpg','2026-09-07 15:08:44','2026-09-07 08:08:44','2026-09-07 08:08:44'),(33,1,7,1,250000,'Masuk','Beli Tanaka #24','bukti_stok/ufEky4iKg6VhFAvuj454mMcblgEbFn6zk32DvDa8.avif','2026-09-07 15:15:25','2026-09-07 08:15:25','2026-09-07 08:15:25'),(34,1,11,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0987JA (Nota #13)',NULL,'2026-09-26 04:37:57','2026-09-25 21:37:57','2026-09-25 21:37:57'),(35,1,403,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0987JA (Nota #13)',NULL,'2026-09-26 04:37:57','2026-09-25 21:37:57','2026-09-25 21:37:57'),(36,1,401,1,NULL,'Keluar','Servis Selesai - Kendaraan: A7890MNO (Nota #14)',NULL,'2026-09-30 04:59:41','2026-09-29 21:59:41','2026-09-29 21:59:41'),(37,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0987AAZ (Nota #15)',NULL,'2026-10-01 06:54:54','2026-09-30 23:54:54','2026-09-30 23:54:54'),(38,1,401,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0987AAZ (Nota #15)',NULL,'2026-10-01 06:54:54','2026-09-30 23:54:54','2026-09-30 23:54:54'),(39,1,399,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0987AAZ (Nota #16)',NULL,'2026-10-01 07:24:40','2026-10-01 00:24:40','2026-10-01 00:24:40'),(40,1,401,1,NULL,'Keluar','Servis Selesai - Kendaraan: BL0987AAZ (Nota #16)',NULL,'2026-10-01 07:24:40','2026-10-01 00:24:40','2026-10-01 00:24:40');
/*!40000 ALTER TABLE `stock_adjustment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','mekanik') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mekanik',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Doles','admin','admin@doles.com',NULL,'$2y$12$nkDbeqb2.JBppf7/fY1MM.9Boxfq4iKcTYL4oyUwCRgbK2kyI4T0a','admin',NULL,'2026-08-22 11:14:10','2026-08-26 07:02:17'),(2,'BULEK (MEKANIK)','mekanik','mekanik@doles.com',NULL,'$2y$12$xLQDkubMMMiK048bH6ADneiam43fS2yDWePGQ1aQLiHtqmROnh5r2','mekanik',NULL,'2026-08-22 11:14:10','2026-08-26 07:02:34'),(3,'Danil Arianda','danil','danil@doles.local',NULL,'$2y$12$JNvcihbEs5.dlKIK.zOCeOhLwpl049Ef9IVDSu9g7m9TjR73Wa6wa','admin',NULL,'2026-09-07 08:23:33','2026-09-29 21:52:58'),(4,'Fahrianda','fahrianda','fahrianda@doles.local',NULL,'$2y$12$extJX.szVDgnQ0nG5BYCyeyxyw/J.BHP0uCuFvvf1P0xzHnoxWC0y','mekanik',NULL,'2026-09-25 21:33:21','2026-09-25 21:33:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warranty`
--

DROP TABLE IF EXISTS `warranty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warranty` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `status_garansi` enum('Aktif','Habis','Diklaim') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warranty_service_id_foreign` (`service_id`),
  CONSTRAINT `warranty_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warranty`
--

LOCK TABLES `warranty` WRITE;
/*!40000 ALTER TABLE `warranty` DISABLE KEYS */;
INSERT INTO `warranty` VALUES (8,9,'2026-08-26','2026-09-25','Aktif','2026-08-26 09:02:33','2026-08-26 09:02:33'),(10,8,'2026-08-26','2026-09-25','Aktif','2026-08-26 09:35:54','2026-08-26 09:35:54'),(11,10,'2026-08-26','2026-09-25','Aktif','2026-08-26 09:45:02','2026-08-26 09:45:02'),(14,11,'2026-08-27','2026-09-27','Aktif','2026-08-27 08:36:10','2026-08-27 08:36:26'),(16,12,'2026-08-27','2026-09-26','Aktif','2026-08-27 10:36:16','2026-08-27 10:36:16'),(17,13,'2026-09-26','2026-10-26','Aktif','2026-09-25 21:37:57','2026-09-25 21:37:57'),(18,14,'2026-09-30','2026-10-30','Aktif','2026-09-29 21:59:41','2026-09-29 21:59:41'),(20,16,'2026-10-01','2026-10-31','Aktif','2026-10-01 00:24:40','2026-10-01 00:24:40');
/*!40000 ALTER TABLE `warranty` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 10:38:39
