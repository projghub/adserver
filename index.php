<?php 
	header("content-type: application/x-javascript");

	include("config.php");

	$url = 'http://173.203.243.140/';
	#$url = 'http://adserver.lvh.me/';

	@$vendor_id 			= ((int)$_GET['v'] > 0 && is_numeric($_GET['v'])) ? (int)$_GET["v"] : 1; ### Site Scout
	@$publisher_id 	= ((int)$_GET['p'] > 0 && is_numeric($_GET['p'])) ? (int)$_GET["p"] : ''; ### FoxNews.com
	@$campaign_id	 	= ((int)$_GET['c'] > 0 && is_numeric($_GET['c'])) ? (int)$_GET["c"] : ''; ### Site Scout Campaign ID
	@$creative_id		= ((int)$_GET['a'] > 0 && is_numeric($_GET['a'])) ? (int)$_GET["a"] : ''; ### Site Scout Creative ID
	@$ad_type_id 		= ((int)$_GET['at'] > 0 && is_numeric($_GET['at'])) ? (int)$_GET["at"] : 1; ### Set by BgBng Ad Server in ad_types table

	$token = sha1(time());

	### Create Master DB Connection
	$db_conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbuser, $dbpass);
	$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	### Choose Placement
	$placement_stmt = $db_conn->prepare("SELECT p.id, p.template_id, t.positions, at.medium
		FROM placements p
		INNER JOIN templates t ON
			t.id = p.template_id
		INNER JOIN ad_types at ON
			p.ad_type_id = at.id
		WHERE p.vendor_id = ?
		AND p.ad_type_id = ?
		LIMIT 1");
	$placement_stmt->execute(array($vendor_id, $ad_type_id));
	$placement = $placement_stmt->fetch(PDO::FETCH_ASSOC);
	#print_r($placement);

	if(!$placement) {
		## Do something, default ad?
		exit();
	}

	//Choose the ad(s) shown based on ad_types.type
	//Limit it to $placement->positions
	if($placement['medium'] == "text") { //Text Placement
		$ads_stmt = $db_conn->prepare("SELECT a.id, a.title, CONCAT(a.description_line_1, ' ', a.description_line_2) AS description, ass.name, a.display_url,
									CONCAT(a.destination_url_prefix, a.destination_url) AS destination_url
									FROM placements p 
									INNER JOIN placement_positions pp ON
										pp.placement_id = p.id
									INNER JOIN templates t ON
										t.id = p.template_id
									INNER JOIN ads a ON
										a.id = pp.ad_id
									LEFT JOIN assets ass ON
										a.asset_id = ass.id
									INNER JOIN vendors v ON
										v.id = p.vendor_id
									WHERE
										p.id = ?
									AND
										a.deleted_at IS NULL
									ORDER BY pp.priority DESC
									LIMIT 0, 3");
		$ads_stmt->execute(array($placement['id']));
		$ads = $ads_stmt->fetchAll();
		#print_r($ads);
	} else if($placement['medium'] == "display") { //Display/Image Placement
	} else if($placement['medium'] == "mobile") { //Mobile Placement
	}

	### Shuffle/Randomize Ads
	shuffle($ads);
	#print_r($ads);

	if($placement['medium'] == "text") { //Text Placement
		$impression_stmt = $db_conn->prepare("INSERT INTO impressions
				(ad_id, vendor_id, placement_id, template_id, position, total, created_at)
			VALUES
				(?,?,?,?,?,1,UNIX_TIMESTAMP(?)),
				(?,?,?,?,?,1,UNIX_TIMESTAMP(?)),
				(?,?,?,?,?,1,UNIX_TIMESTAMP(?))
			ON DUPLICATE KEY UPDATE total = total + 1");
		$impression_stmt->execute(array(
			$ads[0]['id'], $vendor_id, $placement['id'], $placement['template_id'], 1, date("Y-m-d H:00:00", time()),
			$ads[1]['id'], $vendor_id, $placement['id'], $placement['template_id'], 2, date("Y-m-d H:00:00", time()),
			$ads[2]['id'], $vendor_id, $placement['id'], $placement['template_id'], 3, date("Y-m-d H:00:00", time())
		));

	} else if($placement['medium'] == "display") { //Display/Image Placement
	} else if($placement['medium'] == "mobile") { //Mobile Placement
	}

	### Set Ad Links
	$ads[0]['link'] = $url.'c.php?a='.$ads[0]['id'];
	$ads[1]['link'] = $url.'c.php?a='.$ads[1]['id'];
	$ads[2]['link'] = $url.'c.php?a='.$ads[2]['id'];

	
	echo 'document.write(\'<style type="text/css">#container'.$token.' { height: 250px; width: 300px; background-color: #FFF; border: 0px solid #0F0; padding: 0px 0px 1px 0px; margin: 0px 0px 0px 0px; } #container'.$token.' a { padding: 0px; margin: 0px; text-decoration: none; } #container'.$token.' a:hover { text-decoration: none; } #ad'.$token.' { background-color: #FFF; height: 83px; width: 300px; padding: 1px 0px 0px 0px; margin: 0px 0px 0px 0px; } #ad'.$token.':hover { background-image: url("'.$url.'images/button_bg.gif"); } #image'.$token.' { height: 82px; width: 100px; position:relative; float: left; padding: 2px 0px 0px 0px; margin: 0px 3px 0px 3px; } #content'.$token.' { height: 82px; width: 194px; position:relative; float: right; padding: 0px; margin: 0px; text-align: left; } #content'.$token.' .title'.$token.' { width: 194px; color: #1122CC; font-family: Arial; font-size: 14px; font-weight: bold; text-decoration: underline; } #content'.$token.' .description'.$token.' { width: 190px; color: #000; font-family: Arial; font-size: 13px; padding: 2px; } </style><div id="container'.$token.'"><a href="'.$ads[0]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[0]['name'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[0]['title'].'</span><br /><span class="description'.$token.'">'.$ads[0]['description'].'</span></div></div></a><a href="'.$ads[1]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[1]['name'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[1]['title'].'</span><br /><span class="description'.$token.'">'.$ads[1]['description'].'</span></div></div></a><a href="'.$ads[2]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[2]['name'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[2]['title'].'</span><br /><span class="description'.$token.'">'.$ads[2]['description'].'</span></div></div></a></div>\');';
