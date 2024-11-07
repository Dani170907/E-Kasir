/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.30 : Database - kasir
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kasir` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `kasir`;

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `customerId` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `customerName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_general_ci NOT NULL,
  `phoneNumber` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `customers` */

insert  into `customers`(`customerId`,`customerName`,`gender`,`phoneNumber`,`address`,`createdAt`) values 
('PLG001','Dimas','Male','089886785234234','Sawajoho','2024-10-17 04:56:46'),
('PLG002','Andini','Female','088866567','Simbang Kulon','2024-10-17 04:58:50'),
('PLG003','Ujang','Male','0887546432234','Kradenan','2024-10-17 05:08:59'),
('PLG004','irfan','Male','0836478234','batang','2024-10-17 05:20:06'),
('PLG005','Sidqi','Male','08862514534534','Soko Duwet','2024-11-05 04:46:16'),
('PLG006','Reza','Male','087654568772','Comal','2024-11-07 16:00:34'),
('PLG007','Andin','Female','08875564312','Simbang Kulon','2024-11-07 16:50:15'),
('PLG008','Dimas','Male','088832156741','Buaran','2024-11-08 04:37:27'),
('PLG009','Dani','Male','088293634298','Kradenan','2024-11-08 05:01:27');

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `orderId` int NOT NULL AUTO_INCREMENT,
  `productId` int DEFAULT NULL,
  `customerId` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` int NOT NULL,
  `userId` int DEFAULT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_general_ci NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orders` */

insert  into `orders`(`orderId`,`productId`,`customerId`,`quantity`,`userId`,`status`,`orderDate`) values 
(1,12,'PLG003',2,1,'2','2024-10-17 05:08:59'),
(2,1,'PLG004',3,1,'2','2024-10-17 05:20:06'),
(3,5,'PLG005',2,1,'2','2024-11-05 04:46:16'),
(4,1,'PLG006',1,1,'2','2024-11-07 16:00:34'),
(5,15,'PLG007',3,1,'2','2024-11-07 16:50:15'),
(6,2,'PLG008',2,1,'2','2024-11-08 04:37:27'),
(7,11,'PLG009',2,1,'2','2024-11-08 05:01:27');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `productId` int NOT NULL AUTO_INCREMENT,
  `productName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` enum('jaket','hoodie','celana','tas') COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `imageUrl` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `products` */

insert  into `products`(`productId`,`productName`,`category`,`price`,`stock`,`imageUrl`,`description`,`createdAt`,`updatedAt`) values 
(1,'Celana Jeans Skinny','celana',150000.00,10,'images/celana1.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(2,'Tas Ransel Outdoor','tas',200000.00,5,'images/tas1.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(3,'Hoodie Polos Hitam','hoodie',180000.00,8,'images/hoodie1.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(4,'Jaket Bomber Army','jaket',250000.00,6,'images/jaket1.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(5,'Celana Chino Slimfit','celana',140000.00,12,'images/celana2.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(6,'Tas Selempang Kecil','tas',120000.00,15,'images/tas2.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(7,'Hoodie Zipper Abu','hoodie',170000.00,9,'images/hoodie2.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(8,'Jaket Kulit Coklat','jaket',300000.00,4,'images/jaket2.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(9,'Celana Pendek Kasual','celana',90000.00,20,'images/celana3.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(10,'Tas Tote Bag Polos','tas',80000.00,25,'images/tas3.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(11,'Hoodie Oversize Biru','hoodie',190000.00,7,'images/hoodie3.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(12,'Jaket Parasut Waterproof','jaket',220000.00,11,'images/jaket3.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(13,'Celana Jogger Sport','celana',110000.00,18,'images/celana4.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(14,'Tas Backpack Vintage','tas',230000.00,6,'images/tas4.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(15,'Hoodie Crop Top Putih','hoodie',160000.00,10,'images/hoodie4.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(16,'Jaket Denim Classic','jaket',270000.00,3,'images/jaket4.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(17,'Celana Cargo Outdoor','celana',160000.00,12,'images/celana5.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(18,'Tas Punggung Kulit','tas',240000.00,5,'images/tas5.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(19,'Hoodie Graphic Print','hoodie',185000.00,9,'images/hoodie5.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10'),
(20,'Jaket Windbreaker','jaket',210000.00,14,'images/jaket5.jpg',NULL,'2024-10-17 05:02:10','2024-10-17 05:02:10');

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `transactionId` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `orderId` int DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `cashback` decimal(10,2) NOT NULL,
  `transactionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionId`),
  KEY `orderId` (`orderId`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transactions` */

insert  into `transactions`(`transactionId`,`orderId`,`total`,`payment`,`cashback`,`transactionDate`) values 
('TRX001',3,280000.00,300000.00,20000.00,'2024-11-07 21:40:30'),
('TRX002',2,450000.00,500000.00,50000.00,'2024-11-08 04:40:46'),
('TRX003',4,150000.00,200000.00,50000.00,'2024-11-08 04:42:40'),
('TRX004',1,440000.00,500000.00,60000.00,'2024-11-08 04:47:44'),
('TRX005',6,400000.00,450000.00,50000.00,'2024-11-08 04:48:43'),
('TRX006',7,380000.00,435267.00,55267.00,'2024-11-08 05:01:48');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('admin','pemilik','kasir') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`userId`,`userName`,`password`,`level`) values 
(1,'asep','202cb962ac59075b964b07152d234b70','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
