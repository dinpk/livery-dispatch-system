-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2022 at 06:46 PM
-- Server version: 5.7.38-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `limopath`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_address_book`
--

CREATE TABLE `customer_address_book` (
  `key_customer_address_book` int(10) UNSIGNED NOT NULL,
  `key_customer_passengers` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_billing_contacts`
--

CREATE TABLE `customer_billing_contacts` (
  `key_customer_billing_contacts` int(10) UNSIGNED NOT NULL,
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_companies`
--

CREATE TABLE `customer_companies` (
  `key_customer_companies` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `image_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_contacts`
--

CREATE TABLE `customer_contacts` (
  `key_customer_contacts` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `key_customer_companies` int(10) UNSIGNED NOT NULL DEFAULT '0',
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_invoices`
--

CREATE TABLE `customer_invoices` (
  `key_customer_invoices` int(10) UNSIGNED NOT NULL,
  `key_customer_passengers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `amount_paid` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `due_date` date DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_passengers`
--

CREATE TABLE `customer_passengers` (
  `key_customer_passengers` int(10) UNSIGNED NOT NULL,
  `key_customer_companies` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_customer_rate_packages` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_customer_billing_contacts` int(10) UNSIGNED NOT NULL DEFAULT '0',
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_rate_packages`
--

CREATE TABLE `customer_rate_packages` (
  `key_customer_rate_packages` int(10) UNSIGNED NOT NULL,
  `package_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gratuity_percent` float NOT NULL DEFAULT '0',
  `gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `admin_fee_percent` float NOT NULL DEFAULT '0',
  `discount_percent` float NOT NULL DEFAULT '0',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `key_drivers` int(10) UNSIGNED NOT NULL,
  `key_vehicles` int(10) UNSIGNED NOT NULL DEFAULT '0',
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_payroll`
--

CREATE TABLE `driver_payroll` (
  `key_driver_payroll` int(10) UNSIGNED NOT NULL,
  `key_drivers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `amount_paid` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `due_date` date DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `notes` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landmarks`
--

CREATE TABLE `landmarks` (
  `key_landmarks` int(10) UNSIGNED NOT NULL,
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `key_logs` int(10) UNSIGNED NOT NULL,
  `log_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `action_performed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rates_zones`
--

CREATE TABLE `rates_zones` (
  `key_rates_zones` int(10) UNSIGNED NOT NULL,
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_ad_source_values`
--

CREATE TABLE `settings_ad_source_values` (
  `key_settings_ad_source_values` int(10) UNSIGNED NOT NULL,
  `ad_source` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_airline_values`
--

CREATE TABLE `settings_airline_values` (
  `key_settings_airline_values` int(10) UNSIGNED NOT NULL,
  `airline` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_company`
--

CREATE TABLE `settings_company` (
  `key_settings_company` int(10) UNSIGNED NOT NULL,
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_country_values`
--

CREATE TABLE `settings_country_values` (
  `key_settings_country_values` int(10) UNSIGNED NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_dispatch_area_values`
--

CREATE TABLE `settings_dispatch_area_values` (
  `key_settings_dispatch_area_values` int(10) UNSIGNED NOT NULL,
  `dispatch_area` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_email_configuration`
--

CREATE TABLE `settings_email_configuration` (
  `key_settings_email_configuration` int(10) UNSIGNED NOT NULL,
  `sender_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sender_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `reply_to_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `copy_to_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `smtp_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_extra_charges_values`
--

CREATE TABLE `settings_extra_charges_values` (
  `key_settings_extra_charges_values` int(10) UNSIGNED NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_insurance_company_values`
--

CREATE TABLE `settings_insurance_company_values` (
  `key_settings_insurance_company_values` int(10) UNSIGNED NOT NULL,
  `insurance_company` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_landmark_values`
--

CREATE TABLE `settings_landmark_values` (
  `key_settings_landmark_values` int(10) UNSIGNED NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_offtime_type_values`
--

CREATE TABLE `settings_offtime_type_values` (
  `key_settings_offtime_type_values` int(10) UNSIGNED NOT NULL,
  `offtime_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_payment_card_type_values`
--

CREATE TABLE `settings_payment_card_type_values` (
  `key_settings_payment_card_type_values` int(10) UNSIGNED NOT NULL,
  `payment_card_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_payment_method_values`
--

CREATE TABLE `settings_payment_method_values` (
  `key_settings_payment_method_values` int(10) UNSIGNED NOT NULL,
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_state_values`
--

CREATE TABLE `settings_state_values` (
  `key_settings_state_values` int(10) UNSIGNED NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_toll_type_values`
--

CREATE TABLE `settings_toll_type_values` (
  `key_settings_toll_type_values` int(10) UNSIGNED NOT NULL,
  `toll_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_trips`
--

CREATE TABLE `settings_trips` (
  `key_settings_trips` int(10) UNSIGNED NOT NULL,
  `gratuity_percent` float NOT NULL DEFAULT '0',
  `gas_surcharge_percent` float NOT NULL DEFAULT '0',
  `admin_fee_percent` float NOT NULL DEFAULT '0',
  `tax_percent` float NOT NULL DEFAULT '0',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_trip_status_values`
--

CREATE TABLE `settings_trip_status_values` (
  `key_settings_trip_status_values` int(10) UNSIGNED NOT NULL,
  `trip_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `back_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `active_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_trip_type_values`
--

CREATE TABLE `settings_trip_type_values` (
  `key_settings_trip_type_values` int(10) UNSIGNED NOT NULL,
  `trip_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_vehicle_model_values`
--

CREATE TABLE `settings_vehicle_model_values` (
  `key_settings_vehicle_model_values` int(10) UNSIGNED NOT NULL,
  `vehicle_model` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_vehicle_type_values`
--

CREATE TABLE `settings_vehicle_type_values` (
  `key_settings_vehicle_type_values` int(10) UNSIGNED NOT NULL,
  `vehicle_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_workshop_name_values`
--

CREATE TABLE `settings_workshop_name_values` (
  `key_settings_workshop_name_values` int(10) UNSIGNED NOT NULL,
  `workshop_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `key_staff` int(10) UNSIGNED NOT NULL,
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `key_trips` int(10) UNSIGNED NOT NULL,
  `key_customer_invoices` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_driver_payroll` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_customer_passengers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_customer_contacts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_drivers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_vehicles` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_settings_airline_values` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `key_rates_zones` int(10) UNSIGNED NOT NULL DEFAULT '0',
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
  `entry_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip_extra_charges`
--

CREATE TABLE `trip_extra_charges` (
  `key_trip_extra_charges` int(10) UNSIGNED NOT NULL,
  `key_trips` int(10) UNSIGNED NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` float DEFAULT '0',
  `notes` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `key_vehicles` int(10) UNSIGNED NOT NULL,
  `key_settings_insurance_company_values` int(10) UNSIGNED NOT NULL DEFAULT '0',
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
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_maintenance`
--

CREATE TABLE `vehicles_maintenance` (
  `key_vehicles_maintenance` int(10) UNSIGNED NOT NULL,
  `key_vehicles` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `repair_date` date DEFAULT NULL,
  `repair_description` varchar(3000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `workshop_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `labor_cost` float NOT NULL DEFAULT '0',
  `parts_cost` float NOT NULL DEFAULT '0',
  `warranty_description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `warranty_expiration` date DEFAULT NULL,
  `entry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_address_book`
--
ALTER TABLE `customer_address_book`
  ADD PRIMARY KEY (`key_customer_address_book`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_customer_passengers` (`key_customer_passengers`);
ALTER TABLE `customer_address_book` ADD FULLTEXT KEY `phpblink_fulltext` (`title`,`category`,`city`,`zip_code`);

--
-- Indexes for table `customer_billing_contacts`
--
ALTER TABLE `customer_billing_contacts`
  ADD PRIMARY KEY (`key_customer_billing_contacts`),
  ADD UNIQUE KEY `card_number` (`card_number`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `customer_billing_contacts` ADD FULLTEXT KEY `customer_billing_contacts_fulltext` (`contact_name`,`card_type`,`name_on_card`);

--
-- Indexes for table `customer_companies`
--
ALTER TABLE `customer_companies`
  ADD PRIMARY KEY (`key_customer_companies`),
  ADD UNIQUE KEY `company_name` (`company_name`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `customer_companies` ADD FULLTEXT KEY `customer_companies_fulltext` (`company_name`,`address1`,`state`,`zip_code`,`country`);

--
-- Indexes for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  ADD PRIMARY KEY (`key_customer_contacts`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_customer_companies` (`key_customer_companies`);
ALTER TABLE `customer_contacts` ADD FULLTEXT KEY `customer_contacts_fulltext` (`company_name`,`first_name`,`last_name`,`address1`,`address2`,`city`,`state`,`zip_code`,`country`,`email`);

--
-- Indexes for table `customer_invoices`
--
ALTER TABLE `customer_invoices`
  ADD PRIMARY KEY (`key_customer_invoices`),
  ADD KEY `key_customer_passengers` (`key_customer_passengers`),
  ADD KEY `end_date` (`end_date`),
  ADD KEY `due_date` (`due_date`),
  ADD KEY `payment_method` (`payment_method`);

--
-- Indexes for table `customer_passengers`
--
ALTER TABLE `customer_passengers`
  ADD PRIMARY KEY (`key_customer_passengers`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_customer_companies` (`key_customer_companies`),
  ADD KEY `key_customer_rate_packages` (`key_customer_rate_packages`),
  ADD KEY `key_customer_billing_contacts` (`key_customer_billing_contacts`);
ALTER TABLE `customer_passengers` ADD FULLTEXT KEY `customer_passengers_fulltext` (`first_name`,`last_name`,`address1`,`city`,`state`,`country`,`zip_code`,`email`,`ad_source`);

--
-- Indexes for table `customer_rate_packages`
--
ALTER TABLE `customer_rate_packages`
  ADD PRIMARY KEY (`key_customer_rate_packages`),
  ADD UNIQUE KEY `package_name` (`package_name`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `customer_rate_packages` ADD FULLTEXT KEY `customer_rate_packages_fulltext` (`package_name`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`key_drivers`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_vehicles` (`key_vehicles`);
ALTER TABLE `drivers` ADD FULLTEXT KEY `drivers_fulltext` (`first_name`,`last_name`,`contract_type`,`city`,`state`,`zip_code`,`fleet_number`);

--
-- Indexes for table `driver_payroll`
--
ALTER TABLE `driver_payroll`
  ADD PRIMARY KEY (`key_driver_payroll`),
  ADD KEY `end_date` (`end_date`),
  ADD KEY `due_date` (`due_date`),
  ADD KEY `payment_method` (`payment_method`),
  ADD KEY `key_drivers` (`key_drivers`);
ALTER TABLE `driver_payroll` ADD FULLTEXT KEY `driver_payroll_fulltext` (`payment_method`);

--
-- Indexes for table `landmarks`
--
ALTER TABLE `landmarks`
  ADD PRIMARY KEY (`key_landmarks`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `landmarks` ADD FULLTEXT KEY `landmarks_fulltext` (`title`,`category`,`city`,`zip_code`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`key_logs`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `log_datetime` (`log_datetime`);
ALTER TABLE `logs` ADD FULLTEXT KEY `logs_fulltext` (`log_type`,`action_performed`);

--
-- Indexes for table `rates_zones`
--
ALTER TABLE `rates_zones`
  ADD PRIMARY KEY (`key_rates_zones`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `rates_zones` ADD FULLTEXT KEY `rates_zones_fulltext` (`from_city`,`to_city`);

--
-- Indexes for table `settings_ad_source_values`
--
ALTER TABLE `settings_ad_source_values`
  ADD PRIMARY KEY (`key_settings_ad_source_values`),
  ADD UNIQUE KEY `ad_source` (`ad_source`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_ad_source_values` ADD FULLTEXT KEY `settings_ad_source_values_fulltext` (`ad_source`);

--
-- Indexes for table `settings_airline_values`
--
ALTER TABLE `settings_airline_values`
  ADD PRIMARY KEY (`key_settings_airline_values`),
  ADD UNIQUE KEY `airline` (`airline`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_airline_values` ADD FULLTEXT KEY `settings_airline_values_fulltext` (`airline`);

--
-- Indexes for table `settings_company`
--
ALTER TABLE `settings_company`
  ADD PRIMARY KEY (`key_settings_company`),
  ADD KEY `entry_date_time` (`entry_date_time`);

--
-- Indexes for table `settings_country_values`
--
ALTER TABLE `settings_country_values`
  ADD PRIMARY KEY (`key_settings_country_values`),
  ADD UNIQUE KEY `country` (`country`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_country_values` ADD FULLTEXT KEY `settings_country_values_fulltext` (`country`,`country_code`);

--
-- Indexes for table `settings_dispatch_area_values`
--
ALTER TABLE `settings_dispatch_area_values`
  ADD PRIMARY KEY (`key_settings_dispatch_area_values`),
  ADD UNIQUE KEY `dispatch_area` (`dispatch_area`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_dispatch_area_values` ADD FULLTEXT KEY `settings_dispatch_area_values_fulltext` (`dispatch_area`);

--
-- Indexes for table `settings_email_configuration`
--
ALTER TABLE `settings_email_configuration`
  ADD PRIMARY KEY (`key_settings_email_configuration`),
  ADD KEY `entry_date_time` (`entry_date_time`);

--
-- Indexes for table `settings_extra_charges_values`
--
ALTER TABLE `settings_extra_charges_values`
  ADD PRIMARY KEY (`key_settings_extra_charges_values`),
  ADD UNIQUE KEY `category` (`category`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_extra_charges_values` ADD FULLTEXT KEY `settings_extra_charges_values_fulltext` (`category`);

--
-- Indexes for table `settings_insurance_company_values`
--
ALTER TABLE `settings_insurance_company_values`
  ADD PRIMARY KEY (`key_settings_insurance_company_values`),
  ADD UNIQUE KEY `insurance_company` (`insurance_company`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_insurance_company_values` ADD FULLTEXT KEY `settings_insurance_company_values_fulltext` (`insurance_company`);

--
-- Indexes for table `settings_landmark_values`
--
ALTER TABLE `settings_landmark_values`
  ADD PRIMARY KEY (`key_settings_landmark_values`),
  ADD UNIQUE KEY `category` (`category`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_landmark_values` ADD FULLTEXT KEY `settings_landmark_values_fulltext` (`category`);

--
-- Indexes for table `settings_offtime_type_values`
--
ALTER TABLE `settings_offtime_type_values`
  ADD PRIMARY KEY (`key_settings_offtime_type_values`),
  ADD UNIQUE KEY `offtime_type` (`offtime_type`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_offtime_type_values` ADD FULLTEXT KEY `settings_offtime_type_values_fulltext` (`offtime_type`);

--
-- Indexes for table `settings_payment_card_type_values`
--
ALTER TABLE `settings_payment_card_type_values`
  ADD PRIMARY KEY (`key_settings_payment_card_type_values`),
  ADD UNIQUE KEY `payment_card_type` (`payment_card_type`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_payment_card_type_values` ADD FULLTEXT KEY `settings_payment_card_type_values_fulltext` (`payment_card_type`);

--
-- Indexes for table `settings_payment_method_values`
--
ALTER TABLE `settings_payment_method_values`
  ADD PRIMARY KEY (`key_settings_payment_method_values`),
  ADD UNIQUE KEY `payment_method` (`payment_method`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_payment_method_values` ADD FULLTEXT KEY `settings_payment_method_values_fulltext` (`payment_method`);

--
-- Indexes for table `settings_state_values`
--
ALTER TABLE `settings_state_values`
  ADD PRIMARY KEY (`key_settings_state_values`),
  ADD UNIQUE KEY `state` (`state`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_state_values` ADD FULLTEXT KEY `settings_state_values_fulltext` (`state`,`state_code`);

--
-- Indexes for table `settings_toll_type_values`
--
ALTER TABLE `settings_toll_type_values`
  ADD PRIMARY KEY (`key_settings_toll_type_values`),
  ADD UNIQUE KEY `toll_type` (`toll_type`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_toll_type_values` ADD FULLTEXT KEY `settings_toll_type_values_fulltext` (`toll_type`);

--
-- Indexes for table `settings_trips`
--
ALTER TABLE `settings_trips`
  ADD PRIMARY KEY (`key_settings_trips`),
  ADD KEY `entry_date_time` (`entry_date_time`);

--
-- Indexes for table `settings_trip_status_values`
--
ALTER TABLE `settings_trip_status_values`
  ADD PRIMARY KEY (`key_settings_trip_status_values`),
  ADD UNIQUE KEY `trip_status` (`trip_status`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_trip_status_values` ADD FULLTEXT KEY `settings_trip_status_values_fulltext` (`trip_status`);

--
-- Indexes for table `settings_trip_type_values`
--
ALTER TABLE `settings_trip_type_values`
  ADD PRIMARY KEY (`key_settings_trip_type_values`),
  ADD UNIQUE KEY `trip_type` (`trip_type`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_trip_type_values` ADD FULLTEXT KEY `settings_trip_type_values_fulltext` (`trip_type`);

--
-- Indexes for table `settings_vehicle_model_values`
--
ALTER TABLE `settings_vehicle_model_values`
  ADD PRIMARY KEY (`key_settings_vehicle_model_values`),
  ADD UNIQUE KEY `vehicle_model` (`vehicle_model`),
  ADD KEY `entry_date_time` (`entry_date_time`);

--
-- Indexes for table `settings_vehicle_type_values`
--
ALTER TABLE `settings_vehicle_type_values`
  ADD PRIMARY KEY (`key_settings_vehicle_type_values`),
  ADD UNIQUE KEY `vehicle_type` (`vehicle_type`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_vehicle_type_values` ADD FULLTEXT KEY `settings_vehicle_type_values_fulltext` (`vehicle_type`);

--
-- Indexes for table `settings_workshop_name_values`
--
ALTER TABLE `settings_workshop_name_values`
  ADD PRIMARY KEY (`key_settings_workshop_name_values`),
  ADD UNIQUE KEY `workshop_name` (`workshop_name`),
  ADD KEY `entry_date_time` (`entry_date_time`);
ALTER TABLE `settings_workshop_name_values` ADD FULLTEXT KEY `settings_workshop_name_values_fulltext` (`workshop_name`,`city`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`key_trips`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_customer_invoices` (`key_customer_invoices`),
  ADD KEY `key_driver_payroll` (`key_driver_payroll`),
  ADD KEY `key_customer_passengers` (`key_customer_passengers`),
  ADD KEY `key_customer_contacts` (`key_customer_contacts`),
  ADD KEY `key_drivers` (`key_drivers`),
  ADD KEY `key_vehicles` (`key_vehicles`),
  ADD KEY `key_rates_zones` (`key_rates_zones`),
  ADD KEY `pickup_datetime` (`pickup_datetime`),
  ADD KEY `key_settings_airline_values` (`key_settings_airline_values`);
ALTER TABLE `trips` ADD FULLTEXT KEY `trips_fulltext` (`passenger_name`,`reference_number`,`reserved_by`,`trip_type`,`driver_name`,`vehicle`,`airline`,`flight_number`,`zone_from`,`zone_to`);

--
-- Indexes for table `trip_extra_charges`
--
ALTER TABLE `trip_extra_charges`
  ADD PRIMARY KEY (`key_trip_extra_charges`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_trips` (`key_trips`);
ALTER TABLE `trip_extra_charges` ADD FULLTEXT KEY `phpblink_fulltext` (`category`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`key_vehicles`),
  ADD UNIQUE KEY `fleet_number` (`fleet_number`),
  ADD UNIQUE KEY `vin_number` (`vin_number`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_insurance_company_values` (`key_settings_insurance_company_values`);
ALTER TABLE `vehicles` ADD FULLTEXT KEY `vehicles_fulltext` (`fleet_number`,`vehicle_type`,`tag`,`vin_number`,`year_made`,`model`,`color`,`notes`);

--
-- Indexes for table `vehicles_maintenance`
--
ALTER TABLE `vehicles_maintenance`
  ADD PRIMARY KEY (`key_vehicles_maintenance`),
  ADD KEY `entry_date_time` (`entry_date_time`),
  ADD KEY `key_vehicles` (`key_vehicles`),
  ADD KEY `repair_date` (`repair_date`);
ALTER TABLE `vehicles_maintenance` ADD FULLTEXT KEY `vehicles_maintenance_fulltext` (`repair_description`,`workshop_name`,`warranty_description`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_address_book`
--
ALTER TABLE `customer_address_book`
  MODIFY `key_customer_address_book` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_billing_contacts`
--
ALTER TABLE `customer_billing_contacts`
  MODIFY `key_customer_billing_contacts` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_companies`
--
ALTER TABLE `customer_companies`
  MODIFY `key_customer_companies` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  MODIFY `key_customer_contacts` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer_invoices`
--
ALTER TABLE `customer_invoices`
  MODIFY `key_customer_invoices` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;
--
-- AUTO_INCREMENT for table `customer_passengers`
--
ALTER TABLE `customer_passengers`
  MODIFY `key_customer_passengers` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customer_rate_packages`
--
ALTER TABLE `customer_rate_packages`
  MODIFY `key_customer_rate_packages` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `key_drivers` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `driver_payroll`
--
ALTER TABLE `driver_payroll`
  MODIFY `key_driver_payroll` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `landmarks`
--
ALTER TABLE `landmarks`
  MODIFY `key_landmarks` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `key_logs` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rates_zones`
--
ALTER TABLE `rates_zones`
  MODIFY `key_rates_zones` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_ad_source_values`
--
ALTER TABLE `settings_ad_source_values`
  MODIFY `key_settings_ad_source_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings_airline_values`
--
ALTER TABLE `settings_airline_values`
  MODIFY `key_settings_airline_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings_company`
--
ALTER TABLE `settings_company`
  MODIFY `key_settings_company` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_country_values`
--
ALTER TABLE `settings_country_values`
  MODIFY `key_settings_country_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_dispatch_area_values`
--
ALTER TABLE `settings_dispatch_area_values`
  MODIFY `key_settings_dispatch_area_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `settings_email_configuration`
--
ALTER TABLE `settings_email_configuration`
  MODIFY `key_settings_email_configuration` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_extra_charges_values`
--
ALTER TABLE `settings_extra_charges_values`
  MODIFY `key_settings_extra_charges_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings_insurance_company_values`
--
ALTER TABLE `settings_insurance_company_values`
  MODIFY `key_settings_insurance_company_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_landmark_values`
--
ALTER TABLE `settings_landmark_values`
  MODIFY `key_settings_landmark_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings_offtime_type_values`
--
ALTER TABLE `settings_offtime_type_values`
  MODIFY `key_settings_offtime_type_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings_payment_card_type_values`
--
ALTER TABLE `settings_payment_card_type_values`
  MODIFY `key_settings_payment_card_type_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings_payment_method_values`
--
ALTER TABLE `settings_payment_method_values`
  MODIFY `key_settings_payment_method_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings_state_values`
--
ALTER TABLE `settings_state_values`
  MODIFY `key_settings_state_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings_toll_type_values`
--
ALTER TABLE `settings_toll_type_values`
  MODIFY `key_settings_toll_type_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_trips`
--
ALTER TABLE `settings_trips`
  MODIFY `key_settings_trips` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings_trip_status_values`
--
ALTER TABLE `settings_trip_status_values`
  MODIFY `key_settings_trip_status_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings_trip_type_values`
--
ALTER TABLE `settings_trip_type_values`
  MODIFY `key_settings_trip_type_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings_vehicle_model_values`
--
ALTER TABLE `settings_vehicle_model_values`
  MODIFY `key_settings_vehicle_model_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings_vehicle_type_values`
--
ALTER TABLE `settings_vehicle_type_values`
  MODIFY `key_settings_vehicle_type_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings_workshop_name_values`
--
ALTER TABLE `settings_workshop_name_values`
  MODIFY `key_settings_workshop_name_values` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `key_trips` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;
--
-- AUTO_INCREMENT for table `trip_extra_charges`
--
ALTER TABLE `trip_extra_charges`
  MODIFY `key_trip_extra_charges` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `key_vehicles` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vehicles_maintenance`
--
ALTER TABLE `vehicles_maintenance`
  MODIFY `key_vehicles_maintenance` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_address_book`
--
ALTER TABLE `customer_address_book`
  ADD CONSTRAINT `customer_address_book_ibfk_1` FOREIGN KEY (`key_customer_passengers`) REFERENCES `customer_passengers` (`key_customer_passengers`) ON DELETE CASCADE;

--
-- Constraints for table `trip_extra_charges`
--
ALTER TABLE `trip_extra_charges`
  ADD CONSTRAINT `trip_extra_charges_ibfk_1` FOREIGN KEY (`key_trips`) REFERENCES `trips` (`key_trips`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles_maintenance`
--
ALTER TABLE `vehicles_maintenance`
  ADD CONSTRAINT `vehicles_maintenance_ibfk_1` FOREIGN KEY (`key_vehicles`) REFERENCES `vehicles` (`key_vehicles`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
