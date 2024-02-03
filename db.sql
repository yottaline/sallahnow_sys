-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 15, 2023 at 02:16 PM
-- Server version: 5.7.23-23
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yottasqr_sallahnow`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` INT UNSIGNED NOT NULL,
  `brand_name` VARCHAR(24) NOT NULL,
  `brand_logo` VARCHAR(24) NOT NULL,
  `brand_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `compatibilities`
--

CREATE TABLE `compatibilities` (
  `compatibility_id` INT UNSIGNED NOT NULL,
  `compatibility_category` INT UNSIGNED NOT NULL,
  `compatibility_part` VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `compatible_models`
--

CREATE TABLE `compatible_models` (
  `compatible_id` bigint(20) UNSIGNED NOT NULL,
  `compatible_src` INT UNSIGNED NOT NULL COMMENT 'compatibilities.compatibility_id',
  `compatible_model` INT UNSIGNED NOT NULL COMMENT 'models.model_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` INT UNSIGNED NOT NULL,
  `customer_code` VARCHAR(24) NOT NULL,
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(100) NOT NULL,
  `customer_mobile` VARCHAR(24) NOT NULL,
  `customer_password` VARCHAR(255) NOT NULL,
  `customer_country` INT UNSIGNED NOT NULL,
  `customer_state` INT UNSIGNED NOT NULL,
  `customer_city` INT UNSIGNED NOT NULL,
  `customer_area` INT UNSIGNED NOT NULL,
  `customer_address` VARCHAR(1024) NOT NULL,
  `customer_geo` VARCHAR(64) NOT NULL,
  `customer_notes` VARCHAR(1024),
  `customer_rate` tinyint(4) DEFAULT NULL,
  `customer_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `customer_blocked` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `customer_login` DATETIME DEFAULT NULL,
  `customer_register` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issue_categories`
--

CREATE TABLE `issue_categories` (
  `issuecat_id` INT UNSIGNED NOT NULL,
  `issuecat_name` VARCHAR(1024) NOT NULL,
  `issuecat_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issue_subcategories`
--

CREATE TABLE `issue_subcategories` (
  `issuesubcat_id` INT UNSIGNED NOT NULL,
  `issuesubcat_category` INT UNSIGNED NOT NULL,
  `issuesubcat_name` VARCHAR(1024) NOT NULL,
  `issuesubcat_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `language_id` TINYINT UNSIGNED NOT NULL,
  `language_name` VARCHAR(24) NOT NULL,
  `language_code` VARCHAR(2) NOT NULL,
  `language_dir` VARCHAR(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` INT UNSIGNED NOT NULL,
  `location_name` VARCHAR(100) NOT NULL,
  `location_type` TINYINT UNSIGNED NOT NULL COMMENT '1:country,2:state,3:city,4:area',
  `location_parent` INT UNSIGNED NOT NULL,
  `location_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `merchant_id` INT UNSIGNED NOT NULL,
  `merchant_code` VARCHAR(24) NOT NULL,
  `merchant_store` VARCHAR(100) NOT NULL,
  `merchant_person` VARCHAR(100) NOT NULL,
  `merchant_email` VARCHAR(100) NOT NULL,
  `merchant_mobile` VARCHAR(24) NOT NULL,
  `merchant_tel` VARCHAR(24) NOT NULL,
  `merchant_password` VARCHAR(255) NOT NULL,
  `merchant_country` INT UNSIGNED NOT NULL,
  `merchant_state` INT UNSIGNED NOT NULL,
  `merchant_city` INT UNSIGNED NOT NULL,
  `merchant_area` INT UNSIGNED NOT NULL,
  `merchant_address` VARCHAR(1024) NOT NULL,
  `merchant_geo` VARCHAR(64) NOT NULL,
  `merchant_desc` VARCHAR(1024),
  `merchant_notes` VARCHAR(1024),
  `merchant_rate` TINYINT UNSIGNED DEFAULT NULL,
  `merchant_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `merchant_blocked` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `merchant_login` DATETIME DEFAULT NULL,
  `merchant_register` DATETIME NOT NULL,
  `merchant_user` INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `model_id` INT UNSIGNED NOT NULL,
  `model_name` VARCHAR(24) NOT NULL,
  `model_brand` INT UNSIGNED NOT NULL,
  `model_photo` VARCHAR(120) NOT NULL,
  `model_url` VARCHAR(120) NOT NULL,
  `model_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `part_id` INT UNSIGNED NOT NULL,
  `part_merchant` INT UNSIGNED NOT NULL,
  `part_brand` INT UNSIGNED NOT NULL,
  `part_name` VARCHAR(24) NOT NULL,
  `part_desc` VARCHAR(1024) NOT NULL,
  `part_photo` VARCHAR(24) NOT NULL,
  `part_stock` INT UNSIGNED NOT NULL DEFAULT '0',
  `part_cost` decimal(7,2) NOT NULL,
  `part_warrenty` INT UNSIGNED NOT NULL DEFAULT '0',
  `part_add` INT UNSIGNED NOT NULL,
  `part_update` INT UNSIGNED NOT NULL,
  `part_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parts_brands`
--

CREATE TABLE `parts_brands` (
  `prtbrnd_id` INT UNSIGNED NOT NULL,
  `prtbrnd_name` VARCHAR(24) NOT NULL,
  `prtbrnd_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` INT UNSIGNED NOT NULL,
  `post_code` VARCHAR(12) NOT NULL,
  `post_title` VARCHAR(255) NOT NULL,
  `post_brief` VARCHAR(2048) NOT NULL,
  `post_file` VARCHAR(24) NOT NULL,
  `post_photo` VARCHAR(24) NOT NULL,
  `post_languages` VARCHAR(255) NOT NULL COMMENT 'en,ar,fr',
  `post_type` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `post_cost` INT UNSIGNED NOT NULL DEFAULT '0',
  `post_published` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `post_publish_user` INT UNSIGNED DEFAULT NULL,
  `post_publish_time` DATETIME DEFAULT NULL,
  `post_archived` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `post_archive_user` INT UNSIGNED DEFAULT NULL,
  `post_archive_time` DATETIME DEFAULT NULL,
  `post_deleted` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `post_delete_user` INT UNSIGNED NOT NULL,
  `post_delete_time` DATETIME DEFAULT NULL,
  `post_views` INT UNSIGNED NOT NULL DEFAULT '0',
  `post_likes` INT UNSIGNED NOT NULL DEFAULT '0',
  `post_create_user` INT UNSIGNED NOT NULL,
  `post_create_time` DATETIME NOT NULL,
  `post_modify_user` INT UNSIGNED DEFAULT NULL,
  `post_modify_time` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts_likes`
--

CREATE TABLE `posts_likes` (
  `like_id` bigint(20) UNSIGNED NOT NULL,
  `like_tech` INT UNSIGNED NOT NULL,
  `like_post` INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts_views`
--

CREATE TABLE `posts_views` (
  `view_id` bigint(20) UNSIGNED NOT NULL,
  `view_device` VARCHAR(200) DEFAULT NULL,
  `view_tech` INT UNSIGNED NOT NULL,
  `view_post` INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` INT UNSIGNED NOT NULL,
  `request_code` VARCHAR(24) NOT NULL,
  `request_customer` INT UNSIGNED NOT NULL,
  `request_uid` VARCHAR(120) NOT NULL,
  `request_brand` INT UNSIGNED NOT NULL,
  `request_model` INT UNSIGNED NOT NULL,
  `request_alive` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `request_note` VARCHAR(2048) NOT NULL,
  `request_status` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `request_modify` DATETIME NOT NULL,
  `request_register` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `req_attach`
--

CREATE TABLE `req_attach` (
  `reqattach_id` INT UNSIGNED NOT NULL,
  `reqattach_request` INT UNSIGNED NOT NULL,
  `reqattach_file` VARCHAR(42) NOT NULL,
  `reqattach_time` DATETIME NOT NULL,
  `reqattach_status` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `req_issues`
--

CREATE TABLE `req_issues` (
  `reqissue_id` INT UNSIGNED NOT NULL,
  `reqissue_request` INT UNSIGNED NOT NULL,
  `reqissue_category` INT UNSIGNED NOT NULL,
  `reqissue_subcategory` INT UNSIGNED NOT NULL,
  `reqissue_status` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `req_parts`
--

CREATE TABLE `req_parts` (
  `reqpart_id` INT UNSIGNED NOT NULL,
  `reqpart_request` INT UNSIGNED NOT NULL,
  `reqpart_repair` INT UNSIGNED NOT NULL,
  `reqpart_part` INT UNSIGNED NOT NULL,
  `reqpart_cost` decimal(7,2) NOT NULL,
  `reqpart_qty` TINYINT UNSIGNED NOT NULL,
  `reqpart_time` DATETIME NOT NULL,
  `reqpart_status` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `req_repairs`
--

CREATE TABLE `req_repairs` (
  `reqrepair_id` INT UNSIGNED NOT NULL,
  `reqrepair_request` INT UNSIGNED NOT NULL,
  `reqrepair_tech` INT UNSIGNED NOT NULL,
  `reqrepair_cost` decimal(7,2) NOT NULL,
  `reqrepair_total` decimal(7,2) NOT NULL,
  `reqrepair_notes` VARCHAR(1024) NOT NULL,
  `reqrepair_arrive` DATETIME NOT NULL,
  `reqrepair_finished` DATETIME NOT NULL,
  `reqrepair_status` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `req_repairs_reviews`
--

CREATE TABLE `req_repairs_reviews` (
  `reprvw_id` INT UNSIGNED NOT NULL,
  `reprvw_repair` INT UNSIGNED NOT NULL,
  `reprvw_request` INT UNSIGNED NOT NULL,
  `reprvw_tech` INT UNSIGNED NOT NULL,
  `reprvw_customer` INT UNSIGNED NOT NULL,
  `reprvw_comment` VARCHAR(512) NOT NULL,
  `reprvw_rate` TINYINT UNSIGNED NOT NULL,
  `reprvw_target` TINYINT UNSIGNED NOT NULL COMMENT '1:Customer,2:Tech'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `attach_id` bigint(20) UNSIGNED NOT NULL,
  `attach_file` VARCHAR(24) NOT NULL,
  `attach_ticket` INT UNSIGNED DEFAULT NULL,
  `attach_reply` INT UNSIGNED DEFAULT NULL,
  `attach_target` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '0: ticket, 1: reply',
  `attach_time` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `support_categories`
--

CREATE TABLE `support_categories` (
  `category_id` INT UNSIGNED NOT NULL,
  `category_name` VARCHAR(120) NOT NULL,
  `category_cost` INT UNSIGNED NOT NULL DEFAULT '1',
  `category_active` TINYINT UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `support_replies`
--

CREATE TABLE `support_replies` (
  `reply_id` bigint(20) UNSIGNED NOT NULL,
  `reply_ticket` INT UNSIGNED NOT NULL,
  `reply_context` VARCHAR(1024) NOT NULL,
  `reply_type` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '0:admin, 1:tech',
  `reply_target` INT UNSIGNED NOT NULL,
  `reply_time` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `ticket_id` INT UNSIGNED NOT NULL,
  `ticket_code` VARCHAR(12) NOT NULL,
  `ticket_brand` INT UNSIGNED NOT NULL,
  `ticket_model` INT UNSIGNED NOT NULL,
  `ticket_cost` INT UNSIGNED NOT NULL DEFAULT '0',
  `ticket_category` TINYINT UNSIGNED NOT NULL,
  `ticket_context` VARCHAR(1024) NOT NULL,
  `ticket_status` TINYINT UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Unread, 2: Opened, 3: Closed, 4: Solved, 5: Canceled',
  `ticket_tech` INT UNSIGNED NOT NULL,
  `ticket_time` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `tech_id` INT UNSIGNED NOT NULL,
  `tech_code` VARCHAR(24) NOT NULL,
  `tech_place` VARCHAR(100) NOT NULL,
  `tech_person` VARCHAR(100) NOT NULL,
  `tech_email` VARCHAR(100) NOT NULL,
  `tech_mobile` VARCHAR(24) NOT NULL,
  `tech_tel` VARCHAR(24) NOT NULL,
  `tech_password` VARCHAR(255) NOT NULL,
  `tech_country` INT UNSIGNED NOT NULL,
  `tech_state` INT UNSIGNED NOT NULL,
  `tech_city` INT UNSIGNED NOT NULL,
  `tech_area` INT UNSIGNED NOT NULL,
  `tech_address` VARCHAR(1024) NOT NULL,
  `tech_geo` VARCHAR(64) NOT NULL,
  `tech_desc` VARCHAR(1024),
  `tech_notes` VARCHAR(1024),
  `tech_rate` TINYINT UNSIGNED DEFAULT NULL,
  `tech_pkg` TINYINT UNSIGNED DEFAULT '0',
  `tech_points` INT UNSIGNED DEFAULT '0',
  `tech_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `tech_blocked` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `tech_login` DATETIME DEFAULT NULL,
  `tech_register` DATETIME NOT NULL,
  `tech_user` INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tech_form`
--

CREATE TABLE `tech_form` (
  `form_id` INT UNSIGNED NOT NULL,
  `form_name` VARCHAR(120) NOT NULL,
  `form_email` VARCHAR(100) DEFAULT NULL,
  `form_mobile` VARCHAR(24) NOT NULL,
  `form_whatsapp` VARCHAR(24) DEFAULT NULL,
  `form_key` VARCHAR(6) NOT NULL,
  `form_national_id` VARCHAR(14) NOT NULL,
  `form_birth` DATE DEFAULT NULL,
  `form_store` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `form_store_name` VARCHAR(120) DEFAULT NULL,
  `form_store_cr` VARCHAR(20) DEFAULT NULL,
  `form_store_tax` VARCHAR(20) DEFAULT NULL,
  `form_store_address` VARCHAR(220) DEFAULT NULL,
  `form_level` VARCHAR(1024) DEFAULT NULL,
  `form_note` VARCHAR(1024) DEFAULT NULL,
  `form_ref` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `form_media` VARCHAR(24) NOT NULL,
  `form_modify` DATETIME DEFAULT NULL,
  `form_create` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tech_points`
--

CREATE TABLE `tech_points` (
  `points_id` bigint(20) UNSIGNED NOT NULL,
  `points_tech` INT UNSIGNED NOT NULL,
  `points_amount` INT UNSIGNED NOT NULL,
  `points_res` TINYINT UNSIGNED DEFAULT '0' COMMENT '0:pkg, 1:purch, 2:promo, 3:academy, 4:ticket, 5:ads',
  `points_target` bigint(20) UNSIGNED DEFAULT NULL,
  `points_process` TINYINT UNSIGNED NOT NULL DEFAULT '1' COMMENT '0:spend, 1:earn',
  `points_time` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ugroups`
--

CREATE TABLE `ugroups` (
  `ugroup_id` INT UNSIGNED NOT NULL,
  `ugroup_name` VARCHAR(42) NOT NULL,
  `ugroup_privileges` VARCHAR(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` INT UNSIGNED NOT NULL,
  `user_name` VARCHAR(100) NOT NULL,
  `user_email` VARCHAR(100) NOT NULL,
  `user_mobile` VARCHAR(24) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `user_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `user_group` INT UNSIGNED NOT NULL,
  `user_login` DATETIME DEFAULT NULL,
  `user_register` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `compatibilities`
--
ALTER TABLE `compatibilities`
  ADD PRIMARY KEY (`compatibility_id`),
  ADD KEY `compatibility_type` (`compatibility_type`);

--
-- Indexes for table `compatible_models`
--
ALTER TABLE `compatible_models`
  ADD PRIMARY KEY (`compatible_id`),
  ADD KEY `compatible_src` (`compatible_src`),
  ADD KEY `compatible_model` (`compatible_model`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `customer_country` (`customer_country`),
  ADD KEY `customer_state` (`customer_state`),
  ADD KEY `customer_city` (`customer_city`),
  ADD KEY `customer_area` (`customer_area`);

--
-- Indexes for table `issue_categories`
--
ALTER TABLE `issue_categories`
  ADD PRIMARY KEY (`issuecat_id`);

--
-- Indexes for table `issue_subcategories`
--
ALTER TABLE `issue_subcategories`
  ADD PRIMARY KEY (`issuesubcat_id`),
  ADD KEY `issuesubcat_category` (`issuesubcat_category`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `location_parent` (`location_parent`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`merchant_id`),
  ADD KEY `merchant_country` (`merchant_country`),
  ADD KEY `merchant_state` (`merchant_state`),
  ADD KEY `merchant_city` (`merchant_city`),
  ADD KEY `merchant_area` (`merchant_area`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`model_id`),
  ADD KEY `model_brand` (`model_brand`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`part_id`),
  ADD KEY `part_merchant` (`part_merchant`),
  ADD KEY `part_brand` (`part_brand`);

--
-- Indexes for table `parts_brands`
--
ALTER TABLE `parts_brands`
  ADD PRIMARY KEY (`prtbrnd_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_code` (`post_code`),
  ADD KEY `post_publish_user` (`post_publish_user`),
  ADD KEY `post_archive_user` (`post_archive_user`),
  ADD KEY `post_delete_user` (`post_delete_user`),
  ADD KEY `post_create_user` (`post_create_user`),
  ADD KEY `post_modify_user` (`post_modify_user`);

--
-- Indexes for table `posts_likes`
--
ALTER TABLE `posts_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `like_tech` (`like_tech`),
  ADD KEY `like_post` (`like_post`);

--
-- Indexes for table `posts_views`
--
ALTER TABLE `posts_views`
  ADD PRIMARY KEY (`view_id`),
  ADD KEY `view_tech` (`view_tech`),
  ADD KEY `view_post` (`view_post`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `request_customer` (`request_customer`),
  ADD KEY `request_brand` (`request_brand`),
  ADD KEY `request_model` (`request_model`);

--
-- Indexes for table `req_attach`
--
ALTER TABLE `req_attach`
  ADD PRIMARY KEY (`reqattach_id`),
  ADD KEY `reqattach_request` (`reqattach_request`);

--
-- Indexes for table `req_issues`
--
ALTER TABLE `req_issues`
  ADD PRIMARY KEY (`reqissue_id`),
  ADD KEY `reqissue_request` (`reqissue_request`),
  ADD KEY `reqissue_category` (`reqissue_category`),
  ADD KEY `reqissue_subcategory` (`reqissue_subcategory`);

--
-- Indexes for table `req_parts`
--
ALTER TABLE `req_parts`
  ADD PRIMARY KEY (`reqpart_id`),
  ADD KEY `reqpart_request` (`reqpart_request`),
  ADD KEY `reqpart_repair` (`reqpart_repair`),
  ADD KEY `reqpart_part` (`reqpart_part`);

--
-- Indexes for table `req_repairs`
--
ALTER TABLE `req_repairs`
  ADD PRIMARY KEY (`reqrepair_id`),
  ADD KEY `reqrepair_request` (`reqrepair_request`),
  ADD KEY `reqrepair_tech` (`reqrepair_tech`);

--
-- Indexes for table `req_repairs_reviews`
--
ALTER TABLE `req_repairs_reviews`
  ADD PRIMARY KEY (`reprvw_id`),
  ADD KEY `reprvw_repair` (`reprvw_repair`),
  ADD KEY `reprvw_request` (`reprvw_request`),
  ADD KEY `reprvw_tech` (`reprvw_tech`),
  ADD KEY `reprvw_customer` (`reprvw_customer`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`attach_id`),
  ADD KEY `attach_ticket` (`attach_ticket`),
  ADD KEY `attach_reply` (`attach_reply`);

--
-- Indexes for table `support_categories`
--
ALTER TABLE `support_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `reply_ticket` (`reply_ticket`),
  ADD KEY `reply_type` (`reply_type`),
  ADD KEY `reply_target` (`reply_target`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `ticket_brand` (`ticket_brand`),
  ADD KEY `ticket_model` (`ticket_model`),
  ADD KEY `ticket_category` (`ticket_category`),
  ADD KEY `ticket_tech` (`ticket_tech`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`tech_id`),
  ADD KEY `tech_country` (`tech_country`),
  ADD KEY `tech_state` (`tech_state`),
  ADD KEY `tech_city` (`tech_city`),
  ADD KEY `tech_area` (`tech_area`);

--
-- Indexes for table `tech_form`
--
ALTER TABLE `tech_form`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `tech_points`
--
ALTER TABLE `tech_points`
  ADD PRIMARY KEY (`points_id`),
  ADD KEY `points_res` (`points_res`),
  ADD KEY `points_tech` (`points_tech`),
  ADD KEY `points_target` (`points_target`);

--
-- Indexes for table `ugroups`
--
ALTER TABLE `ugroups`
  ADD PRIMARY KEY (`ugroup_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_group` (`user_group`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compatibilities`
--
ALTER TABLE `compatibilities`
  MODIFY `compatibility_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compatible_models`
--
ALTER TABLE `compatible_models`
  MODIFY `compatible_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_categories`
--
ALTER TABLE `issue_categories`
  MODIFY `issuecat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_subcategories`
--
ALTER TABLE `issue_subcategories`
  MODIFY `issuesubcat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `language_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `merchant_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `model_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `part_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parts_brands`
--
ALTER TABLE `parts_brands`
  MODIFY `prtbrnd_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_likes`
--
ALTER TABLE `posts_likes`
  MODIFY `like_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_views`
--
ALTER TABLE `posts_views`
  MODIFY `view_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `req_attach`
--
ALTER TABLE `req_attach`
  MODIFY `reqattach_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `req_issues`
--
ALTER TABLE `req_issues`
  MODIFY `reqissue_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `req_parts`
--
ALTER TABLE `req_parts`
  MODIFY `reqpart_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `req_repairs`
--
ALTER TABLE `req_repairs`
  MODIFY `reqrepair_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `req_repairs_reviews`
--
ALTER TABLE `req_repairs_reviews`
  MODIFY `reprvw_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `attach_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_categories`
--
ALTER TABLE `support_categories`
  MODIFY `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_replies`
--
ALTER TABLE `support_replies`
  MODIFY `reply_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `ticket_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `tech_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tech_form`
--
ALTER TABLE `tech_form`
  MODIFY `form_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tech_points`
--
ALTER TABLE `tech_points`
  MODIFY `points_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ugroups`
--
ALTER TABLE `ugroups`
  MODIFY `ugroup_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
