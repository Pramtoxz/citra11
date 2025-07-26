/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - dbcitra
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbcitra` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `dbcitra`;

/*Table structure for table `checkin` */

DROP TABLE IF EXISTS `checkin`;

CREATE TABLE `checkin` (
  `idcheckin` char(30) NOT NULL,
  `idbooking` char(30) DEFAULT NULL,
  `sisabayar` double DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcheckin`),
  KEY `fk_checkin_reservasi` (`idbooking`),
  KEY `idx_checkin_created` (`created_at`),
  CONSTRAINT `fk_checkin_reservasi` FOREIGN KEY (`idbooking`) REFERENCES `reservasi` (`idbooking`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `checkin` */

insert  into `checkin`(`idcheckin`,`idbooking`,`sisabayar`,`deposit`,`created_at`,`updated_at`,`deleted_at`) values 
('CK-20250727-0001','RS-20250727-0001',50000,100000,'2025-07-27 02:39:09','2025-07-27 02:39:09',NULL);

/*Table structure for table `checkout` */

DROP TABLE IF EXISTS `checkout`;

CREATE TABLE `checkout` (
  `idcheckout` char(30) NOT NULL,
  `idcheckin` char(30) DEFAULT NULL,
  `tglcheckout` date DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `keterangan` text,
  `grandtotal` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcheckout`),
  KEY `fk_checkout_checkin` (`idcheckin`),
  KEY `idx_checkout_tglcheckout` (`tglcheckout`),
  CONSTRAINT `fk_checkout_checkin` FOREIGN KEY (`idcheckin`) REFERENCES `checkin` (`idcheckin`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `checkout` */

insert  into `checkout`(`idcheckout`,`idcheckin`,`tglcheckout`,`potongan`,`keterangan`,`grandtotal`,`created_at`,`updated_at`,`deleted_at`) values 
('CO-20250727-0001','CK-20250727-0001','2025-07-28',50000,'Telat Bangun',50000,NULL,NULL,NULL);

/*Table structure for table `kamar` */

DROP TABLE IF EXISTS `kamar`;

CREATE TABLE `kamar` (
  `id_kamar` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `status_kamar` varchar(30) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `dp` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kamar`),
  KEY `idx_kamar_status` (`status_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kamar` */

insert  into `kamar`(`id_kamar`,`nama`,`harga`,`status_kamar`,`cover`,`deskripsi`,`dp`,`created_at`,`updated_at`,`deleted_at`) values 
('KM0001','Family Room',1250000,'tersedia','cover-20250727-KM0001.jpeg','Family Room untuk Keluarga yang ingin bersama dalam kehangatan malam',300000,NULL,NULL,NULL),
('KM0002','Standart',150000,'tersedia','cover-20250727-KM0002.jpeg','Singel',100000,NULL,NULL,NULL),
('KM0003','King Double',550000,'tersedia','cover-20250727-KM0003.jpg','Double bed',200000,NULL,NULL,NULL);

/*Table structure for table `otp_codes` */

DROP TABLE IF EXISTS `otp_codes`;

CREATE TABLE `otp_codes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `type` enum('register','forgot_password') NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_otp_code` (`otp_code`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `otp_codes` */

/*Table structure for table `pengeluaran` */

DROP TABLE IF EXISTS `pengeluaran`;

CREATE TABLE `pengeluaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `total` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pengeluaran_tgl` (`tgl`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pengeluaran` */

insert  into `pengeluaran`(`id`,`tgl`,`keterangan`,`total`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'2025-07-24','Acc Pimpinan Pembelian Lampu Kamar Mandi',10000,'2025-07-24 08:00:00','2025-07-24 08:00:00',NULL);

/*Table structure for table `reservasi` */

DROP TABLE IF EXISTS `reservasi`;

CREATE TABLE `reservasi` (
  `idbooking` varchar(30) NOT NULL,
  `nik` char(30) NOT NULL,
  `idkamar` char(30) NOT NULL,
  `tglcheckin` date NOT NULL,
  `tglcheckout` date NOT NULL,
  `totalbayar` double NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `buktibayar` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `status` enum('diproses','diterima','ditolak','checkin','selesai','cancel','limit') DEFAULT 'diproses',
  `batas_waktu` datetime DEFAULT NULL COMMENT 'Batas waktu 15 menit dari created_at untuk upload bukti',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idbooking`),
  KEY `fk_reservasi_tamu` (`nik`),
  KEY `fk_reservasi_kamar` (`idkamar`),
  KEY `idx_reservasi_tglcheckin` (`tglcheckin`),
  KEY `idx_reservasi_tglcheckout` (`tglcheckout`),
  KEY `idx_reservasi_status` (`status`),
  KEY `idx_reservasi_online` (`online`),
  CONSTRAINT `fk_reservasi_kamar` FOREIGN KEY (`idkamar`) REFERENCES `kamar` (`id_kamar`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reservasi_tamu` FOREIGN KEY (`nik`) REFERENCES `tamu` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `reservasi` */

insert  into `reservasi`(`idbooking`,`nik`,`idkamar`,`tglcheckin`,`tglcheckout`,`totalbayar`,`tipe`,`buktibayar`,`online`,`status`,`batas_waktu`,`created_at`,`updated_at`,`deleted_at`) values 
('RS-20250727-0001','1371020706010099','KM0002','2025-07-27','2025-07-28',100000,'cash',NULL,0,'selesai',NULL,'2025-07-27 02:36:37','2025-07-27 02:36:37',NULL);

/*Table structure for table `tamu` */

DROP TABLE IF EXISTS `tamu`;

CREATE TABLE `tamu` (
  `nik` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `iduser` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nik`),
  KEY `fk_tamu_user` (`iduser`),
  KEY `idx_tamu_jk` (`jk`),
  CONSTRAINT `fk_tamu_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tamu` */

insert  into `tamu`(`nik`,`nama`,`alamat`,`nohp`,`jk`,`iduser`,`created_at`,`updated_at`,`deleted_at`) values 
('1371020706010099','Rindiani','Jayanusasdsdsc','08123343444','P',2,'2025-06-28 10:30:11','2025-06-28 10:30:11',NULL),
('3456788895','rindi','Padang','083182117492','L',NULL,'2025-07-26 03:08:47','2025-07-26 03:08:47',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL COMMENT 'admin, user, dll',
  `status` varchar(20) NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`status`,`last_login`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin@example.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','admin','active','2025-07-27 05:48:14',NULL,'2025-06-14 21:50:56','2025-06-14 21:50:56',NULL),
(2,'Rindiani','rindianir573@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','user','active','2025-07-27 02:09:21',NULL,'2025-06-28 10:30:11','2025-06-28 10:30:11',NULL),
(26,'Pimpinan','pimpinan@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','pimpinan','active','2025-07-27 05:36:19',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
