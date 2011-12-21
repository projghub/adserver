<?php
	include("config.php");

	$db_conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbuser, $dbpass);

	$db_conn->query("DROP TABLE IF EXISTS `clicks`;");
	$db_conn->query("DROP TABLE IF EXISTS `assets`;");
	$db_conn->query("DROP TABLE IF EXISTS `impressions`;");
	$db_conn->query("DROP TABLE IF EXISTS `placement_positions`;");
	$db_conn->query("DROP TABLE IF EXISTS `ads`;");
	$db_conn->query("DROP TABLE IF EXISTS `placements`;");
	$db_conn->query("DROP TABLE IF EXISTS `templates`;");
	$db_conn->query("DROP TABLE IF EXISTS `ad_types`;");
	$db_conn->query("DROP TABLE IF EXISTS `vendors`;");
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
		`positions` TINYINT UNSIGNED DEFAULT 1,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### Placements
	$db_conn->query("CREATE TABLE `placements` (
		`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`vendor_id` INT(10) UNSIGNED NOT NULL,
		`template_id` INT(10) UNSIGNED NOT NULL,
		`ad_type_id` INT(10) UNSIGNED NOT NULL,
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
		`created_at` INT(10) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY (ad_id, vendor_id, placement_id, template_id, position, created_at)
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
		`created_at` INT(10) NOT NULL,
		PRIMARY KEY (`id`),
		CONSTRAINT `c_ad_id_ads_id` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

	### TEST DATA
/*

INSERT INTO ads SET id = 1, asset_id = 1, title = 'Increase Customer Revenue', description_line_1 = 'Keep customers longer with our', description_line_2 = 'new Retention Reporting. Learn More',  destination_url_prefix = 'http://', destination_url = 'www.bgbng.com', display_url = 'http://bgbng.com/', created_at = NOW(), updated_at = NOW();
INSERT INTO ads SET id = 2, asset_id = 2, title = '1 Way To Feel Happy', description_line_1 = 'Researchers have discovered a', description_line_2 = 'simple secret to happier living...',  destination_url_prefix = 'http://', destination_url = 'www.griffinhillconsulting.com', display_url = 'griffinhillconsulting.com', created_at = NOW(), updated_at = NOW();
INSERT INTO ads SET id = 3, asset_id = 3, title = 'Secret of a Home Business', description_line_1 = 'Find out how moms can make extra', description_line_2 = 'from the comfort of their home',  destination_url_prefix = 'http://', destination_url = 'www.bgbng.com', display_url = 'bgbng.com', created_at = NOW(), updated_at = NOW();

INSERT INTO `assets` SET id = 1, name = 'http://173.203.243.140/images/text/bgbng.gif', created_at = NOW();
INSERT INTO `assets` SET id = 2, name = 'http://173.203.243.140/images/text/anxiety.jpg', created_at = NOW();
INSERT INTO `assets` SET id = 3, name = 'http://173.203.243.140/images/text/home.png', created_at = NOW();

INSERT INTO templates SET id = 1, positions = 3;

INSERT INTO placements SET id = 1, template_id = 1, ad_type_id = 1, vendor_id = 1;

INSERT INTO placement_positions SET id = 1, ad_id = 1, placement_id = 1;
INSERT INTO placement_positions SET id = 2, ad_id = 2, placement_id = 1;
INSERT INTO placement_positions SET id = 3, ad_id = 3, placement_id = 1;
 
 */
