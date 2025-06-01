/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - projectdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`projectdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `projectdb`;

/*Table structure for table `class_subjects` */

DROP TABLE IF EXISTS `class_subjects`;

CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `class_subjects` */

insert  into `class_subjects`(`id`,`class_id`,`subject_id`,`enable`) values 
(12,4,3,1),
(13,4,4,1),
(14,4,5,1),
(15,4,6,1),
(16,4,7,1),
(17,4,8,1),
(61,3,2,1),
(62,3,3,1),
(63,3,4,1),
(64,12,1,1),
(65,3,6,1),
(66,7,1,1),
(67,7,2,1),
(68,7,6,1),
(69,7,8,1),
(70,7,9,1),
(71,8,3,1),
(72,11,7,1),
(73,8,1,1),
(74,3,0,1),
(76,4,2,1),
(77,9,4,1),
(79,3,1,1),
(80,0,0,1);

/*Table structure for table `classes` */

DROP TABLE IF EXISTS `classes`;

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(100) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `classes` */

insert  into `classes`(`class_id`,`class_name`,`enable`) values 
(1,'KG',1),
(2,'Class 1',1),
(3,'Class iii',1),
(5,'Class iv',1),
(6,'Class v',1),
(8,'Class vii',1),
(9,'Class viii',1),
(10,'Class x',1),
(12,'Class xii',1),
(14,'test112',1);

/*Table structure for table `day_time` */

DROP TABLE IF EXISTS `day_time`;

CREATE TABLE `day_time` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(100) DEFAULT NULL,
  `time_start` varchar(100) DEFAULT NULL,
  `time_end` varchar(100) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`day_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `day_time` */

insert  into `day_time`(`day_id`,`day`,`time_start`,`time_end`,`enable`) values 
(1,'Monday','8:30am','9:30am',1),
(2,'Monday','9:30am','10:30am',1),
(3,'Monday','10:30am','11:30am',1),
(4,'Monday','11:30am','12:30pm',1),
(5,'Monday','12:30pm','1:30pm',1),
(6,'Monday','1:30pm','2:30pm',1);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_name` varchar(256) DEFAULT NULL,
  `menus_links` varchar(256) DEFAULT NULL,
  `sort_order` int(10) DEFAULT 1,
  `is_display` smallint(1) DEFAULT 1,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`menus_name`,`menus_links`,`sort_order`,`is_display`,`enable`) values 
(1,'Users','users.php',1,1,1),
(2,'Roles','add_role.php',2,1,1),
(3,'Role Permission','role_pre.php',2,0,1),
(4,'Students','students.php',3,1,1),
(11,'Classes','class.php',6,1,1),
(12,'Subjects','subjects.php',5,1,1),
(13,'Teachers','teachers.php',4,1,1),
(15,'Teacher Subjects','teacher_sub.php',8,1,1),
(16,'Class Subjects','class_subjects.php',7,1,1),
(17,'Time Table','time_table.php',9,1,1);

/*Table structure for table `role_per` */

DROP TABLE IF EXISTS `role_per`;

CREATE TABLE `role_per` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `role_per` */

insert  into `role_per`(`id`,`menus_id`,`role_id`,`enable`) values 
(8,2,5,1),
(9,3,5,1),
(37,1,3,1),
(38,2,3,1),
(39,4,3,1),
(43,1,1,1),
(44,2,1,1),
(45,4,1,1),
(50,2,7,1),
(51,4,7,1),
(64,4,8,1),
(65,17,8,1),
(68,4,11,1),
(69,13,11,1),
(80,1,2,1),
(81,2,2,1),
(82,3,2,1),
(83,4,2,1),
(84,11,2,1),
(85,12,2,1),
(86,13,2,1),
(87,15,2,1),
(88,16,2,1),
(89,17,2,1),
(90,1,4,1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`role_name`,`enable`) values 
(2,'Admin',1),
(4,'User',1),
(7,'Sub admin',1),
(8,'Teacher',1),
(9,'Student',1),
(10,'Parent',1),
(11,'HR',1);

/*Table structure for table `student_info` */

DROP TABLE IF EXISTS `student_info`;

CREATE TABLE `student_info` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(256) DEFAULT NULL,
  `user_name` varchar(256) DEFAULT NULL,
  `pasword` varchar(256) DEFAULT NULL,
  `role_id` varchar(11) DEFAULT NULL,
  `profile_pic` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `user_type` varchar(256) DEFAULT 'user',
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `student_info` */

insert  into `student_info`(`student_id`,`full_name`,`user_name`,`pasword`,`role_id`,`profile_pic`,`email`,`user_type`,`enable`) values 
(1,'Shoaib ALi','shoaib','shoaib','9',NULL,'shoaib@gmail.com','user',1),
(3,'kareem ali','kareem ','kareem ','9',NULL,'kareem@gmail.com','user',1);

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `subjects` */

insert  into `subjects`(`subject_id`,`subject_name`,`enable`) values 
(1,'English',1),
(2,'Mathamatices',1),
(3,'Urdu',1),
(4,'Chemistry',1),
(5,'General Science',1),
(7,'Sindhi',1);

/*Table structure for table `teacher_subjects` */

DROP TABLE IF EXISTS `teacher_subjects`;

CREATE TABLE `teacher_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) DEFAULT NULL,
  `class_subject_id` int(11) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `teacher_subjects` */

insert  into `teacher_subjects`(`id`,`teacher_id`,`class_subject_id`,`enable`) values 
(2,1,62,1),
(3,3,61,1),
(4,3,62,1),
(5,3,63,1),
(6,3,71,1),
(7,1,61,1),
(8,1,77,1);

/*Table structure for table `teachers_info` */

DROP TABLE IF EXISTS `teachers_info`;

CREATE TABLE `teachers_info` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(256) DEFAULT NULL,
  `user_name` varchar(256) DEFAULT NULL,
  `pasword` varchar(256) DEFAULT NULL,
  `role_id` varchar(11) DEFAULT NULL,
  `profile_pic` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `user_type` varchar(256) DEFAULT 'user',
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `teachers_info` */

insert  into `teachers_info`(`teacher_id`,`full_name`,`user_name`,`pasword`,`role_id`,`profile_pic`,`email`,`user_type`,`enable`) values 
(1,'Tanveer Kalhoro','jogi','11111','8',NULL,'tanveerkalhoro09@gmail.com','user',1),
(2,'Aftab Ali Tunio','aftab','aftab','8',NULL,'aftab@gmail.com','user',1),
(3,'fatah','fatah','fatah','8',NULL,'fatah@gamil.com','user',1),
(4,'fatah','fatah','fatah','8',NULL,'fatah1@gamil.com','user',1);

/*Table structure for table `time_table` */

DROP TABLE IF EXISTS `time_table`;

CREATE TABLE `time_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_subject_id` int(11) DEFAULT NULL,
  `day_id` int(11) DEFAULT NULL,
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `time_table` */

insert  into `time_table`(`id`,`class_subject_id`,`day_id`,`enable`) values 
(9,21,1,1),
(10,22,6,1),
(11,22,5,1),
(12,1,1,1),
(13,1,3,1),
(14,2,4,1),
(15,2,1,1),
(16,2,2,1),
(17,7,1,1),
(18,0,0,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(256) DEFAULT NULL,
  `user_name` varchar(256) DEFAULT NULL,
  `pasword` varchar(256) DEFAULT NULL,
  `role_id` varchar(11) DEFAULT NULL,
  `profile_pic` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `user_type` varchar(256) DEFAULT 'user',
  `enable` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`full_name`,`user_name`,`pasword`,`role_id`,`profile_pic`,`email`,`user_type`,`enable`) values 
(2,'kareem ali','kareem','kareem','12',NULL,'kareemkalhoro09@gmail.com','user',1),
(6,'','rehman','rehman','4',NULL,'Rehman09@gmail.com','user',1),
(9,'Tanveer Kalhoro','tanveer','tanveer','2',NULL,'kalhoro09@gmail.com','SuperAdmin',1),
(11,'fatah ahmed','fatah ','fatah ','3',NULL,'fatah@gamil.com','user',1),
(12,'jawad','jawad','jawad','3',NULL,'jawad123@gmail.com','user',1),
(13,'A','a','a','7',NULL,'a09@gmail.com','user',1),
(14,'Shoaib ALi','shoaib','shoaib','4',NULL,'shoaibkalhoro09@gmail.com','user',1),
(15,'Tanveer Kalhoro','jogi','11111','8',NULL,'tanveerkalhoro09@gmail.com','user',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
