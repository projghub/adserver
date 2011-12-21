<?php
	include("config.php");

	### Create Master DB Connection
	$db_conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbuser, $dbpass);
	$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);	

	$ad_id = ((int)$_GET['a'] > 0 && is_numeric($_GET['a'])) ? (int)$_GET['a'] : NULL;

	if($ad_id == NULL) {
		header("location: http://www.msn.com/");
		exit();
	}

	$ad_stmt = $db_conn->prepare("SELECT CONCAT(destination_url_prefix, destination_url) AS destination_url
		FROM ads
		WHERE id = ?
		AND deleted_at IS NULL");
	$ad_stmt->execute(array($ad_id));
	$ad = $ad_stmt->fetch(PDO::FETCH_ASSOC);

	if($ad) {
		$click_stmt = $db_conn->prepare("INSERT INTO clicks SET
			ad_id				= ?,
			ip_address	= ?,
			useragent		= ?,
			referrer		= ?,
			created_at	= UNIX_TIMESTAMP(NOW());");
		$click_stmt->execute(array($ad_id, ip2long($_SERVER['REMOTE_ADDR']), $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_REFERER']));
		#echo $db_conn->lastInsertId();

		header("location: ".$ad['destination_url']);
		exit();
	} else {
		header("location: http://www.google.com/");
		exit();
	}
