<?php
	exit();

	include("config.php");

	$db_conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbuser, $dbpass);

	$db_conn->query("DROP TABLE IF EXISTS `publishers`;");

	### Publishers
	$db_conn->query("CREATE TABLE `vendors` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(255),
		`created_at` DATETIME NOT NULL,
		`deleted_at` DATETIME DEFAULT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	
	$db_conn->query("INSERT INTO `vendors` SET
		id					= 1,
		name				= 'Site Scout',
		created_at	= NOW();");

	### Publishers
	$db_conn->query("CREATE TABLE `publishers` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`vendor_id` INT(10) UNSIGNED,
		`name` VARCHAR(255),
		`created_at` DATETIME NOT NULL,
		`deleted_at` DATETIME DEFAULT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Ad Types
	$db_conn->query("CREATE TABLE `ad_types` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`medium` ENUM('text', 'image', 'mobile') DEFAULT 'text',
		`size` VARCHAR(255),
		`created_at` DATETIME NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	$db_conn->query("INSERT INTO `ad_types` SET
		id					= 1,
		medium			= 'text',
		size				= '300x250',
		created_at	= NOW();");	

	### Templates
	$db_conn->query("CREATE TABLE `templates` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`postitions` TINYINT UNSIGNED DEFAULT 1,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Placements
	$db_conn->query("CREATE TABLE `placements` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`vendor_id` INT(10) UNSIGNED NOT NULL,
		`template_id` INT(10) UNSIGNED NOT NULL,
		`ad_type_id` INT(10) UNSIGNED NOT NULL,
		`positions` TINYINT DEFAULT 1,
		PRIMARY KEY (`id`),
		CONSTRAINT `p_vendor_id_vendors_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON UPDATE CASCADE,
		CONSTRAINT `p_template_id_templates_id` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON UPDATE CASCADE,
		CONSTRAINT `p_ad_type_id_ad_types_id` FOREIGN KEY (`ad_type_id`) REFERENCES `ad_types` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	
	### Ads
	$db_conn->query("CREATE TABLE `ads` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`asset_id` INT(10) DEFAULT NULL,
		`title` VARCHAR(255) NOT NULL,
		`description_line_1` VARCHAR(255) NOT NULL,
		`description_line_2` VARCHAR(255) NOT NULL,
		`destination_url_prefix` VARCHAR(255) NOT NULL,
		`destination_url` VARCHAR(255) NOT NULL,
		`display_url` VARCHAR(255) NOT NULL,
		`created_at` DATETIME NOT NULL,
		`updated_at` DATETIME NOT NULL,
		`deleted_at` DATETIME DEFAULT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Placement Positions 
	$db_conn->query("CREATE TABLE `placement_positions` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`placement_id` INT(10) UNSIGNED NOT NULL,
		`ad_id` INT(10) UNSIGNED NOT NULL,
		`priority` TINYINT DEFAULT 1,
		`random` TINYINT DEFAULT 0,
		PRIMARY KEY (`id`),
		CONSTRAINT `pp_placement_id_placements_id` FOREIGN KEY (`placement_id`) REFERENCES `placements` (`id`) ON UPDATE CASCADE,
		CONSTRAINT `pp_ad_id_ads_id` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Impressions
	$db_conn->query("CREATE TABLE `impressions` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`ad_id` INT(10) UNSIGNED NOT NULL,
		`vendor_id` INT(10) UNSIGNED NOT NULL,
		`publisher_id` VARCHAR(255),
		`placement_id` INT(10) UNSIGNED NOT NULL,
		`template_id` INT(10) UNSIGNED NOT NULL,
		`position` INT(10) UNSIGNED NOT NULL,
		`total` INT(10) UNSIGNED NOT NULL,
		`useragent` VARCHAR(255) COLLATE utf8_unicode_ci,
		`referrer` VARCHAR(255) COLLATE utf8_unicode_ci,
		`created_at` DATETIME NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE INDEX(ad_id, vendor_id, publisher_id, placement_id, template_id, position)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Images
	$db_conn->query("CREATE TABLE `assets` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(255) NOT NULL,
		`created_at` DATETIME NOT NULL,
		`deleted_at` DATETIME DEFAULT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Clicks
	$db_conn->query("CREATE TABLE `clicks` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`ad_id` INT(10) UNSIGNED NOT NULL,
		`impression_id` INT(10) UNSIGNED NOT NULL,
		`ip_address` INT(10) UNSIGNED NOT NULL,
		`useragent` VARCHAR(255) COLLATE utf8_unicode_ci,
		`referrer` VARCHAR(255) COLLATE utf8_unicode_ci,
		`created_at` DATETIME NOT NULL,
		PRIMARY KEY (`id`),
		CONSTRAINT `c_ad_id_ads_id` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON UPDATE CASCADE,
		CONSTRAINT `c_impression_id_impressions_id` FOREIGN KEY (`impression_id`) REFERENCES `impressions` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### TEST DATA
/*
	INSERT INTO ads SET id = 1, image_id = 1, title = 'title', description_line_1 = 'line 1', description_line_2 = 'line 2',  destination_url_prefix = 'http://', destination_url = 'www.bgbng.com', display_url = 'http://bgbng.com/', created_at = NOW(), updated_at = NOW;
