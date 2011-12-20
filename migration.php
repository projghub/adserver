<?php
	include("config.php");

	$db_conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbuser, $dbpass);

	$db_conn->query("DROP TABLE IF EXISTS `order_users`;");

	### Placements
	$db_conn->query("CREATE TABLE `placements` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`template_id` INT(10) UNSIGNED NOT NULL,
		`positions` INT(10) UNSIGNED NOT NULL,
		`type` INT(10) UNSIGNED NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	
	### Placement Positions 
	$db_conn->query("CREATE TABLE `placement_positions` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`placement_id` INT(10) UNSIGNED NOT NULL,
		`ad_id` INT(10) UNSIGNED NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Ads
	$db_conn->query("CREATE TABLE `ads` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`title` VARCHAR(255) NOT NULL,
		`description_line_1` VARCHAR(255) NOT NULL,
		`description_line_2` VARCHAR(255) NOT NULL,
		`destination_url_prefix` VARCHAR(255) NOT NULL,
		`destination_url` VARCHAR(255) NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Templates
	$db_conn->query("CREATE TABLE `templates` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Impressions
	$db_conn->query("CREATE TABLE `impressions` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`ad_id` INT(10) UNSIGNED NOT NULL,
		`publisher_id` INT(10) UNSIGNED NOT NULL,
		`template_id` INT(10) UNSIGNED NOT NULL,
		`postition` INT(10) UNSIGNED NOT NULL,
		`total` INT(10) UNSIGNED NOT NULL,
		`created_at` INT(8) UNSIGNED NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Images
	$db_conn->query("CREATE TABLE `images` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`ad_id` INT(10) UNSIGNED NOT NULL,
		`file_name` VARCHAR(255) NOT NULL,
		`created_at` DATETIME,
		`updated_at` DATETIME,
		`deleted_at` DATETIME DEFAULT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

