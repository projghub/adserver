<?php 
	header("content-type: application/x-javascript");

	$vendor_id 			= ((int)$_GET["v"] > 0 && (int)$_GET['v'] === $_GET['v']) ? (int)$_GET["v"] : 1; ### Site Scout
	$publisher_id 	= ((int)$_GET["p"] > 0) ? (int)$_GET["p"] : ''; ### FoxNews.com
	$campaign_id	 	= ((int)$_GET["c"] > 0) ? (int)$_GET["c"] : ''; ### Site Scout Campaign ID
	$creative_id		= ((int)$_GET["a"] > 0) ? (int)$_GET["a"] : ''; ### Site Scout Creative ID
	$ad_type_id 		= ((int)$_GET["t"] > 0) ? (int)$_GET["t"] : 1; ### Set by BgBng Ad Server in ad_types table

	$token = sha1(time());

	### Choose Placement
	$placement_stmt = $db_conn->prepare("SELECT p.id, p.template_id, t.positions, at.type
		FROM placements p 
		INNER JOIN templates t ON
			t.id = p.template_id
		INNER JOIN ad_types at ON
			at.id = p.ad_type_id
		WHERE p.vendor_id = ?
		LIMIT 1");
	$placement_stmt->execute($vendor_id);
	$placement = $placement_stmt->fetch(PDO::FETCH_ASSOC);

	if(!$placement) {
		## Do something, default ad?
		exit();
	}

	//Choose the ad(s) shown based on ad_types.type
	//Limit it to $placement->positions
	if($placement['medium'] == "text") { //Text Placement
		$ads_stmt = $db_conn->prepare("SELECT a.id, a.title, CONCAT(a.description_line_1, ' ', a.description_line_2) AS description, i.file_name, a.display_url,
									CONCAT(a.destination_url_prefix, a.destination_url) AS destination_url
									FROM placements p 
									INNER JOIN placement_positions pp ON
										pp.placement_id = p.id
									INNER JOIN templates t ON
										t.id = p.template_id
									INNER JOIN ads a ON
										a.id = pp.ad_id
									LEFT JOIN images i ON
										i.ad_id = a.id
									INNER JOIN vendors v ON
										v.id = p.vendor_id
									WHERE
										p.id = ?
									ORDER BY pp.priority DESC
									LIMIT 0, ?");
		$ads_stmt->execute(array($placement['id'], $placement['positions']));
		$ads = $ads_stmt->fetch(PDO::FETCH_ASSOC);

	} else if($placement['medium'] == "display") { //Display/Image Placement
	} else if($placement['medium'] == "mobile") { //Mobile Placement
	}

	$ads[0]['id'] = '231';
	$ads[0]['link'] = 'http://173.203.243.140/?c='.$ads[0]['id'];
	$ads[0]['image'] = 'http://173.203.243.140/images/text/bgbng.gif';
	$ads[0]['title'] = 'Increase Customer Revenue';
	$ads[0]['description'] = 'Keep customers longer with our new Retention Reporting..';

	$ads[1]['link'] = 'http://www.griffinhillconsulting.com/';
	$ads[1]['image'] = 'http://173.203.243.140/images/text/anxiety.jpg';
	$ads[1]['title'] = '1 Way To Feel Happy';
	$ads[1]['description'] = 'Researchers have discovered a simple secret to happier living...';

	$ads[2]['link'] = 'http://www.bgbng.com/';
	$ads[2]['image'] = 'http://173.203.243.140/images/text/home.png';
	$ads[2]['title'] = 'Secret of a Home Business';
	$ads[2]['description'] = 'Find out how moms can make extra money from the comfort of their home..';

	shuffle($ads);

################
###  LOG IMPRESSIONS
###  insert the impressions served (for each position, must build the query for how many ads we've shown)
###  $db->query("INSERT INTO impressions (ad_id, publisher_id, template_id, position, total, time_served)
###  			VALUES (1,1,1,1,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) )),
###  			(2,1,1,2,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) )),
###  			(3,1,1,3,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) ))
###  			ON DUPLICATE KEY UPDATE total = total + 1");
################
	if($placement['medium'] == "text") { //Text Placement
		$impressionSQL 		= "INSERT INTO impressions (ad_id, vendor_id, template_id, position, total, time_served)
							   VALUES (?,?,?,1,1,UNIX_TIMESTAMP(?))";
		for($i = 1; $i < count($ads); $i++) {
			$impressionSQL .= ", (?,?,?,?,1,UNIX_TIMESTAMP(?))";
		}
		$impressionSQL .= " ON DUPLICATE KEY UPDATE total = total + 1";
		### Debugging
		#		echo $impressionSQL;

		$impression_stmt = $db_conn->prepare($impressionSQL);
		$impression_stmt->execute(array(
			$ads[0]['id'], $vendor_id, $template_id, 1, 1, date("Y-m-d H:00:00", time()),
			$ads[1]['id'], $vendor_id, $template_id, 2, 1, date("Y-m-d H:00:00", time()),
			$ads[2]['id'], $vendor_id, $template_id, 3, 1, date("Y-m-d H:00:00", time())
		));

	} else if($placement['medium'] == "display") { //Display/Image Placement
	} else if($placement['medium'] == "mobile") { //Mobile Placement
	}

	
	echo 'document.write(\'<style type="text/css">#container'.$token.' { height: 250px; width: 300px; background-color: #FFF; border: 0px solid #0F0; padding: 0px 0px 1px 0px; margin: 0px 0px 0px 0px; } #container'.$token.' a { padding: 0px; margin: 0px; text-decoration: none; } #container'.$token.' a:hover { text-decoration: none; } #ad'.$token.' { background-color: #FFF; height: 83px; width: 300px; padding: 1px 0px 0px 0px; margin: 0px 0px 0px 0px; } #ad'.$token.':hover { background-image: url("http://173.203.243.140/images/button_bg.gif"); } #image'.$token.' { height: 82px; width: 100px; position:relative; float: left; padding: 2px 0px 0px 0px; margin: 0px 3px 0px 3px; } #content'.$token.' { height: 82px; width: 194px; position:relative; float: right; padding: 0px; margin: 0px; text-align: left; } #content'.$token.' .title'.$token.' { width: 194px; color: #1122CC; font-family: Arial; font-size: 14px; font-weight: bold; text-decoration: underline; } #content'.$token.' .description'.$token.' { width: 190px; color: #000; font-family: Arial; font-size: 13px; padding: 2px; } </style><div id="container'.$token.'"><a href="'.$ads[0]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[0]['image'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[0]['title'].'</span><br /><span class="description'.$token.'">'.$ads[0]['description'].'</span></div></div></a><a href="'.$ads[1]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[1]['image'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[1]['title'].'</span><br /><span class="description'.$token.'">'.$ads[1]['description'].'</span></div></div></a><a href="'.$ads[2]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[2]['image'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[2]['title'].'</span><br /><span class="description'.$token.'">'.$ads[2]['description'].'</span></div></div></a></div>\');';

	//__log($log_file, 'index.php', $_SERVER['REMOTE_ADDR'].':showing impression:sess '.session_id());
