-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2018 at 08:11 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feedbacker`
--

-- --------------------------------------------------------

--
-- Table structure for table `fb_attachments`
--

CREATE TABLE `fb_attachments` (
  `at_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `at_type_id` int(11) NOT NULL,
  `at_path` varchar(128) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attaments of porfolio''s and profile''s';

-- --------------------------------------------------------

--
-- Table structure for table `fb_attach_type`
--

CREATE TABLE `fb_attach_type` (
  `at_type_id` int(11) NOT NULL,
  `at_type` enum('PORTFOLIO','PROFILE','PORTFOLIO WITH PROFILE') NOT NULL,
  `at_text` varchar(512) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attachment Types';

--
-- Dumping data for table `fb_attach_type`
--

INSERT INTO `fb_attach_type` (`at_type_id`, `at_type`, `at_text`, `is_deleted`, `created_by`, `created_dtm`, `updated_by`, `updated_dtm`) VALUES
(1, 'PORTFOLIO', 'Portfolio', 0, 1, '2016-05-25 00:00:00', NULL, NULL),
(2, 'PROFILE', 'Profile', 0, 1, '2016-05-25 12:50:12', NULL, NULL),
(3, 'PORTFOLIO WITH PROFILE', 'Portfolio with Profile', 0, 1, '2016-05-25 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fb_company`
--

CREATE TABLE `fb_company` (
  `comp_id` int(11) NOT NULL,
  `comp_name` varchar(512) NOT NULL,
  `comp_url` varchar(128) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `comp_email` varchar(128) NOT NULL,
  `comp_pass` varchar(128) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lead proposing company';

--
-- Dumping data for table `fb_company`
--

INSERT INTO `fb_company` (`comp_id`, `comp_name`, `comp_url`, `address`, `contact`, `comp_email`, `comp_pass`, `is_deleted`, `created_by`, `created_dtm`, `updated_by`, `updated_dtm`) VALUES
(1, 'CodeInsect', 'http://www.codeinsect.com', 'Pune, India', NULL, 'admin@example.com', 'codeinsect', 0, 1, '2016-05-25 12:24:42', NULL, NULL),
(2, 'Company 2', 'http://www.codeinsect.com', 'Pune, India', '', 'admin@example.com', 'codeinsect', 0, 1, '2016-05-25 12:24:42', NULL, NULL),
(3, 'Company 3', 'http://www.codeinsect.com', 'Pune, India', NULL, 'admin@example.com', 'codeinsect', 0, 1, '2016-05-26 10:41:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fb_cron_counter`
--

CREATE TABLE `fb_cron_counter` (
  `fb_ofid` bigint(20) NOT NULL,
  `fb_ofcount` bigint(20) NOT NULL DEFAULT '0',
  `fb_totcount` bigint(20) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_dtm` datetime NOT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fb_cust_followup`
--

CREATE TABLE `fb_cust_followup` (
  `fp_id` bigint(20) NOT NULL,
  `fp_type` enum('EMAIL','CALL') NOT NULL DEFAULT 'CALL',
  `cust_id` bigint(20) NOT NULL,
  `currently_served_by` bigint(20) NOT NULL,
  `fp_dtm` datetime DEFAULT NULL,
  `fp_summary` text,
  `fbt_id` int(11) NOT NULL,
  `fp_next_call` datetime DEFAULT NULL,
  `fp_status` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fb_cust_reqment`
--

CREATE TABLE `fb_cust_reqment` (
  `rem_id` bigint(20) NOT NULL,
  `cust_id` bigint(20) NOT NULL,
  `currently_served_by` bigint(20) NOT NULL,
  `rem_summary` text,
  `interested_in` varchar(512) DEFAULT NULL,
  `cust_cost` varchar(50) DEFAULT NULL,
  `estimated_cost` varchar(50) DEFAULT NULL,
  `conversion_cost` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fb_cust_scr`
--

CREATE TABLE `fb_cust_scr` (
  `scr_id` bigint(20) NOT NULL,
  `cust_id` bigint(20) NOT NULL,
  `scr_img_desk` varchar(50) DEFAULT NULL,
  `scr_img_mobile` varchar(50) DEFAULT NULL,
  `scr_dtm` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fb_email_template`
--

CREATE TABLE `fb_email_template` (
  `temp_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `temp_name` varchar(512) NOT NULL,
  `temp_html` text NOT NULL,
  `temp_type` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Email templates by company id';

--
-- Dumping data for table `fb_email_template`
--

INSERT INTO `fb_email_template` (`temp_id`, `comp_id`, `temp_name`, `temp_html`, `temp_type`, `is_deleted`, `created_by`, `created_dtm`, `updated_by`, `updated_dtm`) VALUES
(1, 1, 'Portfolio Template', '<div>\n<table style="width: 100%; border-spacing: 0;" cellspacing="0" cellpadding="0">\n<tbody>\n<tr style="height: 78px;">\n<th style="border-top: 5px solid #f56400; font-weight: normal; text-align: center; background: #ffffff none repeat scroll 0% 0%; border-bottom: 1px solid #e3e5e1; height: 78px;">\n<table style="width: 100%; max-width: 596px; border-spacing: 0; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">\n<tbody>\n<tr style="height: 74px;">\n<td style="height: 74px;">\n<table style="margin: 0%; width: 100%; border-spacing: 0; table-layout: fixed;" cellspacing="0" cellpadding="0">\n<tbody>\n<tr style="height: 38px;">\n<td style="padding: 17px 3.358% 15px; height: 38px;"><cite style="text-align: center; display: block; font-style: normal;"><cite style="text-align: center; display: block; font-style: normal;"> <span style="font-size: 1px; min-height: 0; color: #fff; width: 0; display: block;">The portfolio is on the way</span></cite></cite>\n<div style="font-size: 15px; display: inline-block; width: 100%; margin: 0px; vertical-align: top;">CodeInsect</div>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</th>\n</tr>\n<tr style="height: 28px;">\n<th style="background: #f5f5f1; height: 28px;">&nbsp;</th>\n</tr>\n<tr style="height: 318px;">\n<th style="background: #f5f5f1 none repeat scroll 0% 0%; font-weight: normal; text-align: left; height: 318px;">\n<table style="width: 100%; max-width: 596px; border-spacing: 0; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">\n<tbody>\n<tr>\n<td>\n<table style="margin: 0%; width: 100%; border-spacing: 0; table-layout: fixed;" cellspacing="0" cellpadding="0">\n<tbody>\n<tr>\n<td style="padding: 0 3.358%; font-size: 15px; color: #555; line-height: 24px;">\n<div style="min-height: 28px;">&nbsp;</div>\n<div style="padding: 24px 3.6% 24px; background: #fff; border: 1px solid #e3e5e1;">\n<table style="width: 100%; margin: 0; padding: 0;" cellspacing="0" cellpadding="0">\n<tbody>\n<tr>\n<td align="center">\n<div style="width: 100%;">Hi, You got the portfolio, please download the attachment.\n<div style="min-height: 20px;">&nbsp;</div>\n</div>\n</td>\n</tr>\n</tbody>\n</table>\n</div>\n<div style="min-height: 28px;">&nbsp;</div>\n<table style="width: 100%; margin: 0; padding: 0;" cellspacing="0" cellpadding="0">\n<tbody>\n<tr>\n<td align="center">\n<div style="width: 100%;"><span style="font-size: 12px; line-height: 18px; color: #555;">If you have any query, <a style="text-decoration: none; color: #0192b5;" href="#" target="_blank"> please contact CodeInsect support</a>.</span></div>\n</td>\n</tr>\n</tbody>\n</table>\n<div style="min-height: 28px;">&nbsp;</div>\n<div style="text-align: center; padding: 0 6% 24px; font-size: 12px; line-height: 18px; color: #555;">You are receiving this email from CodeInsect because you <span class="il"> subscribed </span> <a style="color: #555; font-weight: normal; text-decoration: underline;" href="http://codeinsect.com" target="_blank"> CodeInsect </a> with this email address.<br /><br /> Copyright CodeInsect 2017 - All Rights Reserved</div>\n</td>\n</tr>\n</tbody>\n</table>\n</td>\n</tr>\n</tbody>\n</table>\n</th>\n</tr>\n</tbody>\n</table>\n<div class="yj6qo">&nbsp;</div>\n<div class="adL">&nbsp;</div>\n</div>', 1, 0, 1, '2016-05-25 00:00:00', 1, '2016-05-26 11:51:41'),
(2, 2, 'Portfolio Template', '<div>\r\n<table style="width: 100%; border-spacing: 0;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="height: 78px;">\r\n<th style="border-top: 5px solid #f56400; font-weight: normal; text-align: center; background: #ffffff none repeat scroll 0% 0%; border-bottom: 1px solid #e3e5e1; height: 78px;">\r\n<table style="width: 100%; max-width: 596px; border-spacing: 0; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">\r\n<tbody>\r\n<tr style="height: 74px;">\r\n<td style="height: 74px;">\r\n<table style="margin: 0%; width: 100%; border-spacing: 0; table-layout: fixed;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="height: 38px;">\r\n<td style="padding: 17px 3.358% 15px; height: 38px;"><cite style="text-align: center; display: block; font-style: normal;"><cite style="text-align: center; display: block; font-style: normal;"> <span style="font-size: 1px; min-height: 0; color: #fff; width: 0; display: block;">The portfolio is on the way</span></cite></cite>\r\n<div style="font-size: 15px; display: inline-block; width: 100%; margin: 0px; vertical-align: top;">CodeInsect</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</th>\r\n</tr>\r\n<tr style="height: 28px;">\r\n<th style="background: #f5f5f1; height: 28px;">&nbsp;</th>\r\n</tr>\r\n<tr style="height: 318px;">\r\n<th style="background: #f5f5f1 none repeat scroll 0% 0%; font-weight: normal; text-align: left; height: 318px;">\r\n<table style="width: 100%; max-width: 596px; border-spacing: 0; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table style="margin: 0%; width: 100%; border-spacing: 0; table-layout: fixed;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="padding: 0 3.358%; font-size: 15px; color: #555; line-height: 24px;">\r\n<div style="min-height: 28px;">&nbsp;</div>\r\n<div style="padding: 24px 3.6% 24px; background: #fff; border: 1px solid #e3e5e1;">\r\n<table style="width: 100%; margin: 0; padding: 0;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center">\r\n<div style="width: 100%;">Hi, You got the portfolio, please download the attachment.\r\n<div style="min-height: 20px;">&nbsp;</div>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<div style="min-height: 28px;">&nbsp;</div>\r\n<table style="width: 100%; margin: 0; padding: 0;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center">\r\n<div style="width: 100%;"><span style="font-size: 12px; line-height: 18px; color: #555;">If you have any query, <a style="text-decoration: none; color: #0192b5;" href="#" target="_blank"> please contact CodeInsect support</a>.</span></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style="min-height: 28px;">&nbsp;</div>\r\n<div style="text-align: center; padding: 0 6% 24px; font-size: 12px; line-height: 18px; color: #555;">You are receiving this email from CodeInsect because you <span class="il"> subscribed </span> <a style="color: #555; font-weight: normal; text-decoration: underline;" href="http://codeinsect.com" target="_blank"> CodeInsect </a> with this email address.<br /><br /> Copyright CodeInsect 2016 - All Rights Reserved</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div class="yj6qo">&nbsp;</div>\r\n<div class="adL">&nbsp;</div>\r\n</div>', 1, 0, 1, '2016-05-25 00:00:00', 1, '2018-02-13 08:04:21'),
(3, 3, 'Portfolio Template', '<div>\r\n<table style="width: 100%; border-spacing: 0;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="height: 78px;">\r\n<th style="border-top: 5px solid #f56400; font-weight: normal; text-align: center; background: #ffffff none repeat scroll 0% 0%; border-bottom: 1px solid #e3e5e1; height: 78px;">\r\n<table style="width: 100%; max-width: 596px; border-spacing: 0; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">\r\n<tbody>\r\n<tr style="height: 74px;">\r\n<td style="height: 74px;">\r\n<table style="margin: 0%; width: 100%; border-spacing: 0; table-layout: fixed;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr style="height: 38px;">\r\n<td style="padding: 17px 3.358% 15px; height: 38px;"><cite style="text-align: center; display: block; font-style: normal;"><cite style="text-align: center; display: block; font-style: normal;"> <span style="font-size: 1px; min-height: 0; color: #fff; width: 0; display: block;">The portfolio is on the way</span></cite></cite>\r\n<div style="font-size: 15px; display: inline-block; width: 100%; margin: 0px; vertical-align: top;">CodeInsect</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</th>\r\n</tr>\r\n<tr style="height: 28px;">\r\n<th style="background: #f5f5f1; height: 28px;">&nbsp;</th>\r\n</tr>\r\n<tr style="height: 318px;">\r\n<th style="background: #f5f5f1 none repeat scroll 0% 0%; font-weight: normal; text-align: left; height: 318px;">\r\n<table style="width: 100%; max-width: 596px; border-spacing: 0; margin: 0 auto;" cellspacing="0" cellpadding="0" align="center">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table style="margin: 0%; width: 100%; border-spacing: 0; table-layout: fixed;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="padding: 0 3.358%; font-size: 15px; color: #555; line-height: 24px;">\r\n<div style="min-height: 28px;">&nbsp;</div>\r\n<div style="padding: 24px 3.6% 24px; background: #fff; border: 1px solid #e3e5e1;">\r\n<table style="width: 100%; margin: 0; padding: 0;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center">\r\n<div style="width: 100%;">Hi, You got the portfolio, please download the attachment.\r\n<div style="min-height: 20px;">&nbsp;</div>\r\n</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<div style="min-height: 28px;">&nbsp;</div>\r\n<table style="width: 100%; margin: 0; padding: 0;" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center">\r\n<div style="width: 100%;"><span style="font-size: 12px; line-height: 18px; color: #555;">If you have any query, <a style="text-decoration: none; color: #0192b5;" href="#" target="_blank"> please contact CodeInsect support</a>.</span></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style="min-height: 28px;">&nbsp;</div>\r\n<div style="text-align: center; padding: 0 6% 24px; font-size: 12px; line-height: 18px; color: #555;">You are receiving this email from CodeInsect because you <span class="il"> subscribed </span> <a style="color: #555; font-weight: normal; text-decoration: underline;" href="http://codeinsect.com" target="_blank"> CodeInsect</a> with this email address.<br /><br /> Copyright CodeInsect 2016 - All Rights Reserved</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div class="yj6qo">&nbsp;</div>\r\n<div class="adL">&nbsp;</div>\r\n</div>', 1, 0, 1, '2016-05-25 00:00:00', 1, '2018-02-13 08:04:58');

-- --------------------------------------------------------

--
-- Table structure for table `fb_fbtype`
--

CREATE TABLE `fb_fbtype` (
  `fbt_id` int(11) NOT NULL,
  `fbt_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='these are feedback types';

--
-- Dumping data for table `fb_fbtype`
--

INSERT INTO `fb_fbtype` (`fbt_id`, `fbt_name`) VALUES
(1, 'Good'),
(2, 'Bad'),
(3, 'Interested'),
(4, 'Not Interested'),
(5, 'Abused'),
(6, 'Not Received'),
(7, 'Unable to connect');

-- --------------------------------------------------------

--
-- Table structure for table `fb_packages`
--

CREATE TABLE `fb_packages` (
  `pkg_id` int(11) NOT NULL,
  `pkg_name` varchar(128) DEFAULT NULL,
  `pkg_cost` double NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL DEFAULT '1',
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fb_packages`
--

INSERT INTO `fb_packages` (`pkg_id`, `pkg_name`, `pkg_cost`, `status`, `is_deleted`, `created_by`, `created_dtm`, `updated_by`, `updated_dtm`) VALUES
(1, 'SEO', 10000, 1, 0, 1, '2016-05-17 16:27:43', NULL, NULL),
(2, 'Static Pages', 20000, 1, 0, 1, '2016-05-17 16:29:31', NULL, NULL),
(3, 'Dynamic Site', 50000, 1, 0, 1, '2016-05-17 16:29:45', NULL, NULL),
(4, 'PHP Development', 400000, 1, 0, 1, '2016-05-17 16:30:11', NULL, NULL),
(5, 'Android App', 500000, 1, 0, 1, '2016-05-17 16:30:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fb_raw_cust`
--

CREATE TABLE `fb_raw_cust` (
  `cust_id` bigint(20) NOT NULL,
  `domain_name` varchar(1024) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `domain_registrar_name` varchar(128) DEFAULT NULL,
  `registrant_name` varchar(128) DEFAULT NULL,
  `registrant_company` varchar(100) DEFAULT NULL,
  `registrant_address` varchar(1024) DEFAULT NULL,
  `registrant_city` varchar(50) DEFAULT NULL,
  `registrant_state` varchar(50) DEFAULT NULL,
  `registrant_zip` varchar(10) DEFAULT NULL,
  `registrant_country` varchar(50) DEFAULT NULL,
  `registrant_email` varchar(128) DEFAULT NULL,
  `registrant_phone` varchar(20) DEFAULT NULL,
  `registrant_alt_email` varchar(128) DEFAULT NULL,
  `registrant_alt_phone` varchar(20) DEFAULT NULL,
  `registrant_fax` varchar(20) DEFAULT NULL,
  `conversion_flag` tinyint(4) NOT NULL DEFAULT '0',
  `scr_dtm` datetime DEFAULT NULL,
  `scr_img_desk` varchar(512) DEFAULT NULL,
  `scr_img_mobile` varchar(512) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `assigned_to` bigint(20) NOT NULL DEFAULT '0',
  `currently_served_by` bigint(20) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL,
  `created_dtm` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_dtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_last_login`
--

CREATE TABLE `tbl_last_login` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `sessionData` varchar(2048) NOT NULL,
  `machineIp` varchar(1024) NOT NULL,
  `userAgent` varchar(128) NOT NULL,
  `agentString` varchar(1024) NOT NULL,
  `platform` varchar(128) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_last_login`
--

INSERT INTO `tbl_last_login` (`id`, `userId`, `sessionData`, `machineIp`, `userAgent`, `agentString`, `platform`, `createdDtm`) VALUES
(1, 1, '{"role":"1","roleText":"System Administrator","name":"Administrator"}', '::1', 'Firefox 58.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0', 'Windows 10', '2018-02-13 12:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reset_password`
--

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` bigint(20) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Manager'),
(3, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'login password md5',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `email`, `password`, `name`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`) VALUES
(1, 'admin@example.com', '$2y$10$gbQl4Dbtl7m9wwKC3ABTVeVDUar/ko/zW.PCHZ8DxGJPwOXiq9QuS', 'Administrator', '9890098900', 1, 0, 0, '2015-07-01 18:56:49', 1, '2018-02-13 07:57:55'),
(2, 'emp1@example.com', '$2y$10$/raL8WKiJjyRiPazkPeuYu3DCAJE5DOsoWPErmpYPUgLtYjXArpJ6', 'Employee 1', '9890098900', 3, 0, 1, '2016-05-10 14:21:51', 1, '2018-02-12 09:57:16'),
(3, 'emp2@example.com', '$2y$10$/raL8WKiJjyRiPazkPeuYu3DCAJE5DOsoWPErmpYPUgLtYjXArpJ6', 'Employee 2', '9890098900', 3, 0, 1, '2016-05-16 11:18:58', NULL, NULL),
(4, 'emp3@example.com', '$2y$10$/raL8WKiJjyRiPazkPeuYu3DCAJE5DOsoWPErmpYPUgLtYjXArpJ6', 'Employee 3', '9890098900', 3, 0, 1, '2016-05-16 11:19:29', NULL, NULL),
(5, 'emp4@example.com', '$2y$10$/raL8WKiJjyRiPazkPeuYu3DCAJE5DOsoWPErmpYPUgLtYjXArpJ6', 'Employee 4', '9890098900', 3, 0, 1, '2016-06-01 18:24:13', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fb_attachments`
--
ALTER TABLE `fb_attachments`
  ADD PRIMARY KEY (`at_id`);

--
-- Indexes for table `fb_attach_type`
--
ALTER TABLE `fb_attach_type`
  ADD PRIMARY KEY (`at_type_id`);

--
-- Indexes for table `fb_company`
--
ALTER TABLE `fb_company`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `fb_cron_counter`
--
ALTER TABLE `fb_cron_counter`
  ADD PRIMARY KEY (`fb_ofid`);

--
-- Indexes for table `fb_cust_followup`
--
ALTER TABLE `fb_cust_followup`
  ADD PRIMARY KEY (`fp_id`);

--
-- Indexes for table `fb_cust_reqment`
--
ALTER TABLE `fb_cust_reqment`
  ADD PRIMARY KEY (`rem_id`);

--
-- Indexes for table `fb_cust_scr`
--
ALTER TABLE `fb_cust_scr`
  ADD PRIMARY KEY (`scr_id`);

--
-- Indexes for table `fb_email_template`
--
ALTER TABLE `fb_email_template`
  ADD PRIMARY KEY (`temp_id`);

--
-- Indexes for table `fb_fbtype`
--
ALTER TABLE `fb_fbtype`
  ADD PRIMARY KEY (`fbt_id`);

--
-- Indexes for table `fb_packages`
--
ALTER TABLE `fb_packages`
  ADD PRIMARY KEY (`pkg_id`);

--
-- Indexes for table `fb_raw_cust`
--
ALTER TABLE `fb_raw_cust`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `tbl_last_login`
--
ALTER TABLE `tbl_last_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fb_attachments`
--
ALTER TABLE `fb_attachments`
  MODIFY `at_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_attach_type`
--
ALTER TABLE `fb_attach_type`
  MODIFY `at_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fb_company`
--
ALTER TABLE `fb_company`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fb_cron_counter`
--
ALTER TABLE `fb_cron_counter`
  MODIFY `fb_ofid` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_cust_followup`
--
ALTER TABLE `fb_cust_followup`
  MODIFY `fp_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_cust_reqment`
--
ALTER TABLE `fb_cust_reqment`
  MODIFY `rem_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_cust_scr`
--
ALTER TABLE `fb_cust_scr`
  MODIFY `scr_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fb_email_template`
--
ALTER TABLE `fb_email_template`
  MODIFY `temp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fb_fbtype`
--
ALTER TABLE `fb_fbtype`
  MODIFY `fbt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `fb_packages`
--
ALTER TABLE `fb_packages`
  MODIFY `pkg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fb_raw_cust`
--
ALTER TABLE `fb_raw_cust`
  MODIFY `cust_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_last_login`
--
ALTER TABLE `tbl_last_login`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
