
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(120) NOT NULL,
  `user_email` VARCHAR(120) NOT NULL,
  `user_mobile` VARCHAR(24) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `user_active` BOOLEAN NOT NULL DEFAULT '1',
  `user_group` INT UNSIGNED NOT NULL,
  `user_login` DATETIME DEFAULT NULL,
  `user_create` DATETIME NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_group` (`user_group`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `ugroups` (
  `ugroup_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ugroup_name` VARCHAR(42) NOT NULL,
  `ugroup_privileges` VARCHAR(2048) NOT NULL,
  PRIMARY KEY (`ugroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `locations` (
  `location_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_name` VARCHAR(4096) NOT NULL,
  `location_type` TINYINT UNSIGNED NOT NULL COMMENT '1:country,2:state,3:city,4:area',
  `location_parent` INT UNSIGNED NOT NULL,
  `location_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`location_id`),
  KEY `location_parent` (`location_parent`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `technicians` (
  `tech_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tech_code` VARCHAR(12) NOT NULL,
  `tech_center` INT UNSIGNED NOT NULL,
  `tech_email` VARCHAR(120) DEFAULT NULL,
  `tech_email_verefied` DATETIME DEFAULT NULL,
  `tech_mobile` VARCHAR(24) NOT NULL,
  `tech_mobile_verefied` DATETIME DEFAULT NULL,
  `tech_tel` VARCHAR(24) DEFAULT NULL,
  `tech_password` VARCHAR(255) NOT NULL,
  `tech_identification` VARCHAR(24) DEFAULT NULL,
  `tech_birth` DATE DEFAULT NULL,
  `tech_country` INT UNSIGNED NOT NULL,
  `tech_state` INT UNSIGNED NOT NULL,
  `tech_city` INT UNSIGNED NOT NULL,
  `tech_area` INT UNSIGNED NOT NULL,
  `tech_address` VARCHAR(1024) NOT NULL,
  `tech_bio` VARCHAR(1024),
  `tech_notes` VARCHAR(1024),
  `tech_rate` TINYINT UNSIGNED DEFAULT NULL,
  `tech_pkg` TINYINT UNSIGNED DEFAULT '0',
  `tech_points` INT UNSIGNED DEFAULT '0',
  `tech_blocked` BOOLEAN NOT NULL DEFAULT '0',
  `tech_login` DATETIME DEFAULT NULL,
  `tech_register` DATETIME NOT NULL,
  `tech_register_by` INT UNSIGNED DEFAULT NULL,
  `tech_modify` DATETIME DEFAULT NULL,
  `tech_modify_by` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`tech_id`),
  KEY `tech_code` (`tech_code`),
  KEY `tech_center` (`tech_center`),
  KEY `tech_country` (`tech_country`),
  KEY `tech_state` (`tech_state`),
  KEY `tech_city` (`tech_city`),
  KEY `tech_area` (`tech_area`),
  KEY `tech_register_by` (`tech_create_by`),
  KEY `tech_modify_by` (`tech_modify_by`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_centers` (
  `center_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `center_owner` INT UNSIGNED NOT NULL,
  `center_name` VARCHAR(255) NOT NULL,
  `center_logo` VARCHAR(24) DEFAULT NULL,
  `center_cr` VARCHAR(24) DEFAULT NULL,
  `center_tax` VARCHAR(24) DEFAULT NULL,
  `center_email` VARCHAR(120) DEFAULT NULL,
  `center_mobile` VARCHAR(24) DEFAULT NULL,
  `center_tel` VARCHAR(24) DEFAULT NULL,
  `center_whatsapp` VARCHAR(24) DEFAULT NULL,
  `center_country` INT UNSIGNED NOT NULL,
  `center_state` INT UNSIGNED NOT NULL,
  `center_city` INT UNSIGNED NOT NULL,
  `center_area` INT UNSIGNED NOT NULL,
  `center_address` VARCHAR(1024) NOT NULL,
  `center_rate` TINYINT UNSIGNED DEFAULT NULL,
  `center_create` DATETIME NOT NULL,
  `center_create_by` INT UNSIGNED DEFAULT NULL,
  `center_modify` DATETIME DEFAULT NULL,
  `center_modify_by` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`center_id`),
  KEY `center_owner` (`center_owner`),
  KEY `center_country` (`center_country`),
  KEY `center_state` (`center_state`),
  KEY `center_city` (`center_city`),
  KEY `center_area` (`center_area`),
  KEY `center_create_by` (`center_create_by`),
  KEY `center_modify_by` (`center_modify_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_packages` (
  `pkg_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pkg_type` TINYINT UNSIGNED NOT NULL COMMENT '1:free, 2:silver, 3:gold, 4:diamond',
  `pkg_period` INT UNSIGNED NOT NULL,
  `pkg_cost` DECIMAL(9, 2) NOT NULL,
  `pkg_points` INT UNSIGNED NOT NULL,
  `pkg_priv` VARCHAR(4096) NOT NULL,
  PRIMARY KEY (`pkg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_subscriptions` (
  `sub_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sub_tech` INT UNSIGNED NOT NULL,
  `sub_pkg` INT UNSIGNED NOT NULL,
  `sub_cost` DECIMAL(9, 2) NOT NULL,
  `sub_points` INT UNSIGNED NOT NULL,
  `sub_period` INT UNSIGNED NOT NULL,
  `sub_priv` VARCHAR(4096) NOT NULL,
  `sub_start` DATE NOT NULL,
  `sub_end` DATE NOT NULL,
  `sub_status` BOOLEAN NOT NULL COMMENT '0:in-active, 1:active',
  `sub_register` DATETIME NOT NULL,
  `sub_register_by` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`sub_id`),
  KEY `sub_tech` (`sub_tech`),
  KEY `sub_pkg` (`sub_pkg`),
  KEY `sub_register_by` (`sub_register_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_transactions` (
  `trans_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `trans_ref` VARCHAR(32) NOT NULL,
  `trans_tech` INT UNSIGNED NOT NULL,
  `trans_method` TINYINT UNSIGNED NOT NULL COMMENT '1:gateway, 2:cash, 3: wallet, 4:cobon, 5:transfer',
  `trans_amount` DECIMAL(9, 2) NOT NULL,
  `trans_process` TINYINT UNSIGNED NOT NULL COMMENT '1:spend, 2:earn',
  `trans_create` DATETIME NOT NULL,
  `trans_create_by` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `trans_tech` (`trans_tech`),
  KEY `trans_create_by` (`trans_create_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_points` (
  `points_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `points_count` INT UNSIGNED NOT NULL,
  `points_src` TINYINT UNSIGNED NOT NULL COMMENT '1:pkg, 2:credit, 3:cobon, 4:academy, 5:ticket, 6:transfer, 7:sugg, 8:ads, 9:articles',
  `points_target` INT UNSIGNED DEFAULT NULL,
  `points_process` TINYINT UNSIGNED NOT NULL COMMENT '1:spend, 2:earn',
  `points_register` DATETIME NOT NULL,
  PRIMARY KEY (`points_id`),
  KEY `points_tech` (`points_tech`),
  KEY `points_src` (`points_src`),
  KEY `points_target` (`points_target`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand_name` VARCHAR(24) NOT NULL,
  `brand_logo` VARCHAR(24) NOT NULL,
  `brand_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `models` (
  `model_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `model_name` VARCHAR(24) NOT NULL,
  `model_brand` INT UNSIGNED NOT NULL,
  `model_photo` VARCHAR(120) NOT NULL,
  `model_url` VARCHAR(120) NOT NULL,
  `model_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`model_id`),
  KEY `model_brand` (`model_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `compats` (
  `compat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `compat_category` INT UNSIGNED NOT NULL,
  `compat_part` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`compat_id`),
  KEY `compat_category`(`compat_category`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `compats_categories` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(1024) NOT NULL,
  `category_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`);
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `compatible_models` (
  `compatible_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `compatible_src` INT UNSIGNED NOT NULL COMMENT 'compats.compat_id',
  `compatible_model` INT UNSIGNED NOT NULL COMMENT 'models.model_id',
  PRIMARY KEY (`compatible_id`),
  KEY `compatible_src` (`compatible_src`),
  KEY `compatible_model` (`compatible_model`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `compats_sugg` (
  `sugg_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sugg_category` INT UNSIGNED NOT NULL COMMENT 'compats_categories.category_id',
  `sugg_tech` INT UNSIGNED NOT NULL COMMENT 'technicians.tech_id',
  `sugg_status` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '0:new, 1:accepted, 2:rejected',
  `sugg_points` INT UNSIGNED DEFAULT NULL,
  `sugg_act_note` VARCHAR(1024) DEFAULT NULL,
  `sugg_act_by` INT UNSIGNED DEFAULT NULL,
  `sugg_act_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`sugg_id`),
  KEY `sugg_category` (`sugg_category`),
  KEY `sugg_model` (`sugg_model`),
  KEY `sugg_tech` (`sugg_tech`),
  KEY `sugg_act_by` (`sugg_act_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `compats_sugg_models` (
  `csugg_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sugg_src` INT UNSIGNED NOT NULL COMMENT 'compats_sugg.sugg_id',
  `sugg_model` INT UNSIGNED NOT NULL COMMENT 'models.model_id',
  PRIMARY KEY (`csugg_id`),
  KEY `sugg_src` (`sugg_src`),
  KEY `sugg_model` (`sugg_model`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_code` VARCHAR(12) NOT NULL,
  `post_title` VARCHAR(255) NOT NULL,
  `post_body` VARCHAR(2048) NOT NULL,
  `post_file` VARCHAR(24) DEFAULT NULL,
  `post_photo` VARCHAR(24) DEFAULT NULL,
  `post_type` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `post_cost` INT UNSIGNED NOT NULL DEFAULT '0',
  `post_allow_comments` BOOLEAN NOT NULL DEFAULT '1',
  `post_archived` BOOLEAN NOT NULL DEFAULT '0',
  `post_archive_user` INT UNSIGNED DEFAULT NULL,
  `post_archive_time` DATETIME DEFAULT NULL,
  `post_deleted` BOOLEAN NOT NULL DEFAULT '0',
  `post_delete_user` INT UNSIGNED NOT NULL,
  `post_delete_time` DATETIME DEFAULT NULL,
  `post_views` INT UNSIGNED NOT NULL DEFAULT '0',
  `post_likes` INT UNSIGNED NOT NULL DEFAULT '0',
  `post_create_tech` INT UNSIGNED DEFAULT NULL,
  `post_create_user` INT UNSIGNED DEFAULT NULL,
  `post_create_time` DATETIME NOT NULL,
  `post_modify_tech` INT UNSIGNED DEFAULT NULL,
  `post_modify_user` INT UNSIGNED DEFAULT NULL,
  `post_modify_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_code` (`post_code`),
  KEY `post_archive_user` (`post_archive_user`),
  KEY `post_delete_user` (`post_delete_user`),
  KEY `post_create_tech` (`post_create_tech`),
  KEY `post_create_user` (`post_create_user`),
  KEY `post_modify_tech` (`post_modify_tech`)
  KEY `post_modify_user` (`post_modify_user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `posts_comments`;
CREATE TABLE IF NOT EXISTS `posts_comments` (
  `comment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_post` INT UNSIGNED NOT NULL,
  `comment_context` VARCHAR(2048) NOT NULL,
  `comment_visible` BOOLEAN DEFAULT NULL,
  `comment_review` INT UNSIGNED DEFAULT NULL,
  `comment_parent` INT UNSIGNED DEFAULT NULL,
  `comment_user` INT UNSIGNED DEFAULT NULL,
  `comment_tech` INT UNSIGNED DEFAULT NULL,
  `comment_create` DATETIME NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_post` (`comment_post`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_review` (`comment_review`),
  KEY `comment_user` (`comment_user`),
  KEY `comment_tech` (`comment_tech`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `posts_likes` (
  `like_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `like_tech` INT UNSIGNED NOT NULL,
  `like_post` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`like_id`),
  KEY `like_tech` (`like_tech`),
  KEY `like_post` (`like_post`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `posts_views` (
  `view_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `view_device` VARCHAR(200) DEFAULT NULL,
  `view_tech` INT UNSIGNED NOT NULL,
  `view_post` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`view_id`),
  KEY `view_tech` (`view_tech`),
  KEY `view_post` (`view_post`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `room_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` VARCHAR(12) NOT NULL,
  `room_type` TINYINT UNSIGNED NOT NULL COMMENT '1:couple, 2:group',
  `room_name` VARCHAR(64) DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  KEY `room_code` (`room_code`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `chat_rooms_members` (
  `member_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_room` INT UNSIGNED NOT NULL,
  `member_tech` INT UNSIGNED NOT NULL,
  `member_admin` BOOLEAN NOT NULL DEFAULT '0',
  `member_add` DATETIME NOT NULL,
  PRIMARY KEY (`member_room`),
  KEY `member_room` (`member_room`),
  KEY `member_tech` (`member_tech`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `chat_msgs` (
  `msg_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `msg_room` INT UNSIGNED NOT NULL,
  `msg_from` INT UNSIGNED NOT NULL,
  `msg_context` VARCHAR(1024) NOT NULL,
  `msg_create` DATETIME NOT NULL,
  PRIMARY KEY (`msg_room`),
  KEY `member_room` (`member_room`),
  KEY `msg_from` (`msg_from`),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `support_categories` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(2048) NOT NULL COMMENT "JSON en/ar",
  `category_cost` INT UNSIGNED NOT NULL DEFAULT '1',
  `category_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `support_tickets` (
  `ticket_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_code` VARCHAR(12) NOT NULL,
  `ticket_brand` INT UNSIGNED NOT NULL,
  `ticket_model` INT UNSIGNED NOT NULL,
  `ticket_category` TINYINT UNSIGNED NOT NULL,
  `ticket_cost` INT UNSIGNED NOT NULL DEFAULT '0',
  `ticket_context` VARCHAR(4096) NOT NULL,
  `ticket_status` TINYINT UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Unread, 2: Opened, 3: Closed, 4: Solved, 5: Canceled',
  `ticket_tech` INT UNSIGNED NOT NULL,
  `ticket_create` DATETIME NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `ticket_brand` (`ticket_brand`),
  KEY `ticket_model` (`ticket_model`),
  KEY `ticket_category` (`ticket_category`),
  KEY `ticket_tech` (`ticket_tech`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `support_replies` (
  `reply_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reply_ticket` INT UNSIGNED NOT NULL,
  `reply_context` VARCHAR(1024) NOT NULL,
  `reply_user` INT UNSIGNED DEFAULT NULL,
  `reply_tech` INT UNSIGNED DEFAULT NULL,
  `reply_create` DATETIME NOT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `reply_ticket` (`reply_ticket`),
  KEY `reply_user` (`reply_user`),
  KEY `reply_tech` (`reply_tech`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `support_attachments` (
  `attach_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `attach_file` VARCHAR(24) NOT NULL,
  `attach_ticket` INT UNSIGNED DEFAULT NULL,
  `attach_reply` INT UNSIGNED DEFAULT NULL,
  `attach_time` DATETIME NOT NULL,
  PRIMARY KEY (`attach_id`),
  KEY `attach_ticket` (`attach_ticket`),
  KEY `attach_reply` (`attach_reply`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_code` VARCHAR(12) NOT NULL,
  `course_title` VARCHAR(255) NOT NULL,
  `course_body` VARCHAR(2048) NOT NULL,
  `course_file` VARCHAR(24) DEFAULT NULL,
  `course_photo` VARCHAR(24) DEFAULT NULL,
  `course_type` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `course_cost` DECIMAL(12, 2) NOT NULL DEFAULT '0',
  `course_archived` BOOLEAN NOT NULL DEFAULT '0',
  `course_archive_user` INT UNSIGNED DEFAULT NULL,
  `course_archive_time` DATETIME DEFAULT NULL,
  `course_deleted` BOOLEAN NOT NULL DEFAULT '0',
  `course_delete_user` INT UNSIGNED NOT NULL,
  `course_delete_time` DATETIME DEFAULT NULL,
  `course_views` INT UNSIGNED NOT NULL DEFAULT '0',
  `course_requests` INT UNSIGNED NOT NULL DEFAULT '0',
  `course_create_user` INT UNSIGNED DEFAULT NULL,
  `course_create_time` DATETIME NOT NULL,
  `course_modify_user` INT UNSIGNED DEFAULT NULL,
  `course_modify_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `course_code` (`course_code`),
  KEY `course_archive_user` (`course_archive_user`),
  KEY `course_delete_user` (`course_delete_user`),
  KEY `course_create_user` (`course_create_user`),
  KEY `course_modify_user` (`course_modify_user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_ads` (
  `ads_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ads_title` VARCHAR(255) NOT NULL,
  `ads_photo` VARCHAR(64) NOT NULL,
  `ads_body` VARCHAR(4096) NOT NULL,
  `ads_url` VARCHAR(255) NOT NULL,
  `ads_start` DATETIME NOT NULL,
  `ads_end` DATETIME NOT NULL,
  `ads_create_user` INT NOT NULL,
  `ads_create_time` DATETIME NOT NULL,
  PRIMARY KEY (`ads_id`),
  KEY `ads_create_user` (`ads_create_user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `customer_notes` VARCHAR(1024),
  `customer_rate` tinyint(4) DEFAULT NULL,
  `customer_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `customer_login` DATETIME DEFAULT NULL,
  `customer_register` DATETIME NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `customer_country` (`customer_country`),
  KEY `customer_state` (`customer_state`),
  KEY `customer_city` (`customer_city`),
  KEY `customer_area` (`customer_area`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `languages` (
  `language_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `language_name` VARCHAR(24) NOT NULL,
  `language_code` VARCHAR(2) NOT NULL,
  `language_dir` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `merchants` (
  `merchant_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `merchant_user` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`merchant_id`),
  KEY `merchant_country` (`merchant_country`),
  KEY `merchant_state` (`merchant_state`),
  KEY `merchant_city` (`merchant_city`),
  KEY `merchant_area` (`merchant_area`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `parts` (
  `part_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `part_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`part_id`),
  KEY `part_merchant` (`part_merchant`),
  KEY `part_brand` (`part_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `parts_brands` (
  `prtbrnd_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `prtbrnd_name` VARCHAR(24) NOT NULL,
  `prtbrnd_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`prtbrnd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `issue_categories` (
  `issuecat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `issuecat_name` VARCHAR(1024) NOT NULL,
  `issuecat_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`issuecat_id`);
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `issue_subcategories` (
  `issuesubcat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `issuesubcat_category` INT UNSIGNED NOT NULL,
  `issuesubcat_name` VARCHAR(1024) NOT NULL,
  `issuesubcat_visible` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`issuesubcat_id`),
  KEY `issuesubcat_category` (`issuesubcat_category`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `requests` (
  `request_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `request_code` VARCHAR(24) NOT NULL,
  `request_customer` INT UNSIGNED NOT NULL,
  `request_uid` VARCHAR(120) NOT NULL,
  `request_brand` INT UNSIGNED NOT NULL,
  `request_model` INT UNSIGNED NOT NULL,
  `request_alive` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `request_note` VARCHAR(2048) NOT NULL,
  `request_status` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `request_modify` DATETIME NOT NULL,
  `request_register` DATETIME NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `request_customer` (`request_customer`),
  KEY `request_brand` (`request_brand`),
  KEY `request_model` (`request_model`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `req_attach` (
  `reqattach_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reqattach_request` INT UNSIGNED NOT NULL,
  `reqattach_file` VARCHAR(42) NOT NULL,
  `reqattach_time` DATETIME NOT NULL,
  `reqattach_status` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`reqattach_id`),
  KEY `reqattach_request` (`reqattach_request`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `req_issues` (
  `reqissue_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reqissue_request` INT UNSIGNED NOT NULL,
  `reqissue_category` INT UNSIGNED NOT NULL,
  `reqissue_subcategory` INT UNSIGNED NOT NULL,
  `reqissue_status` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`reqissue_id`),
  KEY `reqissue_request` (`reqissue_request`),
  KEY `reqissue_category` (`reqissue_category`),
  KEY `reqissue_subcategory` (`reqissue_subcategory`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `req_parts` (
  `reqpart_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reqpart_request` INT UNSIGNED NOT NULL,
  `reqpart_repair` INT UNSIGNED NOT NULL,
  `reqpart_part` INT UNSIGNED NOT NULL,
  `reqpart_cost` decimal(7,2) NOT NULL,
  `reqpart_qty` TINYINT UNSIGNED NOT NULL,
  `reqpart_time` DATETIME NOT NULL,
  `reqpart_status` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`reqpart_id`),
  KEY `reqpart_request` (`reqpart_request`),
  KEY `reqpart_repair` (`reqpart_repair`),
  KEY `reqpart_part` (`reqpart_part`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `req_repairs` (
  `reqrepair_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reqrepair_request` INT UNSIGNED NOT NULL,
  `reqrepair_tech` INT UNSIGNED NOT NULL,
  `reqrepair_cost` decimal(7,2) NOT NULL,
  `reqrepair_total` decimal(7,2) NOT NULL,
  `reqrepair_notes` VARCHAR(1024) NOT NULL,
  `reqrepair_arrive` DATETIME NOT NULL,
  `reqrepair_finished` DATETIME NOT NULL,
  `reqrepair_status` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`reqrepair_id`),
  KEY `reqrepair_request` (`reqrepair_request`),
  KEY `reqrepair_tech` (`reqrepair_tech`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `req_repairs_reviews` (
  `reprvw_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reprvw_repair` INT UNSIGNED NOT NULL,
  `reprvw_request` INT UNSIGNED NOT NULL,
  `reprvw_tech` INT UNSIGNED NOT NULL,
  `reprvw_customer` INT UNSIGNED NOT NULL,
  `reprvw_comment` VARCHAR(512) NOT NULL,
  `reprvw_rate` TINYINT UNSIGNED NOT NULL,
  `reprvw_target` TINYINT UNSIGNED NOT NULL COMMENT '1:Customer,2:Tech',
  PRIMARY KEY (`reprvw_id`),
  KEY `reprvw_repair` (`reprvw_repair`),
  KEY `reprvw_request` (`reprvw_request`),
  KEY `reprvw_tech` (`reprvw_tech`),
  KEY `reprvw_customer` (`reprvw_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tech_form` (
  `form_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_name` VARCHAR(120) NOT NULL,
  `form_email` VARCHAR(100) DEFAULT NULL,
  `form_mobile` VARCHAR(24) NOT NULL,
  `form_whatsapp` VARCHAR(24) DEFAULT NULL,
  `form_key` VARCHAR(6) NOT NULL,
  `form_national_id` VARCHAR(14) NOT NULL,
  `form_birth` DATE DEFAULT NULL,
  `form_store` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `form_store_name` VARCHAR(120) DEFAULT NULL,
  `form_store_cr` VARCHAR(20) DEFAULT NULL,
  `form_store_tax` VARCHAR(20) DEFAULT NULL,
  `form_store_address` VARCHAR(220) DEFAULT NULL,
  `form_level` VARCHAR(1024) DEFAULT NULL,
  `form_note` VARCHAR(1024) DEFAULT NULL,
  `form_ref` SMALLINT UNSIGNED NOT NULL DEFAULT '0',
  `form_media` VARCHAR(24) NOT NULL,
  `form_modify` DATETIME DEFAULT NULL,
  `form_create` DATETIME NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------