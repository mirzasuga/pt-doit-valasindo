-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.1.21-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Membuang struktur basisdata untuk kkp
CREATE DATABASE IF NOT EXISTS `kkp` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `kkp`;

-- membuang struktur untuk table kkp.group_roles
CREATE TABLE IF NOT EXISTS `group_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  KEY `FK_group_roles_roles` (`role_id`),
  KEY `FK_group_roles_users` (`user_id`),
  CONSTRAINT `FK_group_roles_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  CONSTRAINT `FK_group_roles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.kuitansipenukaran
CREATE TABLE IF NOT EXISTS `kuitansipenukaran` (
  `no_kuitansi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tukar_id` int(10) unsigned NOT NULL,
  `tanggal_cetak` datetime NOT NULL,
  `jumlah_cetak` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`no_kuitansi`),
  KEY `FK__penukaran` (`tukar_id`),
  CONSTRAINT `FK__penukaran` FOREIGN KEY (`tukar_id`) REFERENCES `penukaran` (`tukar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.kurs
CREATE TABLE IF NOT EXISTS `kurs` (
  `kurs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `valas_id` int(10) unsigned NOT NULL,
  `mitra_id` int(10) unsigned NOT NULL,
  `modal_jual` int(11) NOT NULL,
  `modal_beli` int(11) NOT NULL,
  `jual` int(11) NOT NULL,
  `beli` int(11) NOT NULL,
  `selisih` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kurs_id`),
  KEY `FK__valas` (`valas_id`),
  KEY `FK_kurs_mitra` (`mitra_id`),
  CONSTRAINT `FK__valas` FOREIGN KEY (`valas_id`) REFERENCES `valas` (`valas_id`),
  CONSTRAINT `FK_kurs_mitra` FOREIGN KEY (`mitra_id`) REFERENCES `mitra` (`mitra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.kurs_penukaran
CREATE TABLE IF NOT EXISTS `kurs_penukaran` (
  `kurs_id` int(10) unsigned NOT NULL,
  `tukar_id` int(10) unsigned NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `nominal_rupiah` double NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  KEY `FK_kurs_penukaran_kurs` (`kurs_id`),
  KEY `FK_kurs_penukaran_penukaran` (`tukar_id`),
  CONSTRAINT `FK_kurs_penukaran_kurs` FOREIGN KEY (`kurs_id`) REFERENCES `kurs` (`kurs_id`) ON DELETE NO ACTION,
  CONSTRAINT `FK_kurs_penukaran_penukaran` FOREIGN KEY (`tukar_id`) REFERENCES `penukaran` (`tukar_id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.mitra
CREATE TABLE IF NOT EXISTS `mitra` (
  `mitra_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(40) NOT NULL DEFAULT '0',
  `telepon` varchar(40) NOT NULL DEFAULT '0',
  `fax` varchar(20) NOT NULL DEFAULT '0',
  `alamat` varchar(191) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mitra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.penukaran
CREATE TABLE IF NOT EXISTS `penukaran` (
  `tukar_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teller_id` int(10) unsigned NOT NULL,
  `total_rupiah` double NOT NULL DEFAULT '0',
  `jenis_tukar` enum('S','B') NOT NULL DEFAULT 'S',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tukar_id`),
  KEY `FK__users` (`teller_id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`teller_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.ppsv
CREATE TABLE IF NOT EXISTS `ppsv` (
  `ppsv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `who_request` int(10) unsigned NOT NULL,
  `keterangan` varchar(191) NOT NULL,
  `tgl_permintaan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('U','A','R') NOT NULL DEFAULT 'U',
  `processed_at` datetime DEFAULT NULL,
  `viewed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ppsv_id`),
  KEY `FK_ppsv_users` (`who_request`),
  CONSTRAINT `FK_ppsv_users` FOREIGN KEY (`who_request`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `jenis` enum('PURCHASING','TELLER','ADMINISTRASI','DIREKSI','CUSTOMER') NOT NULL DEFAULT 'CUSTOMER' COMMENT 'P:Purchasing, T:Teller, A:Administrasi, D:Direksi, C:Customers',
  `deskripsi` varchar(50) NOT NULL,
  `permissions` varchar(255) NOT NULL DEFAULT '{}',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `nama_user` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` varchar(191) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
-- membuang struktur untuk table kkp.valas
CREATE TABLE IF NOT EXISTS `valas` (
  `valas_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_valas` varchar(90) NOT NULL,
  `prefix` char(3) NOT NULL,
  `stok` double NOT NULL,
  `deskripsi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`valas_id`),
  UNIQUE KEY `prefix` (`prefix`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Pengeluaran data tidak dipilih.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
