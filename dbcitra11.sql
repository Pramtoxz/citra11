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
  PRIMARY KEY (`idcheckin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `checkin` */

insert  into `checkin`(`idcheckin`,`idbooking`,`sisabayar`,`deposit`,`created_at`,`updated_at`,`deleted_at`) values 
('CK-20250726-0001','RS-20250726-0001',640000,200000,'2025-07-26 09:23:19','2025-07-26 09:23:19',NULL);

/*Table structure for table `checkout` */

DROP TABLE IF EXISTS `checkout`;

CREATE TABLE `checkout` (
  `idcheckout` char(30) NOT NULL,
  `idcheckin` char(30) DEFAULT NULL,
  `tglcheckout` date DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `keterangan` text,
  `grandtotal` double DEFAULT NULL,
  PRIMARY KEY (`idcheckout`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `checkout` */

/*Table structure for table `kamar` */

DROP TABLE IF EXISTS `kamar`;

CREATE TABLE `kamar` (
  `id_kamar` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `status_kamar` varchar(30) DEFAULT NULL,
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `dp` double DEFAULT NULL,
  PRIMARY KEY (`id_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kamar` */

insert  into `kamar`(`id_kamar`,`nama`,`harga`,`status_kamar`,`cover`,`deskripsi`,`dp`) values 
('KMR001','Deluxe 1',650000,'tersedia','cover-20250726-KMR001.670.jpg','OKE BRO',100000);

/*Table structure for table `otp_codes` */

DROP TABLE IF EXISTS `otp_codes`;

CREATE TABLE `otp_codes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `otp_code` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('register','forgot_password') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `otp_code` (`otp_code`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `otp_codes` */

insert  into `otp_codes`(`id`,`email`,`otp_code`,`type`,`is_used`,`expires_at`,`created_at`,`updated_at`) values 
(5,'pramuditometra@gmail.com','411073','register',1,'2025-06-14 22:24:12','2025-06-14 22:14:12','2025-06-14 22:14:50'),
(7,'bossrentalpadang@gmail.com','377888','register',1,'2025-06-14 22:30:04','2025-06-14 22:20:04','2025-06-14 22:20:22'),
(9,'srimulyarni2@gmail.com','866665','register',1,'2025-06-14 22:54:28','2025-06-14 22:44:28','2025-06-14 22:45:35'),
(10,'rindianir573@gmail.com','216643','register',1,'2025-06-28 10:39:30','2025-06-28 10:29:30','2025-06-28 10:30:11'),
(11,'03xa8cfygp@cross.edu.pl','678301','register',1,'2025-07-03 07:31:50','2025-07-03 07:21:50','2025-07-03 07:22:22'),
(12,'putrialifianoerbalqis@gmail.com','531028','register',1,'2025-07-03 14:35:06','2025-07-03 14:25:06','2025-07-03 14:26:15'),
(13,'gamingda273@gmail.com','119943','register',1,'2025-07-16 04:45:40','2025-07-16 04:35:40','2025-07-16 04:36:06'),
(14,'tapekong00@gmail.com','417221','register',1,'2025-07-26 03:18:10','2025-07-26 03:08:10','2025-07-26 03:08:47');

/*Table structure for table `pengeluaran` */

DROP TABLE IF EXISTS `pengeluaran`;

CREATE TABLE `pengeluaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pengeluaran` */

insert  into `pengeluaran`(`id`,`tgl`,`keterangan`,`total`) values 
(1,'2025-07-24','Makan',10000);

/*Table structure for table `reservasi` */

DROP TABLE IF EXISTS `reservasi`;

CREATE TABLE `reservasi` (
  `idbooking` varchar(30) NOT NULL,
  `nik` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `idkamar` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tglcheckin` date NOT NULL,
  `tglcheckout` date NOT NULL,
  `totalbayar` double NOT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `buktibayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `status` enum('diproses','diterima','ditolak','checkin','selesai','cancel','limit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'diproses',
  `batas_waktu` datetime DEFAULT NULL COMMENT 'Batas waktu 15 menit dari created_at untuk upload bukti',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idbooking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `reservasi` */

insert  into `reservasi`(`idbooking`,`nik`,`idkamar`,`tglcheckin`,`tglcheckout`,`totalbayar`,`tipe`,`buktibayar`,`online`,`status`,`batas_waktu`,`created_at`,`updated_at`,`deleted_at`) values 
('RS-20250726-0001','1371020706010099','KMR001','2025-07-26','2025-07-27',100000,'transfer','bukti-RS-20250726-0001-1753503627.jpeg',1,'diterima',NULL,NULL,'2025-07-26 11:43:25',NULL);

/*Table structure for table `tamu` */

DROP TABLE IF EXISTS `tamu`;

CREATE TABLE `tamu` (
  `nik` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tamu` */

insert  into `tamu`(`nik`,`nama`,`alamat`,`nohp`,`jk`,`iduser`) values 
('1371020706010099','Rindiani','Jayanusasdsdsc','08123343444','P',2),
('3456788895','rindi','Padang','083182117492','L',4);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'admin, user, dll',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`status`,`last_login`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin@example.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','admin','active','2025-07-26 08:03:49',NULL,'2025-06-14 21:50:56','2025-06-14 21:50:56',NULL),
(2,'Rindiani','rindianir573@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','user','active','2025-07-26 11:19:38',NULL,'2025-06-28 10:30:11','2025-06-28 10:30:11',NULL),
(25,'sdsds','tapekong00@gmail.com','$2y$10$BJW7CdMTc6gP4SbrsuHCTubcKBSZYrm/NdJa5pagVQlEd6sDJAcNS','user','active','2025-07-26 03:09:02',NULL,'2025-07-26 03:08:47','2025-07-26 03:08:47',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
