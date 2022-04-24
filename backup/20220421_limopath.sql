-- MySQL dump 10.13  Distrib 5.7.37, for Linux (x86_64)
--
-- Host: localhost    Database: limopath
-- ------------------------------------------------------
-- Server version	5.7.37-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customer_address_book`
--

DROP TABLE IF EXISTS `customer_address_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_address_book` (
  `key_customer_address_book` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_customer_passengers` int(10) unsigned NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_customer_address_book`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_customer_passengers` (`key_customer_passengers`),
  FULLTEXT KEY `phpblink_fulltext` (`title`,`category`,`city`,`zip_code`),
  CONSTRAINT `customer_address_book_ibfk_1` FOREIGN KEY (`key_customer_passengers`) REFERENCES `customer_passengers` (`key_customer_passengers`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_address_book`
--

LOCK TABLES `customer_address_book` WRITE;
/*!40000 ALTER TABLE `customer_address_book` DISABLE KEYS */;
INSERT INTO `customer_address_book` VALUES (1,1,'John Doe Office','','123 Almond Street','','Fairfax','VA','221445','','some notes','2021-09-28 01:51:06'),(2,2,'Home','','1234 David Street','','Dale City','Virginia','22192','','d','2021-10-04 19:11:33');
/*!40000 ALTER TABLE `customer_address_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_billing_contacts`
--

DROP TABLE IF EXISTS `customer_billing_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_billing_contacts` (
  `key_customer_billing_contacts` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `card_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `card_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `card_expiration` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `card_security_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name_on_card` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `confirmation_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_customer_billing_contacts`),
  UNIQUE KEY `card_number` (`card_number`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `customer_billing_contacts_fulltext` (`contact_name`,`card_type`,`name_on_card`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_billing_contacts`
--

LOCK TABLES `customer_billing_contacts` WRITE;
/*!40000 ALTER TABLE `customer_billing_contacts` DISABLE KEYS */;
INSERT INTO `customer_billing_contacts` VALUES (1,'Sophia Taylor','American Express','2158-5488-8548-5487','','','Sophia Taylor','','','','Maryland','','','','','on','2021-10-10 01:52:45'),(2,'David Taylor','American Express','1548-554-78548-54','','','David Taylor','','','','','','','','','on','2021-10-10 02:27:45'),(3,'Allen Donald Amex','American Express','44587865488648654','2023/04','123','Allen Donald','3387 Millon Way Rd.','','Fairfax','Virginia','21457','allendonald@gmail.com','571-547-4785','Some notes Some notes Some notes Some notes Some notes Some notes Some notes Some notes Some notes Some notes Some notes Some notes Some notes.','on','2021-10-18 02:17:34'),(4,'Julia Roberts Amex','American Express','85486545158545','','','Julia Roberts','','','','','','','','','on','2021-10-18 02:34:59');
/*!40000 ALTER TABLE `customer_billing_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_companies`
--

DROP TABLE IF EXISTS `customer_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_companies` (
  `key_customer_companies` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_customer_companies`),
  UNIQUE KEY `company_name` (`company_name`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `customer_companies_fulltext` (`company_name`,`address1`,`state`,`zip_code`,`country`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_companies`
--

LOCK TABLES `customer_companies` WRITE;
/*!40000 ALTER TABLE `customer_companies` DISABLE KEYS */;
INSERT INTO `customer_companies` VALUES (1,'Lucky Company','','','','','','','','on','2021-09-28 11:12:10'),(2,'Northern Cricket Club','','','','','Virginia','','United States of America','on','2021-10-18 02:16:31');
/*!40000 ALTER TABLE `customer_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_contacts`
--

DROP TABLE IF EXISTS `customer_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_contacts` (
  `key_customer_contacts` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `key_customer_companies` int(10) unsigned NOT NULL DEFAULT '0',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone_extension` int(10) NOT NULL DEFAULT '0',
  `mobile_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_customer_contacts`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_customer_companies` (`key_customer_companies`),
  FULLTEXT KEY `customer_contacts_fulltext` (`company_name`,`first_name`,`last_name`,`address1`,`address2`,`city`,`state`,`zip_code`,`country`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_contacts`
--

LOCK TABLES `customer_contacts` WRITE;
/*!40000 ALTER TABLE `customer_contacts` DISABLE KEYS */;
INSERT INTO `customer_contacts` VALUES (1,'Northern Cricket Club',2,'','Janet','Doe','','','','','','United States of America','',0,'','','on','2021-09-28 11:17:00'),(3,'Lucky Company',1,'','Julia','Doe','','','','','','United States of America','',0,'','','on','2021-10-10 01:38:48'),(4,'Lucky Company',1,'','Tiffany','Joseph','1234 General Washington Dr.','Building # 4','Alexandria','Virginia','21578','United States of America','703-154-7848',7,'703-123-4589','tiffanyjoseph@outlook.com','on','2021-10-16 12:28:22');
/*!40000 ALTER TABLE `customer_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_invoices`
--

DROP TABLE IF EXISTS `customer_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_invoices` (
  `key_customer_invoices` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_customer_passengers` int(10) unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `amount_paid` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `due_date` date DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`key_customer_invoices`),
  KEY `key_customer_passengers` (`key_customer_passengers`),
  KEY `end_date` (`end_date`),
  KEY `due_date` (`due_date`),
  KEY `payment_method` (`payment_method`)
) ENGINE=InnoDB AUTO_INCREMENT=1005 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_invoices`
--

LOCK TABLES `customer_invoices` WRITE;
/*!40000 ALTER TABLE `customer_invoices` DISABLE KEYS */;
INSERT INTO `customer_invoices` VALUES (1,5,'2021-10-27','2021-10-27',115.32,0,'','2021-10-25','2021-10-22',''),(1001,3,'2021-10-27','2021-10-27',120.97,121,'','2021-10-28','2021-10-22',''),(1002,3,'2021-10-14','2021-10-14',476.04,0,'','2021-10-30','2021-10-22',''),(1003,5,'2021-10-18','2021-10-18',120.32,0,'','2021-10-30','2021-10-27',''),(1004,1,'2021-10-02','2021-10-02',315,315,'','2021-11-25','2021-11-11','');
/*!40000 ALTER TABLE `customer_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_passengers`
--

DROP TABLE IF EXISTS `customer_passengers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_passengers` (
  `key_customer_passengers` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_customer_companies` int(10) unsigned NOT NULL DEFAULT '0',
  `key_customer_rate_packages` int(10) unsigned NOT NULL DEFAULT '0',
  `key_customer_billing_contacts` int(10) unsigned NOT NULL DEFAULT '0',
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone_extension` int(10) NOT NULL DEFAULT '0',
  `mobile_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `package_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `billing_contact_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_method` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `confirm_to_passenger` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `confirm_to_contact` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `confirm_to_billing_contact` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `trip_ticket_notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ad_source` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_customer_passengers`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_customer_companies` (`key_customer_companies`),
  KEY `key_customer_rate_packages` (`key_customer_rate_packages`),
  KEY `key_customer_billing_contacts` (`key_customer_billing_contacts`),
  FULLTEXT KEY `customer_passengers_fulltext` (`first_name`,`last_name`,`address1`,`city`,`state`,`country`,`zip_code`,`email`,`ad_source`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_passengers`
--

LOCK TABLES `customer_passengers` WRITE;
/*!40000 ALTER TABLE `customer_passengers` DISABLE KEYS */;
INSERT INTO `customer_passengers` VALUES (1,1,1,0,'John','Doe','','','','','United States of America','','',0,'','johndoe@yahoo.com','','','Lucky Company','Regular','','','on','on','on','','','','on','2021-10-03 11:56:40'),(2,1,1,3,'David','Joseph','','','','','United States of America','','',0,'','davidjospeh@live.com','','','Lucky Company','Regular','Allen Donald Amex','','on','on','on','general notes','trip notes','','on','2021-10-04 19:10:37'),(3,1,2,1,'Mark','Taylor','a','','','','United States of America','','',0,'703-456-1597','marktaylor@outlook.com','','','Lucky Company','Value Ride','Sophia Taylor','Cash','on','on','on','','','','on','2021-10-10 01:52:57'),(4,2,1,3,'Allen','Donald','8345 Lake River Dr.','','Arlington','Virginia','United States of America','224788','703-487-4515',0,'701-457-4154','allendonald@gmail.com','https://allendonaldonline.info','','Northern Cricket Club','Regular','Allen Donald Amex','Cash','on','on','on','Some profile notes Some profile notes Some profile notes Some profile notes Some profile notes Some profile notes Some profile notes Some profile notes','Trip ticket notes Trip ticket notes Trip ticket notes Trip ticket notes Trip ticket notes Trip ticket notes Trip ticket notes Trip ticket notes','','on','2021-10-18 02:17:55'),(5,2,1,4,'Julia','Roberts','','','','','United States of America','','',0,'571-123-4785','juliaroberts@msn.com','','','Northern Cricket Club','Regular','Julia Roberts Amex','','on','on','on','a','','','on','2021-10-18 02:35:10');
/*!40000 ALTER TABLE `customer_passengers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_rate_packages`
--

DROP TABLE IF EXISTS `customer_rate_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_rate_packages` (
  `key_customer_rate_packages` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `package_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gratuity_percent` float NOT NULL DEFAULT '0',
  `gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `admin_fee_percent` float NOT NULL DEFAULT '0',
  `discount_percent` float NOT NULL DEFAULT '0',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_customer_rate_packages`),
  UNIQUE KEY `package_name` (`package_name`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `customer_rate_packages_fulltext` (`package_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_rate_packages`
--

LOCK TABLES `customer_rate_packages` WRITE;
/*!40000 ALTER TABLE `customer_rate_packages` DISABLE KEYS */;
INSERT INTO `customer_rate_packages` VALUES (1,'Regular',20,1.2,1.1,0.1,'2021-10-06 14:41:44'),(2,'Value Ride',0,0,0,4.9,'2021-10-10 12:19:13');
/*!40000 ALTER TABLE `customer_rate_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driver_payroll`
--

DROP TABLE IF EXISTS `driver_payroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `driver_payroll` (
  `key_driver_payroll` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_drivers` int(10) unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `amount_paid` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `due_date` date DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`key_driver_payroll`),
  KEY `end_date` (`end_date`),
  KEY `due_date` (`due_date`),
  KEY `payment_method` (`payment_method`),
  KEY `key_drivers` (`key_drivers`),
  FULLTEXT KEY `driver_payroll_fulltext` (`payment_method`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_payroll`
--

LOCK TABLES `driver_payroll` WRITE;
/*!40000 ALTER TABLE `driver_payroll` DISABLE KEYS */;
INSERT INTO `driver_payroll` VALUES (1,1,'2021-10-01','2021-10-31',179,179,'Cash','2021-12-10','2021-10-14',''),(2,2,'2021-10-01','2021-10-31',351.97,300,'','2021-12-10','2021-10-14',''),(3,1,'2021-10-27','2021-10-27',54,54,'','2021-11-06','2021-10-14','');
/*!40000 ALTER TABLE `driver_payroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drivers` (
  `key_drivers` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_vehicles` int(10) unsigned NOT NULL DEFAULT '0',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contract_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone_extension` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobile_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_of_birth` date DEFAULT NULL,
  `license_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `license_expiry_date` date DEFAULT NULL,
  `social_security_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hire_date` date DEFAULT NULL,
  `fleet_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_method` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `base_amount_percent` float NOT NULL DEFAULT '0',
  `pay_gratuity_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gratuity_percent` float NOT NULL DEFAULT '0',
  `pay_commission_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `commission_percent` float NOT NULL DEFAULT '0',
  `pay_extra_stops_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `extra_stops_percent` float NOT NULL DEFAULT '0',
  `pay_offtime_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `offtime_percent` float NOT NULL DEFAULT '0',
  `pay_tolls_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tolls_percent` float NOT NULL DEFAULT '0',
  `pay_parking_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parking_percent` float NOT NULL DEFAULT '0',
  `pay_gas_surcharge_checkbox` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `pay_extra_charges_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `extra_charges_percent` float NOT NULL DEFAULT '0',
  `notes` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_drivers`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_vehicles` (`key_vehicles`),
  FULLTEXT KEY `drivers_fulltext` (`first_name`,`last_name`,`contract_type`,`city`,`state`,`zip_code`,`fleet_number`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drivers`
--

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
INSERT INTO `drivers` VALUES (1,1,'','saadiqbal','1234567kdie','Saad','Iqbaal','','','','','Maryland','','','','','saadiqbal3457@outlook.com','1977-06-28','','2023-03-16','','2008-06-25','Sedan (B145)','',40,'on',100,'on',4,'on',100,'on',50,'on',100,'on',100,'on',100,'on',100,'','on','2021-09-28 02:31:24'),(2,1,'','falaksher','12345567','Falak','Sher','','1234 Oakwood Dr.','','Annandale','Virginia','22003','703-544-5488','25','703-124-1548','falaksher123@gmail.com','1980-09-07','sd98039sd983','2023-05-08','118-34-8275','2010-09-10','Sedan (B145)','Cash',50,'on',100,'on',1.5,'on',95,'on',95,'on',95,'on',95,'on',95,'on',95,'Some notes about the driver','on','2021-10-06 16:05:01');
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `landmarks`
--

DROP TABLE IF EXISTS `landmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `landmarks` (
  `key_landmarks` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_landmarks`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `landmarks_fulltext` (`title`,`category`,`city`,`zip_code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landmarks`
--

LOCK TABLES `landmarks` WRITE;
/*!40000 ALTER TABLE `landmarks` DISABLE KEYS */;
INSERT INTO `landmarks` VALUES (1,'Shenandoah National Park - Virginia','','','3655 US Highway 211','','East Luray','Virginia','United States of America','22835','','on','2021-10-04 13:09:39'),(2,'Colonial Williamsburg','','','101 Visitor Center Dr','','Williamsburg','Virginia','United States of America','23185','','on','2021-10-04 13:57:48'),(3,'Virginia Beach','','','','','Virginia Beach','Virginia','United States of America','23450','','on','2021-10-04 14:00:15'),(4,'Arlington National Cemetery','','','1 Memorial Ave.','','Arlington','Virginia','United States of America','22211','','on','2021-10-04 14:00:30'),(5,'Mount Vernon','','','3200 Mount Vernon Memorial Hwy','','Mount Vernon','Virginia','United States of America','22121','','on','2021-10-04 14:00:46'),(6,'Monticello and Charlottesville','','',' 931 Thomas Jefferson Pkwy','','Charlottesville','Virginia','United States of America','22902','','on','2021-10-04 14:01:04'),(7,'Luray Caverns','','','101 Cave Hill Rd','','Luray','Virginia','United States of America','22835','','on','2021-10-04 14:01:25'),(8,'Virginia Museum of Fine Arts','','','200 N Arthur Ashe Blvd','','Richmond','Virginia','United States of America','23220','','on','2021-10-04 14:01:42'),(9,'Busch Gardens','','','1 Busch Gardens Blvd','','Williamsburg','Virginia','United States of America','23185','','on','2021-10-04 14:01:59'),(10,'Jamestown and Yorktown','','','2110 Jamestown Rd','','Williamsburg','Virginia','United States of America','23185','','on','2021-10-04 14:02:17'),(11,'Steven F. Udvar-Hazy Center','','','14390 Air and Space Museum Pkwy','','Chantilly','Virginia','United States of America','20151','','on','2021-10-04 14:02:36'),(12,'Virginia State Capitol','','','1000 Bank St','','Richmond','Virginia','United States of America','23218','','on','2021-10-04 14:02:55'),(13,'Natural Bridge','','','15 Appledore Lane','','Natural Bridge','Virginia','United States of America','24578','','on','2021-10-04 14:03:11'),(14,'Chincoteague Islands','','','5048 Main St','','Chincoteague','Virginia','United States of America','23336','','on','2021-10-04 14:03:27'),(15,'Virginia Aquarium & Marine Science Center','','','717 General Booth Blvd','','Virginia Beach','Virginia','United States of America','23451','a','on','2021-10-04 14:03:45'),(16,'Manassas National Battlefield','','','6511 Sudley Rd','','Manassas','Virginia','United States of America','20109','','on','2021-10-04 14:03:59');
/*!40000 ALTER TABLE `landmarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `key_logs` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `action_performed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_logs`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `log_datetime` (`log_datetime`),
  FULLTEXT KEY `logs_fulltext` (`log_type`,`action_performed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates_zones`
--

DROP TABLE IF EXISTS `rates_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates_zones` (
  `key_rates_zones` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `from_state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `from_zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `to_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `to_state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `to_zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate` float NOT NULL DEFAULT '0',
  `tolls` float NOT NULL DEFAULT '0',
  `miles` float NOT NULL DEFAULT '0',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_rates_zones`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `rates_zones_fulltext` (`from_city`,`to_city`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates_zones`
--

LOCK TABLES `rates_zones` WRITE;
/*!40000 ALTER TABLE `rates_zones` DISABLE KEYS */;
INSERT INTO `rates_zones` VALUES (1,'Arlington','Virginia','21458','Baltimore','Maryland','20458',90,3,0,'on','2021-09-28 10:41:20');
/*!40000 ALTER TABLE `rates_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_ad_source_values`
--

DROP TABLE IF EXISTS `settings_ad_source_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_ad_source_values` (
  `key_settings_ad_source_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_source` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_ad_source_values`),
  UNIQUE KEY `ad_source` (`ad_source`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_ad_source_values_fulltext` (`ad_source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_ad_source_values`
--

LOCK TABLES `settings_ad_source_values` WRITE;
/*!40000 ALTER TABLE `settings_ad_source_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings_ad_source_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_airline_values`
--

DROP TABLE IF EXISTS `settings_airline_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_airline_values` (
  `key_settings_airline_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `airline` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_airline_values`),
  UNIQUE KEY `airline` (`airline`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_airline_values_fulltext` (`airline`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_airline_values`
--

LOCK TABLES `settings_airline_values` WRITE;
/*!40000 ALTER TABLE `settings_airline_values` DISABLE KEYS */;
INSERT INTO `settings_airline_values` VALUES (1,'United Airlines','2021-10-23 13:44:49'),(3,'Delta Airlines','2021-10-23 13:45:16');
/*!40000 ALTER TABLE `settings_airline_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_company`
--

DROP TABLE IF EXISTS `settings_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_company` (
  `key_settings_company` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `company_label` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slogan` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone1` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone2` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `social_media_url1` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `social_media_url2` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `social_media_url3` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `social_media_url4` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `social_media_url5` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_company`),
  KEY `entry_date_time` (`entry_date_time`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_company`
--

LOCK TABLES `settings_company` WRITE;
/*!40000 ALTER TABLE `settings_company` DISABLE KEYS */;
INSERT INTO `settings_company` VALUES (1,'Business Company','BUSICOMP','','','','','','','','','','','','','','','','','','','','','','2021-10-01 16:19:05');
/*!40000 ALTER TABLE `settings_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_country_values`
--

DROP TABLE IF EXISTS `settings_country_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_country_values` (
  `key_settings_country_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_country_values`),
  UNIQUE KEY `country` (`country`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_country_values_fulltext` (`country`,`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_country_values`
--

LOCK TABLES `settings_country_values` WRITE;
/*!40000 ALTER TABLE `settings_country_values` DISABLE KEYS */;
INSERT INTO `settings_country_values` VALUES (1,'United States of America','USA','2021-10-04 13:52:08');
/*!40000 ALTER TABLE `settings_country_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_dispatch_area_values`
--

DROP TABLE IF EXISTS `settings_dispatch_area_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_dispatch_area_values` (
  `key_settings_dispatch_area_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dispatch_area` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_dispatch_area_values`),
  UNIQUE KEY `dispatch_area` (`dispatch_area`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_dispatch_area_values_fulltext` (`dispatch_area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_dispatch_area_values`
--

LOCK TABLES `settings_dispatch_area_values` WRITE;
/*!40000 ALTER TABLE `settings_dispatch_area_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings_dispatch_area_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_email_configuration`
--

DROP TABLE IF EXISTS `settings_email_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_email_configuration` (
  `key_settings_email_configuration` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sender_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `reply_to_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `copy_to_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `smtp_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_email_configuration`),
  KEY `entry_date_time` (`entry_date_time`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_email_configuration`
--

LOCK TABLES `settings_email_configuration` WRITE;
/*!40000 ALTER TABLE `settings_email_configuration` DISABLE KEYS */;
INSERT INTO `settings_email_configuration` VALUES (1,'sender@busicomp.com','123456567','replyto@busicomp.com','copyto@busicomp.com','smtp.busicomp.com','2021-10-01 16:20:40');
/*!40000 ALTER TABLE `settings_email_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_extra_charges_values`
--

DROP TABLE IF EXISTS `settings_extra_charges_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_extra_charges_values` (
  `key_settings_extra_charges_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_extra_charges_values`),
  UNIQUE KEY `category` (`category`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_extra_charges_values_fulltext` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_extra_charges_values`
--

LOCK TABLES `settings_extra_charges_values` WRITE;
/*!40000 ALTER TABLE `settings_extra_charges_values` DISABLE KEYS */;
INSERT INTO `settings_extra_charges_values` VALUES (1,'Coffee','2021-10-10 17:00:31'),(2,'Baby seat','2021-10-10 17:00:44'),(3,'Bottled water','2021-10-10 17:00:54');
/*!40000 ALTER TABLE `settings_extra_charges_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_insurance_company_values`
--

DROP TABLE IF EXISTS `settings_insurance_company_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_insurance_company_values` (
  `key_settings_insurance_company_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `insurance_company` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_insurance_company_values`),
  UNIQUE KEY `insurance_company` (`insurance_company`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_insurance_company_values_fulltext` (`insurance_company`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_insurance_company_values`
--

LOCK TABLES `settings_insurance_company_values` WRITE;
/*!40000 ALTER TABLE `settings_insurance_company_values` DISABLE KEYS */;
INSERT INTO `settings_insurance_company_values` VALUES (1,'Nationwide Insurance Company','2021-10-18 13:12:05');
/*!40000 ALTER TABLE `settings_insurance_company_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_landmark_values`
--

DROP TABLE IF EXISTS `settings_landmark_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_landmark_values` (
  `key_settings_landmark_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_landmark_values`),
  UNIQUE KEY `category` (`category`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_landmark_values_fulltext` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_landmark_values`
--

LOCK TABLES `settings_landmark_values` WRITE;
/*!40000 ALTER TABLE `settings_landmark_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings_landmark_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_offtime_type_values`
--

DROP TABLE IF EXISTS `settings_offtime_type_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_offtime_type_values` (
  `key_settings_offtime_type_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offtime_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_offtime_type_values`),
  UNIQUE KEY `offtime_type` (`offtime_type`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_offtime_type_values_fulltext` (`offtime_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_offtime_type_values`
--

LOCK TABLES `settings_offtime_type_values` WRITE;
/*!40000 ALTER TABLE `settings_offtime_type_values` DISABLE KEYS */;
INSERT INTO `settings_offtime_type_values` VALUES (1,'Early','2021-10-24 09:44:43'),(2,'Late','2021-10-24 09:44:50');
/*!40000 ALTER TABLE `settings_offtime_type_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_payment_card_type_values`
--

DROP TABLE IF EXISTS `settings_payment_card_type_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_payment_card_type_values` (
  `key_settings_payment_card_type_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_card_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_payment_card_type_values`),
  UNIQUE KEY `payment_card_type` (`payment_card_type`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_payment_card_type_values_fulltext` (`payment_card_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_payment_card_type_values`
--

LOCK TABLES `settings_payment_card_type_values` WRITE;
/*!40000 ALTER TABLE `settings_payment_card_type_values` DISABLE KEYS */;
INSERT INTO `settings_payment_card_type_values` VALUES (1,'American Express','2021-10-10 01:50:59'),(2,'Visa','2021-10-24 09:47:22');
/*!40000 ALTER TABLE `settings_payment_card_type_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_payment_method_values`
--

DROP TABLE IF EXISTS `settings_payment_method_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_payment_method_values` (
  `key_settings_payment_method_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_payment_method_values`),
  UNIQUE KEY `payment_method` (`payment_method`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_payment_method_values_fulltext` (`payment_method`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_payment_method_values`
--

LOCK TABLES `settings_payment_method_values` WRITE;
/*!40000 ALTER TABLE `settings_payment_method_values` DISABLE KEYS */;
INSERT INTO `settings_payment_method_values` VALUES (1,'Cash','2021-10-24 09:49:03'),(2,'Credit Card','2021-10-24 09:49:11');
/*!40000 ALTER TABLE `settings_payment_method_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_state_values`
--

DROP TABLE IF EXISTS `settings_state_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_state_values` (
  `key_settings_state_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_state_values`),
  UNIQUE KEY `state` (`state`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_state_values_fulltext` (`state`,`state_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_state_values`
--

LOCK TABLES `settings_state_values` WRITE;
/*!40000 ALTER TABLE `settings_state_values` DISABLE KEYS */;
INSERT INTO `settings_state_values` VALUES (1,'Virginia','VA','2021-10-01 17:34:57'),(2,'Maryland','MD','2021-10-01 17:35:08');
/*!40000 ALTER TABLE `settings_state_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_toll_type_values`
--

DROP TABLE IF EXISTS `settings_toll_type_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_toll_type_values` (
  `key_settings_toll_type_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `toll_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_toll_type_values`),
  UNIQUE KEY `toll_type` (`toll_type`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_toll_type_values_fulltext` (`toll_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_toll_type_values`
--

LOCK TABLES `settings_toll_type_values` WRITE;
/*!40000 ALTER TABLE `settings_toll_type_values` DISABLE KEYS */;
INSERT INTO `settings_toll_type_values` VALUES (1,'Cash','2021-10-24 10:21:40');
/*!40000 ALTER TABLE `settings_toll_type_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_trip_status_values`
--

DROP TABLE IF EXISTS `settings_trip_status_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_trip_status_values` (
  `key_settings_trip_status_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trip_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `back_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_trip_status_values`),
  UNIQUE KEY `trip_status` (`trip_status`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_trip_status_values_fulltext` (`trip_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_trip_status_values`
--

LOCK TABLES `settings_trip_status_values` WRITE;
/*!40000 ALTER TABLE `settings_trip_status_values` DISABLE KEYS */;
INSERT INTO `settings_trip_status_values` VALUES (1,'Confirmed','#ffffff','#388c21',0,'on','2021-10-01 16:26:13'),(2,'Dispatched','#ffffff','#093d53',0,'on','2021-10-01 16:26:25'),(3,'Quoted','#ffffff','#9e8400',0,'on','2021-10-24 10:24:10');
/*!40000 ALTER TABLE `settings_trip_status_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_trip_type_values`
--

DROP TABLE IF EXISTS `settings_trip_type_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_trip_type_values` (
  `key_settings_trip_type_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trip_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_trip_type_values`),
  UNIQUE KEY `trip_type` (`trip_type`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_trip_type_values_fulltext` (`trip_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_trip_type_values`
--

LOCK TABLES `settings_trip_type_values` WRITE;
/*!40000 ALTER TABLE `settings_trip_type_values` DISABLE KEYS */;
INSERT INTO `settings_trip_type_values` VALUES (1,'Wedding','2021-10-24 10:26:45'),(2,'Tour','2021-10-24 10:27:38');
/*!40000 ALTER TABLE `settings_trip_type_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_trips`
--

DROP TABLE IF EXISTS `settings_trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_trips` (
  `key_settings_trips` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gratuity_percent` float NOT NULL DEFAULT '0',
  `gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `admin_fee_percent` float NOT NULL DEFAULT '0',
  `tax_percent` float NOT NULL DEFAULT '0',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_trips`),
  KEY `entry_date_time` (`entry_date_time`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_trips`
--

LOCK TABLES `settings_trips` WRITE;
/*!40000 ALTER TABLE `settings_trips` DISABLE KEYS */;
INSERT INTO `settings_trips` VALUES (1,20,0.5,0.3,2.5,'2021-10-08 04:18:28');
/*!40000 ALTER TABLE `settings_trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_vehicle_model_values`
--

DROP TABLE IF EXISTS `settings_vehicle_model_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_vehicle_model_values` (
  `key_settings_vehicle_model_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_model` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_vehicle_model_values`),
  UNIQUE KEY `vehicle_model` (`vehicle_model`),
  KEY `entry_date_time` (`entry_date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_vehicle_model_values`
--

LOCK TABLES `settings_vehicle_model_values` WRITE;
/*!40000 ALTER TABLE `settings_vehicle_model_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings_vehicle_model_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_vehicle_type_values`
--

DROP TABLE IF EXISTS `settings_vehicle_type_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_vehicle_type_values` (
  `key_settings_vehicle_type_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_vehicle_type_values`),
  UNIQUE KEY `vehicle_type` (`vehicle_type`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_vehicle_type_values_fulltext` (`vehicle_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_vehicle_type_values`
--

LOCK TABLES `settings_vehicle_type_values` WRITE;
/*!40000 ALTER TABLE `settings_vehicle_type_values` DISABLE KEYS */;
INSERT INTO `settings_vehicle_type_values` VALUES (1,'Sedan','2021-10-07 09:50:29'),(2,'SUV','2021-10-18 18:36:04');
/*!40000 ALTER TABLE `settings_vehicle_type_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_workshop_name_values`
--

DROP TABLE IF EXISTS `settings_workshop_name_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_workshop_name_values` (
  `key_settings_workshop_name_values` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workshop_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_settings_workshop_name_values`),
  UNIQUE KEY `workshop_name` (`workshop_name`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `settings_workshop_name_values_fulltext` (`workshop_name`,`city`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_workshop_name_values`
--

LOCK TABLES `settings_workshop_name_values` WRITE;
/*!40000 ALTER TABLE `settings_workshop_name_values` DISABLE KEYS */;
INSERT INTO `settings_workshop_name_values` VALUES (1,'Vine Street Workshop','','','','','','Alexandria','','','2021-10-24 10:33:22');
/*!40000 ALTER TABLE `settings_workshop_name_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `key_staff` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `work_phone_extension` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobile_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_of_birth` date DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `social_security_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payroll_period` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salary_amount` float NOT NULL DEFAULT '0',
  `annual_paid_days` smallint(6) NOT NULL DEFAULT '0',
  `house_rent_allowance` float NOT NULL DEFAULT '0',
  `conveyance_allowance` float NOT NULL DEFAULT '0',
  `hourly_regular_rate` float NOT NULL DEFAULT '0',
  `hourly_overtime_rate` float NOT NULL DEFAULT '0',
  `hours_per_week` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_staff`),
  KEY `entry_date_time` (`entry_date_time`),
  FULLTEXT KEY `staff_fulltext` (`designation`,`first_name`,`last_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'','mauricio','asdfg','','Mauricio','Trigo','1232 Albany St.','Bulding 2-A','Fairfax','Virginia','22145','703-123-4587','25','571-123-4578','mauriciotrigo@outlook.com','1980-05-12','2001-05-04','234-45-5578','Some notes','Semi-monthly',2500,15,10,5,25,40,'40','on','2021-11-04 15:05:51');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trip_extra_charges`
--

DROP TABLE IF EXISTS `trip_extra_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trip_extra_charges` (
  `key_trip_extra_charges` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_trips` int(10) unsigned NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` float DEFAULT '0',
  `notes` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_trip_extra_charges`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_trips` (`key_trips`),
  FULLTEXT KEY `phpblink_fulltext` (`category`),
  CONSTRAINT `trip_extra_charges_ibfk_1` FOREIGN KEY (`key_trips`) REFERENCES `trips` (`key_trips`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trip_extra_charges`
--

LOCK TABLES `trip_extra_charges` WRITE;
/*!40000 ALTER TABLE `trip_extra_charges` DISABLE KEYS */;
INSERT INTO `trip_extra_charges` VALUES (5,4,'Baby seat',20,'','2021-10-10 18:14:38'),(6,4,'Coffee',0,'','2021-10-10 18:16:20'),(7,3,'Coffee',5.4,'','2021-10-10 18:21:38'),(8,2,'Bottled water',5,'','2021-10-10 18:24:30'),(9,4,'Bottled water',0,'','2021-10-11 02:06:55'),(11,5,'Bottled water',5,'','2021-10-12 16:35:09'),(12,1,'Bottled water',5,'','2021-10-13 16:11:22'),(13,4,'Coffee',0,'','2021-10-16 13:59:58'),(14,1007,'Bottled water',5,'','2021-10-27 10:31:56'),(15,1002,'Bottled water',4.5,'','2021-10-27 17:43:04'),(16,1002,'Coffee',5.25,'','2021-10-27 17:46:13');
/*!40000 ALTER TABLE `trip_extra_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trips` (
  `key_trips` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_customer_invoices` int(10) unsigned NOT NULL DEFAULT '0',
  `key_driver_payroll` int(10) unsigned NOT NULL DEFAULT '0',
  `key_customer_passengers` int(10) unsigned NOT NULL DEFAULT '0',
  `key_customer_contacts` int(10) unsigned NOT NULL DEFAULT '0',
  `key_drivers` int(10) unsigned NOT NULL DEFAULT '0',
  `key_vehicles` int(10) unsigned NOT NULL DEFAULT '0',
  `key_settings_airline_values` int(10) unsigned NOT NULL DEFAULT '0',
  `key_rates_zones` int(10) unsigned NOT NULL DEFAULT '0',
  `reference_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `passenger_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `total_passengers` smallint(6) NOT NULL DEFAULT '0',
  `reserved_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pickup_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dropoff_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trip_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `trip_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `driver_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vehicle` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `airline` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flight_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zone_from` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zone_to` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `routing_from` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `routing_to` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `routing_notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dispatcher_notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rate_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hourly_regular_rate` float NOT NULL DEFAULT '0',
  `regular_hours` smallint(6) NOT NULL DEFAULT '0',
  `regular_minutes` tinyint(4) NOT NULL DEFAULT '0',
  `hourly_regular_amount` float NOT NULL DEFAULT '0',
  `hourly_wait_rate` float NOT NULL DEFAULT '0',
  `wait_hours` smallint(11) NOT NULL DEFAULT '0',
  `wait_minutes` tinyint(11) NOT NULL DEFAULT '0',
  `hourly_wait_amount` float NOT NULL DEFAULT '0',
  `hourly_overtime_rate` float NOT NULL DEFAULT '0',
  `overtime_hours` smallint(6) NOT NULL DEFAULT '0',
  `overtime_minutes` tinyint(4) NOT NULL DEFAULT '0',
  `hourly_overtime_amount` float NOT NULL DEFAULT '0',
  `zone_rate` float NOT NULL DEFAULT '0',
  `base_amount` float NOT NULL DEFAULT '0',
  `offtime_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `offtime_amount` float NOT NULL DEFAULT '0',
  `extra_stops` tinyint(4) NOT NULL DEFAULT '0',
  `extra_stops_amount` float NOT NULL DEFAULT '0',
  `toll_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tolls_amount` float NOT NULL DEFAULT '0',
  `parking_amount` float NOT NULL DEFAULT '0',
  `gratuity_percent` float NOT NULL DEFAULT '0',
  `gratuity_amount` float NOT NULL DEFAULT '0',
  `gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `gas_surcharge_amount` float NOT NULL DEFAULT '0',
  `admin_fee_percent` float NOT NULL DEFAULT '0',
  `admin_fee_amount` float NOT NULL DEFAULT '0',
  `discount_percent` float NOT NULL DEFAULT '0',
  `discount_amount` float NOT NULL DEFAULT '0',
  `tax_percent` float NOT NULL DEFAULT '0',
  `tax_amount` float NOT NULL DEFAULT '0',
  `trip_extra_charges` float NOT NULL DEFAULT '0',
  `flat_amount` float NOT NULL DEFAULT '0',
  `total_trip_amount` float NOT NULL DEFAULT '0',
  `pay_base_amount_percent` float NOT NULL DEFAULT '0',
  `pay_driver_base_amount` float NOT NULL DEFAULT '0',
  `pay_offtime_percent` float NOT NULL DEFAULT '0',
  `pay_offtime_amount` float NOT NULL DEFAULT '0',
  `pay_extra_stops_percent` float DEFAULT '0',
  `pay_extra_stops_amount` float NOT NULL DEFAULT '0',
  `pay_tolls_percent` float NOT NULL DEFAULT '0',
  `pay_tolls_amount` float NOT NULL DEFAULT '0',
  `pay_parking_percent` float NOT NULL DEFAULT '0',
  `pay_parking_amount` float NOT NULL DEFAULT '0',
  `pay_gratuity_percent` float NOT NULL DEFAULT '0',
  `pay_gratuity_amount` float NOT NULL DEFAULT '0',
  `pay_gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `pay_gas_surcharge_amount` float NOT NULL DEFAULT '0',
  `pay_commission_percent` float NOT NULL DEFAULT '0',
  `pay_commission_amount` float NOT NULL DEFAULT '0',
  `pay_flat_amount` float NOT NULL DEFAULT '0',
  `pay_total_driver_amount` float NOT NULL DEFAULT '0',
  `pay_notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `concluded_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `settled_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `invoiced_checkbox` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_trips`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_customer_invoices` (`key_customer_invoices`),
  KEY `key_driver_payroll` (`key_driver_payroll`),
  KEY `key_customer_passengers` (`key_customer_passengers`),
  KEY `key_customer_contacts` (`key_customer_contacts`),
  KEY `key_drivers` (`key_drivers`),
  KEY `key_vehicles` (`key_vehicles`),
  KEY `key_rates_zones` (`key_rates_zones`),
  KEY `pickup_datetime` (`pickup_datetime`),
  KEY `key_settings_airline_values` (`key_settings_airline_values`),
  FULLTEXT KEY `trips_fulltext` (`passenger_name`,`reference_number`,`reserved_by`,`trip_type`,`driver_name`,`vehicle`,`airline`,`flight_number`,`zone_from`,`zone_to`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
INSERT INTO `trips` VALUES (1,0,2,1,0,2,2,0,0,'','John Doe',0,'','2021-10-02 07:55:00','1970-01-01 00:00:00','','Dispatched','Falak Sher','SUV (A1234)','','','','','sdfasdfa\r\nNatural Bridge (15 Appledore Lane, , Natural Bridge, Virginia 24578','sdfasdfa\r\nVirginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','','','Hourly',70,2,35,165,40,1,0,30,90,0,0,0,0,195,'',0,0,0,'',0,0,0,0,5,9.75,0,0,0,0,0,0,5,0,209.75,50,97.5,15,0,14,0,13,0,12,0,100,0,10,0.97,9,17.55,0,116.02,'','on','','','2021-10-03 15:40:47'),(2,1004,1,1,1,2,1,0,1,'','John Doe',3,'Janet Doe','2021-10-02 16:05:00','2021-10-02 16:57:00','Tour','Dispatched','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','dsf2342af','fasd234','','Flek Sher driver','Hourly',55,4,0,220,30,0,30,30,60,1,0,60,0,310,'Early',0,0,0,'Cash',0,0,0,0,0,0,0,0,0,0,0,0,5,0,315,40,124,50,0,100,0,100,0,100,0,100,0,100,0,4,12.4,0,136.4,'','on','on','','2021-10-03 15:41:54'),(3,0,0,1,0,2,1,0,1,'','John Doe',2,'','2021-08-15 00:00:00','1970-01-01 00:00:00','','Confirmed','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','John Doe Office (123 Almond Street, , Fairfax, VA 221445','IAD','','Saad Iqbaal driver','Hourly',55,3,3,220,30,2,2,90,60,4,5,300,90.2,610,'',0,0,0,'',4,1,0,0,0,0,0,0,0,0,0,0,5.4,0,620.4,50,305,0,0,0,0,0,0,0,0,100,0,0,0,0,0,0,305,'','on','on','','2021-10-06 16:12:15'),(4,1002,2,3,0,2,1,0,1,'E039458','Mark Taylor',0,'','2021-10-14 10:08:00','1970-01-01 00:00:00','','Confirmed','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','Virginia Beach (, , Virginia Beach, Virginia 23450','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','','','Hourly',56,4,0,224,31,0,23,31,60,0,54,60,90,315,'',10,0,20,'',3,0,31,97.65,0.5,1.57,0.3,0.94,0,0,2.5,7.88,20,150,476.04,50,157.5,100,10,100,20,100,3,100,0,100,97.65,100,1.57,0,0,0,289.72,'hello','on','on','','2021-10-10 13:05:26'),(5,0,2,3,0,2,1,0,1,'','Mark Taylor',0,'','2021-10-13 13:37:00','1970-01-01 00:00:00','Tour','Confirmed','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','Virginia Beach (, , Virginia Beach, Virginia 23450','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','','','Hourly',70,1,0,70,30,0,50,30,90,0,30,90,90,190,'Early',0,0,0,'Cash',3,0,20,38,0.5,0.95,0.3,0.57,0,0,2.5,4.75,5,0,242.27,50,102.5,92,0,91,0,93,2.79,94,0,100,41,95.5,0.97,1.5,3.08,0,150.34,'','','on','','2021-10-12 16:34:52'),(6,0,1,1,0,1,1,0,1,'','John Doe',0,'','2021-10-13 00:51:00','1970-01-01 00:00:00','','Confirmed','Saad Iqbaal','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','Virginia Aquarium & Marine Science Center (717 General Booth Blvd, , Virginia Beach, Virginia 23451','Virginia Museum of Fine Arts (200 N Arthur Ashe Blvd, , Richmond, Virginia 23220','','','Zone',55,0,0,0,30,0,0,0,60,0,0,0,90,90,'',0,0,0,'',3,0,0,0,0,0,0,0,5,0,2.5,0,0,0,93,40,36,50,0,100,0,100,3,100,0,100,0,100,0,4,3.6,0,42.6,'','','','','2021-10-12 16:40:20'),(1001,0,2,2,0,2,1,0,1,'','David Joseph',0,'','2021-10-15 11:25:00','1970-01-01 00:00:00','Tour','Confirmed','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','Shenandoah National Park - Virginia (3655 US Highway 211, , East Luray, Virginia 22835','Virginia Beach (, , Virginia Beach, Virginia 23450','','','Hourly',55,3,15,220,30,1,0,30,60,2,25,180,90,430,'Early',0,0,0,'Cash',3,0,20,86,1.2,5.16,1.1,4.73,0,0,2.5,10.75,0,0,539.64,50.1,45.09,0,0,0,0,0,0,0,0,100,18,0,0,0,0,0,63.09,'','','','','2021-10-14 10:08:12'),(1002,1001,3,3,0,1,2,0,1,'','Mark Taylor',0,'','2021-10-27 22:00:00','1970-01-01 00:00:00','Tour','Confirmed','Saad Iqbaal','SUV (A1234)','','','Arlington, Virginia','Baltimore, Maryland','Shenandoah National Park - Virginia (3655 US Highway 211, , East Luray, Virginia 22835','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','Some routing notes','','Zone',70,4,0,280,40,0,0,0,90,1,30,180,108,108,'Early',0,1,20,'Cash',10,3.5,20,21.6,0.5,0.54,0.3,0.32,8,8.64,2.5,2.7,9.75,170,167.77,40,36,0,0,0,0,0,0,0,0,100,18,0,0,0,0,0,54,'','on','on','','2021-10-14 14:26:37'),(1003,0,0,2,4,2,1,0,1,'','David Joseph',0,'Tiffany Joseph','2021-10-20 14:40:00','2021-10-16 01:00:00','Tour','Confirmed','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','Virginia Beach (, , Virginia Beach, Virginia 23450','Virginia Museum of Fine Arts (200 N Arthur Ashe Blvd, , Richmond, Virginia 23220','','','Hourly',55,4,0,220,30,0,0,0,60,0,0,0,90,220,'Early',0,0,0,'Cash',3,0,20,44,1.2,2.64,1.1,2.42,0,0,2.5,5.5,0,0,277.56,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','on','','','2021-10-16 12:34:52'),(1004,0,0,4,0,1,1,0,1,'AB39458','Allen Donald',1,'','2021-10-20 17:20:00','2021-10-18 01:00:00','','Confirmed','Saad Iqbaal','Sedan (B145)','United Airlines','1750','Arlington, Virginia','Baltimore, Maryland','Shenandoah National Park - Virginia (3655 US Highway 211, , East Luray, Virginia 22835','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','','','Zone',55,0,0,0,30,0,0,0,60,0,0,0,90,90,'',0,0,0,'',3,0,0,0,0,0,0,0,0,0,0,0,0,0,93,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','2021-10-18 02:19:53'),(1005,0,0,5,0,2,1,0,1,'','Julia Roberts',1,'','2021-10-20 12:45:00','2021-10-18 01:00:00','','Dispatched','Falak Sher','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','Virginia Aquarium & Marine Science Center (717 General Booth Blvd, , Virginia Beach, Virginia 23451','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','s','','Flat',55,0,0,0,30,0,0,0,60,0,0,0,90,0,'Early',0,0,0,'Cash',3,0,0,0,0,0,0,0,0,0,0,0,0,100,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','2021-10-18 02:42:48'),(1006,1,0,5,0,2,1,1,1,'','Julia Roberts',1,'','2021-10-20 12:45:00','2021-10-18 01:00:00','Tour','Dispatched','Falak Sher','B145','United Airlines','','Arlington, Virginia','Baltimore, Maryland','Virginia Beach (, , Virginia Beach, Virginia 23450','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','','','Zone',70,0,0,0,40,0,0,0,90,0,0,0,90,90,'Early',0,0,0,'Cash',3,0,20,18,1.2,1.08,1.1,0.99,0.1,0.09,2.5,2.25,0,0,115.23,50,45,0,0,0,0,0,0,0,0,100,18,0,0,0,0,0,63,'','on','on','','2021-10-18 18:41:47'),(1007,1003,0,5,3,2,1,3,1,'','Julia Roberts',1,'Julia Doe','2021-10-18 09:00:00','2021-10-23 01:00:00','Tour','Confirmed','Falak Sher','Sedan (B145)','Delta Airlines','3855','Arlington, Virginia','Baltimore, Maryland','4321 Some Road, Woodbridge, VA\r\nVirginia Aquarium & Marine Science Center (717 General Booth Blvd, , Virginia Beach, Virginia 23451','4321 Some Road, Woodbridge, VA\r\nSteven F. Udvar-Hazy Center (14390 Air and Space Museum Pkwy, , Chantilly, Virginia 20151','','','Zone',55,0,0,0,30,0,0,0,60,0,0,0,90,90,'Early',0,0,0,'Cash',3,0,20,18,1.2,1.08,1.1,0.99,0,0,2.5,2.25,5,0,120.32,50,45,0,0,0,0,0,0,0,0,100,18,0,0,0,0,0,63,'','on','on','','2021-10-23 13:58:21'),(1008,0,0,5,3,2,2,3,1,'','Julia Roberts',1,'Julia Doe','2021-10-18 09:00:00','2021-10-23 01:00:00','Tour','Confirmed','Falak Sher','SUV (A1234)','Delta Airlines','3855','Arlington, Virginia','Baltimore, Maryland','4321 Some Road, Woodbridge, VA','1234 Some Street, Dale City, VA','','','Zone',70,0,0,0,40,0,0,0,90,0,0,0,108,108,'Early',0,0,0,'Cash',3,0,20,21.6,1.2,1.3,1.1,1.19,0,0,2.5,2.7,0,0,137.78,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','2021-10-23 17:28:15'),(1009,0,0,4,0,1,2,0,1,'AB39457','Allen Donald',1,'','2021-10-29 17:20:00','2021-10-18 01:00:00','Tour','Quoted','Saad Iqbaal','SUV (A1234)','United Airlines','1750','Arlington, Virginia','Baltimore, Maryland','Shenandoah National Park - Virginia (3655 US Highway 211, , East Luray, Virginia 22835','Virginia State Capitol (1000 Bank St, , Richmond, Virginia 23218','','','Zone',70,3,0,210,40,2,0,80,90,1,0,90,90,90,'Early',0,0,0,'Cash',3,0,0,0,0,0,0,0,0,0,0,0,0,0,93,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','2021-10-23 17:37:10'),(1010,0,0,2,4,1,1,0,1,'','David Joseph',1,'Tiffany Joseph','2021-10-26 12:00:00','2021-10-25 01:00:00','Tour','Confirmed','Saad Iqbaal','Sedan (B145)','','','Arlington, Virginia','Baltimore, Maryland','John Doe Office (123 Almond Street, , Fairfax, VA 221445','Home (1234 David Street, , Dale City, Virginia 22192','trip notes','','Hourly',45,3,0,135,0,0,0,0,0,0,0,0,90,135,'Early',0,0,0,'Cash',3,0,20,27,1.2,1.62,1.1,1.49,0.1,0.14,2.5,3.38,0,0,171.35,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','2021-10-25 13:49:12');
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles` (
  `key_vehicles` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_settings_insurance_company_values` int(10) unsigned NOT NULL DEFAULT '0',
  `fleet_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vehicle_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vin_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `year_made` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `model` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `max_seats` int(10) NOT NULL DEFAULT '0',
  `color` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `insurance_company` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `insurance_expiry_date` date DEFAULT NULL,
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zone_rate_percent` float NOT NULL DEFAULT '0',
  `hourly_regular_rate` float NOT NULL DEFAULT '0',
  `hourly_wait_rate` float NOT NULL DEFAULT '0',
  `hourly_overtime_rate` float NOT NULL DEFAULT '0',
  `notes` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_vehicles`),
  UNIQUE KEY `fleet_number` (`fleet_number`),
  UNIQUE KEY `vin_number` (`vin_number`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_insurance_company_values` (`key_settings_insurance_company_values`),
  FULLTEXT KEY `vehicles_fulltext` (`fleet_number`,`vehicle_type`,`tag`,`vin_number`,`year_made`,`model`,`color`,`notes`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,1,'B145','Sedan','NW-1234','92384902890809423','2020','',3,'','Nationwide Insurance Company','1970-01-01','',100,55,30,60,'','on','2021-10-07 09:54:22'),(2,1,'A1234','SUV','','','','',0,'','Nationwide Insurance Company','2022-06-16','',120,70,40,90,'','on','2021-10-18 18:37:05');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles_maintenance`
--

DROP TABLE IF EXISTS `vehicles_maintenance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles_maintenance` (
  `key_vehicles_maintenance` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_vehicles` int(10) unsigned NOT NULL DEFAULT '0',
  `repair_date` date DEFAULT NULL,
  `repair_description` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `workshop_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `labor_cost` float NOT NULL DEFAULT '0',
  `parts_cost` float NOT NULL DEFAULT '0',
  `warranty_description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `warranty_expiration` date DEFAULT NULL,
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_vehicles_maintenance`),
  KEY `entry_date_time` (`entry_date_time`),
  KEY `key_vehicles` (`key_vehicles`),
  KEY `repair_date` (`repair_date`),
  FULLTEXT KEY `vehicles_maintenance_fulltext` (`repair_description`,`workshop_name`,`warranty_description`),
  CONSTRAINT `vehicles_maintenance_ibfk_1` FOREIGN KEY (`key_vehicles`) REFERENCES `vehicles` (`key_vehicles`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles_maintenance`
--

LOCK TABLES `vehicles_maintenance` WRITE;
/*!40000 ALTER TABLE `vehicles_maintenance` DISABLE KEYS */;
INSERT INTO `vehicles_maintenance` VALUES (1,1,'2021-09-21','','Lucky Auto Repair',58,180,'yes','2021-11-24','2021-09-27 17:07:24');
/*!40000 ALTER TABLE `vehicles_maintenance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'limopath'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-21  4:44:24
