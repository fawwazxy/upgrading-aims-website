/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 5.7.17-log : Database - indeepre_office
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`indeepre_office` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `indeepre_office`;

/*Table structure for table `agromart_admin` */

DROP TABLE IF EXISTS `agromart_admin`;

CREATE TABLE `agromart_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencies` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nokp` varchar(255) DEFAULT NULL,
  `notel` varchar(255) DEFAULT NULL,
  `umur` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `cawangan` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `daerah` varchar(255) DEFAULT NULL,
  `negeri` varchar(255) DEFAULT NULL,
  `jantina` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Aktif; 0:Tidak Aktif',
  `photo` mediumblob,
  `photo_filename` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `agromart_agencies` */

DROP TABLE IF EXISTS `agromart_agencies`;

CREATE TABLE `agromart_agencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `no_pendaftaran` varchar(255) DEFAULT NULL,
  `notel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `daerah` varchar(255) DEFAULT NULL,
  `negeri` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Aktif; 0:Tidak Aktif',
  `logo` mediumblob,
  `logo_filename` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `agromart_cawangan` */

DROP TABLE IF EXISTS `agromart_cawangan`;

CREATE TABLE `agromart_cawangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencies` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `notel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` text,
  `status` tinyint(4) DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `agromart_sales_transaction` */

DROP TABLE IF EXISTS `agromart_sales_transaction`;

CREATE TABLE `agromart_sales_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencies` int(11) DEFAULT NULL,
  `no_resit` varchar(255) DEFAULT NULL,
  `nama_pembeli` varchar(255) DEFAULT NULL,
  `notel_pembeli` varchar(255) DEFAULT NULL,
  `jumlah_jualan` decimal(10,2) DEFAULT '0.00',
  `jumlah_bayaran` decimal(10,2) DEFAULT '0.00',
  `jumlah_diskaun` decimal(10,2) DEFAULT '0.00',
  `jumlah_baki` decimal(10,2) DEFAULT '0.00',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `agromart_sales_transaction_item` */

DROP TABLE IF EXISTS `agromart_sales_transaction_item`;

CREATE TABLE `agromart_sales_transaction_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sales_transaction` int(11) DEFAULT NULL,
  `nokp_seller` varchar(255) DEFAULT NULL,
  `barcode_item` varchar(255) DEFAULT NULL,
  `kod_item` varchar(255) DEFAULT NULL,
  `nama_item` varchar(255) DEFAULT NULL,
  `harga_item` decimal(10,2) DEFAULT '0.00',
  `jumlah_harga_item` decimal(10,2) DEFAULT '0.00',
  `kuantiti_item` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `agromart_seller` */

DROP TABLE IF EXISTS `agromart_seller`;

CREATE TABLE `agromart_seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencies` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nokp` varchar(255) DEFAULT NULL,
  `notel` varchar(255) DEFAULT NULL,
  `umur` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `daerah` varchar(255) DEFAULT NULL,
  `negeri` varchar(255) DEFAULT NULL,
  `jantina` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Aktif; 0:Tidak Aktif',
  `photo` mediumblob,
  `photo_filename` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `agromart_stocks` */

DROP TABLE IF EXISTS `agromart_stocks`;

CREATE TABLE `agromart_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_stock_type` int(11) DEFAULT NULL,
  `id_agencies` int(11) DEFAULT NULL,
  `nokp_seller` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tarikh` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `barcode` varchar(255) DEFAULT NULL,
  `harga_jualan_semasa` decimal(10,2) DEFAULT '0.00',
  `kuantiti` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `agromart_stocks_shortage` */

DROP TABLE IF EXISTS `agromart_stocks_shortage`;

CREATE TABLE `agromart_stocks_shortage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_stock` int(11) DEFAULT NULL,
  `kuantiti` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `agromart_stocks_surplus` */

DROP TABLE IF EXISTS `agromart_stocks_surplus`;

CREATE TABLE `agromart_stocks_surplus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_stock` int(11) DEFAULT NULL,
  `kuantiti` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `agromart_terminal` */

DROP TABLE IF EXISTS `agromart_terminal`;

CREATE TABLE `agromart_terminal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencies` int(11) DEFAULT NULL,
  `start_time` time DEFAULT '00:00:00',
  `end_time` time DEFAULT '24:00:00',
  `status` char(1) DEFAULT '1',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `lkp_stock_type` */

DROP TABLE IF EXISTS `lkp_stock_type`;

CREATE TABLE `lkp_stock_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agencies` int(11) DEFAULT NULL,
  `kod` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `meter` varchar(255) DEFAULT NULL,
  `harga_belian_semasa` decimal(10,2) DEFAULT '0.00',
  `harga_jualan_semasa` decimal(10,2) DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Aktif,0:Tidak Aktif',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
