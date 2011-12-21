<?php

	include("config.php");

	### Create Master DB Connection
	$db_conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbuser, $dbpass);
	$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);	

	$ad_id = (is_int($_GET['a']) && (int) $_GET['a'] > 0) ? $_GET['a'] : NULL;
	if($ad_id == NULL) {
		header("location: http://www.msn.com/");
		exit();
	}

	$ad_stmt = $db_conn->prepare("SELECT CONCAT(destination_prefix, destination_url) AS destination_url FROM ads
		WHERE id = ?");
	$ad_stmt->execute($ad_id);
	$ad = $ad_stmt->fetch(PDO::ASSOC);

	if($ad) {
		header("location: ".$ad['destination_url'];
		exit();
	} else {
		header("location: http://www.google.com/");
		exit();
	}

	$click_stmt = $db_conn->prepare("INTO INTO clicks SET
		ad_id				= ?,
		ip_address	= ?,
		created_at	= NOW()");
