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

/*Table structure for table `booking` */

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `idbooking` varchar(30) NOT NULL,
  `id_pasien` varchar(30) NOT NULL,
  `idjadwal` varchar(30) NOT NULL,
  `idjenis` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status` enum('diproses','diterima','ditolak','diperiksa','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'diproses',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `bayar` double DEFAULT NULL,
  `catatan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idbooking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `booking` */

insert  into `booking`(`idbooking`,`id_pasien`,`idjadwal`,`idjenis`,`tanggal`,`waktu_mulai`,`waktu_selesai`,`status`,`bukti_bayar`,`online`,`bayar`,`catatan`,`created_at`,`updated_at`,`deleted_at`) values 
('BK0001','PS0002','JD0003','JP0001','2025-07-24','09:00:00','09:30:00','diperiksa',NULL,0,NULL,'sakit gigi sebelah','2025-07-22 21:51:21','2025-07-22 22:06:32',NULL);

/*Table structure for table `kamar` */

DROP TABLE IF EXISTS `kamar`;

CREATE TABLE `kamar` (
  `id_kamar` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `status_kamar` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `kamar` */

insert  into `kamar`(`id_kamar`,`nama`,`harga`,`status_kamar`) values 
('KM0001','VVIP',800000,'tersedia');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `otp_codes` */

insert  into `otp_codes`(`id`,`email`,`otp_code`,`type`,`is_used`,`expires_at`,`created_at`,`updated_at`) values 
(5,'pramuditometra@gmail.com','411073','register',1,'2025-06-14 22:24:12','2025-06-14 22:14:12','2025-06-14 22:14:50'),
(7,'bossrentalpadang@gmail.com','377888','register',1,'2025-06-14 22:30:04','2025-06-14 22:20:04','2025-06-14 22:20:22'),
(9,'srimulyarni2@gmail.com','866665','register',1,'2025-06-14 22:54:28','2025-06-14 22:44:28','2025-06-14 22:45:35'),
(10,'rindianir573@gmail.com','216643','register',1,'2025-06-28 10:39:30','2025-06-28 10:29:30','2025-06-28 10:30:11'),
(11,'03xa8cfygp@cross.edu.pl','678301','register',1,'2025-07-03 07:31:50','2025-07-03 07:21:50','2025-07-03 07:22:22'),
(12,'putrialifianoerbalqis@gmail.com','531028','register',1,'2025-07-03 14:35:06','2025-07-03 14:25:06','2025-07-03 14:26:15'),
(13,'gamingda273@gmail.com','119943','register',1,'2025-07-16 04:45:40','2025-07-16 04:35:40','2025-07-16 04:36:06');

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

/*Table structure for table `tamu` */

DROP TABLE IF EXISTS `tamu`;

CREATE TABLE `tamu` (
  `nik` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tamu` */

insert  into `tamu`(`nik`,`nama`,`alamat`,`nohp`,`jk`,`iduser`,`created_at`,`updated_at`) values 
('PS0001','adit','Padang','083182117492','L',23,'2025-07-24 09:05:23','2025-07-24 09:56:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`password`,`role`,`status`,`last_login`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin@example.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','admin','active','2025-07-24 15:40:55',NULL,'2025-06-14 21:50:56','2025-06-14 21:50:56',NULL),
(3,'pramudito','pramuditometra2@gmail.com','$2y$10$/sKJ3nocDTaEBZwfqWvNj.H08jfcrWSolaA7F6buM7Tq2hYdwg.cK','user','active','2025-06-14 22:14:59',NULL,'2025-06-14 22:14:50','2025-06-14 22:14:50',NULL),
(4,'boss','bossrentalpadang@gmail.com','$2y$10$x1Sb65DdkNNlpU02EiOHcuP.YW1BbF29e4HB8LD14jMqbnV8k4vpG','user','active',NULL,NULL,'2025-06-14 22:20:22','2025-06-14 22:20:22',NULL),
(5,'cimul','srimulyarni2@gmail.com','$2y$10$qLdPOp12x6mohcK9q3FG1.5l/pymdxPRhOVTSuf7PWKDHjuiEZ6Fm','user','active','2025-06-14 22:46:26',NULL,'2025-06-14 22:45:35','2025-06-14 22:45:35',NULL),
(7,'pramtoxz','pramtoxz@gmail.com','$2y$10$/mOhlx0mFM/sLkcdDI7ijOdu48p9dg.j3FZLqtnqZtJawqB24w1le','dokter','active',NULL,NULL,'2025-06-23 19:32:30','2025-06-23 19:32:30',NULL),
(8,'prarram','pra@gmail.com','$2y$10$hI1mC1S1wh2sz1NqPDgDl.I.ZM9sjbmqm4aiFI6lzzB7XgOvZgnhe','pasien','active','2025-07-22 23:27:08',NULL,'2025-06-23 19:36:13','2025-06-23 19:36:13',NULL),
(9,'Rindiani','rindianir573@gmail.com','$2y$10$iF4y9bw3chbQ//818ZYDkuX4JsjHLCqdgP39YZPFRR.oFueUc7vNq','user','active','2025-06-28 10:42:11',NULL,'2025-06-28 10:30:11','2025-06-28 10:30:11',NULL),
(10,'akademis','03xa8cfygp@cross.edu.pl','$2y$10$XDoOZvMEUQ424rV4VXBkhOlbc52IVwTwTJpqzSp5ItkOmk/hmE9ZC','user','active','2025-07-03 07:22:37',NULL,'2025-07-03 07:22:22','2025-07-03 07:22:22',NULL),
(11,'balqisa','putrialifianoerbalqis@gmail.com','$2y$10$LDX08rQsEptfP1g/fp5kGuHBL70c99FOjCJeD0d6RvRm3sxQwR9hW','user','active','2025-07-03 14:27:34',NULL,'2025-07-03 14:26:15','2025-07-03 14:26:15',NULL),
(13,'gaming','gamingda273@gmail.com','$2y$10$lFUjQkkArXn3..WQrXadD.APWNfBnNVN1cWpI/42B1.LktGT55ra.','user','active','2025-07-16 04:36:18',NULL,'2025-07-16 04:36:06','2025-07-16 04:36:06',NULL),
(16,'akademis7','password@gmail.com','$2y$10$Tl4glHJOhYfkWhx6TcA5b.7W/kP2awhhA3CG2VEXlWNnMJ7C6Rq9m','user','active',NULL,NULL,'2025-07-16 14:46:45','2025-07-16 14:46:45',NULL),
(17,'agus123','agus@gmail.com','$2y$10$ZQOTNS/mMwx9Eb9V/Ngir.FxIlwW9AO3x.gPdJi3u.qbgOSLgz5mO','user','active',NULL,NULL,'2025-07-22 02:05:44','2025-07-22 02:05:44',NULL),
(20,'aditt','adit@gmail.com','$2y$10$EIDvfHeRxcuOAVusR4QWj.9VBP262mz7oxvST44EO3bAhfUMloaEC','user','active',NULL,NULL,'2025-07-24 09:45:08','2025-07-24 09:45:08',NULL),
(21,'afiqqq','afiq@gmail.com','$2y$10$QbjwYhj1HEAMd2TEjG4nXuMh6B3aWOuQJCAp1kEeBQLXY99gI4c06','user','active',NULL,NULL,'2025-07-24 09:48:14','2025-07-24 09:48:14',NULL),
(22,'aaaaaaaa','aaa@gmail.com','$2y$10$zqnhdzKBTAc23jb9PR4OjuwfPQeL4krJVDZnW84.ImLoJT3jX4b1m','user','active',NULL,NULL,'2025-07-24 09:52:48','2025-07-24 09:52:48',NULL),
(23,'adittya','adittya@gmail.com','$2y$10$FMBcZ1NJrT0/CVfbs.PLgeCdXBKM0aiKSlpd2L7QKNXx.nMpUjmuG','user','active',NULL,NULL,'2025-07-24 09:56:36','2025-07-24 09:56:36',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
