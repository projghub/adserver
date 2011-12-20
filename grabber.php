<?php
##	header("content-type: application/x-javascript");

	include("C:/www/adserver/includes/class.standard.php");
	include("C:/www/adserver/includes/class.sql.php");

	## With mod_rewrite or whatever, we should be able to grab the ad type (300x250 text) and the publisher id
	## Grab ad type and publisher id here
	$publisher_id 	= ((int)$_GET["publisher_id"] > 0) ? (int)$_GET["publisher_id"] : 1;
	$ad_type_id 	= ((int)$_GET["ad_type_id"] > 0) ? (int)$_GET["ad_type_id"] : 1;
	
	//VARIABLES WE COULD PASS IN
	//$publisher_id 	= 1;
	//$ad_type_id		= 1; //1 == text, 8 == display
	//$template_id 		= 1;
	//$placement_id		= 1;

	//randomly choose the template for this publisher and ad type if the template is not specified
	//else get the template_id and how many ads there are
	## We want to grab placements with enough ads that meet how many positions there are (if positions = 3, then there should be atleast 3 ads)
	## Grab the template based on the publisher id and the ad type
	if($template_id){ //grab whatever template they passed in
		$placement = $db->get_row("SELECT p.id, p.template_id, t.positions, at.type
									FROM placements p 
									INNER JOIN templates t ON t.id = p.template_id
									INNER JOIN ad_types at ON at.id = p.ad_type_id
									
									WHERE p.template_id = '".$template_id."' ");
	} else { //randomly grab a placement for the publisher if they didn't specify a template
		$placement = $db->get_row("SELECT p.id, p.template_id, t.positions, at.type
									FROM placements p 
									INNER JOIN templates t ON t.id = p.template_id
									INNER JOIN ad_types at ON at.id = p.ad_type_id
									
									WHERE p.publisher_id = '".$publisher_id."' ORDER BY RAND() LIMIT 1");
	}
	
$db->debug();

	## What happens if we don't find a placement?  Do we just return a default/catch all ad
	## if(!$placement) { WHAT HAPPENS HERE }
	if(!$placement) {
		exit();
	}

	//Choose the ad(s) shown based on ad_types.type
	//Limit it to $placement->positions
	if($placement->type == "text") { //Text Placement
		//get ads in an associative array in their current position (random or otherwise)
		$ads = $db->get_results("SELECT a.id, a.title, CONCAT(a.description_line_1, ' ', a.description_line_2) AS description, i.file_name, a.display_url,
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
									INNER JOIN publishers pubs ON
										pubs.id = p.publisher_id
									WHERE
										p.id = '".$placement->id."'
									ORDER BY
										RAND()
									LIMIT 0, ".$placement->positions, ARRAY_N);
	} else if($placement->type == "display") { //Display/Image Placement
		$ads = $db->get_row("SELECT a.id, a.title, i.file_name, CONCAT(a.destination_url_prefix, a.destination_url) AS destination_url
									FROM placements p 
									INNER JOIN placement_positions pp ON
										pp.placement_id = p.id
									INNER JOIN templates t ON
										t.id = p.template_id
									INNER JOIN ads a ON
										a.id = pp.ad_id
									INNER JOIN images i ON
										i.ad_id = a.id
									INNER JOIN publishers pubs ON
										pubs.id = p.publisher_id
									WHERE
										p.id = '".$placement->id."'
									ORDER BY
										pp.position ASC
									LIMIT 0, ".$placement->positions, ARRAY_N);
	} else if($placement->type == "mobile") { //Mobile Placement

	}

$db->debug();
//print_r($ads);

################
###  LOG IMPRESSIONS
###  insert the impressions served (for each position, must build the query for how many ads we've shown)
###  $db->query("INSERT INTO impressions (ad_id, publisher_id, template_id, position, total, time_served)
###  			VALUES (1,1,1,1,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) )),
###  			(2,1,1,2,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) )),
###  			(3,1,1,3,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) ))
###  			ON DUPLICATE KEY UPDATE total = total + 1");
################
	if($placement->type == "text") { //Text Placement
		$impressionSQL 		= "INSERT INTO impressions (ad_id, publisher_id, template_id, position, total, time_served)
							   VALUES (".$ads[0][0].",".$publisher_id.",".$placement->template_id.",1,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) ))";
		for($i = 1; $i < count($ads); $i++) {
			$impressionSQL .= ", (".$ads[$i][0].",".$publisher_id.",".$placement->template_id.",".($i+1).",1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) ))";
		}
	} else if($placement->type == "display") { //Display/Image Placement
		$impressionSQL 		= "INSERT INTO impressions (ad_id, publisher_id, template_id, position, total, time_served)
							   VALUES (".$ads[0].",".$publisher_id.",".$placement->template_id.",1,1,UNIX_TIMESTAMP( DATE_FORMAT(NOW(), '%Y-%m-%d %H:00:00' ) ))";
	} else if($placement->type == "mobile") { //Mobile Placement

	}
	$impressionSQL .= " ON DUPLICATE KEY UPDATE total = total + 1";

	//echo $impressionSQL;
	$db->query($impressionSQL);

##echo "document.write(\"";

################
###  INCLUDE TEMPLATE
###  Include the correct template and type
################
	if($placement->type == "text") { //Text Placement
		include("C:/www/adserver/templates/text/".$placement->template_id.".php");
	} else if($placement->type == "display") { //Display/Image Placement
		include("C:/www/adserver/templates/display/display.php");
	} else if($placement->type == "mobile") { //Mobile Placement
		include("C:/www/adserver/templates/mobile/mobile.php");
	}

##echo "\");";
?>